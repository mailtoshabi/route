@extends('layouts.master')
@section('title') @lang('translation.Rent_Terms_Add') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Rental_Management') @endslot
@slot('title') @lang('translation.Rent_Terms_Add') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($rent_term)? route('admin.rent_products.rent_terms.update') : route('admin.rent_products.rent_terms.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($rent_term))
            <input type="hidden" name="rent_term_id" value="{{ encrypt($rent_term->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">Rent Term Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Rent Term Name" value="{{ isset($rent_term)?$rent_term->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Rent Term Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Rent Term Name Arabic" value="{{ isset($rent_term)?$rent_term->name_ar:old('name_ar')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            {{-- <div class="mb-3">
                                <label class="control-label">Term Types</label>
                                <select name="rent_term_type_id" id="rent_term_type_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::rent_term_types() as $index => $rent_term_type )
                                        <option value="{{ $index}}" {{ isset($rent_term)&&($rent_term->rent_term_type_id==$index)?'selected':'' }}>{{ $rent_term_type['en']}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label for="days">Days</label>
                                <input id="days" name="days" type="text" class="form-control"  placeholder="Days" value="{{ isset($rent_term)?$rent_term->days:old('days')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($rent_term) ? 'Update' : 'Add New' }}</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <input name="isImageDelete" type="hidden" value="0">
    </form>
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
