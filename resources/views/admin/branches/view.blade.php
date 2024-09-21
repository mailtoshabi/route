@extends('layouts.master')
@section('title') @lang('translation.Branch_Details') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Branch_Manage') @endslot
@slot('li_2') @lang('translation.Branch_Details') @endslot
@slot('title') Details of {{ $branch->name }} @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <a href="javascript: void(0);" class="text-primary">Joined on {{ $branch->created_at->format('d-m-Y') }}</a>
                            <h4 class="mt-1 mb-3">{{ $branch->name }}</h4>

                            {{-- <p class="text-muted float-start me-3">
                                @for ($x=1;$x<=$branch->my_review; $x++)
                                    <i class="bx bxs-star text-warning"></i>
                                @endfor
                                @for ($x=1;$x<=(Utility::MAX_REVIEW_LIMIT-$branch->my_review); $x++)
                                    <span class="bx bxs-star"></span>
                                @endfor
                            </p> --}}
                            {{-- <p class="text-muted mb-4">( {{ $branch->reviews()->count() }} Review(s) )</p> --}}

                            <h6 class="text-primary"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $branch->phone }}</h6>
                            <h6 class="text-success"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $branch->email }}</h6>
                            {{-- <h5 class="mb-4">Price : <span class="text-muted me-2"><del>$240 USD</del></span> <b>$225 USD</b></h5> --}}
                            <p class="text-muted mb-0">{{ $branch->building_no }}, {{ $branch->street }}</p>
                            <p class="text-muted mb-0">{{ $branch->district }}</p>
                            <p class="text-muted mb-0">{{ $branch->city }}</p>
                            <p class="text-muted mb-4">{{ $branch->postal_code }}</p>
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
                                {{-- <div class="col-md-2 col-sm-3 col-4">
                                    <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="product-1-tab" data-bs-toggle="pill" href="#product-1" role="tab" aria-controls="product-1" aria-selected="true">
                                            <img src="{{ URL::asset('assets/images/product/img-7.png') }}" alt="" class="img-fluid mx-auto d-block rounded">
                                        </a>
                                        <a class="nav-link" id="product-2-tab" data-bs-toggle="pill" href="#product-2" role="tab" aria-controls="product-2" aria-selected="false">
                                            <img src="{{ URL::asset('assets/images/product/img-8.png') }}" alt="" class="img-fluid mx-auto d-block rounded">
                                        </a>
                                        <a class="nav-link" id="product-3-tab" data-bs-toggle="pill" href="#product-3" role="tab" aria-controls="product-3" aria-selected="false">
                                            <img src="{{ URL::asset('assets/images/product/img-7.png') }}" alt="" class="img-fluid mx-auto d-block rounded">
                                        </a>
                                        <a class="nav-link" id="product-4-tab" data-bs-toggle="pill" href="#product-4" role="tab" aria-controls="product-4" aria-selected="false">
                                            <img src="{{ URL::asset('assets/images/product/img-8.png') }}" alt="" class="img-fluid mx-auto d-block rounded">
                                        </a>
                                    </div>
                                </div> --}}
                                <div class="col-md-6 offset-md-1 col-sm-9 col-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                            <div>
                                                <img src="https://place-hold.it/800x800?text={{ $branch->first_name }}&fontsize=40" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane fade" id="product-2" role="tabpanel" aria-labelledby="product-2-tab">
                                            <div>
                                                <img src="{{ URL::asset('assets/images/product/img-8.png') }}" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-3" role="tabpanel" aria-labelledby="product-3-tab">
                                            <div>
                                                <img src="{{ URL::asset('assets/images/product/img-7.png') }}" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-4" role="tabpanel" aria-labelledby="product-4-tab">
                                            <div>
                                                <img src="{{ URL::asset('assets/images/product/img-8.png') }}" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('admin.customers.order',encrypt($branch->id)) }}" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                            Active Orders
                                        </a>
                                        <a href="{{ route('admin.customers.history.order',encrypt($branch->id)) }}" class="btn btn-success waves-effect waves-light mt-2 me-1">
                                            Order History
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                {{-- <div class="mt-5">
                    <h5 class="mb-3">Specifications :</h5>

                    <div class="table-responsive">
                        <table class="table mb-0 table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 400px;">Category</th>
                                    <td>Headphone</td>
                                </tr>
                                <tr>
                                    <th scope="row">Brand</th>
                                    <td>JBL</td>
                                </tr>
                                <tr>
                                    <th scope="row">Color</th>
                                    <td>Black</td>
                                </tr>
                                <tr>
                                    <th scope="row">Connectivity</th>
                                    <td>Bluetooth</td>
                                </tr>
                                <tr>
                                    <th scope="row">Warranty Summary</th>
                                    <td>1 Year</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <!-- end Specifications -->

                {{-- <div class="mt-5">
                    <h5>Reviews :</h5>
                    @foreach ( $reviews as $review )
                        <div class="mt-4 border p-4">

                            <div class="row">
                                <div class="col-xl-3 col-md-5">
                                    <div>
                                        <div class="d-flex">
                                            <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" class="avatar-sm rounded-circle" alt="img" />
                                            <div class="flex-1 ms-4">
                                                <h5 class="mb-2 font-size-15 text-primary">{{ $review->creviewable_type=='App\Models\Customer'?$review->reviewed_by_cust->name : $review->reviewed_by_brnch->name }}</h5>
                                                <h5 class="text-muted font-size-15">{{ $review->creviewable_type=='App\Models\Customer'?$review->reviewed_by_cust->city : $review->reviewed_by_brnch->city }}</h5>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div> --}}

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
