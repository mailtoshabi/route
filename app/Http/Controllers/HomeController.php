<?php

namespace App\Http\Controllers;

use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Planner;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('welcome');

    }

    public function products()
    {
        $products = Product::where('rent_type',Utility::PRODUCT_TYPE_NORMAL)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('front.pages.products',compact('products'));
    }

    public function product_details()
    {
        // $products = Product::where('rent_type',Utility::PRODUCT_TYPE_NORMAL)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('front.pages.product');
    }

    public function categories()
    {
        return view('front.pages.categories');
    }

    public function cart()
    {
        return view('front.pages.cart');
    }

    public function delivery()
    {
        return view('front.pages.delivery');
    }

    public function payment()
    {
        return view('front.pages.payment');
    }

    public function reciept()
    {
        return view('front.pages.reciept');
    }

    public function index1(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {
        return view('index');
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }

    public function login() {
        return view('auth-login');
    }

    public function handleAdmin()
    {
        return view('admin.home');
    }

    public function test() {
        // $latitude1 = 52.5200;
        // $longitude1 = 13.4050;
        // $latitude2 = 51.5074;
        // $longitude2 = -0.1278;

        // $earthRadius = 6371; // in kilometers

        // $dLat = deg2rad($latitude2 - $latitude1);
        // $dLon = deg2rad($longitude2 - $longitude1);

        // $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // $distance = $earthRadius * $c;

        // return "Distance: " . $distance . " km";







        // if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //     $ip = $_SERVER['HTTP_CLIENT_IP'];
        // } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // } else {
        //     $ip = $_SERVER['REMOTE_ADDR'];
        // }

        // $geolocation = file_get_contents('http://ip-api.com/json/'.$ip);
        // $locationData = json_decode($geolocation);

        // $latitude = $locationData->lat;
        // $longitude = $locationData->lon;

        // return "Latitude: " . $latitude . "<br>" . "Longitude: " . $longitude;





    //     $address = "Kondotty";
    //     if(!empty($address)){

    //         //Formatted address

    //         $formattedAddr = str_replace(' ','+',$address);

    //         //Send request and receive json data by address

    //         $geocodeFromAddr = file_get_contents
    // ('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');

    //         $output = json_decode($geocodeFromAddr);

    //         return  $output;

    //         //Get latitude and longitute from json data

    //         $data['latitude']  = $output->results[0]->geometry->location->lat;

    //         $data['longitude'] = $output->results[0]->geometry->location->lng;

    //         //Return latitude and longitude of the given address

    //         if(!empty($data)){

    //             $latitude = $data['latitude']?$data['latitude']:'Not found';
    //             $longitude = $data['longitude']?$data['longitude']:'Not found';

    //             return "Your Latitude:".$latitude."<br>" . "Your longitude:".$longitude."";

    //         }else{

    //             return false;

    //         }

    //     }else{

    //         return false;

    //     }



    // $number = 10.5678;
    // $formattedNumber = number_format($number, 0, '', '');
    // echo $formattedNumber; // Output: 11

    $latitude = 11.1460409; // Example latitude
    $longitude = 75.9616457; // Example longitude
    $radius = 6; // Radius in kilometers

    // $locations = Branch::withinRadius($latitude, $longitude, $radius)->get();
    // return $locations;






    // $products = Product::get();

    // $productIds = $products->pluck('id');

    // $branches = Branch::select('id')->selectRaw(
    //     '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
    //     [$latitude, $longitude, $latitude])->having('distance', '<', $radius)->get();



    // $warehouseIds = $branches->pluck('id');


    // $includedProducts = Product::whereIn('id', $productIds)
    // ->whereHas('branch', function ($query) use ($warehouseIds) {
    //     $query->whereIn('branches.id', $warehouseIds);
    // })
    // ->get();



    // return response()->json($includedProducts);

    // return $code = rand(1000, 9999);

    // Fetch all planners and group them by month
    // $planners = Planner::all()->groupBy(function($date) {
    //      Carbon::parse($date->date)->format('F'); // Group by month name
    // });
    // return $planners;


    $dates = Planner::active()->select('action_date')->distinct()->get();
    foreach($dates as $date) {
        $planners = Planner::active()->where('action_date',$date->action_date)->get();
        foreach($planners as $planner) {
            $planner->planner_type = $planner->type==1? 'Delivery':'Pickup';
        }
        $date->data = $planners;
    }
    return response()->json($dates);

    }


}
