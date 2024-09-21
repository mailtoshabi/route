@extends('layouts.invoice')
@section('title') @lang('translation.Sales_Detail') @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">

                        <h6 class="text-primary">Invoice To</h6>
                        <p class="mb-2">{{ $order_item->sale->customer->name }} </p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->building_no }}, {{ $order_item->sale->customer->street }}</p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->district }}</p>
                        <p class="text-muted mb-0">{{ $order_item->sale->customer->city }}</p>
                        <p class="text-muted mb-2">{{ $order_item->sale->customer->postal_code }}</p>
                        <p class="text-primary mb-0">Mob:{{ $order_item->sale->customer->phone }}</p>
                        <p class="text-success mb-2">Email:{{ $order_item->sale->customer->email }}</p>
                    </div>
                    <div class="col-sm-6">
                        <br>
                        <p class="mb-0">Date : {{ $order_item->sale->created_at->format('d-m-Y') }}</p>
                        <p class="mb-2">Order ID : {{ $order_item->invoice_no }} </p>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">VAT</th>
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
                                    <td>{{ $order_item->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                                    <td>{{ $order_item->vat . ' ' . Utility::CURRENCY_DISPLAY }}</td>

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
