@extends('layouts.master')
@section('title') @lang('translation.Sales_Detail') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang('translation.Sales_Detail') @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
                <p class="card-title-desc">Fill all information below</p>
            </div> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        {{-- <p class="mb-2">Order ID: <span class="text-primary">#{{ $order_item->invoice_no }}</span></p> --}}
                        <h5 class="text-primary">Customer Details</h5>
                        <p class="mb-0"><a class="text-primary" href="{{ route('admin.customers.view',encrypt($order_item->sale->customer->id))}}" target="_blank">{{ $order_item->sale->customer->name }} (ID:{{ $order_item->sale->customer->id }})</a></p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->building_no }}, {{ $order_item->sale->customer->street }}</p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->district }}</p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->city }}</p>
                        <p class="text-muted mb-2">{{ $order_item->sale->customer->postal_code }}</p>
                        <p class="text-primary mb-0"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $order_item->sale->customer->phone }}</p>
                        <p class="text-success mb-4"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $order_item->sale->customer->email }}</p>

                        <p class="mb-0">Order Status: <span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$order_item->status]['name'] }}</span></p>
                        <p class="mb-3">Delivery Status: {!! $order_item->is_delivered? '<span class="badge badge-pill badge-soft-success font-size-12">Delivered</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Not Delivered</span>' !!}</p>

                        <p class="mb-0">Seller Name:
                            <a href="{{ route('admin.customers.view',encrypt($order_item->product->branch->customer->id))}}" target="_blank">{{ $order_item->product->branch->customer->name }}</a>
                        </p>
                        <p class="mb-3">Branch Name:
                            <a class="text-primary"  href="{{ route('admin.branches.view',encrypt($order_item->product->branch->id))}}" target="_blank">{{ $order_item->product->branch->name }}, {{ $order_item->product->branch->city }}</a>
                        </p>
                        @if(!empty($order_item->sale->customer->adresse_default))
                            <h6 class="">Delivery Address</h6>
                            <p class="text-muted mb-0">{{ $order_item->sale->customer->adresse_default->building_no }}, {{ $order_item->sale->customer->adresse_default->street }}</p>
                            <p class="text-muted mb-0">{{ $order_item->sale->customer->adresse_default->district }}</p>
                            <p class="text-muted mb-0">{{ $order_item->sale->customer->adresse_default->city }}</p>
                            <p class="text-muted mb-4">{{ $order_item->sale->customer->adresse_default->postal_code }}</p>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary mb-2">Payment Details</h6>
                        <p class="mb-0">Payment Method : {!! $order_item->sale->payment_method_text !!}</p>
                        <p class="mb-2">Payment Status : {!! $order_item->payment_text !!} </p>
                        <h6 class="mb-2">Sub Total : {{ ($order_item->price) . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        <h6 class="mb-2">Total VAT : {{ ($order_item->vat) . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @isset($order_item->delivery_charge)
                            <h6 class="mb-2">Delivery Charge : {{ $order_item->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @endisset
                        <h5 class="mb-2">Grand Total : {{ ($order_item->price) + ($order_item->vat) + $order_item->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                        {{-- <a href="{{ route('admin.orders.invoice.view', encrypt($order_item->id)) }}" target="_blank" class="btn btn-primary btn-lg waves-effect waves-light" >View Invoice</a> --}}
                        <a onClick='showPopup(this.href);return(false);' href="{{ route('admin.orders.invoice.view_new', encrypt($order_item->id)) }}" target="_blank" class="btn btn-primary btn-lg waves-effect waves-light" >View Invoice</a>
                    </div>

                </div>
            </div>

            <div class="card-header">
                <h3 class="card-title">Order ID - {{ $order_item->invoice_no }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
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
                                            <h5 class="text-truncate font-size-14">{{ $order_item->product->name }}</h5>
                                            <p class="text-muted mb-0">{{ $order_item->price . ' ' . Utility::CURRENCY_DISPLAY }}</p>
                                        </div>
                                    </td>
                                    <td>{{ Utility::rentTermNameById($order_item->rent_term_id) }}</td>
                                    <td>{{ $order_item->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                    <td>{{ $order_item->vat . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                    <td>{{ Utility::saleStatus()[$order_item->status]['name'] }}</td>
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
                                        <h6 class="m-0 text-right">{{ $order_item->price . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Total VAT:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{ $order_item->vat . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5 class="m-0 text-right">Grand Total:</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 text-right">{{ (($order_item->price) + ($order_item->vat)) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
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
<script type="text/javascript">
    function showPopup(url) {
    newwindow=window.open(url,'name','height=700,width=520,top=200,left=300,resizable');
    if (window.focus) {newwindow.focus()}
    }
    </script>
@endsection
