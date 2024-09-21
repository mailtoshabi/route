@extends('layouts.drivers.master')
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
@slot('li_1') @lang('translation.Product_Manage') @endslot
@slot('title') @lang('translation.Product_Item_Manage_Add') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($product_item)? route('branch.product_items.update') : route('branch.product_items.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product_item))
            <input type="hidden" name="product_item_id" value="{{ encrypt($product_item->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Informations</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Select Product</label>
                                <select class="select2 form-control" name="product_id" id="product_id">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ encrypt($product->id) }}" {{ isset($product_item)&&($product_item->product_id==$product->id)?'selected':''}}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="item_code">Item Code</label>
                                <input id="item_code" name="item_code" type="text" class="form-control" placeholder="Item Code" value="{{ isset($product_item)?$product_item->item_code:old('item_code')}}">
                                @error('item_code') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name">Product Modal Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Product Modal Name" value="{{ isset($product_item)?$product_item->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Product Modal Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Product Modal Name Arabic" value="{{ isset($product_item)?$product_item->name_ar:old('name_ar')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>


                        </div>

                        <div class="col-sm-6">
                            {{-- <div class="mb-3">
                                <label class="control-label">Unit</label>
                                <select name="uom" id="uom" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_units() as $index => $product_item_unit )
                                    <option value="{{ $index}}" {{ isset($product_item)&&($product_item->uom==$index)?'selected':'' }}>{{ $product_item_unit['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Size</label>
                                <select name="size" id="size" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_sizes() as $index => $product_item_size )
                                    <option value="{{ $index}}" {{ isset($product_item)&&($product_item->size==$index)?'selected':'' }}>{{ $product_item_size['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Product Color</label>
                                <select name="color" id="color" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_colors() as $index => $product_item_color )
                                    <option value="{{ $index}}" {{ isset($product_item)&&($product_item->color==$index)?'selected':'' }}>{{ $product_item_color['en']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="barcode">Bar Code</label>
                                <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Bar Code" value="{{ isset($product_item)?$product_item->barcode:old('barcode')}}">
                            </div>
                            <div class="mb-3">
                                <label for="sku">SKU Code</label>
                                <input id="sku" name="sku" type="text" class="form-control" placeholder="SKU Code" value="{{ isset($product_item)?$product_item->sku:old('sku')}}">
                            </div>
                            <div class="mb-3">
                                <label for="tax_type_id">Tax</label>
                                <select name="tax_type_id" id="tax_type_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ isset($product_item)&&($product_item->tax_type_id==$tax->id)?'selected':''}}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                                @error('tax_type_id') <p class="text-danger">{{ $message }} @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="model_year">Modal year</label>
                                <input id="model_year" name="model_year" type="text" class="form-control" placeholder="Modal year" value="{{ isset($product_item)?$product_item->model_year:old('model_year')}}">
                            </div>
                            <div class="mb-3">
                                <label for="glocation">Google Location</label>
                                <input id="glocation" name="glocation" type="text" class="form-control" placeholder="Google Location" value="{{ isset($product_item)?$product_item->glocation:old('glocation')}}">
                            </div>
                            <div class="mb-3">
                                <label for="video">Youtube Video Link</label>
                                <input id="video" name="video" type="text" class="form-control" placeholder="Video Link" value="{{ isset($product_item)?$product_item->video:old('video')}}">
                            </div>

                            <div class="mb-3">
                                <label for="delivery_days">Delivery Days</label>
                                <input id="delivery_days" name="delivery_days" type="text" class="form-control" placeholder="Delivery Days" value="{{ isset($product_item)?$product_item->delivery_days:old('delivery_days')}}">
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    @foreach (Utility::status() as $index => $status )
                                    <option value="{{ $index}}" {{ isset($product_item)&&($product_item->status==$index)?'selected':'' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Product Image</h4>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <br><span id="imageContainer" @if(isset($product_item)&&empty($product_item->image)) style="display: none" @endif>
                                        @if(isset($product_item)&&!empty($product_item->image))
                                            <img src="{{ URL::asset(App\Models\Product::DIR_STORAGE . $product_item->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($product_item)&&!empty($product_item->image)) style="display: none" @endif>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        @if(isset($product_item)&&!empty($product_item->image))
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>

            </div> <!-- end card-->

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
                    @isset($product_item)
                        @foreach ($product_item->rentTerms as $index => $rent_term_pivot)
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
                    @empty($product_item)
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
                       data-count="{{ isset($product_item) ? $index : 0 }}"
                       data-addindex='[{"selector":".rent_terms","attr":"name", "value":"rent_terms"},{"selector":".prices","attr":"name", "value":"prices"}]'
                       data-plugins='[{"selector":".rent_terms","plugin":"select2"}]'
                       data-increment='[{"selector":".rent_terms","attr":"id"},{"selector":".prices","attr":"id"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add more Range</a>
                </div>
            </div>


            <div class="row hidden" id="template_prices">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Terms</label>
                        <select class="form-control rent_terms" name="" id="rent_terms">
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
                        <input id="prices" name="" type="text" class="form-control prices"  placeholder="Price" value="">
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
                                        <input type="checkbox" class="form-check-input" id="is_trending" name="is_trending" value="1" {{ isset($product_item)&&($product_item->is_trending)?'checked':''}}>
                                        <label class="form-check-label" for="is_trending">Trending Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ isset($product_item)&&($product_item->is_featured)?'checked':''}}>
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
                                <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Meta Title" value="{{ isset($product_item)?$product_item->meta_title:old('meta_title')}}">
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Meta Keywords" value="{{ isset($product_item)?$product_item->meta_keywords:old('meta_keywords')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="5" name="meta_description" placeholder="Meta Description">{{ isset($product_item)?$product_item->meta_description:old('meta_description')}}</textarea>
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
                                    <select name="['related_product_items']" id="['related_product_items']" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
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
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
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
                        $el.find(p.selector).attr(p.attr, $el.find(p.selector).attr(p.attr)+'['+count+']'+'['+have_child+']' );
                    }
                });
            }

            var increment = $(this).data("increment");
            if(typeof increment == "object") {
                $.each(increment, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, $el.find(p.selector).attr(p.attr)+"-"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, $el.find(p.selector).attr(p.attr)+"-"+count+"-"+have_child);
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
