<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;
use App\Models\Admin;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }


    public function showLinkRequestForm(Request $request)
    {
        dd($request);
        return view('backend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $data['token'] = encrypt(rand(12345,98765));
        $data['email'] = $request->email;
        $data['created_at'] = date("Y-m-d H:i:s");

        $mail_body = "
                        <span class='h3'>Password Reset</span>:<a href='"
                                    .url('/').
                                    '/admin/password/reset/'
                                    .$data['token'].
                                    "'>click to reset</a>
                    ";
        $check = Admin::where('email', $data['email'])->first();

        if ($check) {

            Mail::send(array(), array(), function ($message) use ($request, $mail_body, $data, $check) {
                $mail_subject = 'Password Reset - '.$check->name;

                $mail_to_name = $check->name;
                $mail_to_address = $data['email'];

                $mail_from_name = env('APP_NAME');
                $mail_from_address = env('MAIL_USERNAME');

                $message->to($mail_to_address, $mail_to_name)
                        ->subject($mail_subject)
                        ->from($mail_from_address, $mail_from_name)
                        ->setBody($mail_body, 'text/html');
            });
            PasswordReset::insert($data);
            session()->flash('reset_send', 'Check Email...');
            return redirect()->route('admin.login');
        } else {
            return "Email not Found !";
        }
    }


    public function broker()
    {
        return Password::broker('admins');
    }
}
