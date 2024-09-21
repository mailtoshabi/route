@extends('layouts.master')
@section('title') @lang('translation.Add_Supplier') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Purchase_Manage') @endslot
@slot('title') @lang('translation.Add_Supplier') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($supplier)? route('admin.suppliers.update') : route('admin.suppliers.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($supplier))
            <input type="hidden" name="supplier_id" value="{{ encrypt($supplier->id) }}" />
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
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="First Name" value="{{ isset($supplier)?$supplier->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Name Arabic" value="{{ isset($supplier)?$supplier->name_ar:old('name_ar')}}">
                                @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control"  placeholder="Email" value="{{ isset($supplier)?$supplier->email:old('email')}}">
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone" value="{{ isset($supplier)?$supplier->phone:old('phone')}}">
                                @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location">Place</label>
                                <input id="location" name="location" type="text" class="form-control" placeholder="Place" value="{{ isset($supplier)?$supplier->location:old('location')}}">
                            </div>


                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="legal_name">Legal Name</label>
                                <input id="legal_name" name="legal_name" type="text" class="form-control" placeholder="Legal Name" value="{{ isset($supplier)?$supplier->legal_name:old('legal_name')}}">
                            </div>
                            <div class="mb-3">
                                <label for="business_email">Business Email</label>
                                <input id="business_email" name="business_email" type="text" class="form-control" placeholder="Business Email" value="{{ isset($supplier)?$supplier->business_email:old('business_email')}}">
                            </div>
                            <div class="mb-3">
                                <label for="vat_number">Vat Number</label>
                                <input id="vat_number" name="vat_number" type="text" class="form-control" placeholder="Vat Number" value="{{ isset($supplier)?$supplier->vat_number:old('vat_number')}}">
                            </div>
                            <div class="mb-3">
                                <label for="cr_number">CR number</label>
                                <input id="cr_number" name="cr_number" type="text" class="form-control" placeholder="CR number" value="{{ isset($supplier)?$supplier->cr_number:old('cr_number')}}">
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address"  rows="5" placeholder="Address">{{ isset($supplier)?$supplier->address:old('address')}}</textarea>
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
@endsection
