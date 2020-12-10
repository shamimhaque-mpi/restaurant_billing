<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}


	public function index()
	{
		$myAdmines = Admin::orderBy('status','desc')->orderBy('id','desc')->get();
		return view('backend.pages.myAdmin.index', compact('myAdmines'));
	} 


	public function create()
	{
		return view('backend.pages.myAdmin.create');
	}


	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|unique:admins',
			'username' => 'required|unique:admins',
			'admin_role' => 'required',
			'password' => 'required',
		]);

		$data = array(
			'name' => $request->name,
			'email' => $request->email,
			'username' => $request->username,
			'admin_role' => $request->admin_role,
			'password' => Hash::make($request->password),
			'status' => $request->status,
		);

		if($request->photo){
			$data['photo'] = 'public/images/admins/'.ImageUploadHelper::upload('photo', $request->file('photo'), time(), 'public/images/admins');
		}	
		
		QueryHelper::simpleInsert('Admin', $data);

		session()->flash('add_message', 'Added');
		return redirect()->route('admin.myadmin.index');
	}


	public function edit($id)
	{
		$admin = Admin::where('id', $id)->first();
		return view('backend.pages.myAdmin.edit', compact('admin'));
	}


	public function update(Request $request, $id)
	{
		$admin = Admin::where('id', $id)->first();

		$this->validate($request, [
			'name' => 'required',
			'admin_role' => 'required',
			'username' => 'required|unique:admins,username,'.$id,
			'email' => 'required|unique:admins,email,'.$id,
		]);

		$data = array(
			'name' => $request->name,
			'admin_role' => $request->admin_role,
			'username' => $request->username,
			'email' => $request->email,
			'status' => $request->status,
		);

		if ($request->password) {
			$data['password'] = Hash::make($request->password);
		}

		if($request->photo){
			if($admin->photo){
				$data['photo'] = 'public/images/admins/'.ImageUploadHelper::update('photo', $request->file('photo'), time(), 'public/images/admins', $admin->photo);
			}
			else{
				$data['photo'] = 'public/images/admins/'.ImageUploadHelper::upload('photo', $request->file('photo'), time(), 'public/images/admins');
			}
		}

		$admin->update($data);

		session()->flash('update_message', 'Added');
		return redirect()->route('admin.myadmin.index');
	}


	public function delete($slug)
	{

		$where = array('id' => $slug);
		$data = array(
			'status' => 0
		);

		QueryHelper::simpleUpdate('Admin', $data, $where);
		
		session()->flash('delete_message', 'Deleted');

		return redirect()->route('admin.myadmin.index');
	}
}
