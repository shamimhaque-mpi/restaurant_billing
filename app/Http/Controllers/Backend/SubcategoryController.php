<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Helpers\QueryHelper;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $subcategory = SubCategory::orderBy('status', 'desc')->orderBy('id', 'desc')->get();
        return view('backend.pages.subcategory.index',compact('subcategory'));
    }



    public function create()
    {
        $category = Category::where('status','1')->get();
        return view('backend.pages.subcategory.add',compact('category'));
    }



    public function store(Request $request)
    {

        //Validation Check
        $request->validate([
            'title'=>'required|unique:categories',
        ]);

        // This Data array Using For all Request Set in DB insert
        $data = array (
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug'  => StringHelper::createSlug($request->title, 'Category', 'slug'),
            'status' => 1
        );

        // Here simple Insert method Using For allrequest insert Data base;
        SubCategory::create($data);

        session()->flash('add_message', 'Subcategory Successfully Saved!');
        return redirect()->route('admin.subcategory.index');
    }



    public function edit($slug)
    {
        $category = Category::where('status','1')->get();
        $subcategory = Subcategory::where('slug',$slug)->first();
        return view('backend.pages.subcategory.edit',compact('subcategory','category'));
    }



    public function update(Request $request, $slug)
    {
        // Validation Check
        $request->validate([
            'title'=>'required|unique:categories,title,'.$request->id
        ]);

        $data = array (
            'title' => $request->title,
            'category_id' => $request->category_id,
            'status' => $request->status
        );

        // Set Condition
        $condition = array(
            'slug' => $slug
        );

        $sub_category = SubCategory::where('slug', $slug)->first();
        $sub_category->update($data);

        session()->flash('update_message', 'Subcategory Successfully Update!');

        return redirect()->route('admin.subcategory.index');
    }


    public function delete($slug)
    {
        SubCategory::where('slug', $slug)->update(['status' => 0]);

        session()->flash('delete_message', 'Deleted');
        return redirect()->route('admin.subcategory.index');
    }
}
