<?php


namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Helpers\NumberHelper;
use App\Models\PurchaseItem;
use App\Models\PurchaseHistory;
use App\Models\RawMaterialCategory;
use DB;

class PurchaseItemController extends Controller
{

	/**
	* Site Access
	**/
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function item_index()
	{
		$rows = PurchaseItem::orderBy('status', 'desc')
		->orderBy('id', 'desc')
		->where('status', '!=', 9)
		->get();


		 $groups = DB::table('purchase_items')
		->leftJoin('raw_material_categories', 'purchase_items.r_m_cat_id', '=', 'raw_material_categories.id')
		->select('purchase_items.*', 'raw_material_categories.title as cat_title')
		->orderBy('raw_material_categories.title', 'desc')
		->where('purchase_items.status', '!=', 9)
		->get()
		->groupBy('cat_title');

		// dd($groups);
		return view('backend.pages.purchase.purchase_item.index', compact('rows', 'groups'));
	}

	public function item_add()
	{
		$raw_material_categories = RawMaterialCategory::get();
		return view('backend.pages.purchase.purchase_item.add', compact('raw_material_categories'));
	}

	public function item_store(Request $request)
	{
		$this->validate($request, [
			'title' => 'required',
			'regular_price' => 'required',
			'r_m_cat_id' => 'required'
		]);
		$data = $request->except(['_token']);
		QueryHelper::simpleInsert('PurchaseItem', $data);
		session()->flash('add_message', 'Added');
		return redirect()->route('admin.purchase_item.index');
	}

	public function item_edit($id)
	{
		$raw_material_categories = RawMaterialCategory::get();
		$row = PurchaseItem::where('id', $id)->first();
		return view('backend.pages.purchase.purchase_item.edit', compact('row', 'raw_material_categories'));
	}

	public function item_update(Request $request, $id)
	{
		$purchase_item = PurchaseItem::where('id', $id)->first();

		$this->validate($request, [
			'title' => 'required',
			'regular_price' => 'required',
			'r_m_cat_id' => 'required'
		]);

		$data = $request->except(['_token']);
		
		$purchase_item->update($data);
		session()->flash('update_message', 'Added');
		return redirect()->route('admin.purchase_item.index');
	}

	public function item_delete($id)
	{
		$purchase_item = PurchaseItem::where('id', $id)->first();
		$data['status'] = 9;
		$purchase_item->update($data);
		session()->flash('deactive_message', 'Deactived');
		return redirect()->route('admin.purchase_item.index');
	}






	public function index(Request $request)
	{
		$rows = PurchaseHistory::orderBy('status', 'desc');
		if($request->isMethod('post'))
		{
			$field = array('from_date' => null, 'to_date' => null, 'purchase_field_id' => null);
            $data = $request->except(['_token']);


            foreach ($data as $key => $value) 
            {
                $field[$key] = $value;
            }
            if($field['from_date'] != null && $field['to_date'] == null)
            {
                $rows = $rows->where('purchase_date', $field['from_date']);
            }
            if($field['from_date'] != null && $field['to_date'] != null )
            {
                $rows = $rows->whereBetween('purchase_date', [$field['from_date'], $field['to_date']]);
            }
            if($field['purchase_field_id'] != null)
            {
                $rows = $rows->where('purchase_item_id', $field['purchase_field_id']);
            }
		}
		$rows = $rows->orderBy('id', 'desc')
		->where('status', '!=', 9)
		->get();
		return view('backend.pages.purchase.index', compact('rows'));
	}

	public function add()
	{
		$rows = PurchaseItem::orderBy('status', 'desc')
		->orderBy('id', 'desc')
		->where('status', '!=', 9)
		->get();
		return view('backend.pages.purchase.add', compact('rows'));
	}
	
	public function store(Request $request)
	{

		$this->validate($request, [
			'purchase_item_id' => 'required',
			'price' => 'required',
			'quantity' => 'required',
			'purchase_date' => 'required',
		]);
		$data_temp = $request->except(['_token']);
		$voucher = round(microtime(true) * 1000);
		$voucher = substr($voucher, 0, 13);
		foreach ($data_temp['purchase_item_id'] as $k => $val) {
			$data['voucher'] = $voucher;
			$data['price'] = $request->price[$k];
			$data['quantity'] = $request->quantity[$k];
			$data['purchase_date'] = $request->purchase_date;
			$data['purchase_item_id'] = $request->purchase_item_id[$k];
			QueryHelper::simpleInsert('PurchaseHistory', $data);
		}
		session()->flash('add_message', 'Added');
		return redirect()->route('admin.purchase.index');
	}

	public function edit($id)
	{
		$rows = PurchaseItem::orderBy('status', 'desc')
		->orderBy('id', 'desc')
		->where('status', '!=', 9)
		->get();
		$purchase_history = PurchaseHistory::where('id', $id)->first();
		return view('backend.pages.purchase.edit', compact('rows', 'purchase_history'));
	}

	public function update(Request $request, $id)
	{
        $product_history = PurchaseHistory::where('id', $id)->first();

		$this->validate($request, [
			'purchase_item_id' => 'required',
			'price' => 'required',
			'quantity' => 'required',
			'purchase_date' => 'required',
		]);
		$data = $request->except(['_token']);

        $product_history->update($data);

        session()->flash('update_message', 'Added');
        return redirect()->route('admin.purchase.index');
	}

	public function delete($id)
	{
		$purchase_item = PurchaseHistory::where('id', $id)->first();
		$data['status'] = 9;
		$purchase_item->update($data);
		session()->flash('deactive_message', 'Deactived');
		return redirect()->route('admin.purchase.index');
	}

	public function raw_material_category_add()
	{
		$raw_material_Categories =  RawMaterialCategory::get();
		return view('backend.pages.purchase.category.add', compact('raw_material_Categories'));
	}

	public function raw_material_category_store(Request $request){

		//form validation
		$request->validate([
			'title' => 'required| unique:raw_material_categories,title'
		]);
		// get value from form
		$data = $request->except(['_token']);
		RawMaterialCategory::insert($data);

		session()->flash('add_message', 'Insert Successfull');
		return redirect()->route('admin.purchase_item.category');
	}

	public function raw_material_category_delete($id){

		RawMaterialCategory::find($id)->delete();

		session()->flash('delete_message', 'Insert Successfull');
		return redirect()->route('admin.purchase_item.category');
	}

}
