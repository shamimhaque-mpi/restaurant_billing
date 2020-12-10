<?php
namespace App\Http\Controllers\Backend;

use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Cart;
use DB;

class AddToSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Save Sale record
     * destroy cart
     */
    public function index(Request $request)
    {
        if(Cart::count() > 0){
            $data = array(
                'admin_id'                       => Auth::guard('admin')->id(),
                'customer_name'                  => $request->customer_name,
                'customer_mobile'                => $request->customer_mobile,
                'given_money'                    => $request->given_money,
                'total_price_after_discount'     => $request->total_after_discount,
                'total_price'                    => Cart::subtotalInConditon($request->table_no),
                'total_product'                  => Cart::countInCondition($request->table_no),
                'discount'                       => $request->discount,
                'discount_2'                     => $request->discount_2,
                'vat'                            => $request->vat,
                'is_order'                       => $request->is_order,
                'total_due'                      => $request->total_due,
                'table_no'                       => $request->table_no,
                'pickdate'                       => date('Y-m-d')
            );
            $sale = new Sale();
            $sale = $sale->create($data);

            $sale_products = [];
            foreach(Cart::content($request->table_no) as $cart){
                $sale_products[] = array(
                    'sale_id' => $sale->id,
                    'product_id' => $cart->id,
                    'quantity' => $cart->qty,
                    'price' => round(str_replace( ',', '', $cart->price), 2)
                );
                Cart::remove($cart->rowId);
            }

            SaleProduct::insert($sale_products);

            /*
            * ***************************
            * g=givenMone
            * p=Total_after_discount
            * ************************
            */
            $g = $request->given_money;
            $p = $request->total_after_discount;
            if($g>0){
                DB::table('due_collections')->insert([
                    'sale_id' => $sale->id,
                    'date'    => date('Y-m-d'),
                    'payment' => ($g > $p ? $request->total_after_discount : $request->given_money),
                    'type'    => 'sale'
                ]);
            }
            // Cart::destroy();
        }

        return $sale;
    }

    /**
     * Save Edit Sale record
     * destroy cart
     */
    public function SaleUpdate(Request $request)
    {
        if(Cart::count() > 0){
            $data = array(
                'admin_id'                       => Auth::guard('admin')->id(),
                'customer_name'                  => $request->customer_name,
                'customer_mobile'                => $request->customer_mobile,
                'given_money'                    => $request->given_money,
                'total_price_after_discount'     => $request->total_after_discount,
                'total_price'                    => Cart::subtotalInConditon($request->table_no),
                'total_product'                  => Cart::countInCondition($request->table_no),
                'discount'                       => $request->discount,
                'discount_2'                     => $request->discount_2,
                'vat'                            => $request->vat,
                'is_order'                       => $request->is_order,
                'total_due'                      => $request->total_due,
                'table_no'                       => $request->table_no,
                'pickdate'                       => date('Y-m-d')
            );
            $sale = new Sale();
            $sale->where('id', $request->sale_id)->update($data);

            $sale_products = [];
            foreach(Cart::content() as $cart){
                $sale_products[] = array(
                    'sale_id' => $request->sale_id,
                    'product_id' => $cart->id,
                    'quantity' => $cart->qty,
                    'price' => round(str_replace( ',', '', $cart->price), 2)
                );
                Cart::remove($cart->rowId);
            }

            SaleProduct::where('sale_id', $request->sale_id)->delete();
            SaleProduct::insert($sale_products);

            // Cart::destroy();
        }

        return $request->sale_id;
    }

    public function get_single_sale($id)
    {
        $sales = DB::table('sale_products')
            ->leftJoin('products as products', 'sale_products.product_id', '=', 'products.id')
            ->leftJoin('sales as sales', 'sale_products.sale_id', '=', 'sales.id')
            ->select('sale_products.price as product_price', 'sale_products.quantity as product_quantity',
                'products.title as product_title', 'products.image as image', 'products.regular_sale_price as sale_price',
                'products.discount as discount', 'products.discount_2 as discount_2', 'sales.*', 'sale_products.id as sale_product_id',
                'sale_products.product_id as product_id')
            ->where('sale_id', $id)
            ->get();

        return $sales;
    }

    public function update_to_sale_product(Request $request)
    {
        $data = array(
            'admin_id'                   => Auth::guard('admin')->id(),
            'customer_name'              => $request->customer_name,
            'customer_mobile'            => $request->customer_mobile,
            'given_money'                => $request->given_money,
            'total_product'              => $request->totalQty,
            'total_price'                => $request->totalPrice,
            'discount'                   => $request->discount,
            'discount_2'                   => $request->discount_2,
            'vat'                        => $request->vat,
            'total_price_after_discount' => $request->total_price_after_discount
        );

        Sale::where('id',$request->sale_id)->update($data);

        SaleProduct::where('sale_id',$request->sale_id)->delete();

        $sale_products = [];
        foreach($request->products as $data){
            $sale_products[] = array(
                'sale_id' => $request->sale_id,
                'product_id' => $data['product_id'],
                'quantity' => $data['product_quantity'],
                'price' => $data['product_price']
            );
        }
        $saleProduct = new SaleProduct();
        $saleProduct::insert($sale_products);

        return 'ok';
    }


    public function delete_from_sale(Request $request)
    {
        $sale = SaleProduct::where('id',$request->id)->delete();
        return  $sale;
    }
}