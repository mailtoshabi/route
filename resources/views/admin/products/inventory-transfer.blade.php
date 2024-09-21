@extends('layouts.master')
@section('title') @lang('translation.Inventory_Transfer') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Product_Manage') @endslot
@slot('title') @lang('translation.Inventory_Transfer') @endslot
@endcomponent
@if(session()->has('success')) <p class="text-success">{{ session()->get('success') }} @endif</p>
<div class="row">
    <form method="POST" action="{{ route('admin.products.branch.stock.store') }}">
        @csrf
        <input id="total_quantity" name="total_quantity" type="hidden" value="">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="control-label">Select Product</label>
                                <select name="product_id" id="product_id" class="form-control select2" onchange="onChangeGetStock()">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - Total Stock in all Branch:{{ $product->stock }}</option>
                                    @endforeach
                                </select>
                                @error('product_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="control-label">Branch From</label>
                                <select name="branch_from" id="branch_from" class="form-control select2" onchange="onChangeGetStock()">
                                    <option value="">Select</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_from') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="control-label">Branch To</label>
                                <select name="branch_to" id="branch_to" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_to') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="quantity">Quantity</label>
                                <input id="quantity" name="quantity" type="text" class="form-control" placeholder="Quantity" value="">
                                </select>
                                @error('quantity') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-4" id="branch_stock"></div>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Move</button>
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
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    });

    function onChangeGetStock() {
        var product = $('#product_id').val();
        var branch = $('#branch_from').val();
        var formdata = {product: product,branch: branch};
        // console.log(formdata);
        var url = "{{ route('admin.products.get.branch.stock') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: formdata,
            success: function (data) {
                console.log(data);
                if(typeof  data.product != 'undefined') {
                    var html = '<p>Stock of <strong>' + data.product + '</strong> in <strong>' + data.branch + '</strong> is <strong class="text-primary">' + data.stock + '</strong></p>';
                $('#branch_stock').html(html);
                $('#total_quantity').val(data.stock)
                }

            },
            error : function(jqXHR, textStatus, errorThrown) {

            },
            complete : function(jqXHR, textStatus) {
            }
        });
    }

</script>
@endsection
