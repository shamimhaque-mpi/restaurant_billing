<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\QueryHelper;
use App\Helpers\StringHelper;
use App\Helpers\NumberHelper;
use App\Models\Category;
use App\Models\Cost;
use App\Models\CostField;
use DB;

class CostController extends Controller
{

    /**
     * Site Access
    **/
    public function __construct()
    {
        $this->initalItems = 50;
        $this->middleware('auth:admin');
    }


    public function index(Request $request)
    {
        if (request()->filled('items')) {
            $items = request()->items;
        }else{
            $items = $this->initalItems;
        }

        if($request->isMethod('post')){
            $search_field = $request->except('_token');
            
            $costs = DB::table('costs')
            ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id');

            $new_search_field = [];        
            $without_date_field = [];        
            foreach ($search_field as $key => $value) {
                if($key == 'from_date'){
                    $new_search_field['from_date'] = $value; 
                } 
                if($key == 'to_date'){
                    $new_search_field['to_date'] = $value; 
                } 
                if($key == 'cost_field_id'){
                    $new_search_field['costs.cost_field_id'] = $value; 
                    $without_date_field['costs.'.$key] = $value;
                }          
            }    
            
            foreach ($new_search_field as $key => $value) {
                if($new_search_field['from_date'] && $new_search_field['to_date']){
                    $costs = $costs->whereBetween('costs.pickdate', [$new_search_field['from_date'], $new_search_field['to_date']]); 

                    foreach ($without_date_field as $key_without_date => $value_without_date) {
                        $costs = $costs->where($key_without_date, $value_without_date);       
                    }

                    break;
                }
                else if($new_search_field['from_date'] || $new_search_field['to_date']){
                    $costs = $costs->where('costs.pickdate', '=', $value);

                    foreach ($without_date_field as $key_without_date => $value_without_date) {
                        if($value_without_date != null){
                            $costs = $costs->where($key_without_date, $value_without_date);
                        }       
                    }
                    
                    break; 
                }
                else if($key != 'from_date' && $key != 'to_date'){
                    $costs = $costs->where($key, $value);
                }     
            }  

            $rows = $costs->select('costs.*', 'field.title as field_title')
            ->where('costs.status', 1)
            ->paginate($items);

            $total = $rows->total();

            // dd($costs);
            // if($request->to_date != '' || $request->from_date != ''){
            //     if($request->to_date && $request->to_date != $request->from_date){
            //         $rows = DB::table('costs')
            //             ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id')
            //             ->whereBetween('costs.created_at', [$request->from_date, $request->to_date])
            //             ->orderBy('status','desc')
            //             ->orderBy('id','desc')
            //             ->select('costs.*', 'field.title as field_title')
            //             ->paginate($items);
            //     } else {
            //         // $from_date = date('Y-m-d', strtotime($request->from_date . " +1 days"));
            //         $rows = DB::table('costs')
            //             ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id')
            //             ->whereDate('costs.created_at', '=', $request->from_date)
            //             ->orderBy('status','desc')
            //             ->orderBy('id','desc')
            //             ->select('costs.*', 'field.title as field_title')
            //             ->paginate($items);
            //         }

            //     $total = $rows->total();

            // } else {
            //     $rows = DB::table('costs')
            //     ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id')
            //     ->orderBy('status','desc')
            //     ->orderBy('id','desc')
            //     ->where('costs.cost_field_id', $request->cost_field_id)
            //     ->select('costs.*', 'field.title as field_title')
            //     ->sum('costs.price');
            //     dd($rows);
            // }

        } else {
            $rows = DB::table('costs')
            ->leftJoin('cost_fields as field', 'field.id', '=', 'costs.cost_field_id')
            ->where('costs.status', 1)
            ->orderBy('status','desc')
            ->orderBy('id','desc')
            ->select('costs.*', 'field.title as field_title')
            ->paginate($items);

            $total = $rows->total();
        }

        $cost_fields = \App\Models\Cost_field::orderBy('title', 'asc')->where('status', 1)->get();

        return view('backend.pages.cost.index', compact('rows', 'items', 'total', 'cost_fields'));
    }


    public function add()
    {
        $cost_field = \App\Models\Cost_field::orderBy('title', 'asc')->where('status', 1)->get();
        return view('backend.pages.cost.add', compact('cost_field'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'cost_field_id' => 'required',
            'cost_type' => 'required',
            'description' => 'required',
            'price' => 'required',
            'pickdate' => 'required',
        ]);

        $data = $request->except(['_token']); // this fields are not received

        QueryHelper::simpleInsert('Cost', $data); // insert into table

        session()->flash('add_message', 'Added');
        return redirect()->route('admin.cost.add');
    }


    public function edit($id)
    {
        $row = Cost::where('id', $id)->first();
        $cost_field = \App\Models\Cost_field::orderBy('title', 'asc')->where('status', 1)->get();
        return view('backend.pages.cost.edit', compact('row', 'cost_field'));
    }


    public function update(Request $request, $id)
    {  
        $cost = Cost::where('id', $id)->first();

        $this->validate($request, [
            'cost_field_id' => 'required',
            'cost_type' => 'required',
            'description' => 'required',
            'price' => 'required',
            'pickdate' => 'required',
        ]);

        $data = $request->except(['_token']); // this fields are not received

        $cost->update($data);

        session()->flash('update_message', 'Added');
        return redirect()->route('admin.cost.index');
    }


    public function delete($id)
    {
        $cost = Cost::where('id', $id)->first();
        $data['status'] = 0;
        $cost->update($data);

        session()->flash('deactive_message', 'Deactived');
        return redirect()->route('admin.cost.index');
    }
}
