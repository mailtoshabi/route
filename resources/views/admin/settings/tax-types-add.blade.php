@extends('layouts.master')
@section('title') @lang('translation.Tax Type') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Settings @endslot
@slot('title') Tax Type Setup @endslot
@endcomponent
<div class="row">
    <div class="col-12">

        @empty($delivery_charge)
        <form class="form" action="{{ route('admin.settings.tax-types.store') }}" id="product_form"
            name="product_form" method="POST">
        @endempty

        @isset($delivery_charge)
        <form class="form" action="{{ route('admin.settings.tax-types.store') }}" id="product_form"
            name="product_form" method="POST">
            <input type="hidden" name="post_id" id="post_id" value="{{ $delivery_charge->id }}">
        @endisset
        @csrf


        <div class="card">

            <div class="card-body">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">

                                <label for="productname">Tax Description</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Tax Description" step=any  @empty($delivery_charge) value="{{ old('min_order_amount') }}" @endempty
                                @isset($delivery_charge) value="{{ $delivery_charge->name }}" @endisset>
                                {!! $errors->first('min_order_amount', ' <label for="" class="text-danger">:message</label>') !!}
                            </div>


                            <div class="mb-3">
                                <label class="form-label required">Tax Percentage</label>
                                <input id="perc" name="perc" type="text" class="form-control" placeholder="%"  @empty($delivery_charge) value="{{ old('delivery_charge') }}" @endempty
                                @isset($delivery_charge) value="{{ $delivery_charge->perc }}" @endisset>
                                {!! $errors->first('delivery_charge', ' <label for="" class="text-danger">:message</label>') !!}
                            </div>

                        </div>


                    </div>

            </div>
        </div>



        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                </div>
            </div>
        </div>
    </form>
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
