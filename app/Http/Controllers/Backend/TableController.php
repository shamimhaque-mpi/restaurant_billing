<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SMSHelper;
use App\Models\Sale;
use App\Models\RestaurantTable;
use DB;

class TableController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}
	public function index()
	{
		$tables = RestaurantTable::get();
		return view('backend.pages.table.index', compact('tables'));
	}

	public function store(Request $request)
	{

		$request->validate([
			'name'=>'required',
		]);
		$data = $request->except(['_token']);
		RestaurantTable::insert($data);

		session()->flash("add_message", "Insert successfull");
		return redirect()->route('admin.sale.table');
	}

	public function delete($id)
	{
		RestaurantTable::find($id)->delete();
		session()->flash("delete_message", "Delete successfull");
		return redirect()->route('admin.sale.table');
	}

	public function edit(Request $request ,$id)
	{
		RestaurantTable::where('id', $id)->update(['name' => $request->table]);
		session()->flash("update_message", "Update successfull...");
		return redirect()->back();
	}
}