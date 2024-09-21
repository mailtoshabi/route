@extends('layouts.master')
@section('title', 'Add orders')
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Sale_Manage') @endslot
@slot('title') @lang('translation.Sales') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($product)? route('admin.products.update') : route('admin.products.store')  }}" enctype="multipart/form-data">
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
                                <label class="control-label">Customers</label>
                                <input id="customer_id" name="customer_id" type="text" class="form-control" value="1" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="customer_address_id">customer_address_id</label>
                                <input id="customer_address_id" name="customer_address_id" type="text" class="form-control" value="1">
                            </div>
                            <div class="mb-3">
                                <label for="invoice_no">invoice_no</label>
                                <input id="invoice_no" name="invoice_no" type="text" class="form-control"  placeholder="invoice_no" value="INV004/2023">

                            </div>
                            <div class="mb-3">
                                <label class="control-label">pay_method</label>
                                <select class="select2 form-control" name="pay_method" id="pay_method"  data-placeholder="Choose ...">
                                    <option value="1">Online</option>
                                    <option value="2">COD</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">is_delivery</label>
                                <select class="select2 form-control" name="is_delivery" id="is_delivery"  data-placeholder="Choose ...">
                                    <option value="0">pickup</option>
                                    <option value="1">delivery</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="delivery_charge">delivery_charge</label>
                                <input id="delivery_charge" name="delivery_charge" type="text" class="form-control" value="30">
                            </div>

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
                                <label class="control-label">Unit</label>
                                <select name="uom" id="uom" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (Utility::product_units() as $index => $product_unit )
                                    <option value="{{ $index}}" {{ isset($product)&&($product->uom==$index)?'selected':'' }}>{{ $product_unit['en']}}</option>
                                    @endforeach
                                </select>
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

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Products</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label>product id</label>
                                    <input id="prices-1" name="prices[]" type="text" class="form-control"  placeholder="Price" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Price</label>
                                <input id="prices-" name="prices[]" type="text" class="form-control"  placeholder="Price" value="">
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

@endsection
