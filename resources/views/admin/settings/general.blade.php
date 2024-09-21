@extends('layouts.master')
@section('title') @lang('translation.General_Settings') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Settings') @endslot
@slot('title') @lang('translation.General_Settings') @endslot
@endcomponent
<div class="row">
    @if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
    @if(session()->has('error')) <p class="text-danger">{{ session()->get('error') }} @endif</p>
    <form method="POST" action="{{ route('admin.settings.update.general')  }}">
        @csrf
        <input type="hidden" name="_method" value="PUT" />
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
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control"  placeholder="Email" value="{{ Utility::settings('email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp">WhatsApp No</label>
                                <input id="whatsapp" name="whatsapp" type="text" class="form-control" placeholder="WhatsApp No" value="{{ Utility::settings('whatsapp') }}">
                            </div>
                            <div class="mb-3">
                                <label for="instagram">Instagram Link</label>
                                <input id="instagram" name="instagram" type="text" class="form-control" placeholder="Instagram Link" value="{{ Utility::settings('instagram') }}">
                            </div>
                            <div class="mb-3">
                                <label for="youtube">Youtube Link</label>
                                <input id="youtube" name="youtube" type="text" class="form-control" placeholder="Youtube Link" value="{{ Utility::settings('youtube') }}">
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label for="mobile">Mobile No</label>
                                <input id="mobile" name="mobile" type="text" class="form-control" placeholder="Contact No" value="{{ Utility::settings('mobile') }}">
                            </div>
                            <div class="mb-3">
                                <label for="facebook">Facebook Link</label>
                                <input id="facebook" name="facebook" type="text" class="form-control" placeholder="Facebook Link" value="{{ Utility::settings('facebook') }}">
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="5" placeholder="Address">{{ Utility::settings('address') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
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
