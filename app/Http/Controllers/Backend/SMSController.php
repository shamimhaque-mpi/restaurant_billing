<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SMSHelper;
use App\Models\Sale;
use DB;

class SMSController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	
	public function sendSMS(Request $request)
	{
		$users = Sale::where('customer_mobile', '!=', null)->get()->toArray();
		
		return view('backend.pages.sms.send', compact('users'));
	}


	public function submitSendSMS(Request $request)
	{
		foreach($request->mobile_no as $mobile_no){
			$success = SMSHelper::sendSMS($mobile_no, $request->message, $request->message_length);
		}

		if($success){
			session()->flash('sending_success', "Successfully Send");
		}
		else{
			session()->flash('sending_failed', "Something went wrong");
		}

		return redirect()->route('admin.sms.send');
	}


	public function customSMS(Request $request)
	{
		$success = '';
		if($request->isMethod('post')){
			$all_mobile_no = explode(',', $request->mobile_no);
			foreach($all_mobile_no as $mobile_no){
				$success = SMSHelper::sendSMS($mobile_no, $request->message, $request->message_length);
			}

			if($success){
				session()->flash('sending_success', "Successfully Send");
			}
			else{
				session()->flash('sending_failed', "Something went wrong");
			}
			
			return redirect()->route('admin.sms.custom');
		}

		return view('backend.pages.sms.custom');
	}


	public function smsReport(Request $request)
	{
		$allSms = DB::table('sms_records')
		->leftJoin('admins as admins', 'admins.id', '=', 'sms_records.send_by')
		->select('sms_records.*', 'admins.name as send_by_user')
		->get();

		$totalSms = DB::table('sms_records')
		->where('is_send', 1)
		->sum('sms_count');			

		return view('backend.pages.sms.report', compact('allSms', 'totalSms'));
	}
}
