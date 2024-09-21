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
            <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
                <p class="card-title-desc">Fill all information below</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mb-2">Order ID: <span class="text-primary">#{{ $sale->order_no }}</span></p>
                        <p class="mb-2">Customer Name: <a class="text-primary" href="{{ route('admin.customers.view',encrypt($sale->customer->id))}}" target="_blank">{{ $sale->customer->name }}</a></p>
                    </div>

                </div>
            </div>


                @foreach ($sale->sale_batches as $sale_batch)
                    <div class="card-header">
                        <h4 class="card-title">Sub Order - {{ $loop->iteration }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="mb-2">Seller Name:
                                    @if ($sale_batch->is_customer)
                                        <a class="text-primary"  href="{{ route('admin.customers.view',encrypt($sale_batch->customer->id))}}" target="_blank">{{ $sale_batch->customer->name }}, {{ $sale_batch->customer->city }}</a>
                                    @else
                                        <a class="text-primary"  href="{{ route('admin.branches.view',encrypt($sale_batch->branch->id))}}" target="_blank">{{ $sale_batch->branch->name }}, {{ $sale_batch->branch->city }}</a>
                                    @endif
                                </p>
                                <p class="mb-4">Current Status: <span class="text-primary">{{ $sale_batch->status_text }}</span></p>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap">
                                    <thead>
                                        <tr>

                                            <th scope="col" colspan="2">Product Name</th>
                                            <th scope="col">Duration</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Seller Type</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale_batch->product_items as $product_item)
                                            <tr>
                                                <th scope="row">
                                                    <div>
                                                        <img src="{{ URL::asset('/assets/images/product/img-7.png') }}" alt="" class="avatar-sm">
                                                    </div>
                                                </th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14">{{ $product_item->name }}</h5>
                                                        <p class="text-muted mb-0">{{ $product_item->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</p>
                                                    </div>
                                                </td>
                                                <td>{{ Utility::rentTermNameById($product_item->pivot->rent_term_id) }}</td>
                                                <td>{{ $product_item->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                                <td>{{ $product_item->is_customer? Utility::SELLER_TYPE_CUSTOMER : Utility::SELLER_TYPE_WAREHOUSE }}</td>

                                            </tr>
                                        @endforeach
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
                                                <h6 class="m-0 text-right">{{ $sale_batch->sub_total . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h6 class="m-0 text-right">Total VAT:</h6>
                                            </td>
                                            <td>
                                                <h6 class="m-0 text-right">{{ $sale_batch->vat_total . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h6 class="m-0 text-right">Shipping:</h6>
                                            </td>
                                            <td>
                                                <h6 class="m-0 text-right">{{ $sale_batch->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h5 class="m-0 text-right">Grand Total:</h5>
                                            </td>
                                            <td>
                                                <h5 class="m-0 text-right">{{ ($sale_batch->sub_total + $sale_batch->vat_total + $sale_batch->delivery_charge) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach


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
