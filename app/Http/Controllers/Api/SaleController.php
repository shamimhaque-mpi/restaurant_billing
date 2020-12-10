<?php

namespace App\Http\Controllers\Api;

use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use DB;

class SaleController extends Controller
{
	public function allProduct()
	{
		$products = DB::table('products')
		->where('status', 1)
		->get();

		return response()->json(['products' => $products]);			
	}


	public function categoryProduct($category_id)
	{
		$products = DB::table('products')
		->where('category_id', $category_id)
		->where('status', 1)
		->get();

		return response()->json(['products' => $products]);			
	}


	public function allSale($per_page)
	{
		$sales = DB::table('sales')
				->join('admins','sales.admin_id','=','admins.id')
                ->join('restaurant_tables','restaurant_tables.id','=','sales.table_no')
				->select('sales.*', 'admins.name as saler_name', 'restaurant_tables.name as table_name')
				->orderBy('sales.created_at', 'desc')
				->where('sales.status', 1)
				// ->where('sales.total_due', 0)
				->paginate($per_page);
		$sales = SaleResource::collection($sales);

		return $sales;		
	}


	public function search($from_date, $to_date, $table_no, $per_page)
	{

		$sales = DB::table('sales')
				->join('admins','sales.admin_id','=','admins.id')
                ->join('restaurant_tables','restaurant_tables.id','=','sales.table_no')
				->select('sales.*', 'admins.name as saler_name', 'restaurant_tables.name as table_name')
				->orderBy('sales.created_at', 'desc')
				->where('sales.status', 1);
				// ->where('sales.total_due', 0);

		if($to_date != "invalid" && $to_date != "invalid"  && $table_no != "invalid"){
			$sales = $sales
					->where('table_no', $table_no)
					->where('sales.created_at', '>=', $from_date)
					->where('sales.created_at', '<=',  date('Y-m-d',strtotime($to_date . "+1 days")))
					->paginate($per_page);
		}
		else if($to_date != "invalid" && $to_date != "invalid" ){
			$sales = $sales
					->where('sales.created_at', '>=', $from_date)
					->where('sales.created_at', '<=',  date('Y-m-d',strtotime($to_date . "+1 days")))
					->paginate($per_page);
		}
		else if($table_no != "invalid"){
			$sales = $sales
					->where('table_no',$table_no)
					->paginate($per_page);
		}
		else{
			$sales = $sales
					->where('sales.created_at', '>=', $from_date)
					->paginate($per_page);
		}

		$sales = SaleResource::collection($sales);

		return $sales;
	}


	public function getSingleSale($sale_id)
	{
		$sale = DB::table('sale_products')
					->leftJoin('products as products', 'products.id', '=', 'sale_products.product_id')
					->where('sale_id', $sale_id)
					->select('sale_products.*', 'products.title as title')
					->get();

		return response()->json(['sale' => $sale]);			
	}


	public function saleDelete(Request $request)
	{
		DB::table('sales')->where('id', $request->sale_id)->update(['status' => 0]);

		return "deleted";
	}


	public function getAllSaleQuantity()
	{
		$allSaleQty = DB::table('sales')
				->where('status', 1)
				->sum('total_product');

		return $allSaleQty;				
	}


	public function getAllSalePrice()
	{
		$allSalePrice = DB::table('sales')
				->where('status', 1)
				->sum('total_price_after_discount');

		return $allSalePrice;				
	}
}
