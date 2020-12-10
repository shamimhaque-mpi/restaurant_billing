<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\QueryHelper;
use Countries;
use Auth;
use Hash;
use DB;
class HomeController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:admin');
    }

    /**
     * Admin Dashboard 
    */
    public function index()
    {
        /*$product = DB::table('products')->where('status', 1)->count();
        $category = DB::table('categories')->where('status', 1)->count();
        $totalAmount = DB::table('sales')->sum('total_price_after_discount');
        $this_week_sale = $this->getThiWeekSale();
        $this_month_sale = $this->getThiMonthSale();
        $getThisYear = $this->getThisYear();*/

        $today_due = $this->getTodayDue();
        $today_sale = $this->getTodaySale();
        $today_purchase_cost = $this->getTodayPurchaseCost();
        $today_other_cost = $this->getTodayOtherCost();

        //dd($today_sale, $today_purchase_cost, $today_other_cost);

      return view('backend.pages.index', compact('today_sale', 'today_purchase_cost', 'today_other_cost','today_due'));
    }

    private function getTodaySale()
    {
        $today_sales = DB::table('sales')
            ->where('created_at', '>=', date('Y-m-d'))
            ->sum('total_price_after_discount');
        return $today_sales;
    }

    private function getTodayDue()
    {
        $today_due = DB::table('sales')
            ->where('created_at', '>=', date('Y-m-d'))
            ->sum('total_due');
        return $today_due;
    }

    private function getTodayPurchaseCost()
    {
        $today_cost = DB::table('purchase_histories')
            ->where('purchase_date', '=', date('Y-m-d'))
            // ->where('created_at', '>=', date('Y-m-d'))
            // ->where('cost_type', 'Purchase')
            ->sum(DB::raw('price * quantity'));

        return $today_cost;
    }

    private function getTodayOtherCost()
    {
        $today_cost = DB::table('costs')
            ->where('pickdate', '=', date('Y-m-d'))
            // ->where('created_at', '>=', date('Y-m-d'))
            // ->where('cost_type', 'General')
            ->sum('price');

        return $today_cost;
    }


/*    public function getThiWeekSale()
    {
        $oneWeek = date("Y-m-d", strtotime("-1 week"));
        $this_week_sales = DB::table('sales')
            ->where('created_at', '>=', $oneWeek)
            ->sum('total_price');

        return $this_week_sales;
    }


    public function getThiMonthSale()
    {
        $oneMonth = date("Y-m-d", strtotime("-1 month"));
        $this_month_sales = DB::table('sales')
            ->where('created_at', '>=', $oneMonth)
            ->sum('total_price');

        return $this_month_sales;
    }

    public function getThisYear()
    {
        $oneYear = date("Y-m-d", strtotime("-1 year"));
        $this_year_sales = DB::table('sales')
            ->where('created_at', '>=', $oneYear)
            ->sum('total_price');

        return $this_year_sales;
    }*/

    public function chart()
    {
    	return view('backend.pages.demo.chart');
    }

    public function form()
    {
    	return view('backend.pages.demo.form');
    }

    public function table()
    {
    	return view('backend.pages.demo.table');
    }


    /*
     * Change password form
    */
    public function chnagePasswordForm()
    {
        return view('backend.pages.changePasswordForm');
    }


    /*
    * Change password with matching old one
    */
    public function chnagePassword(Request $request)
    {
        $this->validate($request, [
          'old_password' => 'required',
          'password' => 'required|confirmed',
          'password_confirmation' => 'required'
        ]);

        $admin = Auth::guard('admin')->user();

        if(Hash::check($request->old_password, $admin->password)){
          $admin->password = Hash::make($request->password);
          $admin->save();

          session()->flash('success', 'Password changed successfully');
          return back();
        }
        else{
          session()->flash('old_password', 'Old password does not match');
          return back();
        }
    }
}
