<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    use AuthenticatesUsers {

        logout as performLogout;

    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CUSTOMER_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest')->except('logout');
    }

    public function login() {
        return view('front.auth.login');
    }

    public function doLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Login attempt faild.');
        }

        $credentials = $request->only('email', 'password');
         if (Auth::guard('seller')->attempt($credentials)) {
            return redirect()->route('seller.dashboard');
         } else {
             return redirect()->back()->with('error', 'Invalid Credentials');
         }
    }

    // public function logout(Request $request) {

    // $this->performLogout($request);

    // return redirect()->route('login');
    // }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('index');
    }

    // public function login(Request $request)
    // {

    //     $inputVal = $request->all();

    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if(auth()->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))){
    //         if (auth()->user()->utype == 1) {
    //             dd('nasar');
    //             return redirect()->route('admin.route');
    //         }else{
    //             return redirect()->route('home');
    //         }
    //     }else{
    //         return redirect()->route('login')
    //             ->with('error','Email & Password are incorrect.');
    //     }
    // }
}
