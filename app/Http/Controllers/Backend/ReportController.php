<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Auth;
use DB;
class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$sales = DB::table('sales')
				->join('admins','sales.admin_id','=','admins.id')
				->select('sales.*', 'admins.name as saler_name')
				->orderBy('sales.created_at', 'desc')
				->where('sales.status', 1)
				->get();

		$costs = DB::table('costs')
				->join('cost_fields', 'costs.cost_field_id', '=', 'cost_fields.id')
				->where('costs.status', 1)
				->select('costs.*', 'cost_fields.title as field_title')
				->get();
		$PurchaseHistory = PurchaseHistory::orderBy('status', 'desc')
				->orderBy('id', 'desc')
				->where('status', 1)
				->get();
				// dd($PurchaseHistory);
    	return view('backend.pages.report.index', compact('sales', 'costs', 'PurchaseHistory'));
    }
    public function sales(Request $request)
    {


    // $name = 'Rupkotha';
    // Mail::to('jahangiralomshamim3@gmail.com')->send(new SendMailable($name));
    // dd('mail send');


        $sales = DB::table('sales')
		->join('admins','sales.admin_id','=','admins.id');
        if($request->isMethod('post'))
        {
            $field = array('from_date' => null, 'to_date' => null, 'common_field' => null);
            $data = $request->except(['_token']);


            foreach ($data as $key => $value) 
            {
                $field[$key] = $value;
            }
            if($field['from_date'] != null && $field['to_date'] == null)
            {
                $sales = $sales->where('sales.pickdate', $field['from_date']);
            }
            if($field['from_date'] != null && $field['to_date'] != null )
            {
                $sales = $sales->whereBetween('sales.pickdate', [$field['from_date'], $field['to_date']]);
            }
            if($field['common_field'] != null)
            {
                $sales = $sales->orWhere('sales.id',str_replace('0', '', $field['common_field']))->orWhere('admins.name',$field['common_field']);
            }
        }
    	 
			$sales = $sales->select('sales.*', 'admins.name as saler_name')
			->orderBy('sales.created_at', 'desc')
			->where('sales.status', 1)
			->get();
    	return view('backend.pages.report.sales', compact('sales'));
    }
    public function purchase(Request $request)
    {
    	$PurchaseHistory = PurchaseHistory::orderBy('status', 'desc');
        if($request->isMethod('post')){
            $field = array('from_date' => null, 'to_date' => null, 'purchase_field_id' => null);
            $data = $request->except(['_token']);


            foreach ($data as $key => $value) 
            {
                $field[$key] = $value;
            }
            if($field['from_date'] != null && $field['to_date'] == null)
            {
                $PurchaseHistory = $PurchaseHistory->where('purchase_date', $field['from_date']);
            }
            if($field['from_date'] != null && $field['to_date'] != null )
            {
                $PurchaseHistory = $PurchaseHistory->whereBetween('purchase_date', [$field['from_date'], $field['to_date']]);
            }
            if($field['purchase_field_id'] != null)
            {
                $PurchaseHistory = $PurchaseHistory->where('purchase_item_id', $field['purchase_field_id']);
            }
        }
		$PurchaseHistory = $PurchaseHistory->orderBy('id', 'desc')
				->where('status', 1)
				->get();
    	return view('backend.pages.report.purchase', compact('PurchaseHistory'));
    }
    public function cost(Request $request)
    {
    	if($request->isMethod('post')){
            $search_field = $request->except('_token');
            
            $costs = DB::table('costs')
            ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id');

            $new_search_field = [];        
            $without_date_field = [];        
            foreach ($search_field as $key => $value) {
                if($key == 'from_date'){
                    $new_search_field['from_date'] = $value; 
                } 
                if($key == 'to_date'){
                    $new_search_field['to_date'] = $value; 
                } 
                if($key == 'cost_field_id'){
                    $new_search_field['costs.cost_field_id'] = $value; 
                    $without_date_field['costs.'.$key] = $value;
                }          
            }    
            
            foreach ($new_search_field as $key => $value) {
                if($new_search_field['from_date'] && $new_search_field['to_date']){
                    $costs = $costs->whereBetween('costs.pickdate', [$new_search_field['from_date'], $new_search_field['to_date']]); 

                    foreach ($without_date_field as $key_without_date => $value_without_date) {
                        $costs = $costs->where($key_without_date, $value_without_date);       
                    }

                    break;
                }
                else if($new_search_field['from_date'] || $new_search_field['to_date']){
                    $costs = $costs->where('costs.pickdate', '=', $value);

                    foreach ($without_date_field as $key_without_date => $value_without_date) {
                        if($value_without_date != null){
                            $costs = $costs->where($key_without_date, $value_without_date);
                        }       
                    }
                    
                    break; 
                }
                else if($key != 'from_date' && $key != 'to_date'){
                    $costs = $costs->where($key, $value);
                }     
            }  

            $costs = $costs->select('costs.*', 'field.title as field_title')
            ->where('costs.status', 1)
            ->get();


        } else {
            $costs = DB::table('costs')
             ->join('cost_fields', 'costs.cost_field_id', '=', 'cost_fields.id')
             ->where('costs.status', 1)
             ->select('costs.*', 'cost_fields.title as field_title')
             ->get();
        }
    	return view('backend.pages.report.cost', compact('costs'));
    }
}