<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\Cost_field;
use App\Models\DueCollection;
use DB;

class BalanceSheetController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}


	public function index(Request $request)
	{
		$cost_fields = Cost_field::get()->toArray();
        $cost_fields_tmp = [];
		foreach ($cost_fields as $key => $cost_field) {
			$cost_fields_tmp[$cost_field['id']] = $cost_field['title'];
		}
		
		$cost_fields = $cost_fields_tmp;

		if($request->isMethod('post')){
			$sales = $this->searchSale($request->from_date, $request->to_date);

			$purchases = $this->searchPurchase($request->from_date, $request->to_date);
			$purchases = $purchases->groupBy('voucher');
			$purchases_tmp = [];
			foreach ($purchases as $key => $purchase) {
				$price_tmp = 0;
				foreach ($purchase as $k => $purc) {
					$price_tmp += $purc->price*$purc->quantity;
				}
				$purchases_tmp[$key]['voucher'] = $purc->voucher;
				$purchases_tmp[$key]['price'] = $price_tmp;
			}
			$purchases = $purchases_tmp;

			$costs = $this->searchCost($request->from_date, $request->to_date);
			$dues = $this->searchDueCollection($request->from_date, $request->to_date);
			$totalDue = $this->searchTotalDueCollection($request->from_date, $request->to_date);
		}
		else{
			$costs = $this->getTodayCost();

			$purchases = $this->getTodayPurchase();
			$purchases = $purchases->groupBy('voucher');
			$purchases_tmp = [];
			foreach ($purchases as $key => $purchase) {
				$price_tmp = 0;
				foreach ($purchase as $k => $purc) {
					$price_tmp += $purc->price*$purc->quantity;
				}
				$purchases_tmp[$key]['voucher'] = $purc->voucher;
				$purchases_tmp[$key]['price'] = $price_tmp;
			}
			$purchases = $purchases_tmp;

			$sales = $this->getTodaySale();
			$dues = $this->getTodayDueCollection();
			$totalDue = $this->getTodayTotalDueCollection();
		}

        // get closing balance start
        $closing_balane = \DB::table("closing_balances")->get();
        // get closing balance end
		return view('backend.pages.balance_sheet.index', compact('costs', 'purchases', 'sales', 'cost_fields','closing_balane','dues', 'totalDue'));
	}


	private function getTodaySale($date=null)
	{
		$todayDate = date('Y-m-d');

		$sales = DB::table('sales')
		->where('status', 1)
		->whereDate('sales.created_at', '=', $todayDate)
		->select('*')
		->get();

		return $sales;
	}

	private function getTodayTotalDueCollection($date=null)
	{
		$todayDate = date('Y-m-d');

		$totalDue = DB::table('due_collections')
		->whereDate('due_collections.date', '=', $todayDate)
		->selectRaw('sum(payment) as total_collection')
		->first();
		return $totalDue;
	}

	private function getTodayDueCollection($date=null)
	{
		$todayDate = date('Y-m-d');

		$dues = DB::table('due_collections')
		->where('type', 'due')
		->whereDate('due_collections.date', '=', $todayDate)
		->select('*')
		->get();
		return $dues;
	}	

	private function searchDueCollection($from, $to=null)
	{
		if($to && $from && $from != $to){
			$to = date('Y-m-d', strtotime($to . ' +1 day'));
			$dues = DB::table('due_collections')
			->where('type', 'due')
			->whereBetween('due_collections.date', [$from, $to])
			->select('*')
			->get();
		}
		else{
			$dues = DB::table('due_collections')
			->where('type', 'due')
			->whereDate('due_collections.date', '=', $from)
			->select('*')
			->get();
		}

		return $dues;
	}

	private function searchTotalDueCollection($from, $to=null)
	{
		if($to && $from && $from != $to){
			$to = date('Y-m-d', strtotime($to . ' +1 day'));
			$TotalCollection = DB::table('due_collections')
			->whereBetween('due_collections.date', [$from, $to])
			->selectRaw('sum(payment) as total_collection')
			->first();
		}
		else{
			$TotalCollection = DB::table('due_collections')
			->whereDate('due_collections.date', '=', $from)
			->selectRaw('sum(payment) as total_collection')
			->first();
		}
		return $TotalCollection;
	}

	private function getTodayPurchase()
	{
		$todayDate = date('Y-m-d');

		$purchases = DB::table('purchase_histories')
		->where('status', 1)
		// ->where('cost_type', 'Purchase')
		->whereDate('purchase_histories.purchase_date', '=', $todayDate)
		->select('*')
		->get();

		return $purchases;
	}

	private function getTodayCost()
	{
		$todayDate = date('Y-m-d');

		$costs = DB::table('costs')
		->where('status', 1)
		->where('cost_type', 'General')
		->whereDate('costs.pickdate', '=', $todayDate)
		->select('*')
		->get();

		return $costs;
	}

	private function searchSale($from, $to=null)
	{
		if($to && $from && $from != $to){
			$to = date('Y-m-d', strtotime($to . ' +1 day'));
			$sales = DB::table('sales')
			->where('status', 1)
			->whereBetween('sales.created_at', [$from, $to])
			->select('*')
			->get();
		}
		else{
			$sales = DB::table('sales')
			->where('status', 1)
			->whereDate('sales.created_at', '=', $from)
			->select('*')
			->get();
		}

		return $sales;
	}	

	private function searchPurchase($from, $to=null)
	{
		if($to && $from && $from != $to){
			$to = date('Y-m-d', strtotime($to . ' +1 day'));
			$purchases = DB::table('purchase_histories')
			->where('status', 1)
			// ->where('cost_type', 'Purchase')
			->whereBetween('purchase_histories.purchase_date', [$from, $to])
			->select('*')
			->get();
		}
		else{
			$purchases = DB::table('purchase_histories')
			->where('status', 1)
			// ->where('cost_type', 'Purchase')
			->whereDate('purchase_histories.purchase_date', '=', $from)
			->select('*')
			->get();
		}

		return $purchases;
	}

	private function searchCost($from, $to=null)
	{
		if($to && $from && $from != $to){
			// $to = date('Y-m-d', strtotime($to . ' +1 day'));
			$costs = DB::table('costs')
			->where('status', 1)
			->where('cost_type', 'General')
			->whereBetween('costs.pickdate', [$from, $to])
			->select('*')
			->get();
		}
		else{
			$costs = DB::table('costs')
			->where('status', 1)
			->where('cost_type', 'General')
			->whereDate('costs.pickdate', '=', $from)
			->select('*')
			->get();
		}

		return $costs;
	}
    
    
    
    
	function closing($closing_balance)
	{
		if(count(\DB::table("closing_balances")->where(['date'=>date("Y-m-d")])->get())>0){
            session()->flash("warning","Closing Balance Already Added!");
		}else{
    		if(\DB::table("closing_balances")->insert(["date"=>date("Y-m-d"), "closing_balance"=>$closing_balance])){
    		    session()->flash("add_message","Closing Balance Added Successfully!");
    		}else{
    		    session()->flash("warning","Closing Balance Not Added!");
    		}
		}
        return redirect()->route('admin.balance_sheet.index');
	}
}
