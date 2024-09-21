@extends('layouts.master')
@section('title') @lang('translation.Vednor_Details') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Vendor_Manage') @endslot
@slot('li_2') @lang('translation.Vednor_Details') @endslot
@slot('title') Details of {{ $seller->name }} @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <h4 class="mt-1 mb-0">{{ $seller->name }}</h4>
                            <a href="javascript: void(0);" class="text-primary">Joined on {{ $seller->created_at->format('d-m-Y') }}</a><br><br>


                            <h6 class="text-primary"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $seller->phone }}</h6>
                            <h6 class="text-success"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $seller->email }}</h6>
                            {{-- <h5 class="mb-4">Price : <span class="text-muted me-2"><del>$240 USD</del></span> <b>$225 USD</b></h5> --}}
                            <p class="text-muted mb-0">{{ $seller->building_no }}, {{ $seller->street }}</p>
                            <p class="text-muted mb-0">{{ $seller->district }}</p>
                            <p class="text-muted mb-0">{{ $seller->city }}</p>
                            <p class="text-muted mb-0">{{ $seller->postal_code }}</p>
                            <p class="text-muted mb-4">{{ $seller->country }}</p>
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
                        <div class="col-md-6 col-sm-9 col-8">
                            <div class="dropdown">
                                <button class="btn btn-primary waves-effect waves-light mt-2 me-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status Action
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="#" class="dropdown-item"><i class="mdi mdi-hand-left font-size-16 text-success me-1"></i> Under Reviewal</a></li>
                                    <li><a href="#" class="dropdown-item"><i class="mdi mdi-chart-timeline-variant font-size-16 text-success me-1"></i> Request For Modification</a></li>
                                    <li><a href="#" class="dropdown-item"><i class="mdi mdi-thumb-up font-size-16 text-success me-1"></i> Approve</a></li>
                                </ul>
                            </div>
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
                                                <img src="https://place-hold.it/800x800?text={{ $seller->name }}&fontsize=40" alt="" class="img-fluid mx-auto d-block">
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
                                        <a href="{{ route('admin.sellers.active.orders',encrypt($seller->id)) }}" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                            Active Orders
                                        </a>
                                        <a href="{{ route('admin.sellers.history.orders',encrypt($seller->id)) }}" class="btn btn-success waves-effect waves-light mt-2 me-1">
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

                <div class="mt-5">
                    <h5>Owner</h5>
                    <div class="mt-4 border p-4">
                        <div class="row">
                            <div class="col-xl-3 col-md-5">
                                <div>
                                    <div class="d-flex">
                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" class="avatar-sm rounded-circle" alt="img" />
                                        <div class="flex-1 ms-4">
                                            <h5 class="mb-2 font-size-15 text-primary">{{ $seller->customer->name }}</h5>
                                            <h5 class="text-muted font-size-15">{{ $seller->customer->city }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-md-7">
                                <div>
                                    <p class="text-muted float-start me-3">
                                        @for ($x=1;$x<=$seller->customer->my_review; $x++)
                                            <i class="bx bxs-star text-warning"></i>
                                        @endfor
                                        @for ($x=1;$x<=(Utility::MAX_REVIEW_LIMIT-$seller->customer->my_review); $x++)
                                            <span class="bx bxs-star"></span>
                                        @endfor
                                    </p>
                                    <p class="text-muted mb-3">( {{ $seller->customer->reviews()->count() }} Review(s) )</p>
                                    <h6 class="text-primary"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $seller->customer->phone }} | <i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $seller->customer->email }}</h6>
                                    {{-- <h6 class="text-success"></h6> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h5>Official Documents</h5>
                    <div class="mt-4 border p-4">
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div>
                                    <div class="d-flex">
                                        <div class="flex-1 ms-4">
                                            <h5 class="mb-2 font-size-15 text-primary">ID Number : {{ $seller->id_number }} </h5> <a href="#"><i class="bx bx-download font-size-16 align-middle text-primary me-1"></i> Download Document</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div>
                                    <div class="d-flex">
                                        <div class="flex-1 ms-4">
                                            <h5 class="mb-2 font-size-15 text-primary">License Number : {{ $seller->license_number }} </h5> <a href="#"><i class="bx bx-download font-size-16 align-middle text-primary me-1"></i> Download Document</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4">
                                <div>
                                    <div class="d-flex">
                                        <div class="flex-1 ms-4">
                                            <h5 class="mb-2 font-size-15 text-primary">Registration Number : {{ $seller->registration_number }} </h5> <a href="#"><i class="bx bx-download font-size-16 align-middle text-primary me-1"></i> Download Document</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h5 class="">Warehouses</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Product Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($seller->branches as $branch)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-body">{{ $branch->name }}</a>
                                        </td>
                                        <td>{{ $branch->phone }}</td>
                                        <td>{{ $branch->email }}</td>
                                        <td>{{ $branch->city }}</td>
                                        <td>{{ $branch->country }}</td>
                                        <td><a href="{{ route('admin.branches.show.product.items',encrypt($branch->id)) }}" target="_blank" class="btn btn-sm btn-primary ">
                                            View Details
                                        </a></td>
                                    </tr>
                             @endforeach

                            </tbody>
                        </table>
                    </div>
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
