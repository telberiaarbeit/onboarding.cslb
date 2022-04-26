<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function showLoginForm()
    {
        return view('auth/login');
    }
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $user = \App\Models\User::where('email', $request->get('email'))->first();

        if(!empty($user) && $user->password == md5($request->get('password'))){
            Auth::login($user, true);
            return redirect('/boarding-unterlagen');
        } else {
            Session::flash('message', 'Username or Password wrong!');
            Session::flash('alert-class', 'alert-danger');
            return back()->withInput($request->all);
        }
    }
    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect("/");
    }
    public function getRegister()
    {
        return view('auth/register');
    }
    public function username()
    {
        return 'email';
    }
    function postRegister(Request $request) {

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password'
        ]);


        $user = \App\Models\User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' =>  md5($request->get('password'))
        ]);
        
        Auth::login($user, true);
        return back()->with('success','Register account successfully');
    }
    // public function customRegistration(Request $request)
    // {  
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //     ]);
           
    //     $data = $request->all();
    //     $check = $this->create($data);
         
    //     return redirect("dashboard")->withSuccess('You have signed-in');
    // }
    // public function create(array $data)
    // {
    //   return User::create([
    //     'name' => $data['name'],
    //     'email' => $data['email'],
    //     'password' => Hash::make($data['password'])
    //   ]);
    // } 
}
