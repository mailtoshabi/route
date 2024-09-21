@extends('layouts.master')
@section('title') @lang('translation.Sales_Return') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang('translation.Sales_Return') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">@lang('translation.Sales_Return') <span class="text-muted fw-normal ms-2">({{ $return_sales->count() }})</span></h5>
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
                                <th class="align-middle">Order ID</th>
                                <th class="align-middle">Order Date</th>
                                <th class="align-middle">Return Date</th>
                                <th class="align-middle">Customer</th>
                                <th class="align-middle">Seller</th>
                                <th class="align-middle">Return Amount</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Details</th>
                                {{-- <th class="align-middle">Details</th> --}}
                            </tr>
                        </thead>
                         <tbody>
                             @foreach ($return_sales as $return_sale)
                             <tr>
                                {{-- <th scope="row">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                        <label class="form-check-label" for="contacusercheck1"></label>
                                    </div>
                                </th> --}}

                                <td>
                                    {{  $return_sale->invoice_no }}
                                </td>
                                <td>{{ $return_sale->product_sale->created_at->format('d F, Y') }}</td>
                                <td>{{ $return_sale->created_at->format('d F, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.customers.view',encrypt($return_sale->product_sale->sale->customer->id))}}" target="_blank">{{ $return_sale->product_sale->sale->customer->name }}, {{ $return_sale->product_sale->sale->customer->city }}</a>
                                </td>
                                <td>
                                    <a class="text-primary"  href="{{ route('admin.customers.view',encrypt($return_sale->product_sale->product->branch->customer->id))}}" target="_blank">{{ $return_sale->product_sale->product->branch->customer->name }}</a>,<br>
                                    <a class="text-primary"  href="{{ route('admin.branches.view',encrypt($return_sale->product_sale->product->branch->id))}}" target="_blank">{{ $return_sale->product_sale->product->branch->name }}, {{ $return_sale->product_sale->product->branch->city }}</a>
                                </td>
                                <td>
                                    <a href="#" class="text-body">
                                        {{ $return_sale->price . ' ' . Utility::CURRENCY_DISPLAY }}
                                    </a>
                                </td>

                                <td> <span class="badge badge-pill badge-soft-primary font-size-12">
                                    {{ Utility::returnStatus()[$return_sale->status]['name'] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.sale_returns.show', encrypt($return_sale->id)) }}" class="btn btn-primary btn-sm btn-rounded" >
                                        View Details
                                    </a>
                                </td>
                                {{-- <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @foreach ( Utility::saleStatus() as $index => $return_sale_status )
                                                @if ($index!=0)
                                                    <li><a href="{{ route('admin.sales.changeStatus',['id'=>encrypt($return_sale->id),'status'=>encrypt($index)])}}" class="dropdown-item">{{ $return_sale_status['name'] }}</a></li>
                                                @endif
                                            @endforeach
                                    </ul>
                                    </div>
                                </td> --}}
                            </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $return_sales->links() }}</div>
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
