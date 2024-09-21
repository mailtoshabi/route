@extends('layouts.master')
@section('title') @lang('translation.Add_Faq_type') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Faq_type_Manage') @endslot
@slot('title') @lang('translation.Add_Faq_type') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($faq_type)? route('admin.faqs.types.update') : route('admin.faqs.types.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($faq_type))
            <input type="hidden" name="faq_type_id" value="{{ encrypt($faq_type->id) }}" />
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
                                    <label for="name">Faq Type Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Faq Type Name" value="{{ isset($faq_type)?$faq_type->name:old('name')}}">
                                    @error('name') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="mb-3">
                                    <label for="name_ar">Faq Type Name Arabic</label>
                                    <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Faq Type Name Arabic" value="{{ isset($faq_type)?$faq_type->name_ar:old('name_ar')}}">
                                    @error('name_ar') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>


                        </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($faq_type) ? 'Update' : 'Add New' }}</button>
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
