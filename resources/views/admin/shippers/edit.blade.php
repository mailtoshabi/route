@extends('layouts.master')
@section('title') @lang('translation.Vednor_Details') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Brand_Manage') @endslot
@slot('title') @lang('translation.Vednor_Details') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($seller)? route('admin.sellers.update',encrypt($seller->id)) : route('admin.sellers.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($seller))

            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Seller Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="form-control"  placeholder="First Name" value="{{ isset($seller)?$seller->first_name:old('first_name')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="form-control"  placeholder="Last Name" value="{{ isset($seller)?$seller->last_name:old('last_name')}}">

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone" value="{{ isset($seller)?$seller->phone:old('phone')}}">

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control"  placeholder="Email" value="{{ isset($seller)?$seller->email:old('email')}}">

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address"  rows="5" placeholder="Address">{{ isset($seller)?$seller->address:old('address')}}</textarea>
                            </div>
                        </div>



                        </div>
                    </div>
                </div>




                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Company Document</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="legal_name">Leagal Name</label>
                                <input id="legal_name" name="legal_name" type="text" class="form-control"  placeholder="Leagal Name" value="{{ isset($seller)?$seller->legal_name:old('legal_name')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="business_email">Business Email</label>
                                <input id="business_email" name="business_email" type="text" class="form-control"  placeholder="Business Email" value="{{ isset($seller)?$seller->business_email:old('business_email')}}">

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="vat_number">VAT/TIN No.</label>
                                <input id="vat_number" name="vat_number" type="text" class="form-control"  placeholder="VAT/TIN No" value="{{ isset($seller)?$seller->vat_number:old('vat_number')}}">

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="productname">VAT Certificate</label>
                                <p style="padding-top: 8px;"><a href="{{ route('admin.sellers.download.document', ['id' => $seller->vat_scan,'type' => 1]) }}"><i class="fa fa-download icon-sm"></i> &nbsp; Download </a></p>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="cr_number">CR Number</label>
                                <input id="cr_number" name="cr_number" type="text" class="form-control"  placeholder="CR Number" value="{{ isset($seller)?$seller->cr_number:old('cr_number')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">CR Certificate</label>
                                <p style="padding-top: 8px;"><a href="{{ route('admin.sellers.download.document', ['id' => $seller->cr_scan,'type' => 2]) }}"><i class="fa fa-download icon-sm"></i> &nbsp; Download </a></p>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bank Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="bank_id">Bank Name</label>
                                    <select class="form-select" id="bank_id" name="bank_id">
                                        <option selected>Select Bank Details</option>
                                        @foreach ($banks as $bank)
                                        <option value="{{ encrypt($bank->id) }}" {{ isset($seller)&&($seller->bank->id==$bank->id) ? 'selected' : '' }}>{{ $bank->name_en }}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="branch_name">Branch Name</label>
                                    <input id="branch_name" name="branch_name" type="text" class="form-control"  placeholder="Branch Name" value="{{ isset($seller)?$seller->branch_name:old('branch_name')}}">

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="iban_number">IBAN</label>
                                    <input id="iban_number" name="iban_number" type="text" class="form-control"  placeholder="IBAN" value="{{ isset($seller)?$seller->iban_number:old('iban_number')}}">

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="account_number">Account Number</label>
                                    <input id="account_number" name="account_number" type="text" class="form-control"  placeholder="Account Number" value="{{ isset($seller)?$seller->account_number:old('account_number')}}">

                                </div>

                            </div>
                        </div>

                    </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($seller) ? 'Update' : 'Add New' }}</button>
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
