<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        //Get All Categories
        $categories = Category::orderBy('status','desc')->orderBy('id','desc')->get();

        return view('backend.pages.category.index', compact('categories'));
    }


    public function create()
    {

        return view('backend.pages.category.add');
    }


    public function store(Request $request)
    {
        //Validation Check 
        $request->validate([
            'title' => 'required|unique:categories',
            'image' => 'required',
        ]);
        // This Code Fore Image Uploade Heare ImageUpolder is Helper
        $image = ImageUploadHelper::upload('image', $request->image, time(), 'public/images/category');
        $category_image = 'public/images/category/' . $image;
        // This Data array Using For all Request Set in DB insert   
        $data = array(
            'title' => $request->title,
            'image' => $category_image,
            'slug' => StringHelper::createSlug($request->title, 'Category', 'slug'),
            'status' => $request->status
        );
        // Heare simpoleInsert method Using For allrequest insert Data base  
        QueryHelper::simpleInsert('Category', $data);

        session()->flash('add_message', 'Category Successfully Saved!');

        return redirect()->route('admin.category.index');

    }



    public function edit($id)
    {

        $categories = Category::where('id', $id)->first();

        return view('backend.pages.category.edit', compact('categories'));
    }


    public function update(Request $request, $id)
    {

        //Validation Check 
        $request->validate([
            'title' => 'required|unique:categories,title,' . $request->id
        ]);

        $category = Category::find($request->id);

        // This Data array Using For all Request Set in DB Update   
        if ($request->image) {
            // This Code Fore Image Uploade Heare ImageUpolder is Helper   
            if ($request->old_image != null) {
                $image = ImageUploadHelper::update('image', $request->image, time(), 'public/images/category', $request->old_image);
            } else {
                $image = ImageUploadHelper::upload('image', $request->image, time(), 'public/images/category');
            }

            $category_image = 'public/images/category/' . $image;
            $category->image = $category_image;
        }


        $category->title = $request->title;
        $category->status = $request->status;
        $category->save();

        session()->flash('update_message', 'Category Successfully Update!');

        return redirect()->route('admin.category.index');

    }


    public function delete($id)
    {
        Category::where('id', $id)->update(['status' => 0]);

        session()->flash('deactive_message', 'Deactivated');
        return redirect()->route('admin.category.index');
    }
}
