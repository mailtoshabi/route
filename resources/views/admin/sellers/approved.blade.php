@extends('layouts.master')
@section('title') @lang('translation.Vednor_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Vendor_Manage') @endslot
@slot('title') @lang('translation.Vednor_Approved_List') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                <
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane customerdetailsTab active" role="tabpanel">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <h5 class="card-title">Sellers Approved List <span class="text-muted fw-normal ms-2">({{ $sellers->count() }})</span></h5>
                                </div>
                            </div>


                        </div>
                         <!-- end row -->

                        <div class="table-responsive mb-4">
                            <table class="table align-middle dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                                <thead>
                                <tr>

                                    <th scope="col">ID</th>
                                    <th scope="col">Organization Name</th>
                                    <th scope="col">Owner/ID</th>
                                    <th scope="col">Items Categories</th>

                                    <th scope="col">Documents</th>
                                    <th scope="col">Joining Date</th>
                                    <th class="align-middle">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach ($sellers as $index => $seller)
                                       <tr>

                                           <td>{{ $seller->id }}</td>
                                           <td>

                                               <a href="#" class="text-body">{{ $seller->name }}</a>
                                           </td>
                                           <td>@if($seller->is_by_customer) {{ $seller->customer->name }} - {{ $seller->customer->id }} @else Seller By ADMIN @endif</td>
                                           <td>
                                                @foreach($seller->categories as $category)
                                                    {{ $category->name . ',' }}
                                                @endforeach
                                            </td>

                                           <td>
                                            ID NO : {{ $seller->id_number }} <a href="#" target="_blank"><small>View</small></a><br>
                                            License NO : {{ $seller->license_number }}  <a href="#" target="_blank"><small>View</small></a><br>
                                            Reg NO : {{ $seller->registration_number }}  <a href="#" target="_blank"><small>View</small></a>
                                            </td>
                                            <td>{{ $seller->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.sellers.show',encrypt($seller->id)) }}" class="btn btn-primary btn-sm btn-rounded" >
                                                    View Details
                                                </a>
                                            </td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                            <!-- end table -->
                            <div class="pagination justify-content-center">{{ $sellers->links() }}</div>
                        </div>
                         <!-- end table responsive -->
                    </div>
                </div>
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
