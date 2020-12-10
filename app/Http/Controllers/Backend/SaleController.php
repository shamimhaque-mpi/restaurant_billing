<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sale;
use App\Models\DueCollection;
use App\Models\RestaurantTable;
use Cart;
use DB;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('backend.pages.sale.index');
    }


    public function create()
    {
        // dd(Cart::content());
        $categories = Category::where('status', 1)->orderBy('id', 'ASC')->get();
        // Cart::destroy();
        return view('backend.pages.sale.add', compact('categories'));
    }


    public function addToSale(Request $request)
    {
        $price = $request->product['regular_sale_price'] - ($request->product['regular_sale_price'] * $request->product['discount']) / 100;

        Cart::add(
            [
                "id" => $request->product['id'], 
                "name" => $request->product['title'], 
                "qty" => 1, 
                "price" => $price,
                "table"=> $request->table_no,
                "customer_mobile"=> $request->customer_mobile,
                "customer_name"=> $request->customer_name,
                "options" => [
                    "image" => $request->product['image'],
                    "regular_sale_price" => $request->product['regular_sale_price'],
                    "discount" => $request->product['discount'],
                    "table"=> $request->table_no,
                    "customer_mobile"=> $request->customer_mobile,
                    "customer_name"=> $request->customer_name,
                ],
            ]
        );

        return response()->json(['cart' => Cart::content(), 'total' => Cart::subtotal(), 'count' => Cart::count()]);
    }

    public function CastomBill($sale_id){
        $categories = Category::where('status', 1)->orderBy('id', 'ASC')->get();
        // Cart::destroy();

        $sales = DB::table('sale_products')
        ->leftJoin('products as products', 'products.id', '=', 'sale_products.product_id')
        ->leftJoin('sales as sales', 'sales.id', '=', 'sale_products.sale_id')
        ->leftJoin('admins as admins', 'sales.admin_id', '=', 'admins.id')
        ->leftJoin('restaurant_tables', 'sales.table_no', '=', 'restaurant_tables.id')
        ->where('sale_id', $sale_id)
        ->select('sale_products.*', 'products.title as title', 
            'products.regular_sale_price as regular_sale_price',
            'products.discount as product_discount', 
            'products.image as image', 'sales.customer_name as customer_name', 
            'sales.vat as vat',
            'sales.customer_mobile as customer_mobile', 
            'sales.given_money as given_money', 
            'sales.total_due', 'sales.table_no', 
            'sales.discount as discount', 
            'sales.discount_2 as discount_2', 
            'admins.name as name',
            'sales.total_price_after_discount as after_discount', 
            'restaurant_tables.name as table_name', 'sales.id as sale_id')
        ->get();

        foreach ($sales as $key => $value) {
            Cart::add(
                [
                    "id" => $value->product_id, 
                    "name" => $value->title, 
                    "qty" => (int)$value->quantity, 
                    "price" => (int)$value->price,
                    "table" => $value->table_no,
                    "customer_name" => $value->customer_name,
                    "customer_mobile" => $value->customer_mobile,
                    "options" => [
                        "image" => $value->image,
                        "regular_sale_price" => (int)$value->regular_sale_price,
                        "discount" => $value->product_discount,
                        "customer_name" => $value->customer_name,
                        "customer_mobile" => $value->customer_mobile,
                        "table_no" => $value->table_no,
                        "given_money" => (int)$value->given_money,
                        "after_discount" => (int)$value->after_discount,
                        "discount" => (int)$value->discount,
                        "discount_2" => $value->discount_2,
                        "vat" => $value->vat,
                        "sale_id" => $value->sale_id,
                        "table" => $value->table_no,
                    ]
                ]
            );
            $table_no = $value->table_no;
        }
        // dd(Cart::content());
        return view('backend.pages.sale.cus_sale', compact('categories','table_no'));
    }


    public function store(Request $request)
    {
        //
    }

    /*
    *  @view single sales
    */
    public function view($sale_id)
    {
        
        $sales = DB::table('sale_products')
        ->leftJoin('products as products', 'products.id', '=', 'sale_products.product_id')
        ->leftJoin('sales as sales', 'sales.id', '=', 'sale_products.sale_id')
        ->leftJoin('admins as admins', 'sales.admin_id', '=', 'admins.id')
        ->leftJoin('restaurant_tables', 'sales.table_no', '=', 'restaurant_tables.id')
        ->where('sale_id', $sale_id)
        ->select('sale_products.*', 'products.title as title', 'sales.customer_name as customer_name', 'sales.vat as vat',
            'sales.customer_mobile as customer_mobile', 'sales.given_money as given_money', 'sales.total_due', 'sales.table_no', 'sales.discount as discount', 'sales.discount_2 as discount_2', 'admins.name as name',
            'sales.total_price_after_discount as after_discount', 'restaurant_tables.name as table_name', 'sales.id as sale_id')
        ->get();

        return view('backend.pages.sale.view', compact('sales'));
    }


    public function edit($id)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.pages.sale.edit',compact('id', 'categories'));
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function bill ()
    {
        return view('backend.pages.sale.bill');
    }

    public function getCartItem ($table_no=null)
    {

        return response()->json(['cart' => Cart::content($table_no), 'total' => Cart::subtotalInConditon($table_no), 'count' => Cart::countInCondition($table_no)]);
    }

    public function getTable ()
    {
        
        return response()->json(RestaurantTable::get());
    }

    /**
     * update quantity of a product
     */
    public function updateCart(Request $request, $table_no=null)
    {
        Cart::update($request->rowId, $request->qty);

        return response()->json(['cart' => Cart::content($table_no), 'total' => Cart::subtotalInConditon($table_no), 'count' => Cart::countInCondition($table_no)]);
    }

    /**
     * update quantity of a product
     */
    public function updateCartPrice(Request $request)
    {
        Cart::updateprice($request->rowId, $request->price);
        // Cart::update($request->product_id, $request->price);
        return response()->json(['cart' => Cart::content(), 'total' => Cart::subtotal(), 'count' => Cart::count()]);

        // return response()->json(['cart' => Cart::content(), 'total' => Cart::subtotal(), 'count' => Cart::count()]);
    }

    /**
     * Delete cart item
     */
    public function deleteFromCart(Request $request, $table_no = null)
    {
        Cart::remove($request->rowId);

        return response()->json(['cart' => Cart::content($table_no), 'total' => Cart::subtotalInConditon($table_no), 'count' => Cart::countInCondition($table_no)]);
    }

    /**
     * allI Cart item Delete
     */

    public function allItemDelete()
    {
        Cart::destroy();
        return redirect('admin/sale/add');
    }


    public function delete($id){ 
        DB::table('sales')->where("id",$id)->delete();
        return redirect()->back();
    }
}
