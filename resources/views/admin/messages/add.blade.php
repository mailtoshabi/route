@extends('layouts.master')
@section('title') @lang('translation.Add_Message') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Message_Manage') @endslot
{{-- @slot('li_2') @lang('translation.Brand_Manage') @endslot --}}
@slot('title') @lang('translation.Add_Message') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($message_notification)? route('admin.messages.update') : route('admin.messages.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($message_notification))
            <input type="hidden" name="message_id" value="{{ encrypt($message_notification->id) }}" />
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
                                <label for="title">Title</label>
                                <input id="title" name="title" type="text" class="form-control"  placeholder="Title" value="{{ isset($message_notification)?$message_notification->title:old('title')}}">
                                @error('title') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Description">{{ isset($message_notification)?$message_notification->description:old('description')}}</textarea>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Recipient</label>
                                <select name="type" id="type" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::message_recipients() as $index => $message_recipient )
                                        <option value="{{ $index}}" {{ isset($message_notification)&&($message_notification->type==$index)?'selected':'' }}>{{ $message_recipient }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    @foreach (Utility::status() as $index => $status )
                                    <option value="{{ $index}}" {{ isset($message_notification)&&($message_notification->status==$index)?'selected':'' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($message_notification) ? 'Update' : 'Add New' }}</button>
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
