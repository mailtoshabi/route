@extends('layouts.master')
@section('title') @lang(request()->routeIs('admin.sellers.active.orders')?'translation.Active_orders':'translation.History_orders') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang(request()->routeIs('admin.sellers.active.orders')?'translation.Active_orders':'translation.History_orders') of {{ $seller_name[0] }} @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">@lang(request()->routeIs('admin.sellers.active.orders')?'translation.Active_orders':'translation.History_orders') <span class="text-muted fw-normal ms-2">({{ $orders->total() }})</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">


                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                {{-- <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th> --}}
                                <th class="align-middle">Order Date</th>
                                <th class="align-middle">Order ID</th>
                                <th class="align-middle">Customer</th>
                                <th class="align-middle">Customer Contact</th>
                                <th class="align-middle">Customer House No</th>
                                <th class="align-middle">Customer Location</th>
                                <th class="align-middle">Seller</th>
                                <th class="align-middle">Total</th>
                                {{-- <th class="align-middle">Status</th> --}}
                                <th class="align-middle">Payment Method</th>
                                <th class="align-middle">Payment Status</th>
                                <th class="align-middle">Order Status</th>
                                <th class="align-middle">Details</th>
                                <th class="align-middle">Invoice</th>
                            </tr>
                        </thead>
                         <tbody>
                             @foreach ($orders as $order)
                                <tr>
                                    {{-- <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th> --}}
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="#" class="text-body">{{ $order->invoice_no }}</a>
                                    </td>
                                    <td><a href="" target="_blank">{{ $order->sale->customer->name . '-' . $order->sale->customer->city }}</a></td>
                                    <td class="align-middle">{{ $order->sale->customer->phone }}</td>
                                    <td class="align-middle">{{ $order->sale->customer->building_no }}</td>
                                    <td class="align-middle">Customer Location</td>
                                    <td>
                                        <a class="text-primary"  href="#{{--{{ route('admin.customers.view',encrypt($order->product_item->branch->customer->id))}}--}}" target="_blank">{{ $order->product_item->branch->customer->name }}, {{ $order->product_item->branch->customer->city }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            {{ $order->price . ' ' . Utility::CURRENCY_DISPLAY }}
                                            {{-- <small>vat : {{ $order->vat_total . ' ' . Utility::CURRENCY_DISPLAY }}</small> --}}
                                        </a>
                                    </td>

                                    {{-- <td><span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$order->status]['name'] }}</span></td> --}}
                                    <td>{!! $order->sale->payment_method_text !!}</td>
                                    <td>{!! $order->is_paid?'<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>':'<span class="badge badge-pill badge-soft-danger font-size-12">Not Paid</span>' !!}</td>
                                    <td class="align-middle"><span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$order->status]['name'] }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', encrypt($order->id)) }}" class="btn btn-primary btn-sm btn-rounded" >
                                            View Details
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.invoice.view', encrypt($order->id)) }}" target="_blank" class="btn btn-primary btn-sm btn-rounded" >
                                            View Invoice
                                        </a>
                                    </td>
                                </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $orders->links() }}</div>
                 </div>
                 <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel" aria-hidden="true">

</div><!-- /.modal -->

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatable-pages.init.js') }}"></script>
<script>
$(document).ready(function() {
    $(document).on('click','[data-plugin="render-modal"]',function(e) {
		e.preventDefault();
        var url = $(this).data('target');
        var modal_Id = $(this).data('modal');
        $.get(url, function (data) {
			var $el = $(data.html).clone();
			$(modal_Id).html($el);
			$(modal_Id).modal('show');
			// $(modal_Id).trigger('inside_modal.validation', $el);
		});

        //$(modal_Id).modal('show');
		// var url = $(this).data('target');
		// if(typeof(url)  === "undefined") {
		// 	url = '';
		// }

		// var modal_Id = $(this).data('modal');
		// showModal (modal_Id,url);
	});
});
</script>
@endsection
