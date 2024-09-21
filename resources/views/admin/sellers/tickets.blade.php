@extends('layouts.master')
@section('title') @lang('translation.Seller_Tickets') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Vendor_Manage') @endslot
@slot('title') @lang('translation.Seller_Tickets') @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">Tickets List <span class="text-muted fw-normal ms-2">({{ $tickets->count() }})</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">

                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive mb-4">
                     <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                         <thead>
                            <tr>
                                {{-- <th scope="col" style="width: 50px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th> --}}
                                <th scope="col">Ticket ID</th>
                                <th scope="col">Seller</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Type</th>
                                <th scope="col">Escalation Level</th>
                                <th scope="col">Current Handler</th>
                                <th scope="col">Status</th>
                                <th scope="col">Last Updated</th>
                                {{-- <th style="width: 80px; min-width: 80px;">Action</th> --}}
                            </tr>
                         </thead>
                         <tbody>
                            @foreach ($tickets as $ticket)
                            <tr>
                                {{-- <th scope="row">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                        <label class="form-check-label" for="contacusercheck1"></label>
                                    </div>
                                </th> --}}
                                <td>{{ $ticket->ticket_id }}</td>
                                <td>
                                    <a href="{{ route('admin.sellers.show',encrypt($ticket->seller->id))}}" target="_blank" class="text-primary">{{ $ticket->seller->name }}</a>
                                </td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->description }}</td>
                                <td>{{ Utility::ticket_types()[$ticket->type] }}</td>
                                <td>{{ Utility::ticket_escalations()[$ticket->escalation_level] }}</td>
                                <td>{{ $ticket->current_handler->name }}</td>
                                <td>{{ $ticket->status_text }}</td>
                                <td>{{ $ticket->updated_at->format('d-m-Y') }}</td>
                                {{-- <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="{{ route('admin.customers.tickets.show',encrypt($ticket->id))}}" class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-success me-1"></i> View</a></li>
                                        <li><a href="{{ route('admin.customers.tickets.destroy',encrypt($ticket->id))}}" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.customers.tickets.changeApproval',encrypt($ticket->id))}}"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> {{ $ticket->approve?'Deactivate':'Activate'}}</a></li>
                                    </ul>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $tickets->links() }}</div>
                 </div>
                 <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatable-pages.init.js') }}"></script>
@endsection
