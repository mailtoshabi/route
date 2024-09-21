@extends('layouts.master')
@section('title') @lang('translation.Product_Item_Manage_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Product_Manage') @endslot
@slot('li_2') @lang('translation.Product_Item_Manage_List') @endslot
@slot('title') @lang('translation.Product_Item_Manage_List') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">@lang('translation.Product_Item_Manage_List') @isset($customer) of {{ $customer->name }} @endisset <span class="text-muted fw-normal ms-2">({{ $products->count() }})</span></h5>
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
                                 <a href="{{ route('branch.products.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
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

                 <div class="table-responsive mb-4">
                     <table class="table align-middle dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                         <thead>
                         <tr>
                             {{-- <th scope="col" style="width: 50px;">
                                 <div class="form-check font-size-16">
                                     <input type="checkbox" class="form-check-input" id="checkAll">
                                     <label class="form-check-label" for="checkAll"></label>
                                 </div>
                             </th> --}}
                             {{-- <th scope="col">ID </th> --}}
                             <th scope="col">Name</th>
                             <th scope="col">Sub Categories</th>
                             <th scope="col">Product</th>
                             <th scope="col">Description</th>
                             <th scope="col">Manufacture Date</th>
                             <th scope="col">Warehouse</th>
                             {{-- <th scope="col">Seller</th> --}}
                             <th style="width: 80px; min-width: 80px;">View</th>
                         </tr>
                         </thead>
                         <tbody>
                             @foreach ($products as $product)
                             <tr>
                                {{-- <th scope="row">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                        <label class="form-check-label" for="contacusercheck1"></label>
                                    </div>
                                </th> --}}
                                {{-- <td>{{ $product->item_code }}</td> --}}
                                <td>
                                    @if(!empty($product->image))
                                    <img src="{{ URL::asset('storage/products/' . $product->image) }}" alt="" class="avatar-sm rounded-circle me-2">
                                @else
                                <div class="avatar-sm d-inline-block align-middle me-2">
                                    <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                        <i class="bx bxs-user-circle"></i>
                                    </div>
                                </div>
                                @endif
                                     <a href="#" class="text-body">{{ $product->name }}</a>
                                 </td>
                                <td>
                                    {{ $product->sub_category->name }}
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a class="text-primary"  href="{{ route('admin.branches.view',encrypt($product->branch->id))}}" target="_blank">{{ $product->branch->name }}, {{ $product->branch->city }}</a>
                                </td>
                                {{-- <td>
                                    <a class="text-primary"  href="#" target="_blank">{{ $product->branch->customer->name }}, {{ $product->branch->customer->city }}</a>
                                </td> --}}
                                <td>
                                    {{-- <a href="{{ route('admin.products.items.view',encrypt($product->id)) }}">View</a> --}}
                                    <a href="#" class="btn btn-primary btn-sm btn-rounded" >
                                        View Details
                                    </a>
                                </td>
                            </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $products->links() }}</div>
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
