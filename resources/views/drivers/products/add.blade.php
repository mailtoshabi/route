@extends('layouts.drivers.master')
@section('title') @lang('translation.Add_Product') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Product_Manage') @endslot
@slot('title') @lang('translation.Add_Product') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <form method="POST" action="{{ isset($product)? route('seller.products.update') : route('seller.products.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}" />
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
                                <label for="name">Product Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Product Name" value="{{ isset($product)?$product->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Product Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Product Name Arabic" value="{{ isset($product)?$product->name_ar:old('name_ar')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Categories</label>
                                <select class="select2 form-control select2-multiple" name="categories[]" id="categories" multiple="multiple" data-placeholder="Choose ...">
                                    @foreach ($categories as $category)
                                        <option value="{{ encrypt($category->id) }}" {{ isset($product)&&($product->categories->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ isset($product)&&($product->brand_id==$brand->id)?'selected':''}}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Product Description">{{ isset($product)?$product->description:old('description')}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price">Selling Price</label>
                                <input id="price" name="price" type="text" class="form-control" placeholder="Selling Price" value="{{ isset($product)?$product->price:old('price')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Unit</label>
                                <select name="uom" id="uom" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_units() as $index => $product_unit )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->uom==$index)?'selected':'' }}>{{ $product_unit['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Size</label>
                                <select name="size" id="size" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_sizes() as $index => $product_size )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->size==$index)?'selected':'' }}>{{ $product_size['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Color</label>
                                <select name="color" id="color" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_colors() as $index => $product_color )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->color==$index)?'selected':'' }}>{{ $product_color['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="barcode">Bar Code</label>
                                <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Bar Code" value="{{ isset($product)?$product->barcode:old('barcode')}}">
                            </div>
                            <div class="mb-3">
                                <label for="sku">SKU Code</label>
                                <input id="sku" name="sku" type="text" class="form-control" placeholder="SKU Code" value="{{ isset($product)?$product->sku:old('sku')}}">
                            </div>
                            <div class="mb-3">
                                <label for="tax_type_id">Tax</label>
                                <select name="tax_type_id" id="tax_type_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ isset($product)&&($product->tax_type_id==$tax->id)?'selected':''}}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                                @error('tax_type_id') <p class="text-danger">{{ $message }} @enderror
                            </div>
                            <div class="mb-3">
                                <label for="warranty">Warranty</label>
                                <input id="warranty" name="warranty" type="text" class="form-control" placeholder="Warranty" value="{{ isset($product)?$product->warranty:old('warranty')}}">
                            </div>
                            <div class="mb-3">
                                <label for="video">Youtube Video Link</label>
                                <input id="video" name="video" type="text" class="form-control" placeholder="Video Link" value="{{ isset($product)?$product->video:old('video')}}">
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    @foreach (Utility::status() as $index => $status )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->status==$index)?'selected':'' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Product Images</h4>
                </div>
                <div class="card-body">
                    <form action="/" method="post" class="dropzone">
                        <div class="fallback">
                            <input name="image" id="image" type="file" multiple />
                        </div>

                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                            </div>

                            <h4>Drop files here or click to upload.</h4>
                        </div>
                    </form>
                </div>

            </div> <!-- end card--> --}}

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

            {{-- <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Related Products</h4>
                    <p class="card-title-desc">Search all Related product</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="control-label">Select Releted Products</label>
                                    <select name="['related_products']" id="['related_products']" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                        <option value="1">Wireless</option>
                                        <option value="2">Battery life</option>
                                        <option value="3">Bass</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}

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
