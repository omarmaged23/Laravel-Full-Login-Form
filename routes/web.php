<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login_page')->middleware('notAuth');

Route::get('/register', function () {
    return view('register');
})->name('register_page')->middleware('notAuth');

Route::post('/register',[UserController::class,'Register'])->name('register.post');
Route::post('/login',[UserController::class,'Login'])->name('login.post');

Route::get('/home', function () {
    return view('home');
})->name('home_page')->middleware(['auth','verifyEmail']);

Route::get('/logout',[UserController::class,'Logout'])->name('logout')->middleware('auth');

Route::get('/forget',[UserController::class,'ForgetPassword'])->name('forget_password_page')->middleware('notAuth');
Route::post('/forget',[UserController::class,'ForgetPasswordPost'])->name('forget_password_post');

Route::get('/reset/{token}',[UserController::class,'ResetPassword'])->name('reset_password_page')->middleware('notAuth');
Route::post('/reset',[UserController::class,'ResetPasswordPost'])->name('reset_password_post');

Route::get('/verify-email',[UserController::class,'VerifyEmail'])->name('verify_email_page')->middleware('auth');
Route::post('/verify-email/send',[UserController::class,'VerifyEmailPost'])->name('verify_email_post');
Route::post('/verify-email/resend',[UserController::class,'ResendEmailPost'])->name('resend_email_post');
