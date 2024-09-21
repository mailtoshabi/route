@extends('layouts.drivers.master')
@section('title') @lang('translation.Customer Reviews') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Product_Manage') @endslot
@slot('title') @lang('translation.Customer_Reviews') @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="customerlistcheck01">
                                            <label class="form-check-label" for="customerlistcheck01"></label>
                                        </div>
                                    </td>
                                    <td>{{ $review->customer->name }}</td>
                                    <td>
                                        <p class="mb-0">{{ $review->product->name }}</p>
                                    </td>
                                    <td><span class="badge bg-success font-size-12"><i class="mdi mdi-star me-1"></i> {{ $review->rating }} </span></td>
                                    <td>
                                        <p><a href="{{ route('seller.products.reviews.changeStatus',encrypt($review->id))}}" class="dropdown-item"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> {{ $review->status?'Deactivate':'Activate'}}</a></p>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="pagination justify-content-center">{{ $reviews->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@endsection
@section('script')zz
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
