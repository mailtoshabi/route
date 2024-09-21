@extends('layouts.drivers.master')
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
                        {{-- <p class="mb-2">Order ID: <span class="text-primary">#{{ $delivery->invoice_no }}</span></p> --}}
                        <h6 class="text-primary">Customer Details</h6>
                        <p class="mb-2"><a class="text-primary" href="{{ route('admin.customers.view',encrypt($customer->id))}}" target="_blank">{{ $customer->name }} (ID:{{ $customer->id }})</a></p>
                        <p class="text-primary mb-0"><i class="bx bx-phone font-size-16 align-middle text-primary me-1"></i>{{ $customer->phone }}</p>
                        <p class="text-success mb-2"><i class="bx bx-message font-size-16 align-middle text-success me-1"></i>{{ $customer->email }}</p>
                        <p class="text-muted mb-0">{{ $customer->building_no }}, {{ $customer->street }}</p>
                        <p class="text-muted mb-0">{{ $customer->district }}</p>
                        <p class="text-muted mb-0">{{ $customer->city }}</p>
                        <p class="text-muted mb-4">{{ $customer->postal_code }}</p>

                        {{-- <p class="mb-0">Order Status: <span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$delivery->status]['name'] }}</span></p>
                        <p class="mb-0">Delivery Status: {!! $delivery->is_delivered? '<span class="badge badge-pill badge-soft-success font-size-12">Delivered</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Not Delivered</span>' !!}</p> --}}
                        @if(!empty($order_item->sale->customer->adresse_default))
                            <h6 class="">Delivery Address</h6>
                            <p class="text-muted mb-0">{{ $customer->adresse_default->building_no }}, {{ $customer->adresse_default->street }}</p>
                            <p class="text-muted mb-0">{{ $customer->adresse_default->district }}</p>
                            <p class="text-muted mb-0">{{ $customer->adresse_default->city }}</p>
                            <p class="text-muted mb-4">{{ $customer->adresse_default->postal_code }}</p>
                        @endif
                    </div>


                </div>
            </div>
            {{-- //TODO: add delivery address here --}}

            <div class="card-header">
                <h3 class="card-title">Delivery ID - {{ $delivery->id }}</h3>
                {{-- //TODO: add a special column for delivery_id in DB --}}
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-sm-12">
                        <p class="mb-4">Status: {{ Utility::saleStatus()[$delivery->status]['name'] }}</p>
                    </div> --}}

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Delivery ID</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Delivery Charge</th>
                                    <th scope="col">Delivery Type</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Pickup Location</th>
                                    <th scope="col">Delivery Location</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Delivery Organization</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $delivery->id }}</td>
                                    <td>{{ $delivery->delivery_est_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="#" class="text-body">{{ $delivery->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</a>
                                    </td>
                                    <td>{{ Utility::delivery_types()[$delivery->type] }}</td>
                                    <td>{{ $delivery->deliverable->invoice_no }}</td>
                                    <td>{{ $delivery->glocation_pickup }}</td>
                                    <td>{{ $delivery->glocation_delivery }}</td>
                                    <td>{{ Utility::deliveryStatus()[$delivery->status]['name'] }}</td>
                                    <td>{{ $delivery->driver->driverable->name }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <h6 class="m-0 text-right">&nbsp;</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Price:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{ $delivery->deliverable->price . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">VAT:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{ $delivery->deliverable->vat . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Delivery Charge:</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0 text-right">{{ $delivery->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5 class="m-0 text-right">Total:</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 text-right">{{ (($delivery->deliverable->price) + ($delivery->deliverable->vat) + ($delivery->delivery_charge)) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
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
