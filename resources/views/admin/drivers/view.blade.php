@extends('layouts.master')
@section('title') @lang('translation.Driver_Detail') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Shipping_Manage') @endslot
@slot('li_2') @lang('translation.Driver_Detail') @endslot
@slot('title') Details of {{ $driver->name }} @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <a href="javascript: void(0);" class="text-primary">Joined on {{ $driver->created_at->format('d-m-Y') }}</a>
                            <h4 class="mt-1 mb-3">{{ $driver->name }}</h4>

                            <p class="text-muted float-start me-3">
                                @for ($x=1;$x<=$driver->my_review; $x++)
                                    <i class="bx bxs-star text-warning"></i>
                                @endfor
                                @for ($x=1;$x<=(Utility::MAX_REVIEW_LIMIT-$driver->my_review); $x++)
                                    <span class="bx bxs-star"></span>
                                @endfor
                            </p>
                            <p class="text-muted mb-4">( {{ $driver->reviews()->count() }} Review(s) )</p>

                            <h6 class="text-primary"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $driver->phone }}</h6>
                            <h6 class="text-success"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $driver->email }}</h6>
                            {{-- <h5 class="mb-4">Price : <span class="text-muted me-2"><del>$240 USD</del></span> <b>$225 USD</b></h5> --}}
                            <p class="text-muted mb-0">{{ $driver->building_no }}, {{ $driver->street }}</p>
                            <p class="text-muted mb-0">{{ $driver->district }}</p>
                            <p class="text-muted mb-0">{{ $driver->city }}</p>
                            <p class="text-muted mb-4">{{ $driver->postal_code }}</p>
                            {{-- <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <p class="text-muted"><i class="bx bx-unlink font-size-16 align-middle text-primary me-1"></i> Wireless</p>
                                        <p class="text-muted"><i class="bx bx-shape-triangle font-size-16 align-middle text-primary me-1"></i> Wireless Range : 10m</p>
                                        <p class="text-muted"><i class="bx bx-battery font-size-16 align-middle text-primary me-1"></i> Battery life : 6hrs</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <p class="text-muted"><i class="bx bx-user-voice font-size-16 align-middle text-primary me-1"></i> Bass</p>
                                        <p class="text-muted"><i class="bx bx-cog font-size-16 align-middle text-primary me-1"></i> Warranty : 1 Year</p>
                                    </div>
                                </div>
                            </div> --}}


                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="product-detai-imgs">
                            <div class="row">
                                <div class="col-md-6 offset-md-1 col-sm-9 col-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                            <div>
                                                <img src="https://place-hold.it/800x800?text={{ $driver->name }}&fontsize=40" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <div class="text-center">
                                        <a href="{{ route('admin.customers.order',encrypt($driver->id)) }}" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                            Active Orders
                                        </a>
                                        <a href="{{ route('admin.customers.history.order',encrypt($driver->id)) }}" class="btn btn-success waves-effect waves-light mt-2 me-1">
                                            Order History
                                        </a>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="mt-5">
                    <h5 class="mb-3">Organisation Details :</h5>

                    <div class="table-responsive">
                        <table class="table mb-0 table-bordered">
                            <tbody>
                                {{-- <tr>
                                    <th scope="row" style="width: 400px;">Type</th>
                                    <td>{{ $driver->driverable_type=='App\Models\Customer'?'Customer':'Delivery Organization' }}</td>
                                </tr> --}}
                                <tr>
                                    <th scope="row">Name</th>
                                    <td><a href="{{ $driver->driverable_type=='App\Models\Customer'? route('admin.customers.view',encrypt($driver->driverable->id)) : route('admin.shippers.show',encrypt($driver->driverable->id)) }}" target="_blank">{{ $driver->driverable->name }}</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">City</th>
                                    <td>{{ $driver->driverable->city }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone</th>
                                    <td>{{ $driver->driverable->phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $driver->driverable->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end Specifications -->

                <div class="mt-5">
                    <h5>Reviews :</h5>
                    {{-- //TODO: do paginate here. ajax paginate OR do limit and give a view all button--}}
                    @foreach ( $reviews as $review )
                        <div class="mt-4 border p-4">

                            <div class="row">
                                <div class="col-xl-3 col-md-5">
                                    <div>
                                        <div class="d-flex">
                                            {{-- <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" class="avatar-sm rounded-circle" alt="img" /> --}}
                                            <div class="flex-1 ms-4">
                                                <h5 class="mb-2 font-size-15 text-primary"><a href="{{ route('admin.customers.view',encrypt($review->customer->id)) }}" target="_blank"> {{ $review->customer->name }}</a></h5>
                                                {{-- <h5 class="text-muted font-size-15">{{ $review->creviewable_type=='App\Models\Customer'?$review->reviewed_by_cust->city : $review->reviewed_by_brnch->city }}</h5> --}}
                                                {{-- <p class="text-muted">65 Followers, 86 Reviews</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-md-7">
                                    <div>
                                        <p class="text-muted mb-2">
                                            @for ($x=1;$x<=$review->rating; $x++)
                                                <i class="bx bxs-star text-warning"></i>
                                            @endfor
                                            @for ($x=1;$x<=(Utility::MAX_REVIEW_LIMIT-$review->rating); $x++)
                                                <span class="bx bxs-star"></span>
                                            @endfor
                                            <span class="ms-3"><i class="far fa-calendar-alt text-primary me-1"></i> {{ $review->created_at->format('d/m/Y') }}</span>
                                        </p>

                                        <p class="text-muted">{{ $review->description }}</p>
                                        {{-- <ul class="list-inline float-sm-end mb-sm-0">
                                            <li class="list-inline-item">
                                                <a href="javascript: void(0);"><i class="far fa-thumbs-up me-1"></i> Like</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript: void(0);"><i class="far fa-comment-dots me-1"></i> Comment</a>
                                            </li>
                                        </ul> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
        <!-- end card -->
    </div>
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
