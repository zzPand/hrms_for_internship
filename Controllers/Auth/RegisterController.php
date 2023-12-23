<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register()
    {
        $role = DB::table('role_type_users')->get();
        return view('auth.register',compact('role'));
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'      => 'required|string|max:255',
            'nickname'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'edu'      => 'required|string|max:255',
            'course'      => 'required|string|max:255',
            'school'      => 'required|string|max:255',
            'resume'      => 'required|string|max:255',
            'role_name' => 'required|string|max:255',
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $dt       = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        User::create([
            'name'      => $request->name,
            'avatar'    => $request->image,
            'username'  => $request->username, // Make sure 'username' is present in your form
            'nickname'  => $request->nickname,
            'edu'  => $request->edu,
            'course'  => $request->course,
            'school'  => $request->school,
            'resume'  => $request->resume,
            'email'     => $request->email,
            'join_date' => $todayDate,
            'role_name' => $request->role_name,
            'password'  => Hash::make($request->password),
        ]);
        Toastr::success('Create new account successfully :)','Success');
        return redirect('login');
    }
}
