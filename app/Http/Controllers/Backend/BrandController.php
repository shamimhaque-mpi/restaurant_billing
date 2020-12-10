<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $barand = Brand::orderBy('status','desc')->orderBy('id','desc')->get();
        return view('backend.pages.brand.index',compact('barand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status','1')->get();
        $subCategory = subCategory::where('status','1')->get();
        return view('backend.pages.brand.add',compact('category','subCategory'));
    }



    public function store(Request $request)
    {
        //Validation Check
        $request->validate([
            'title'=>'required|unique:brands',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        // This Data array Using For all Request Set in DB insert
        $data = array (
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'sub_category_id'   => $request->sub_category_id,
            'slug'  => StringHelper::createSlug($request->title, 'Brand', 'slug'),
            'status' => 1
        );

        Brand::create($data);

        session()->flash('add_message', 'Brand Successfully Saved!');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = Category::where('status','1')->get();
        $subCategory = subCategory::where('status','1')->get();
        $brand = Brand::where('slug',$slug)->first();
        return view('backend.pages.brand.edit',compact('brand','category','subCategory'));
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
        // Validation Check
        $request->validate([
            'title'=>'required|unique:brands,title,'.$request->id
        ]);

        $data = array (
                'title'             => $request->title,
                'category_id'       => $request->category_id,
                'sub_category_id'   => $request->sub_category_id,
                'status' => $request->status
            );

        $sub_category = Brand::where('slug', $slug)->first();
        $sub_category->update($data);

        session()->flash('update_message', 'Brand Successfully Update!');

        return redirect()->route('admin.brand.index');
    }


    public function delete($slug)
    {
        Brand::where('slug', $slug)->update(['status' => 0]);

        session()->flash('delete_message', 'Deleted');
        return redirect()->route('admin.brand.index');

    }
}
