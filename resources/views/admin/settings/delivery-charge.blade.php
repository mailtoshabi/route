@extends('layouts.master')
@section('title') @lang('translation.Delivery_Charge_Setup') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Settings') @endslot
@slot('title') @lang('translation.Delivery_Charge_Setup') @endslot
@endcomponent
<div class="row">
    <div class="col-12">

        @empty($delivery_charge)
        <form class="form" action="{{ route('admin.settings.delivery-charge.store') }}" id="product_form"
            name="product_form" method="POST">
        @endempty

        @isset($delivery_charge)
        <form class="form" action="/delivery-charge/{{ $delivery_charge->id }}" id="product_form"
            name="product_form" method="POST">
            @method('PATCH')
            <input type="hidden" name="delivery_charge_id" id="delivery_charge_id" value="{{ $delivery_charge->id }}">
        @endisset
        @csrf


        <div class="card">
            <div class="card-header">Charge Setup</h4>
            </div>
            <div class="card-body">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">

                                <label for="min_order_amount">Minimum order amount</label>
                                <input id="min_order_amount" name="min_order_amount" type="number" class="form-control"  placeholder="Minimum order amount" step=any  @empty($delivery_charge) value="{{ old('min_order_amount') }}" @endempty
                                @isset($delivery_charge) value="{{ $delivery_charge->min_order_amount }}" @endisset>
                                {!! $errors->first('min_order_amount', ' <label for="" class="text-danger">:message</label>') !!}
                            </div>


                            <div class="mb-3">
                                <label for="delivery_charge">Delivery charge</label>
                                <input id="delivery_charge" name="delivery_charge" type="number" class="form-control" placeholder="Delivery charge"  @empty($delivery_charge) value="{{ old('delivery_charge') }}" @endempty
                                @isset($delivery_charge) value="{{ $delivery_charge->delivery_charge }}" @endisset>
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
