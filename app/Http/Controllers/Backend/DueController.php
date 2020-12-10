<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\QueryHelper;
use App\Helpers\FontawesomeHelper;
use App\Models\Sale;
use App\Models\DueCollection;
use DB;

class DueController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function Transaction()
	{
		$histories = DueCollection::get();
		return view('backend.pages.due.history', compact('histories'));
	}
	/**
     * due
    */

    public function due(Request $request)
    {
        $sales = DB::table('sales')
                ->join('admins','sales.admin_id','=','admins.id')
                ->join('restaurant_tables','restaurant_tables.id','=','sales.table_no')
                ->select('sales.*', 'admins.name as saler_name', 'restaurant_tables.name as table_name')
                ->orderBy('sales.created_at', 'desc')
                ->where('sales.status', 1)
                ->where('sales.total_due','>', 0)
                ->get(1);

        $total = DB::table('sales')
                ->join('admins','sales.admin_id','=','admins.id')
                ->select(DB::raw('sum(sales.total_price) as total_price_sum'))
                ->where('sales.status', 1)
                ->where('sales.total_due','>', 0)
                ->first()->total_price_sum;

        if($request->isMethod("POST")){
            $result = $this->due_search($request);
            $sales = $result['sales'];
            $total = $result['total'];
        }
        return view('backend.pages.due.due', compact('sales','total'));
    }

    public function due_search($request)
    {
        $condition = [];
        if(isset($request->to_date)){
            $condition[] = ['sales.pickdate','<=', $request->to_date];
        }
        if(isset($request->from_date)){
            $condition[] = ['sales.pickdate','>=', $request->from_date];
        }
        if(isset($request->table_no)){
            $condition[] = ['sales.table_no','=', $request->table_no];
        }
            

        $sales = DB::table('sales')
                ->join('admins','sales.admin_id','=','admins.id')
                ->join('restaurant_tables','restaurant_tables.id','=','sales.table_no')
                ->select('sales.*', 'admins.name as saler_name', 'restaurant_tables.name as table_name')
                ->orderBy('sales.created_at', 'desc')
                ->where('sales.status', 1)
                ->where('sales.total_due','>', 0)
                ->where($condition)
                ->get();



        $total = DB::table('sales')
                ->join('admins','sales.admin_id','=','admins.id')
                ->select(DB::raw('sum(sales.total_price) as total_price_sum'))
                ->where('sales.status', 1)
                ->where('sales.total_due','>', 0)
                ->where($condition)
                ->first()->total_price_sum;


        return ["sales"=> $sales, "total"=> $total];
    }

    /*
    * @due_collect method
    */
    public function due_collect($id)
    {
        $sale = Sale::where('id', $id)->first();
        // dd($sale);
        return view('backend.pages.due.due_collect', compact('sale'));
    }

    public function due_collect_store(Request $request, $id)
    {
        $sale = Sale::where('id', $id);

        $dueCollection = [
            "sale_id"   =>  $id,
            "date"      =>  date('Y-m-d'),
            "payment"   =>  $request->payment,
        ];
        
        $update_sale = [
            "total_due"   => $request->current_due,
            "given_money" => $sale->first()->given_money + $request->payment,
            "discount_2" => $request->discount_2,
            "discount" => $request->discount,
            "total_due" => $request->current_due,
            "total_price_after_discount" => $request->price_after_discount,
        ];

        $sale->update($update_sale);
        DueCollection::insert($dueCollection);

        session()->flash('add_message', 'Due Collect successfull');
        return redirect(route('admin.sale.view', $id));
    }
}