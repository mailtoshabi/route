@extends('layouts.drivers.master')
@section('title') @lang('translation.Sales') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang('translation.Sales') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">@lang('translation.Sales') <span class="text-muted fw-normal ms-2">({{ $sales->count() }})</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             {{-- <div>
                                 <ul class="nav nav-pills">
                                     <li class="nav-item">
                                         <a class="nav-link active" href="apps-contacts-list" data-bs-toggle="tooltip" data-bs-placement="top" title="List"><i class="bx bx-list-ul"></i></a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="apps-contacts-grid" data-bs-toggle="tooltip" data-bs-placement="top" title="Grid"><i class="bx bx-grid-alt"></i></a>
                                     </li>
                                 </ul>
                             </div> --}}
                             {{-- <div>
                                 <a href="{{ route('admin.sales.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                             </div> --}}

                             {{-- <div class="dropdown">
                                 <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="bx bx-dots-horizontal-rounded"></i>
                                 </a>

                                 <ul class="dropdown-menu dropdown-menu-end">
                                     <li><a class="dropdown-item" href="#">Action</a></li>
                                     <li><a class="dropdown-item" href="#">Another action</a></li>
                                     <li><a class="dropdown-item" href="#">Something else here</a></li>
                                 </ul>
                             </div> --}}
                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Order ID</th>
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Customer Name</th>
                                <th class="align-middle">Total</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Payment Method</th>
                                <th class="align-middle">Details</th>
                                <th class="align-middle">Status</th>
                            </tr>
                        </thead>
                         <tbody>
                             @foreach ($sales as $sale)
                             <tr>
                                <th scope="row">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                        <label class="form-check-label" for="contacusercheck1"></label>
                                    </div>
                                </th>

                                <td>
                                    <a href="#" class="text-body">{{ $sale->invoice_no }}</a>
                                </td>
                                <td>{{ $sale->created_at->format('d F, Y') }}</td>
                                <td>{{ $sale->customer->name }}</td>
                                <td>
                                    <a href="#" class="text-body">
                                        {{ ($sale->sale_total['price'] + $sale->sale_total['vat']) . ' ' . Utility::CURRENCY_DISPLAY }}
                                        @if($sale->delivery_charge!=0) <br><small>Delivery Charge: {{ $sale->delivery_charge }}</small> @endif
                                    </a>
                                </td>

                                <td>{!! $sale->payment_text !!} <span class="badge badge-pill badge-soft-primary font-size-12">{{ Utility::saleStatus()[$sale->status]['name'] }}</span></td>
                                <td>{!! $sale->payment_method_text !!}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" data-plugin="render-modal" data-modal=".orderdetailsModal" data-target="{{ route('admin.sales.show', encrypt($sale->id)) }}">
                                        View Details
                                    </button>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ( Utility::saleStatus() as $index => $sale_status )
                                            @if ($index!=0)
                                                <li><a href="{{ route('admin.sales.changeStatus',['id'=>encrypt($sale->id),'status'=>encrypt($index)])}}" class="dropdown-item">{{ $sale_status['name'] }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </div>
                                </td>
                            </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $sales->links() }}</div>
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
