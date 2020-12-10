<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Helpers\NumberHelper;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{

    /**
     * Site Access
    **/
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        
        if($request->isMethod('post')){
            $_category = $request->category__;
            $rows = Product::where('category_id', $request->category__)->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
            return view('backend.pages.product.index', compact('rows', 'categories', '_category'));
        } else {
            $_category = '';
            $rows = Product::orderBy('status', 'desc')->orderBy('id', 'desc')->get();
            return view('backend.pages.product.index', compact('rows', 'categories', '_category'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.pages.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|unique:products',
            'image' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required',
            'regular_sale_price' => 'required',
            'description' => 'required'
        ]);

        $name = time();

        // uploading image
        $image = ImageUploadHelper::uploadWithOriginalSize('image', $request->file('image'), $name, 'public/images/products');
        $original_image = 'public/images/products/'.$image;

        $data = $request->except(['_token', 'image']); // this fields are not received

        $data['image'] = $original_image;

        $data['discount'] = NumberHelper::simpleMod(NumberHelper::simpleDryString($request->discount), 100);
        $data['slug'] = StringHelper::createSlug($request->title, 'Product', 'slug'); // create slug (url)

        QueryHelper::simpleInsert('Product', $data); // insert into table

        session()->flash('add_message', 'Added');
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($slug)
    {
        $row = Product::where('slug', $slug)->first();
        return view('backend.pages.product.view', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $row = Product::where('slug', $slug)->first();
        return view('backend.pages.product.edit', compact('row', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {        
        $product = Product::where('slug', $slug)->first();

        $this->validate($request, [
            'title' => 'required|unique:products,title,'.$product->id,
            'purchase_price' => 'required',
            'regular_sale_price' => 'required',
            'description' => 'required'
        ]);
        //dd($request->image);
        if ($request->image) {
            // This Code Fore Image Uploade Heare ImageUpolder is Helper   
            if ($request->old_image != null) {
                $image = ImageUploadHelper::updateWithOriginalSize('image', $request->image, time(), 'public/images/products', $request->old_image);
            } else {
                $image = ImageUploadHelper::uploadWithOriginalSize('image', $request->image, time(), 'public/images/products');
            }

            $product_image = 'public/images/products/' . $image;
            //$category->image = $product_image;
        } else {
            $product_image = $request->old_image;
        }

        $data = $request->except(['_token', 'image']);

        $data['image'] = $product_image;
        $data['discount'] = NumberHelper::simpleMod(NumberHelper::simpleDryString($request->discount), 100);
        $data['slug'] = StringHelper::createSlug($request->title, 'Product', 'slug'); // create slug (url)
        
        $product->update($data);

        session()->flash('update_message', 'Added');
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
        $data['status'] = 0;
        $product->update($data);

        session()->flash('deactive_message', 'Deactived');
        return redirect()->route('admin.product.index');
    }
}
