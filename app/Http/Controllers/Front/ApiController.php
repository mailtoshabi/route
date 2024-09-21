<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerOtp;
use App\Models\CustomerTicket;
use App\Models\Planner;
use App\Models\Product;
use App\Models\RentalType;
use App\Models\Sale;
use App\Models\ProductSale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class ApiController
{

    public function registerCustomerGenerate(Request $request) {

        $first_name = request('first_name');
        $last_name = request('last_name');
        $email = request('email');
        $phone = request('phone');
        // $password = request('password');

        // $validated = $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'string|unique:customers,email',
        //     'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:customers,phone',
        //     // 'password' => 'required|string|confirmed|min:6'
        // ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'string|unique:customers,email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:customers,phone',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }



        $customer = Customer::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            // 'password' => bcrypt($data['password'])
        ]);

        $customerOtp = $this->generateOtp($phone);

        $content = $customerOtp->otp . Utility::OTP_MESSAGE;

        // $customerOtp->sendSMS(Utility::COUNTRY_CODE . $phone);


        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sender_number = getenv("TWILIO_FROM");

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                        ->create(Utility::COUNTRY_CODE . $phone, // to
                                [
                                    "body" => $content,
                                    "from" => $sender_number
                                ]
                        );

        return response()->json([
            'message' => 'Customer Created Successfully, Enter OTP now',
            'status' => 200
        ]);
    }

    public function loginCustomerGenerate(Request $request) {
        $phone = request('phone');
        $otpCode = rand(1000, 9999);
        $description = $otpCode . Utility::OTP_MESSAGE;
        // $password = request('password');

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The Phone number deosnt exists. Click Register',
        ];
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|exists:customers,phone',
        ],$messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $customerOtp = $this->generateOtp($phone);
        $content = $customerOtp->otp . Utility::OTP_MESSAGE;
        // $customerOtp->sendSMS(Utility::COUNTRY_CODE . $phone);

        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sender_number = getenv("TWILIO_FROM");

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                        ->create(Utility::COUNTRY_CODE . $phone, // to
                                [
                                    "body" => $content,
                                    "from" => $sender_number
                                ]
                        );

        return response()->json([
            'message' => 'Customer exists, Enter OTP now',
            'status' => 200
        ]);
    }

    public function otpAuthenticate(Request $request)
    {
        /* Validation */
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $customer = Customer::where('phone',$request->phone)->first();

        if(!$customer){
            return response()->json([
                'message' => 'Phone number and OTP doesnt match',
                'status' => 401
            ]);
        }

        /* Validation Logic */
        $customerOtp   = CustomerOtp::where('customer_id', $customer->id)->where('otp', $request->otp)->first();



        $now = now();
        if (!$customerOtp) {
            return response()->json([
                'message' => 'Your OTP is not correct',
                'status' => 401
            ]);
        }else if($customerOtp && $now->isAfter($customerOtp->expire_at)){
            return response()->json([
                'message' => 'Your OTP has been expired',
                'status' => 401
            ]);
        }

        if($customer){

            $customerOtp->delete();

            $token = $customer->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'token' => 'Bearer '. $token,
                'message' => 'Customer Logged In Successfully',
                'status' => 200
            ]);
        }

        return response()->json([
            'message' => 'Your OTP is not correct',
            'status' => 401
        ]);
    }

    public function generateOtp($phone)
    {
        $customer = Customer::where('phone', $phone)->first();

        /* Customer Does not Have Any Existing OTP */
        $customerOtp = CustomerOtp::where('customer_id', $customer->id)->latest()->first();

        $now = now();

        if($customerOtp && $now->isBefore($customerOtp->expire_at)){
            return $customerOtp;
        }

        /* Create a New OTP */
        return CustomerOtp::create([
            'customer_id' => $customer->id,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(10)
        ]);
    }

    // public function loginCustomer(Request $request) {
    //     $data = $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string|min:6'
    //     ]);

    //     $customer = Customer::where('email',request('email'))->first();
    //     if(Hash::check(request('password'),$customer->password)) {
    //         $tokenResult = $customer->createToken('Personal Access Token');
    //         $token = $tokenResult->plainTextToken;
    //         return response()->json([
    //             'token' => 'Bearer '. $token,
    //             'message' => 'Credentials are valid',
    //             'status' => 200
    //         ]);
    //     }else {
    //         return response()->json([
    //             'message' => 'Password is not valid',
    //             'status' => 401
    //         ]);
    //     }
    // }

    public function getCustomerProfile() {
        $customerId = auth()->guard('customer-api')->user()->id;
        // $customerId = Auth::guard('customer-api')->user()->id;
        $customer = Customer::find($customerId);
        return response()->json(
            [
                'status' => 200,
                'data' => $customer,
                'message' => 'Customer details'
            ]
        );
    }

    public function getActiveOrders () {
        $customerId = auth()->guard('customer-api')->user()->id;

        $orders = Sale::with('product_sales')->active()->where('customer_id',$customerId)->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $orders,
                'message' => 'List of Active Orders'
            ]
        );
    }

    public function getPreviousOrders () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $orders = Sale::with('product_sales')->archive()->where('customer_id',$customerId)->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $orders,
                'message' => 'List of Previous Orders'
            ]
        );
    }

    public function getOrderDetails(Request $request) {
        $customerId = auth()->guard('customer-api')->user()->id;
        $order_id = decrypt($request->encrypted_id);
        $order = Sale::find($order_id);
        return response()->json(
            [
                'status' => 200,
                'data' => $order,
                'message' => 'Details of Order'
            ]
        );
    }

    public function getwarehouses () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $warehouses = Branch::where('customer_id',$customerId)->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $warehouses,
                'message' => 'List of warehouses'
            ]
        );
    }

    public function addWarehouse(Request $request) {
        $customerId = auth()->guard('customer-api')->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:branches,name',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }

        $input = request()->all();
        $input['customer_id'] =$customerId;
        $branch = Branch::create($input);
        return response()->json(
            [
                'status' => 200,
                'data' => $branch,
                'message' => 'Warehouse Added successfully'
            ]
        );
    }

    public function addListing(Request $request) {
        $customerId = auth()->guard('customer-api')->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'sub_category_id' => 'required',
            'branch_id' => 'required',
            'price_day' => 'required',
            'price_week' => 'required',
            'price_month' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 401
            ]);
        }
        $input = request()->all();
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'product_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }
        $product = Product::create($input);
        return response()->json(
            [
                'status' => 200,
                'data' => $product,
                'message' => 'Listing Item Added successfully'
            ]
        );
    }

    public function getCustomerOpenTickets () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $tickets = CustomerTicket::open()->where('customer_id',$customerId)->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $tickets,
                'message' => 'List of open tickets'
            ]
        );
    }

    public function getCustomerclosedTickets () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $tickets = CustomerTicket::closed()->where('customer_id',$customerId)->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $tickets,
                'message' => 'List of closed tickets'
            ]
        );
    }

    public function getCustomerListing() {
        $customerId = auth()->guard('customer-api')->user()->id;
        $products = Product::where('products.status',Utility::ITEM_ACTIVE)
        ->join('branches','products.branch_id','=','branches.id')
        ->join('customers','branches.customer_id','=','customers.id')
        ->where('branches.customer_id','=',$customerId)
        ->select('products.*')->paginate(Utility::PAGINATE_COUNT);
        return response()->json(
            [
                'status' => 200,
                'data' => $products,
                'message' => 'List of Customer Listing'
            ]
        );
    }

    public function getCustomerSales() {
        $customerId = auth()->guard('customer-api')->user()->id;
        $product_sales = ProductSale::with('sale.customer')->where('product_sale.status','!=','')
        ->join('products','product_sale.product_id','=','products.id')
        ->join('branches','products.branch_id','=','branches.id')
        ->join('customers','branches.customer_id','=','customers.id')
        ->where('branches.customer_id','=',$customerId)
        ->select('product_sale.*')->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $product_sales,
                'message' => 'List of Sales'
            ]
        );
    }

    public function getCustomerSaleDetail(Request $request) {
        $sale_id = decrypt($request->sale_encrypted_id);
        $product_sale = ProductSale::find($sale_id);
        if($product_sale) {
            return response()->json(
                [
                    'status' => 200,
                    'data' => ['sales'=>$product_sale->makeHidden('sale','customer'), 'customer'=> $product_sale->sale->customer],
                    'message' => 'Details of Sales'
                ]
            );
        }else {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Something went wrong'
                ]
            );
        }

    }

    public function confirmCustomerSale(Request $request) {
        $sale_id = decrypt($request->sale_encrypted_id);
        $product_sale = ProductSale::find($sale_id);
        if($product_sale) {
            $product_sale->update(['is_confirmed'=>1]);
            return response()->json(
                [
                    'status' => 200,
                    'data' => $product_sale,
                    'message' => 'Sale Confirmed'
                ]
            );
        }else {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Something went wrong'
                ]
            );
        }
    }

    public function mySales() {
        $customerId = auth()->guard('customer-api')->user()->id;
        $product_sales = ProductSale::with('sale.customer')->where('product_sale.status','!=','')
        ->join('products','product_sale.product_id','=','products.id')
        ->join('branches','products.branch_id','=','branches.id')
        ->join('customers','branches.customer_id','=','customers.id')
        ->where('branches.customer_id','=',$customerId)
        ->select('product_sale.*')->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $product_sales,
                'message' => 'List of My Sales'
            ]
        );
    }

    public function takeRentItem () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $rentItem = Product::find(request('product_item'));
        $date_from = request('date_from');
        $date_to = request('date_to');
        $delivery_location = request('delivery_location');
        //insert to sale table and sale item table
        return response()->json(
            [
                'status' => 200,
                // 'data' => $orders,
                'message' => 'List of Categories'
            ]
        );
    }

    public function getPlanner() {
        $customerId = auth()->guard('customer-api')->user()->id;
        $dates = Planner::where('planners.status',1)
        ->join('product_sale','planners.product_sale_id','=','product_sale.id')
        ->join('products','product_sale.product_id','=','products.id')
        ->join('branches', function ($join) use($customerId) {
            $join->on('products.branch_id', '=', 'branches.id')
            ->where('branches.customer_id','=',$customerId);
        })
        ->join('customers','branches.customer_id','=','customers.id')
        ->select('planners.action_date')->distinct()->get();

        foreach($dates as $date) {
            $planners = Planner::where('planners.status',1)->where('action_date',$date->action_date)
            ->join('product_sale','planners.product_sale_id','=','product_sale.id')
            ->join('products','product_sale.product_id','=','products.id')
            ->join('branches', function ($join) use($customerId) {
            $join->on('products.branch_id', '=', 'branches.id')
            ->where('branches.customer_id','=',$customerId);
            })
            ->join('customers','branches.customer_id','=','customers.id')
            ->select('planners.*','product_sale.*','product_sale.id as encrypted_id')->get();
            foreach($planners as $planner) {
                $planner->planner_type = $planner->type==1? 'Delivery':'Pickup';
                $planner->sale_encrypted_id = encrypt($planner->encrypted_id);
            }
            $date->sales = $planners;
            $date->sales->makeHidden(['sale_id','product_id','date','price','vat','delivery_charge','rent_term_id','is_paid','is_confirmed','is_refundable','date_ready','date_accepted','date_dispatched','date_out_delivery','date_delivered','date_closed','date_onhold','date_cancelled','status_delivery','status_pickup']);
        }


        return response()->json(
            [
                'status' => 200,
                'data' => $dates,
                'message' => 'List of Planners'
            ]
        );
    }




    public function getProductTypes () {

        $rental_types = RentalType::active()->oldestById()->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $rental_types,
                'message' => 'List of rental types'
            ]
        );
    }

    public function getDefaultCategories () {
        $default_rental_type = RentalType::active()->oldestById()->first();

        $rental_type = RentalType::find($default_rental_type->id);

        return response()->json(
            [
                'status' => 200,
                'default_categories' => $rental_type->categories,
                'message' => 'List of Categories'
            ]
        );
    }

    public function getCategories () {

        $rental_type = RentalType::find(request('product_type_id'));

        return response()->json(
            [
                'status' => 200,
                'categories' => $rental_type->categories,
                'message' => 'List of Categories'
            ]
        );
    }

    public function getDefaultSubCategories () {
        $default_rental_type = RentalType::active()->oldestById()->first();
        $default_category = Category::where('rental_type_id',$default_rental_type->id)->active()->oldestById()->first();

        $category = Category::find($default_category->id);
        return response()->json(
            [
                'status' => 200,
                'default_subcategories' => $category->sub_categories,
                'message' => 'List of sub categories'
            ]
        );
    }

    public function getSubCategories () {
        $category = Category::find(request('category_id'));
        return response()->json(
            [
                'status' => 200,
                'subcategories' => $category->sub_categories,
                'message' => 'List of sub categories'
            ]
        );
    }



    // create getSubCategory function

    // public function getCategories () {
    //     $categories = Category::active()->get();
    //     return response()->json(
    //         [
    //             'status' => 200,
    //             'data' => $categories,
    //             'message' => 'List of Categories'
    //         ]
    //     );
    // }

    public function getProducts () {

        $products = Product::where('sub_category_id',request('sub_category_id'))->active()->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $products,
                'message' => 'List of Products'
            ]
        );
    }

    public function getAllProductItems () {

        $products = Product::active()->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $products,
                'message' => 'List of Products'
            ]
        );
    }

    public function getAvailableProductItems (Request $request) {
        $products = Product::active()->where('is_available',1);
        if ($request->has('rent_date')) {
            $products->whereDate('available_at', '<=', $request->rent_date);
        }
        $products = $products->get();
        return response()->json(
            [
                'status' => 200,
                'data' => $products,
                'message' => 'List of Categories'
            ]
        );
    }

    public function getFilterProducts (Request $request) {
        $type = $request->type;
        $category = $request->category;
        $sub_category_id = $request->subcategory;
        $price_min = $request->priceFrom;
        $price_max = $request->priceTo;
        $products = Product::where('products.status',Utility::ITEM_ACTIVE)
        ->whereBetween(Utility::DEFAULT_PRICE, [$price_min, $price_max])
        ->join('sub_categories', function ($join) use($sub_category_id) {
            $join->on('products.sub_category_id', '=', 'sub_categories.id')
                ->where('products.sub_category_id', $sub_category_id);
        })

        ->select('products.*')->paginate(Utility::PAGINATE_COUNT);
        return response()->json(
            [
                'status' => 200,
                'data' => $products,
                'message' => 'List of products'
            ]
        );

    }

    // public function getProductOnDate_T (Request $request) {
    //     $sub_category_id = $request->sub_category_id;
    //     $price_min = $request->priceFrom;
    //     $price_max = $request->priceTo;
    //     $startDate = $request->date_start;
    //     $endDate = $request->date_end;
    //     $products = Product::where('products.status',Utility::ITEM_ACTIVE)
    //     ->whereBetween(Utility::DEFAULT_PRICE, [$price_min, $price_max])
    //     ->join('sub_categories', function ($join) use($sub_category_id) {
    //         $join->on('products.sub_category_id', '=', 'sub_categories.id')
    //             ->where('products.sub_category_id', $sub_category_id);
    //     })
    //     ->join('product_sale', function ($join) use($startDate,$endDate) {
    //         $join->on('products.id', '=', 'product_sale.product_id')
    //         ->where(function ($query) use ($startDate, $endDate) {
    //             $query->whereNotBetween('product_sale.starts_at', [$startDate, $endDate])
    //                   ->whereNotBetween('product_sale.ends_at', [$startDate, $endDate])
    //                   ->orWhere(function($query) use ($startDate, $endDate) {
    //                     $query->where('start_date', '<=', $startDate)
    //                           ->where('end_date', '>=', $endDate);
    //                 });
    //         });
    //     })
    //     ->select('products.*')->paginate(Utility::PAGINATE_COUNT);
    //     return $products;
    // }

    public function getProductOnDate (Request $request) {
        $sub_category_id = $request->sub_category_id;
        $price_min = $request->priceFrom;
        $price_max = $request->priceTo;
        $startDate = $request->date_start;
        $endDate = $request->date_end;

        $products = Product::where('products.status',Utility::ITEM_ACTIVE);
        $products = $products->whereBetween(Utility::DEFAULT_PRICE, [$price_min, $price_max])
        ->join('sub_categories', function ($join) use($sub_category_id) {
            $join->on('products.sub_category_id', '=', 'sub_categories.id')
                ->where('products.sub_category_id', $sub_category_id);
        })->select('products.*')->get();


        $sales = ProductSale::where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('starts_at', [$startDate, $endDate])
                      ->orWhereBetween('ends_at', [$startDate, $endDate])
                      ->orWhere(function($query) use ($startDate, $endDate) {
                        $query->where('starts_at', '<=', $startDate)
                              ->where('ends_at', '>=', $endDate);
                    });
            })->get();

            $availableProducts = [];

            foreach ($products as $product) {
                $isDateAvailable = true;
                foreach ($sales as $sale) {
                    if ($sale->product_id == $product->id) {
                        $isDateAvailable = false;
                        break;
                    }
                }
                if ($isDateAvailable) {
                    $availableProducts[] = $product;
                }
            }

            return response()->json(
                [
                    'status' => 200,
                    'data' => $availableProducts,
                    'message' => 'List of products'
                ]
            );
    }

    public function getSortProducts (Request $request) {
        $sub_category_id = $request->sub_category_id;
        $price_min = $request->priceFrom;
        $price_max = $request->priceTo;
        $sort_by = $request->sort_by; // price_highest/price_lowest/rating_highest/rating_lowest
        $startDate = $request->date_start;
        $endDate = $request->date_end;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $products = Product::where('products.status',Utility::ITEM_ACTIVE);

        if($request->has('sub_category_id')) {
            $products = $products->join('sub_categories', function ($join) use($sub_category_id) {
                $join->on('products.sub_category_id', '=', 'sub_categories.id')
                    ->where('products.sub_category_id', $sub_category_id);
            });
        }

        if (($request->has('priceFrom')) && ($request->has('priceTo'))) {
            $products = $products->whereBetween(Utility::DEFAULT_PRICE, [$price_min, $price_max]);
        }

        if ($request->has('sort_by')) {

            if(($sort_by=='rating_lowest') || ($sort_by=='rating_highest')) {
                $products = $products->with('product_reviews')->select('products.*', DB::raw('AVG(product_reviews.rating) as average_rating'));
            }else {
                $products = $products->select('products.*');
            }

            if($sort_by=='price_lowest') {
                $products = $products->orderBy(Utility::DEFAULT_PRICE,'asc');
            }else if($sort_by=='price_highest') {
                $products = $products->orderBy(Utility::DEFAULT_PRICE,'desc');
            }else if($sort_by=='rating_highest') {
                $products = $products->leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
                ->groupBy('products.id')->orderBy('average_rating', 'desc');
            }else if($sort_by=='rating_lowest') {
                $products = $products->leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
                ->groupBy('products.id')->orderBy('average_rating', 'asc');
            }

        }else {
            $products = $products->select('products.*');
        }

        // $products->paginate(Utility::PAGINATE_COUNT);
        $products = $products->get();



        if (($request->has('latitude')) && ($request->has('longitude'))) {
            $productIds = $products->pluck('id');

            $branches = Branch::select('id')->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$latitude, $longitude, $latitude])->having('distance', '<', Utility::DEFAULT_LOCATION_RADIUS)->get();

            $warehouseIds = $branches->pluck('id');

            $products = Product::whereIn('id', $productIds)
                                ->whereHas('branch', function ($query) use ($warehouseIds) {
                                    $query->whereIn('branches.id', $warehouseIds);
                                })->get();

        }

        $availableProducts = $products;

        if (($request->has('date_start')) && ($request->has('date_end'))) {

            $availableProducts = [];
            $sales = ProductSale::where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('starts_at', [$startDate, $endDate])
                  ->orWhereBetween('ends_at', [$startDate, $endDate])
                  ->orWhere(function($query) use ($startDate, $endDate) {
                    $query->where('starts_at', '<=', $startDate)
                          ->where('ends_at', '>=', $endDate);
                });
            })->get();

            foreach ($products as $product) {
                $isDateAvailable = true;
                foreach ($sales as $sale) {
                    if ($sale->product_id == $product->id) {
                        $isDateAvailable = false;
                        break;
                    }
                }
                if ($isDateAvailable) {
                    $availableProducts[] = $product;
                }
            }

        }


        return response()->json(
            [
                'status' => 200,
                'data' => $availableProducts,
                'message' => 'List of products'
            ]
        );

    }

    public  function searchResults (Request $request) {
        $term = $request->search_term;
        if (!empty($term)) {
            $products = Product::where('status',Utility::ITEM_ACTIVE);
            $products = $products->where('name', 'like', '%'.$term.'%')->get();
            if(count($products)!=0) {
                return response()->json(
                    [
                        'status' => 200,
                        'data' => $products,
                        'message' => 'List of searched products'
                    ]
                );
            }else {
                return response()->json(
                    [
                        'status' => 401,
                        'message' => 'No products found.'
                    ]
                );
            }

        }else {
            return response()->json([
                'message' => 'No search keyword entered',
                'status' => 401
            ]);
        }
    }

    public function getProductDetails (Request $request) {
        $slug = $request->slug;
        $product = Product::where('slug',$slug)->first();
        $customer = $product->branch->customer;
        $customer['rating'] = $customer->my_review;
        $customer['review_count'] = $customer->reviews->count();
        $product_reviews = $product->product_reviews;
        $customer_id = $customer->id;
        $otherItems = Product::where('products.status',Utility::ITEM_ACTIVE)
        // ->join('branches','products.branch_id','=','branches.id')
        // ->where('products.slug' != $slug)
        ->join('branches', function ($join) use($customer_id) {
            $join->on('products.branch_id', '=', 'branches.id')
            ->where('branches.customer_id','=',$customer_id);
        })
        ->join('customers','branches.customer_id','=','customers.id')
        // ->where('branches.customer_id','=',$customer->id)
        ->select('products.*')->get();
        return response()->json(
            [
                'status' => 200,
                'data' => ['product'=>$product->makeHidden('branch','product_reviews'), 'seller'=>$customer->makeHidden('reviews'), 'product_reviews'=>$product_reviews,'other_products'=>$otherItems],
                'message' => 'Product Details'
            ]
        );
    }

    public function rentBooking (Request $request) {
        $slug = $request->slug;
        $startDate = $request->date_start;
        $endDate = $request->date_end;
        $selected_price_type = $request->selected_price_type;
        $selected_price = $request->selected_price;

        $product = Product::where('slug',$slug)->first();
        $customerId = auth()->guard('customer-api')->user()->id;
        $customer = Customer::find($customerId);

        return response()->json(
            [
                'status' => 200,
                'data' => ['product'=>$product, 'customer'=>$customer, 'selected_date'=>$startDate . ' - ' . $endDate, 'selected_price_type'=>$selected_price_type, 'selected_price'=>$selected_price],
                'message' => 'Proceed to checkout now'
            ]
        );
    }

    public function confirmOrder (Request $request) {
        $slug = $request->slug;
        $startDate = $request->date_start;
        $endDate = $request->date_end;
        $selected_price_type = $request->selected_price_type;
        $selected_price = $request->selected_price;
        $pay_method = $request->pay_method;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $product = Product::where('slug',$slug)->first();
        $customerId = auth()->guard('customer-api')->user()->id;
        $customer = Customer::find($customerId);

        $input = request()->except(['slug','date_start','date_end','selected_price_type','selected_price']); //'customer_id','sub_total','is_delivery','delivery_charge_total',
        $input['customer_id'] =$customerId;
        $input['sub_total'] =$selected_price; //TODO: calculate price based on day, week, month
        // $input['is_delivery'] =$selected_price;
        $sale = Sale::create($input);

        $input_sale = [];
        $input_sale['sale_id'] =$sale->id;
        $input_sale['product_id'] =$product->id;
        $input_sale['invoice_no'] = 'INV1254';
        $input_sale['price'] =$selected_price; //TODO: calculate price based on day, week, month
        $input_sale['starts_at'] = $startDate;
        $input_sale['ends_at'] = $endDate;
        $product_sale =ProductSale::create($input_sale);

        return response()->json(
            [
                'status' => 200,
                'message' => 'Sales recorded successfully'
            ]
        );
    }

    public function logout()
    {
        $customerId = auth()->guard('customer-api')->user()->id;
        $customer = Customer::find($customerId);
        $customer->tokens()->delete();
        return response()->json(
            [
                'status' => 200,
                'message' => 'Customer Logged out Successfully'
            ]
        );
    }

    public function getSupportCategories () {

        $ticket_types = Utility::ticket_types();

        return response()->json(
            [
                'status' => 200,
                'categories' => $ticket_types,
                'message' => 'List of Support Ticket Categories'
            ]
        );
    }

    public function getSupportTickets () {
        $customerId = auth()->guard('customer-api')->user()->id;
        $tickets = CustomerTicket::where('customer_id',$customerId)->where('open',1)->get();

        return response()->json(
            [
                'status' => 200,
                'categories' => $tickets,
                'message' => 'List of Support Tickets'
            ]
        );
    }




    // public function login () {
    //     $credentials = request(['email','password']);
    //         if(!Auth::attempt($credentials))
    //         {
    //         return response()->json([
    //             'message' => 'Unauthorized',
    //             'status' => 401
    //         ],401);
    //         }

    //     $customer = Customer::where('email',request('email'))->first();
    //     $tokenResult = $customer->createToken('Personal Access Token');
    //     $token = $tokenResult->plainTextToken;

    //     return response()->json([
    //         'accessToken' =>$token,
    //         'token_type' => 'Bearer',
    //         'message' => 'Authorized',
    //         'status' => 200
    //         ],200);
    // }
}
