@extends('layouts.master')
@section('title') @lang('translation.Product_Item_Manage_Add') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
<style>
    .hidden{
        display: none !important;
    }
    .close_container{
        position: relative;
    }
    .btn-close {
        position: absolute !important;
        right: 30px;
        top: 36px;
    }
</style>
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Product_Manage_List') @endslot
@slot('li_2') @lang('translation.Product_Item_Manage_List') @endslot
@slot('title') {{ $product->name }} @endslot
@endcomponent
<div class="row">

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
                                <label for="product_id">Main Product</label>
                                <input id="product_id" name="product_id" type="text" class="form-control" placeholder="Main Product" value="{{ isset($product)?$product->name:old('name')}}">
                            </div>
                            {{-- <div class="mb-3">
                                <label for="item_code">Item Code</label>
                                <input id="item_code" name="item_code" type="text" class="form-control" placeholder="Item Code" value="{{ isset($product)?$product->item_code:old('item_code')}}">
                            </div> --}}
                            <div class="mb-3">
                                <label for="name">Item Modal Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Item Modal Name" value="{{ isset($product)?$product->name:old('name')}}">
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Item Modal Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Item Modal Name Arabic" value="{{ isset($product)?$product->name_ar:old('name_ar')}}">
                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label for="model_year">Modal year</label>
                                <input id="model_year" name="model_year" type="text" class="form-control" placeholder="Modal year" value="{{ isset($product)?$product->model_year:old('model_year')}}">
                            </div>
                            <div class="mb-3">
                                <label for="glocation">Google Location</label>
                                <input id="glocation" name="glocation" type="text" class="form-control" placeholder="Google Location" value="{{ isset($product)?$product->glocation:old('glocation')}}">
                            </div>
                            <div class="mb-3">
                                <label for="video">Youtube Video Link</label>
                                <input id="video" name="video" type="text" class="form-control" placeholder="Video Link" value="{{ isset($product)?$product->video:old('video')}}">
                            </div>

                            <div class="mb-3">
                                <label for="status">Status</label>
                                <input id="statuds" name="statuds" type="text" class="form-control" placeholder="Status" value="{{ isset($product)? Utility::status()[$product->status]:''}}">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @if(isset($product)&&!empty($product->image))
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Product Image</h4>
                    </div>
                    <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <br><span id="imageContainer">
                                            <img src="{{ URL::asset(App\Models\Product::DIR_STORAGE . $product->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                        </span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> <!-- end card-->
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Prices</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body" id="prices_container">
                    @isset($product)
                        @foreach ($product->rentTerms as $index => $rent_term_pivot)
                            <div class="row close_container" id="close_container_{{ $index }}">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="control-label">Terms</label>
                                        <select class="select2 form-control select2_rent_terms" name="rent_terms[{{ $index }}]" id="rent_terms-{{ $index }}">
                                            <option value="">Select</option>
                                            @foreach ($rent_terms as $rent_term)
                                                <option value="{{ encrypt($rent_term->id) }}" {{ $rent_term_pivot->pivot->rent_term_id==$rent_term->id?'selected':'' }}>{{ $rent_term->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input id="prices-{{ $index }}" name="prices[{{ $index }}]" type="text" class="form-control"  placeholder="Price" value="{{ $rent_term_pivot->pivot->price }}">
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endisset

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Priorities</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_trending" name="is_trending" value="1" {{ isset($product)&&($product->is_trending)?'checked':''}}>
                                        <label class="form-check-label" for="is_trending">Trending Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ isset($product)&&($product->is_featured)?'checked':''}}>
                                        <label class="form-check-label" for="is_featured">Hot Deal</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meta Data</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_title">Meta title</label>
                                <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Meta Title" value="{{ isset($product)?$product->meta_title:old('meta_title')}}">
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Meta Keywords" value="{{ isset($product)?$product->meta_keywords:old('meta_keywords')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="5" name="meta_description" placeholder="Meta Description">{{ isset($product)?$product->meta_description:old('meta_description')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
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


        $('input,select,textarea').attr('disabled','disabled')

    })
</script>
@endsection
