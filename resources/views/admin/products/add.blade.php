{{-- @extends(request()->routeIs('admin.*') ? 'layouts.master' : 'seller.layouts.master') --}}
@extends('layouts.master')
@section('title') @lang('translation.Add_Product') @endsection
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
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Product_Manage') @endslot
@slot('title') @lang('translation.Add_Product') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($product)? route('admin.products.update') : route('admin.products.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif
        {{-- @if(request()->routeIs('admin.rent_products.create') || request()->routeIs('admin.rent_products.edit') )
            <input type="hidden" name="rent_type" value="{{ Utility::PRODUCT_TYPE_RENT }}" />
        @else
            <input type="hidden" name="rent_type" value="{{ Utility::PRODUCT_TYPE_NORMAL }}" />
        @endif --}}
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
                            {{-- <div class="mb-3">
                                <label class="control-label">Sub Categories</label>
                                <select class="select2 form-control select2-multiple" name="sub_categories[]" id="sub_categories" multiple="multiple" data-placeholder="Choose ...">
                                    @foreach ($sub_categories as $sub_category)
                                        <option value="{{ encrypt($sub_category->id) }}" {{ isset($product)&&($product->sub_categories->contains($sub_category->id)) ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="mb-3">
                                <label class="control-label">Ware house</label>
                                <select name="branch_id" id="branch_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ isset($product)&&($product->branch_id==$branch->id)?'selected':''}}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Sub Category</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}" {{ isset($product)&&($product->sub_category_id==$sub_category->id)?'selected':''}}>{{ $sub_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="control-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ isset($product)&&($product->brand_id==$brand->id)?'selected':''}}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}


                            <div class="mb-3">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Product Description">{{ isset($product)?$product->description:old('description')}}</textarea>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label for="description_ar">Product Description Arabic</label>
                                <textarea class="form-control" name="description_ar" id="description_ar" rows="5" placeholder="Product Description Arabic">{{ isset($product)?$product->description_ar:old('description_ar')}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="model_year">Modal year</label>
                                <input id="model_year" name="model_year" type="text" class="form-control" placeholder="Modal year" value="{{ isset($product)?$product->model_year:old('model_year')}}">
                            </div>

                            {{-- <div class="mb-3">
                                <label class="control-label">Type</label>
                                <select class="form-control select2" name="type" id="type">
                                    <option>Select</option>
                                    @foreach (Utility::product_types() as $index => $product_type)
                                        <option value="{{ $index }}" {{ isset($product)&&($product->type==$index) ? 'selected' : '' }}>{{ $product_type }}</option>
                                    @endforeach
                                </select>
                                @error('type') <p class="text-danger">{{ $message }}</p> @enderror
                            </div> --}}

                            {{-- <div class="mb-3">
                                <label class="control-label">Product Size</label>
                                <select name="size" id="size" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_sizes() as $index => $product_size )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->size==$index)?'selected':'' }}>{{ $product_size['en']}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- <div class="mb-3">
                                <label class="control-label">Product Color</label>
                                <select name="color" id="color" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_colors() as $index => $product_color )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->color==$index)?'selected':'' }}>{{ $product_color['en']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sku">SKU Code</label>
                                <input id="sku" name="sku" type="text" class="form-control" placeholder="SKU Code" value="{{ isset($product)?$product->sku:old('sku')}}">
                            </div> --}}

                            <div class="mb-3">
                                <label for="barcode">Bar Code</label>
                                <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Bar Code" value="{{ isset($product)?$product->barcode:old('barcode')}}">
                            </div>

                            {{-- <div class="mb-3">
                                <label for="tax_type_id">Tax</label>
                                <select name="tax_type_id" id="tax_type_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ isset($product)&&($product->tax_type_id==$tax->id)?'selected':''}}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                                @error('tax_type_id') <p class="text-danger">{{ $message }} @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="delivery_days">Delivery Days</label>
                                <input id="delivery_days" name="delivery_days" type="text" class="form-control" placeholder="Delivery Days" value="{{ isset($product)?$product->delivery_days:old('delivery_days')}}">
                            </div>
                            {{-- <div class="mb-3">
                                <label for="warranty">Warranty</label>
                                <input id="warranty" name="warranty" type="text" class="form-control" placeholder="Warranty" value="{{ isset($product)?$product->warranty:old('warranty')}}">
                            </div>  --}}
                            {{-- <div class="mb-3">
                                <label for="video">Youtube Video Link</label>
                                <input id="video" name="video" type="text" class="form-control" placeholder="Video Link" value="{{ isset($product)?$product->video:old('video')}}">
                            </div> --}}
                            {{-- @if(request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') ) --}}
                                {{-- <div class="mb-3">
                                    <label class="control-label">Status</label>
                                    <select name="status" id="status" class="form-control select2">
                                        @foreach (Utility::status() as $index => $status )
                                        <option value="{{ $index}}" {{ isset($product)&&($product->status==$index)?'selected':'' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            {{-- @endif --}}
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
                    <h4 class="card-title mb-0">Product Image</h4>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <br><span id="imageContainer" @if(isset($product)&&empty($product->image)) style="display: none" @endif>
                                        @if(isset($product)&&!empty($product->image))
                                            <img src="{{ URL::asset(App\Models\Product::DIR_STORAGE . $product->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($product)&&!empty($product->image)) style="display: none" @endif>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        @if(isset($product)&&!empty($product->image))
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
                                <a class="btn-close" data-target="#close_container_{{ $index }}"></a>
                            </div>
                        @endforeach

                    @endisset
                    @empty($product)
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
                    data-count="{{ isset($product) ? $product->rentTerms->count()-1 : 0 }}"
                    data-addindex='[{"selector":".rent_terms","attr":"name", "value":"rent_terms"},{"selector":".prices","attr":"name", "value":"prices"}]'
                    data-plugins='[{"selector":".rent_terms","plugin":"select2"}]'
                    data-increment='[{"selector":".rent_terms","attr":"id", "value":"rent_terms"},{"selector":".prices","attr":"id", "value":"prices"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add</a>
                </div>
            </div> --}}


                {{-- <div class="row hidden" id="template_prices">
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
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Prices</h4>
                        <p class="card-title-desc">Fill all information below</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_day">Price Day</label>
                                    <input id="price_day" name="price_day" type="text" class="form-control"  placeholder="Price Day" value="{{ isset($product)?$product->price_day:old('price_day')}}">
                                    @error('price_day') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_week">Price Week</label>
                                    <input id="price_week" name="price_week" type="text" class="form-control"  placeholder="Price Week" value="{{ isset($product)?$product->price_week:old('price_week')}}">
                                    @error('price_week') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_month">Price Month</label>
                                    <input id="price_month" name="price_month" type="text" class="form-control"  placeholder="Price Month" value="{{ isset($product)?$product->price_month:old('price_month')}}">
                                    @error('price_month') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>



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

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ isset($product)&&($product->is_available)?'checked':''}}>
                                        <label class="form-check-label" for="is_available">Is Available</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{-- <label for="available_at">Available At</label> --}}
                                <input id="available_at" name="available_at" type="text" class="form-control" placeholder="Available At" value="{{ isset($product)?$product->available_at:old('available_at')}}">
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
