<?php

namespace App\Http\Controllers\Branch\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::BRANCH_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('branch.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar' => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create()
    {
        $banks=Bank::all();
        return view('branches.auth.register',compact('banks'));
    }

    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {

            // $vat_scan=$request->file('vat_scan');
            // if($vat_scan)
            // {
            //     $vat_scan_name=time().'.'.$vat_scan->extension();
            //     $vat_scan->move(public_path('vat_scan'),$vat_scan_name);
            // }



            // $cr_number=$request->cr_number;
            // $cr_scan=$request->file('cr_scan');
            // if($cr_scan)
            // {
            //     $cr_scan_name=time().'.'.$cr_scan->extension();
            //     $cr_scan->move(public_path('cr_scan'),$cr_scan_name);
            // }

            // if($request->hasFile('image'));
            // {
            //     $destination_path='public/images/seller_logo';
            //     $image=$request->file('seller_logo');
            //     $seller_logo_name=time().'.'.$image->extension();
            //     $path=$request->file('seller_logo')->storeAs($destination_path,$seller_logo_name);
            // }

            // $seller_logo=$request->file('seller_logo');
            // if($seller_logo)
            // {
            //     $seller_logo_name=time().'.'.$seller_logo->extension();
            //     $seller_logo->storeAs('seller_logo', $seller_logo_name);


            //    // $seller_logo->move(public_path('seller_logo'),$seller_logo_name);
            // }
            $detail = new Seller();

            $detail->first_name=$request->first_name;
            $detail->last_name=$request->last_name;
            $detail->phone=$request->phone;
            $detail->email=$request->email;
            $detail->password=Hash::make($request->password);
            $detail->address=$request->address;

            $detail->legal_name=$request->legal_name;
            $detail->business_email=$request->business_email;
            $detail->vat_number=$request->vat_number;
            //$detail->vat_scan=$vat_scan_name??NULL;

            $detail->cr_number=$request->cr_number;
           // $detail->cr_scan=$cr_scan_name??NULL;



           // $detail->image=$seller_logo_name??NULL;

            $detail->bank_id=$request->bank_id;
            $detail->branch_name=$request->branch_name;
            $detail->iban_number=$request->iban_number;
            $detail->account_number=$request->account_number;

            if(request()->hasFile('vat_scan')) {
                $extension = request('vat_scan')->extension();
                $fileName = 'vat_' . date('YmdHis') . '.' . $extension;
                request('vat_scan')->storeAs('sellers/vat', $fileName);
                $detail->vat_scan=$fileName;
            }

            if(request()->hasFile('cr_scan')) {
                $extension = request('cr_scan')->extension();
                $fileName = 'cr_' . date('YmdHis') . '.' . $extension;
                request('cr_scan')->storeAs('sellers/cr', $fileName);
                $detail->cr_scan=$fileName;
            }

            if(request()->hasFile('image')) {
                $extension = request('image')->extension();
                $fileName = 'seller_pic_' . date('YmdHis') . '.' . $extension;
                request('image')->storeAs('sellers', $fileName);
                $detail->image=$fileName;
            }

            $success = $detail->save();


        });
        return redirect()->route('branch.login')->with('success', 'Registration completed successfully');
    }
}
