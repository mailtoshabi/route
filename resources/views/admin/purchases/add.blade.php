@extends('layouts.master')
@section('title') @lang('translation.Add_Purchase') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
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
@slot('li_1') @lang('translation.Purchase_Manage') @endslot
@slot('title') @lang('translation.Add_Purchase') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($purchase)? route('admin.purchases.update',encrypt($purchase->id)) : route('admin.purchases.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($purchase))
            {{-- <input type="hidden" name="purchase_id" value="{{ encrypt($purchase->id) }}" /> --}}
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
                                <label for="invoice_no">Invoice Number</label>
                                <input id="invoice_no" name="invoice_no" type="text" class="form-control"  placeholder="Invoice Number" value="{{ isset($purchase)?$purchase->invoice_no:old('invoice_no')}}">
                                @error('invoice_no') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Date</label>
                                <input type="text" class="form-control" id="order_at" name="order_at" value="{{ isset($purchase)?$purchase->order_at->format('Y-m-d'):old('order_at')}}">
                                @error('order_at') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Supplier</label>
                                <select id="supplier_id" name="supplier_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($suppliers as $supplier )
                                        <option value="{{ $supplier->id }}" {{ isset($purchase)&&($purchase->supplier_id==$supplier->id)?'selected':''}}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Warehouse</label>
                                <select id="branch_id" name="branch_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($branches as $branch )
                                        <option value="{{ $branch->id }}" {{ isset($purchase)&&($purchase->branch_id==$branch->id)?'selected':''}}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Attach Purchase Order</h4>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <br><span id="po_attachmentContainer" @if(isset($purchase)&&empty($purchase->po_attachment)) style="display: none" @endif>
                                        @if(isset($purchase)&&!empty($purchase->po_attachment))
                                            <img src="{{ URL::asset(App\Models\Purchase::DIR_STORAGE . $purchase->po_attachment) }}" alt="" class="avatsar-xxl rounded-circle me-2 thumb_image">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($purchase)&&!empty($purchase->po_attachment)) style="display: none" @endif>
                                        <input id="po_attachment" name="po_attachment" type="file" class="form-control"  placeholder="File">
                                        @if(isset($purchase)&&!empty($purchase->po_attachment))
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                </div>

            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Purchase Items</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body" id="purchase_container">
                    @isset($purchase)
                    @foreach ($purchase->products as $index => $product_pivot)
                        <div class="row" id="rowContainer_{{ $index }}">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="product_ids_{{ $index }}">Product </label>
                                    <select id="product_ids_{{ $index }}" name="product_ids[{{ $index }}]" class="form-control select2" disabled>
                                        <option value="">Select</option>
                                        @foreach ($products as $product )
                                            <option value="{{ encrypt($product->id) }}" {{ ($product->id==$product_pivot->pivot->product_id)?'selected':'' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="quantities_{{ $index }}">Quantity</label>
                                    <input id="quantities_{{ $index }}" name="quantities[{{ $index }}]" type="text" class="form-control quantities gettotal" data-index="{{ $index }}" placeholder="Quantity" value="{{ $product_pivot->pivot->quantity }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="prices_{{ $index }}">Price</label>
                                    <input id="prices_{{ $index }}" name="prices[{{ $index }}]" type="text" class="form-control prices gettotal"  placeholder="Price" data-index="{{ $index }}" value="{{ $product_pivot->pivot->price }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="vats_{{ $index }}">VAT</label>
                                    <input id="vats_{{ $index }}" name="vats[{{ $index }}]" type="text" class="form-control vats gettotal"  placeholder="VAT" data-index="{{ $index }}" value="{{ $product_pivot->pivot->vat }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="total_amounts_{{ $index }}">Total Amount</label>
                                    <input id="total_amounts_{{ $index }}" name="total_amounts[{{ $index }}]" type="text" class="form-control total_amounts"  placeholder="Total Amount" value="{{ $product_pivot->pivot->quantity*($product_pivot->pivot->price + $product_pivot->pivot->vat) }}" disabled>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endisset
                    @empty($purchase)
                        <div class="row" id="rowContainer_0">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="product_ids_0">Product</label>
                                    <select id="product_ids_0" name="product_ids[0]" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($products as $product )
                                            <option value="{{ encrypt($product->id) }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="quantities_0">Quantity</label>
                                    <input id="quantities_0" name="quantities[0]" type="text" class="form-control quantities gettotal" data-index="0" placeholder="Quantity" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="prices_0">Price</label>
                                    <input id="prices_0" name="prices[0]" type="text" class="form-control prices gettotal"  placeholder="Price" data-index="0" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="vats_0">VAT</label>
                                    <input id="vats_0" name="vats[0]" type="text" class="form-control vats gettotal"  placeholder="VAT" data-index="0" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="total_amounts_0">Total Amount</label>
                                    <input id="total_amounts_0" name="total_amounts[0]" type="text" class="form-control total_amounts"  placeholder="Total Amount" value="0" disabled>
                                </div>
                            </div>
                        </div>
                    @endempty

                </div>
                @empty($purchase)
                    <div class="p-4 pt-1">
                        <a href="#" data-toggle="add-more" data-template="#template_purchase"
                        data-close=".wb-close" data-container="#purchase_container"
                        data-count="{{ isset($purchase) ? $index : 0 }}"
                        data-addindex='[{"selector":".product_ids","attr":"name", "value":"product_ids"},{"selector":".quantities","attr":"name", "value":"quantities"},{"selector":".prices","attr":"name", "value":"prices"},{"selector":".vats","attr":"name", "value":"vats"},{"selector":".total_amounts","attr":"name", "value":"total_amounts"}]'
                        data-plugins='[{"selector":".product_ids","plugin":"select2"}]'
                        data-increment='[{"selector":".product_ids","attr":"id", "value":"product_ids"},{"selector":".quantities","attr":"id", "value":"quantities"},{"selector":".prices","attr":"id", "value":"prices"},{"selector":".vats","attr":"id", "value":"vats"},{"selector":".total_amounts","attr":"id", "value":"total_amounts"}]'><i
                                    class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add more</a>
                    </div>
                @endempty
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">

                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="mb-3">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="mb-3">
                                <label>Sub Total </label>
                                <h5 id="sub_total">{{ isset($purchase) ? Utility::CURRENCY_DISPLAY . ' ' . $purchase->purchase_total['price'] : 0 }}</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="mb-3">
                                <label >Total VAT</label>
                                <h5 id="vats_total">{{ isset($purchase) ? Utility::CURRENCY_DISPLAY . ' ' . $purchase->purchase_total['vat'] : 0 }}</h5>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="mb-3">
                                <label>Final Amount</label>
                                <h5 id="final_amount">{{ isset($purchase) ? Utility::CURRENCY_DISPLAY . ' ' . $purchase->purchase_total['price'] + $purchase->purchase_total['vat'] : 0 }}</h5>
                            </div>
                        </div>
                    </div>
                    @isset($purchase)
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <h5 style="text-align:right;"> Final Amount is <span style="text-transform:capitalize;">{{ Utility::currencyToWords($purchase->purchase_total['price'] + $purchase->purchase_total['vat']) }}</span></h5>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>

            <div class="hidden" id="template_purchase">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label>Product</label>
                            <select id="" name="" class="form-control product_ids">
                                <option value="">Select</option>
                                @foreach ($products as $product )
                                    <option value="{{ encrypt($product->id) }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input id="" name="" type="text" class="form-control quantities gettotal" data-index="" placeholder="Quantity" value="">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label>Price</label>
                            <input id="" name="" type="text" class="form-control prices gettotal"  placeholder="Price" data-index="" value="">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label >VAT</label>
                            <input id="" name="" type="text" class="form-control vats gettotal"  placeholder="VAT" data-index="" value="">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label >Total Amount</label>
                            <input id="" name="" type="text" class="form-control total_amounts"  placeholder="Total Amount" value="" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($purchase) ? 'Update' : 'Add New' }}</button>
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

