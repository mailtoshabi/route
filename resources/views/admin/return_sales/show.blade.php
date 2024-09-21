@extends('layouts.master')
@section('title') @lang('translation.Sales_Return_Detail') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang('translation.Sales_Return_Detail') @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        {{-- <p class="mb-2">Order ID: <span class="text-primary">#{{ $return_sale->invoice_no }}</span></p> --}}
                        <h6 class="text-primary">Customer Details</h6>
                        <p class="mb-2"><a class="text-primary" href="{{ route('admin.customers.view',encrypt($return_sale->product_sale->sale->customer->id))}}" target="_blank">{{ $return_sale->product_sale->sale->customer->name }} (ID:{{ $return_sale->product_sale->sale->customer->id }})</a></p>
                        <p class="text-primary mb-0"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $return_sale->product_sale->sale->customer->phone }}</p>
                        <p class="text-success mb-2"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $return_sale->product_sale->sale->customer->email }}</p>
                        <p class="text-muted mb-0">{{ $return_sale->product_sale->sale->customer->building_no }}, {{ $return_sale->product_sale->sale->customer->street }}</p>
                        <p class="text-muted mb-0">{{ $return_sale->product_sale->sale->customer->district }}</p>
                        <p class="text-muted mb-0">{{ $return_sale->product_sale->sale->customer->city }}</p>
                        <p class="text-muted mb-0">{{ $return_sale->product_sale->sale->customer->postal_code }}</p>
                        <p class="text-muted mb-4">{{ $return_sale->product_sale->sale->customer->country }}</p>
                        <p class="mb-0">Seller Name:
                            <a href="{{ route('admin.customers.view',encrypt($return_sale->product_sale->product->branch->customer->id))}}" target="_blank">{{ $return_sale->product_sale->product->branch->customer->name }}</a>
                        </p>
                        <p class="mb-3">Branch Name:
                            <a class="text-primary"  href="{{ route('admin.branches.view',encrypt($return_sale->product_sale->product->branch->id))}}" target="_blank">{{ $return_sale->product_sale->product->branch->name }}, {{ $return_sale->product_sale->product->branch->city }}</a>
                        </p>
                        <p class="mb-0">Order Return Status: <span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$return_sale->status]['name'] }}</span></p>
                        <p class="mb-0">Delivery Status: {!! $return_sale->product_sale->is_delivered? '<span class="badge badge-pill badge-soft-success font-size-12">Delivered</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Not Delivered</span>' !!}</p>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary mb-2">Payment Details</h6>
                        <p class="mb-0">Payment Method : {!! $return_sale->product_sale->sale->payment_method_text !!}</p>
                        <p class="mb-2">Payment Status : {!! $return_sale->product_sale->payment_text !!} </p>
                        <h6 class="mb-2">Sub Total : {{ ( $return_sale->product_sale->price) . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        <h6 class="mb-2">Total VAT : {{ ( $return_sale->vat) . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @isset( $return_sale->product_sale->delivery_charge)
                            <h6 class="mb-2">Delivery Charge : {{  $return_sale->product_sale->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @endisset
                        <h5 class="mb-2">Grand Total : {{ ( $return_sale->product_sale->price) + ( $return_sale->product_sale->vat) +  $return_sale->product_sale->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                        <a href="{{ route('admin.sale_returns.invoice.view', encrypt( $return_sale->id)) }}" target="_blank" class="btn btn-primary btn-lg waves-effect waves-light" >View Invoice</a>
                    </div>

                </div>
            </div>
            {{-- //TODO: add delivery address here --}}

            <div class="card-header">
                <h3 class="card-title">Order ID - {{  $return_sale->invoice_no }}</h3>
                <p class="card-title">Booking Date - {{  $return_sale->product_sale->created_at->format('d-m-Y') }}</p>
                <p class="card-title">Order Return Date - {{  $return_sale->created_at->format('d-m-Y') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-sm-12">
                        <p class="mb-4">Status: {{ Utility::saleStatus()[$return_sale->status]['name'] }}</p>
                    </div> --}}

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">VAT</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <div>
                                            <img src="{{ URL::asset('/assets/images/product/img-7.png') }}" alt="" class="avatar-sm">
                                        </div>
                                    </th>
                                    <td>
                                        <div>
                                            <h5 class="text-truncate font-size-14">{{  $return_sale->product_sale->product->name }}</h5>
                                            <p class="text-muted mb-0">{{  $return_sale->product_sale->price . ' ' . Utility::CURRENCY_DISPLAY }}</p>
                                        </div>
                                    </td>
                                    <td>{{ Utility::rentTermNameById( $return_sale->product_sale->rent_term_id) }}</td>
                                    <td>{{  $return_sale->product_sale->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                    <td>{{  $return_sale->product_sale->vat . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                    <td>{{ Utility::saleStatus()[ $return_sale->product_sale->status]['name'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <h6 class="m-0 text-right">&nbsp;</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Sub Total:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{  $return_sale->product_sale->price . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Total VAT:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{  $return_sale->product_sale->vat . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5 class="m-0 text-right">Grand Total:</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 text-right">{{ (( $return_sale->product_sale->price) + ( $return_sale->product_sale->vat)) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
