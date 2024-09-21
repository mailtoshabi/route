@extends('layouts.master')
@section('title') @lang('translation.Add_Sub_Category') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Sub_Category_Manage') @endslot
@slot('title') @lang('translation.Add_Sub_Category') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($sub_category)? route('admin.categories.update') : route('admin.categories.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($sub_category))
            <input type="hidden" name="category_id" value="{{ encrypt($sub_category->id) }}" />
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
                                    <label for="name">Sub Category Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Sub Category Name" value="{{ isset($sub_category)?$sub_category->name:old('name')}}">
                                    @error('name') <p>{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name_ar">Sub Category Name Arabic</label>
                                    <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Sub Category Name Arabic" value="{{ isset($sub_category)?$sub_category->name_ar:old('name_ar')}}">
                                    @error('name_ar') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Category</label>
                                    <select id="parent" name="parent" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category )
                                            <option value="{{ $category->id }}" {{ isset($sub_category)&&($sub_category->category==$category->id)?'selected':''}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="control-label">Sub Category Image</label>
                                    <span id="imageContainer" @if(isset($sub_category)&&empty($sub_category->image)) style="display: none" @endif>
                                        @if(isset($sub_category)&&!empty($sub_category->image))
                                            <img src="{{ URL::asset(App\Models\SubCategory::DIR_STORAGE . $sub_category->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($sub_category)&&!empty($sub_category->image)) style="display: none" @endif>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        @if(isset($sub_category)&&!empty($sub_category->image))
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($sub_category) ? 'Update' : 'Add New' }}</button>
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
<script>
    $(document).ready(function() {
        $('#imageContainer').find('button').click(function() {
            $('#imageContainer').hide();
            $('#fileContainer').show();
            $('input[name="isImageDelete"]').val(1);
        })

        $('#fileContainer').find('button').click(function() {
            $('#fileContainer').hide();
            $('#imageContainer').show();
            $('input[name="isImageDelete"]').val(0);
        })
    });
</script>
@endsection