<script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    flatpickr('#order_at', {
        dateFormat: "d-m-Y",
        @if (!isset($purchase))
            defaultDate: new Date()
        @endif
    });
</script>
<script>
    $(document).ready(function() {
        $('#po_attachmentContainer').find('button').click(function() {
            $('#po_attachmentContainer').hide();
            $('#fileContainer').show();
            $('input[name="isImageDelete"]').val(1);
        })

        $('#fileContainer').find('button').click(function() {
            $('#fileContainer').hide();
            $('#po_attachmentContainer').show();
            $('input[name="isImageDelete"]').val(0);
        })



        $('#purchase_container').on('keyup','.gettotal',function(e) {
            e.preventDefault();
            var $this = $(this);
            var index = $(this).data('index');
            var vats = 0;
            var item_container = '#rowContainer_' + index;

            var quantities = parseInt($(item_container).find('#quantities_' + index).val());
            if(isNaN(quantities)) {
                var quantities = 1;
            }

            var prices = parseInt($(item_container).find('#prices_' + index).val());
            if(isNaN(prices)) {
                var prices = 0;
            }

            var vats = parseInt($(item_container).find('#vats_' + index).val());
            if(isNaN(vats)) {
                var vats = 0;
            }

            total = quantities*(prices+vats);

            $(item_container).find('#total_amounts_' + index).val(total);

            $(item_container).find('#sub_total').text(total);

            grandTotal();
	    });


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

            $el.find('.row').attr("id","rowContainer_"+count);

            var addindex = $(this).data("addindex");
            if(typeof addindex == "object") {
                $.each(addindex, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value + '[' + count + ']');
                        $el.find(p.selector).attr('data-index', count);
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
                        $el.find(p.selector).attr(p.attr, p.value +"_"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +"_"+count+"_"+have_child);
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

    });
</script>
<script>
    function grandTotal() {
        var sub_total_prices = 0;
        var sub_total_vats = 0;
        $("input.quantities").each(function (index) {
            var data_index = $(this).data('index');
            var quantities = parseInt($(this).val());
            if(isNaN(quantities)) {
                var quantities = 1;
            }
            var prices = parseInt($('#prices_'+data_index).val());
            if(isNaN(prices)) {
                var prices = 0;
            }

            var vats = parseInt($('#vats_'+data_index).val());
            if(isNaN(vats)) {
                var vats = 0;
            }

            var total_prices = quantities * prices;
            var total_vats = quantities * vats;

            sub_total_prices += total_prices;
            sub_total_vats += total_vats;
        });
        $('#sub_total').text(sub_total_prices);
        $('#vats_total').text(sub_total_vats);
        $('#final_amount').text(sub_total_prices+sub_total_vats);
    }
</script>

@endsection
