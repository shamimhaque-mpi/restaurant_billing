<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\QueryHelper;
use App\Helpers\FontawesomeHelper;
use App\Models\Role;
use App\Models\Menu;
use DB;

class MenuController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}


	public function index()
	{
		$menus = QueryHelper::simpleRead('Menu');
		return view('backend.pages.menu.index', compact('menus'));
	}


	public function create()
	{
		$menus = QueryHelper::simpleRead('Menu');
		return view('backend.pages.menu.add', compact('menus'));
	}


	public function store(Request $request)
	{
		//$icon = FontawesomeHelper::fontawesome($request->icon);

		$this->validate($request, [
			'menu' => 'required',
			'menu_bn' => 'required',
			'menu_position' => 'required',
			'order' => 'required',
			// 'otherMenu1' => 'required',
			// 'otherMenu2' => 'required'
		]);

		if($request->status == 1){
			$status = 1;
		}
		else{
			$status = 0;
		}

		$data = array(
			'menu'           => $request->menu,
			'menu_bn'        => $request->menu_bn,
			'parent_id'      => $request->parent_id,
			'menu_position'  => $request->menu_position,
			'icon'  		 => $request->icon,
			'url'  		     => $request->url,
			'order'  		 => $request->order,
			'route'  		 => $request->route,
			'status'         => $status
		);

		$menu = QueryHelper::simpleInsert('Menu', $data);
		$last_id = $menu;

		$parentMenu = $data['menu'];
		$parentMenuPosition = $data['menu_position'];
		$parentData = Menu::where('id', $last_id)->where('menu', $parentMenu)->where('menu', $parentMenu)->where('menu_position', $parentMenuPosition)->first();

		//$parentData = Menu::where('id', 1)->first();
		//dd($parentMenu, $parentMenuPosition, $parentData);
		if ($request->otherMenu1 && $request->otherMenu2) {
			$otherMenus = array_unique(array_merge($request->otherMenu1,$request->otherMenu2));
		} else {
			$otherMenus = [];
		}
		

		$bug_ = 1;

		if (in_array("add", $otherMenus)) {
			$bug_ = array_search('add', $otherMenus);
		}
		if (in_array("list", $otherMenus)) {
			$bug_ = array_search('list', $otherMenus) + 1;
		}
		if(in_array("action", $otherMenus)) {
			$bug_ = array_search('action', $otherMenus) + 1;
		}

		$menu = array(); $menu_bn = array(); $parent_id = array(); $menu_position = array(); $icon = array(); $url = array(); $order = array(); $route = array(); $status = array();

		if (count($otherMenus) > 0 && $parentData != null) {
			foreach ($otherMenus as $key => $otherMenu) {
				if ($otherMenu == 'add') {
					$menu[$key] = 'Add New';
					$menu_bn[$key] = 'নতুন যোগ করুন';
					$parent_id[$key] = $parentData->id;
					$menu_position[$key] = 0;
					$icon[$key] = 'fa fa-plus';
					$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'/add';
					$order[$key] = 1;
					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.add';
					$status[$key] = 1;

				}elseif ($otherMenu == 'list') {
					$menu[$key] = $parentData->menu.' List';
					$menu_bn[$key] = $parentData->menu_bn.' তালিকা';
					$parent_id[$key] = $parentData->id;
					$menu_position[$key] = 0;
					$icon[$key] = 'fa fa-list-ul';
					$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu']));
					$order[$key] = 2;
					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.index';
					$status[$key] = 1;

				}elseif ($otherMenu == 'action') {
					$menu[$key] = 'Action';
					$menu_bn[$key] = 'অ্যাকশন';
					$parent_id[$key] = $parentData->id;
					$menu_position[$key] = 0;
					$icon[$key] = 'fa fa-edit';
					$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu']));
					$order[$key] = 2;
					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.index';
					$status[$key] = 1;

				}elseif ($otherMenu == 'edit') {
					$menu[$key] = 'Edit';
					$menu_bn[$key] = 'এডিট';
					$parent_id[$key] = $parentData->id + $bug_;
					$menu_position[$key] = 1;
					$icon[$key] = 'fa fa-pencil';
					//$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'/edit';
					$url[$key] = '';

					if (in_array("view", $otherMenus)) {
						$order[$key] = 2;
					} else {
						$order[$key] = 1;
					}

					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.edit';
					$status[$key] = 1;

				}elseif ($otherMenu == 'delete') {
					$menu[$key] = 'Delete';
					$menu_bn[$key] = 'ডিলিট';
					$parent_id[$key] = $parentData->id + $bug_;
					$menu_position[$key] = 1;
					$icon[$key] = 'fa fa-trash';
					//$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'/delete';
					$url[$key] = '';

					if (in_array("view", $otherMenus)) {
						$order[$key] = 3;
					} else {
						$order[$key] = 2;
					}

					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.delete';
					$status[$key] = 1;

				}elseif ($otherMenu == 'view') {
					$menu[$key] = 'View';
					$menu_bn[$key] = 'দেখা';
					$parent_id[$key] = $parentData->id + $bug_;
					$menu_position[$key] = 1;
					$icon[$key] = 'fa fa-eye';
					//$url[$key] = 'admin/'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'/add';
					$url[$key] = '';
					$order[$key] = 1;
					$route[$key] = 'admin.'.strtolower(preg_replace("/[\-\s+]/", "_",  $data['menu'])).'.view';
					$status[$key] = 1;

				}
			}
			foreach ($otherMenus as $key => $otherMenu) {
				$data_[$key] = array(
					'menu'           => $menu[$key],
					'menu_bn'        => $menu_bn[$key],
					'parent_id'      => $parent_id[$key],
					'menu_position'  => $menu_position[$key],
					'icon'  		 => $icon[$key],
					'url'  		     => $url[$key],
					'order'  		 => $order[$key],
					'route'  		 => $route[$key],
					'status'         => $status[$key],
				);
			}
			foreach ($data_ as $key => $value) {
				$menu = QueryHelper::simpleInsert('Menu', $value);
			}
			//dd($data_);
		}
		//dd($menu, $menu_bn, $parent_id, $menu_position, $request->icon, $url, $order, $route, $status);
		if($this->getLocalLanguage()){
			session()->flash('add_message', 'Menu Information Has Been Added Successfully !!!');
		}
		else{
			session()->flash('add_message', 'মেনু সফলভাবে সংযোজন করা হয়েছে !!!');
		}
		return redirect()->route('admin.menu.index');
	}


	public function edit($id)
	{
		$menus = QueryHelper::simpleRead('Menu');
		$condition = array(
			'id' => $id
		);
		$singleMenu = QueryHelper::complexSingleRead('Menu', $condition);
		return view('backend.pages.menu.edit', compact('menus', 'singleMenu'));
	}


	public function update(Request $request, $id)
	{

		//$icon = FontawesomeHelper::fontawesome($request->icon);

		$this->validate($request, [
			'menu' => 'required',
			'menu_bn' => 'required',
			'menu_position' => 'required',
			'order' => 'required'
		]);

		if($request->status == 1){
			$status = 1;
		}
		else{
			$status = 0;
		}

		$data = array(
			'menu'           => $request->menu,
			'menu_bn'        => $request->menu_bn,
			'parent_id'      => $request->parent_id,
			'menu_position'  => $request->menu_position,
			'icon'  		 => $request->icon,
			'url'  		     => $request->url,
			'order'  		 => $request->order,
			'route'  		 => $request->route,
			'status'         => $status
		);

		$condition = array(
			'id' => $id
		);

		$menu = QueryHelper::simpleUpdate('Menu', $data, $condition);

		if($this->getLocalLanguage()){
			session()->flash('update_message', 'Menu Information Has Been Updated Successfully !!!');
		}
		else{
			session()->flash('update_message', 'মেনু সফলভাবে আপডেট করা হয়েছে !!!');
		}
		return redirect()->route('admin.menu.index');
	}


	public function delete($id)
	{
		$condition = array(
			'id' => $id
		);

		// delete menu
		QueryHelper::delete('Menu', $condition);

		$menuCondition = array(
			'parent_id' => $id
		);


		$allSubMenusForRole = QueryHelper::complexRead('Menu', $menuCondition);
		// delete the menu of role
		if($allSubMenusForRole){
			foreach($allSubMenusForRole as $role_key => $allSubMenuForRole){
				$allMenus = QueryHelper::simpleRead('Role', 'id', 'asc');

				foreach($allMenus as $menu_key => $allMenu){
					$sub_menu_arrays = json_decode($allMenu->sub_menu);

					foreach($sub_menu_arrays as $sub_menu_array_key => $sub_menu_array){
						if($sub_menu_array == $allSubMenuForRole->id){
							unset($sub_menu_arrays[$sub_menu_array_key]);
							$array = array_values($sub_menu_arrays);
							$enocde = json_encode($array);
							$data = array(
								'sub_menu' => $enocde
							);
							QueryHelper::simpleUpdate("Role", $data, array('id' => $allMenu->id));
							break;
						}
					}
				}

				$inbody_condition = array(
					'parent_id' => $allSubMenuForRole->id
				);
				QueryHelper::delete('Menu', $inbody_condition);
			}
		}

		// delete submenus for which the menu is parent menu
		QueryHelper::delete('Menu', $menuCondition);
		
		$allMenus = QueryHelper::simpleRead('Role', 'id', 'asc');
		foreach($allMenus as $menu_key => $allMenu){
			$menu_arrays = json_decode($allMenu->menu);
			$sub_menu_arrays = json_decode($allMenu->sub_menu);

			foreach($menu_arrays as $menu_array_key => $menu_array){
				if($menu_array == $id){
					unset($menu_arrays[$menu_array_key]);
					$array = array_values($menu_arrays);
					$enocde = json_encode($array);
					$data = array(
						'menu' => $enocde
					);
					QueryHelper::simpleUpdate("Role", $data, array('id' => $allMenu->id));
					break;
				}
			}

			foreach($sub_menu_arrays as $sub_menu_array_key => $sub_menu_array){
				if($sub_menu_array == $id){
					unset($sub_menu_arrays[$sub_menu_array_key]);
					$array = array_values($sub_menu_arrays);
					$enocde = json_encode($array);
					$data = array(
						'sub_menu' => $enocde
					);
					QueryHelper::simpleUpdate("Role", $data, array('id' => $allMenu->id));
					break;
				}
			}
		}

		if($this->getLocalLanguage()){
			session()->flash('delete_message', 'Menu Information Has Been Deleted Successfully !!!');
		}
		else{
			session()->flash('delete_message', 'মেনু সফলভাবে ডিলিট হয়েছে !!!');
		}
		return redirect()->route('admin.menu.index');
	}

	public function sort()
	{
		$menus = DB::table('menus')
		->where('parent_id', null)
		->where('menu_position', 0)
		->get();
		return view('backend.pages.menu.sort', compact('menus'));
	}

	public function sort_update(Request $request)
	{
		$data_ = [];
		foreach ($request->order as $key => $order) {
			$data_[$request->id[$key]] = $order;
		}

		$this->validate($request, [
			'order' => 'required'
		]);

		foreach ($data_ as $key => $data) {
			DB::table('menus')
	            ->where('id', $key)
	            ->update(['order' => $data]);
		}

		session()->flash('update_message', 'Update!!!');
		return redirect()->route('admin.menu.sort');
	}

	private function getLocalLanguage()
	{
		if(\Config::get('app.locale') == 'en'){
			return true;
		}
		else{
			return false;
		}
	}
}
