<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPostRequest;
use App\Mail\ForgetPasswordMail;
use App\Mail\GenerateOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Register(RegisterPostRequest $request){
        if($request->validated()){
            User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ]);
            return redirect(route('login_page'))->with('success','Account Created Successfully');
        }
    }
    public function Login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::viaRemember() || Auth::attempt($credentials,$request->remembertoken)){
            $request->session()->regenerate();
            return redirect()->intended(route('home_page'));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function ForgetPassword(){
        return view('forget_password');
    }
    public function ForgetPasswordPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->email)->send(new ForgetPasswordMail($token));
        session()->put('forget_success','we successfully sent an email to the entered address');
        return redirect()->back();
    }
    public function ResetPassword($token){

        $user = DB::table('password_resets')->where([
            'token' => $token
        ])->first();
        if(session()->has('forget_success') && $user){
            $token=Crypt::encrypt($token);
            return view('reset_password',compact('token'));
        }

        else
            return redirect()->route('login_page');
    }
    public function ResetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:10|confirmed',
            'password_confirmation' => 'required'
        ]);
        $token = Crypt::decrypt($request->token);
        $user = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $token
        ])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided email do not match our records.'
            ])->onlyInput('email');
        }

        User::where('email' , $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_resets')->where('email',$request->email)->delete();
        session()->forget('forget_success');
        return redirect()->route('login_page')->with('success','password resetted successfully');
    }
    public function generateOtp()
    {
        $otp=mt_rand(10000,99999);
        Mail::to(auth()->user()->email)->send(new GenerateOtpMail($otp));
        return $otp;
    }
    public function VerifyEmail()
    {
        if(auth()->user()->email_verified_at){
            return redirect()->route('login_page');
        }
        $otp=$this->generateOtp();
        $otp=Crypt::encryptString($otp);
        return view('otp',compact('otp'));
    }
    public function VerifyEmailPost(Request $request)
    {
        $request->validate([
            'otp' => 'required|min:5'
        ]);
        $otpToken=Crypt::decryptString($request->otpToken);
        if($otpToken == $request->otp){
            User::where('email',auth()->user()->email)->update([
                'email_verified_at' => Carbon::now()
            ]);
            return redirect()->route('login_page');
        }
        else {
            return back()->with('error',"otp doesn't match we have sent you a new otp please revisit your email address");
        }
    }
    public function ResendEmailPost()
    {
        $otp=$this->generateOtp();
        session()->put('success','we sent another otp to your email address');
        return view('otp',compact('otp'));
    }
    public function Logout(){
        session()->flush();
        Auth::logout();
        return redirect(route('login_page'));
    }
}
