<?php


namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Helpers\NumberHelper;
use App\Models\Employee;

class EmployeeController extends Controller
{

	/**
	* Site Access
	**/
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		$rows = Employee::orderBy('id', 'desc')->where('status', 1)->get();
		return view('backend.pages.employee.index', compact('rows'));
	}

	public function add()
	{
		return view('backend.pages.employee.add');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
		'name' => 'required',
		'mobile' => 'required',
		'pre_address' => 'required',
		'per_address' => 'required',
		'nid_no' => 'required',
		'designation' => 'required',
		'salary' => 'required',
		'photo' => 'required | image | max:1024',
		]);
		$data = $request->except(['_token', 'photo']);
		$data['photo'] = 'public/images/employee/'.time().'.'.request()->photo->getClientOriginalExtension();

		request()->photo->move('public/images/employee/', $data['photo']);
		Employee::insert($data);
		session()->flash('add_message', 'Added');
		return redirect()->route('admin.employee.index');
	}

	public function edit($id)
	{
		$row = Employee::where('id', $id)->first();
		return view('backend.pages.employee.edit', compact('row'));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
		'name' => 'required',
		'mobile' => 'required',
		'pre_address' => 'required',
		'per_address' => 'required',
		'nid_no' => 'required',
		'designation' => 'required',
		'salary' => 'required',
		]);

		$data = $request->except(['_token', 'photo']);
		$Employee = Employee::where('id', $id);
		if(request()->photo != null){
			$this->validate($request, ['photo' => 'required | image | max:1024']);
			unlink($Employee->first()->photo);
			$data['photo'] = 'public/images/employee/'.time().'.'.request()->photo->getClientOriginalExtension();
			request()->photo->move('public/images/employee/', $data['photo']);
		}

		$Employee->update($data);
		session()->flash('update_message', 'Added');
		return redirect()->route('admin.employee.index');
	}

	public function delete($id)
	{
		Employee::where('id', $id)->update(['status'=> 0]);
		session()->flash('delete_message', 'deleted');
		return redirect()->route('admin.employee.index');
	}

	public function view($id)
	{
		$row = Employee::where('status', 1)->where('id', $id)->first();
		// dd($row);
		return view('backend.pages.employee.view', compact('row'));
	}
}
