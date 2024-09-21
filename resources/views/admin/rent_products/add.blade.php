@extends('layouts.master')
@section('title') @lang('translation.Rent_Product_Add') @endsection
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
@slot('li_1') @lang('translation.Rental_Management') @endslot
@slot('title') @lang('translation.Rent_Product_Add') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($rent_product)? route('admin.rent_products.update') : route('admin.rent_products.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($rent_product))
            <input type="hidden" name="product_id" value="{{ encrypt($rent_product->id) }}" />
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
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Product Name" value="{{ isset($rent_product)?$rent_product->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Product Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Product Name Arabic" value="{{ isset($rent_product)?$rent_product->name_ar:old('name_ar')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Categories</label>
                                <select class="select2 form-control select2-multiple" name="categories[]" id="categories" multiple="multiple" data-placeholder="Choose ...">
                                    @foreach ($categories as $category)
                                        <option value="{{ encrypt($category->id) }}" {{ isset($rent_product)&&($rent_product->categories->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ isset($rent_product)&&($rent_product->brand_id==$brand->id)?'selected':''}}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Product Description">{{ isset($rent_product)?$rent_product->description:old('description')}}</textarea>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="purchase_price">Purchase Price</label>
                                <input id="purchase_price" name="purchase_price" type="text" class="form-control" placeholder="Purchase Price" value="{{ isset($product)?$product->purchase_price:old('purchase_price')}}">
                            </div> --}}
                            <div class="mb-3">
                                <label for="quantity">Quantity</label>
                                <input id="quantity" name="quantity" type="text" class="form-control" placeholder="Quantity" value="{{ isset($rent_product)?$rent_product->quantity:old('quantity')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Unit</label>
                                <select name="uom" id="uom" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_units() as $index => $rent_product_unit )
                                    <option value="{{ $index}}" {{ isset($rent_product)&&($rent_product->uom==$index)?'selected':'' }}>{{ $rent_product_unit['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Size</label>
                                <select name="size" id="size" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_sizes() as $index => $rent_product_size )
                                    <option value="{{ $index}}" {{ isset($rent_product)&&($rent_product->size==$index)?'selected':'' }}>{{ $rent_product_size['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Color</label>
                                <select name="color" id="color" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_colors() as $index => $rent_product_color )
                                    <option value="{{ $index}}" {{ isset($rent_product)&&($rent_product->color==$index)?'selected':'' }}>{{ $rent_product_color['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="barcode">Bar Code</label>
                                <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Bar Code" value="{{ isset($rent_product)?$rent_product->barcode:old('barcode')}}">
                            </div>
                            <div class="mb-3">
                                <label for="sku">SKU Code</label>
                                <input id="sku" name="sku" type="text" class="form-control" placeholder="SKU Code" value="{{ isset($rent_product)?$rent_product->sku:old('sku')}}">
                            </div>
                            <div class="mb-3">
                                <label for="tax_type_id">Tax</label>
                                <select name="tax_type_id" id="tax_type_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ isset($rent_product)&&($rent_product->tax_type_id==$tax->id)?'selected':''}}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                                @error('tax_type_id') <p class="text-danger">{{ $message }} @enderror
                            </div>
                            <div class="mb-3">
                                <label for="video">Youtube Video Link</label>
                                <input id="video" name="video" type="text" class="form-control" placeholder="Video Link" value="{{ isset($rent_product)?$rent_product->video:old('video')}}">
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    @foreach (Utility::status() as $index => $status )
                                    <option value="{{ $index}}" {{ isset($rent_product)&&($rent_product->status==$index)?'selected':'' }}>{{ $status }}</option>
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
                    <h4 class="card-title">Prices</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body" id="prices_container">
                    @isset($rent_product)
                        @foreach ($rent_product->rentTerms as $index => $rent_term_pivot)
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
                                <a class="btn-close" data-target="#close_container_{{ $index }}"></a>
                            </div>
                        @endforeach
                        {{-- <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Terms</label>
                                    <select class="form-control select2_rent_terms" name="rent_terms[{{ $index+1 }}]" id="rent_terms-{{ $index+1 }}">
                                        <option value="">Select</option>
                                        @foreach ($rent_terms as $rent_term)
                                            <option value="{{ encrypt($rent_term->id) }}">{{ $rent_term->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="prices">Price</label>
                                    <input id="prices-{{ $index+1 }}" name="prices[{{ $index+1 }}]" type="text" class="form-control"  placeholder="Price" value="">
                                </div>
                            </div>
                        </div> --}}
                    @endisset
                    @empty($rent_product)
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Terms</label>
                                    <select class="form-control select2_rent_terms" name="rent_terms[0]" id="rent_terms-0">
                                        <option value="">Select</option>
                                        @foreach ($rent_terms as $rent_term)
                                            <option value="{{ encrypt($rent_term->id) }}">{{ $rent_term->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="prices">Price</label>
                                    <input id="prices-0" name="prices[0]" type="text" class="form-control"  placeholder="Price" value="">
                                </div>
                            </div>
                        </div>
                    @endempty
                </div>
                <div class="p-4 pt-1">
                    <a href="#" data-toggle="add-more" data-template="#template_prices"
                       data-close=".wb-close" data-container="#prices_container"
                       data-count="{{ isset($rent_product) ? $index : 0 }}"
                       data-addindex='[{"selector":".rent_terms","attr":"name", "value":"rent_terms"},{"selector":".prices","attr":"name", "value":"prices"}]'
                       data-plugins='[{"selector":".rent_terms","plugin":"select2"}]'
                       data-increment='[{"selector":".rent_terms","attr":"id", "value":"rent_terms"},{"selector":".prices","attr":"id", "value":"prices"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add more</a>
                </div>
            </div>


            <div class="row hidden" id="template_prices">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Terms</label>
                        <select class="form-control rent_terms" name="" id="">
                            <option value="">Select</option>
                            @foreach ($rent_terms as $rent_term)
                                <option value="{{ encrypt($rent_term->id) }}">{{ $rent_term->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Price</label>
                        <input id="" name="" type="text" class="form-control prices"  placeholder="Price" value="">
                    </div>
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
                                        <input type="checkbox" class="form-check-input" id="is_trending" name="is_trending" value="1" {{ isset($rent_product)&&($rent_product->is_trending)?'checked':''}}>
                                        <label class="form-check-label" for="is_trending">Trending Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ isset($rent_product)&&($rent_product->is_featured)?'checked':''}}>
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
                                <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Meta Title" value="{{ isset($rent_product)?$rent_product->meta_title:old('meta_title')}}">
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Meta Keywords" value="{{ isset($rent_product)?$rent_product->meta_keywords:old('meta_keywords')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="5" name="meta_description" placeholder="Meta Description">{{ isset($rent_product)?$rent_product->meta_description:old('meta_description')}}</textarea>
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
                                    <select name="['related_rent_products']" id="['related_rent_products']" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
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
<script>
    $(document).ready(function() {
        $('.select2_rent_terms').select2();
        $(document).on("click", 'a[data-toggle="add-more"]', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var $el = $($(this).attr("data-template")).clone();
            $el.removeClass("hidden");
            $el.attr("id", "");

            var count = $(this).data('count');
            count = typeof count == "undefined" ? 0 : count;
            count = count + 1;
            $(this).data('count', count);

            var addindex = $(this).data("addindex");
            if(typeof addindex == "object") {
                $.each(addindex, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value + '[' + count + ']');
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +'['+count+']'+'['+have_child+']' );
                    }
                });
            }

            var increment = $(this).data("increment");
            if(typeof increment == "object") {
                $.each(increment, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count+"-"+have_child);
                    }
                });
            }

            var plugins = $(this).data("plugins");
            $.each(plugins, function(i, p) {
                if(p.plugin=='select2') {
                    //$el.find(p.selector).select2();
                }

            });

            $el.hide().appendTo($(this).attr("data-container")).fadeIn();

        });

        $(document).on('click','.btn-close',function(e) {
            e.preventDefault();
            var $this = $(this);
            var item_container = $(this).data('target');
            console.log(item_container);
            $(item_container).remove();
	    });

    })
</script>
@endsection
