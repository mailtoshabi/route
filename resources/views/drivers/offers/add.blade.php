@extends('layouts.drivers.master')
@section('title') @lang('translation.Add_Offers') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Offer_Management') @endslot
@slot('title') @lang('translation.Add_Offers') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($offer)? route('admin.offers.update', encrypt($offer->id)) : route('admin.offers.store')  }}">
        @csrf
        @if (isset($offer))
            {{-- <input type="hidden" name="offer_id" value="{{ encrypt($offer->id) }}" /> --}}
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
                                <input id="title" name="title" type="text" class="form-control"  placeholder="Title" value="{{ isset($offer)?$offer->title:old('title')}}">
                                @error('title') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description">Offer Description</label>
                                <textarea class="form-control" style="margin-bottom: 20px;" name="description" id="description" rows="9" placeholder="Offer Description">{{ isset($offer)?$offer->description:old('description')}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Type</label>
                                <select class="form-control select2" name="type" id="type">
                                    <option>Select</option>
                                    @foreach (Utility::offer_types() as $index => $offer_type)
                                        <option value="{{ $index }}" {{ isset($offer)&&($offer->type==$index) ? 'selected' : '' }}>{{ $offer_type }}</option>
                                    @endforeach
                                </select>
                                @error('type') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Starting Date</label>
                                <input type="text" class="form-control" id="starts_at" name="starts_at" value="{{ isset($offer)?$offer->starts_at->format('Y-m-d'):old('starts_at')}}">
                                @error('starts_at') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="title_ar">Title Arabic</label>
                                <input id="title_ar" name="title_ar" type="text" class="form-control"  placeholder="Title" value="{{ isset($offer)?$offer->title_ar:old('title_ar')}}">
                                @error('title_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description_ar">Offer Description Arabic</label>
                                <textarea class="form-control" style="margin-bottom: 20px;" name="description_ar" id="description_ar" rows="9" placeholder="Offer Description">{{ isset($offer)?$offer->description_ar:old('description_ar')}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="discount">Discount Value</label>
                                <input id="discount" name="discount" type="text" class="form-control"  placeholder="Discount Value" value="{{ isset($offer)?$offer->discount:old('discount')}}">
                                @error('discount') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">

                                <label class="form-label">End Date</label>
                                <input type="text" class="form-control" id="ends_at" name="ends_at" value="{{ isset($offer)?$offer->ends_at->format('Y-m-d'):old('ends_at')}}">
                                @error('ends_at') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Products</h4>
                    <p class="card-title-desc">Add offers to the Products</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="control-label">Select Products</label>
                                <select class="select2 form-control select2-multiple" name="products[]" multiple="multiple" data-placeholder="Choose ...">
                                    @foreach ($products as $product)
                                    <option value="{{ encrypt($product->id) }}" {{ isset($offer)&&($offer->products->contains($product->id)) ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('products') <p class="text-danger">{{ $message }}</p> @enderror
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
                                <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Meta Title" value="{{ isset($offer)?$offer->meta_title:old('meta_title')}}">
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Meta Keywords" value="{{ isset($offer)?$offer->meta_keywords:old('meta_keywords')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="5" placeholder="Meta Description">{{ isset($offer)?$offer->meta_description:old('meta_description')}}</textarea>
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

<script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    flatpickr('#starts_at,#ends_at', {
        @if (!isset($offer))
            defaultDate: new Date()
        @endif
});
</script>
@endsection
