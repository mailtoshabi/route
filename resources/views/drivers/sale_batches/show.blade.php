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
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
@if(session()->has('failed')) <p class="text-success">{{ session()->get('failed') }} @endif</p>
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
                        <p class="mb-2">Order ID: <span class="text-primary">#{{ $sale_batch->order_no }}</span></p>
                        <p class="mb-2">Customer Name: <a class="text-primary">{{ $sale_batch->sale->customer->name }}</a></p>
                        <p class="mb-0">Order Status: {{ Utility::saleBatchStatus()[$sale_batch->status]['name'] }}</p>

                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-2">Sub Total : {{ $sale_batch->sub_total . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        <h6 class="mb-2">Total VAT : {{ $sale_batch->vat_total . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @isset($sale_batch->delivery_charge)
                            <h6 class="mb-2">Delivery Charge : {{ $sale_batch->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                        @endisset
                        <h5 class="mb-2">Grand Total : {{ ($sale_batch->sub_total + $sale_batch->vat_total + $sale_batch->delivery_charge) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                    </div>

                </div>
            </div>
            @if($sale_batch->status==Utility::STATUS_NEW)
                <div class="card-header" style="border-bottom: none">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light" data-conf="Are you sure to accept all the orders?" data-plugin="submit-form" data-target-form="#accept-all-form">Accept All Orders</button>
                        <form id="accept-all-form" method="POST" action="{{ route('branch.orders.accept',encrypt($sale_batch->id))}}">
                            @csrf
                            <input type="hidden" name="_method" value="POST" />
                        </form>
                    </div>
                </div>
            @endif
            <hr style="height: 5px">
            @foreach ($sale_batch->product_items as $product_item)
                <div class="card-header">
                    <h3 class="card-title">Invoice No - {{ $product_item->pivot->invoice_no }}</h3>
                    <p class="mb-0">Rent Term - {{ Utility::rentTermNameById($product_item->pivot->rent_term_id) }}</p>
                    <p class="mb-0">Starting Date - {{ Carbon\Carbon::parse($product_item->pivot->starts_at)->format('d-m-Y') }}</p>
                    <p class="mb-2">Ending Date - {{ Carbon\Carbon::parse($product_item->pivot->ends_at)->format('d-m-Y') }}</p>
                    {{-- <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Accept Order</button> --}}
                    @if($product_item->pivot->status==Utility::STATUS_NEW)
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-conf="Are you sure to accept this order?" data-plugin="submit-form" data-target-form="#accept-single-form__{{ $loop->iteration }}">Accept Order</button>
                        <form id="accept-single-form__{{ $loop->iteration }}" method="POST" action="{{ route('branch.orders.single.accept',[encrypt($sale_batch->id),encrypt($product_item->id)])}}">
                            @csrf
                            <input type="hidden" name="_method" value="POST" />
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" style="position: relative">
                            {{-- <p class="mb-0">Status: {{ Utility::saleStatus()[$product_item->pivot->status]['name'] }}</p> --}}
                            {{-- <div class="dropdown" style="width:200px;">
                                <button class="btn btn-link font-size-12 text-danger p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Change Status
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @foreach ( Utility::saleStatus() as $index => $product_item_status )
                                        @if ($index!=0)
                                            <li><a href="{{ route('branch.sales.changeStatus',['id'=>encrypt($product_item->id),'status'=>encrypt($index)])}}" class="dropdown-item">{{ $product_item_status['name'] }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div> --}}
                        </div>

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
                                                <h5 class="text-truncate font-size-14">{{ $product_item->name }}</h5>
                                                <p class="text-muted mb-0">{{ $product_item->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</p>
                                            </div>
                                        </td>
                                        <td>{{ Utility::rentTermNameById($product_item->pivot->rent_term_id) }}</td>
                                        <td>{{ $product_item->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                        <td>{{ $product_item->pivot->vat . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                        <td>{{ Utility::saleStatus()[$product_item->pivot->status]['name'] }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5">
                                            <h6 class="m-0 text-right">&nbsp;</h6>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Sub Total:</h6>
                                        </td>
                                        <td>
                                            <h6 class="m-0 text-right">{{ $product_item->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Total VAT:</h6>
                                        </td>
                                        <td>
                                            <h6 class="m-0 text-right">{{ $product_item->pivot->vat . ' ' . Utility::CURRENCY_DISPLAY }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h5 class="m-0 text-right">Grand Total:</h5>
                                        </td>
                                        <td>
                                            <h5 class="m-0 text-right">{{ (($product_item->pivot->price) + ($product_item->pivot->vat)) . ' ' . Utility::CURRENCY_DISPLAY }}</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(!$loop->last)
                    <hr style="height: 2px;">
                @endif
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
