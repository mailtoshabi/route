@extends('layouts.master')
@section('title') @lang('translation.Customer_Details') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Customer_Manage') @endslot
@slot('li_2') @lang('translation.Customer_Details') @endslot
@slot('title') Details of {{ $customer->name }} @endslot
@endcomponent
<div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="customer_id">@lang('translation.Customer_ID')</label>
                                <input id="customer_id" name="customer_id" type="text" class="form-control"  placeholder="@lang('translation.Customer_ID')" value="{{ isset($customer)?$customer->id:old('customer_id')}}">
                            </div>
                            <div class="mb-3">
                                <label for="first_name">@lang('translation.First_Name')</label>
                                <input id="first_name" name="first_name" type="text" class="form-control"  placeholder="@lang('translation.First_Name')" value="{{ isset($customer)?$customer->first_name:old('first_name')}}">
                                {{-- @error('first_name') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                            <div class="mb-3">
                                <label for="last_name">@lang('translation.Last_Name')</label>
                                <input id="last_name" name="last_name" type="text" class="form-control"  placeholder="@lang('translation.Last_Name')" value="{{ isset($customer)?$customer->last_name:old('last_name')}}">
                                {{-- @error('last_name') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($customer)?$customer->email:old('email')}}">
                                {{-- @error('email') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone" value="{{ isset($customer)?$customer->phone:old('phone')}}">
                                {{-- @error('phone') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                            <div class="mb-3">
                                <label for="building_no">Building No</label>
                                <input id="building_no" name="building_no" type="text" class="form-control"  placeholder="Building No" value="{{ isset($customer)?$customer->building_no:old('building_no')}}">
                                {{-- @error('building_no') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="street">Street</label>
                                <input id="street" name="street" type="text" class="form-control"  placeholder="Street" value="{{ isset($customer)?$customer->street:old('street')}}">
                                {{-- @error('street') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>

                            <div class="mb-3">
                                <label for="district">District</label>
                                <input id="district" name="district" type="text" class="form-control"  placeholder="District" value="{{ isset($customer)?$customer->district:old('district')}}">
                                {{-- @error('district') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>

                            <div class="mb-3">
                                <label for="city">City</label>
                                <input id="city" name="city" type="text" class="form-control"  placeholder="City" value="{{ isset($customer)?$customer->city:old('city')}}">
                                {{-- @error('city') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>

                            <div class="mb-3">
                                <label for="postal_code">Postal Code</label>
                                <input id="postal_code" name="postal_code" type="text" class="form-control"  placeholder="Postal Code" value="{{ isset($customer)?$customer->postal_code:old('postal_code')}}">
                                {{-- @error('postal_code') <p class="text-danger">{{ $message }}</p> @enderror --}}
                            </div>
                            <div class="mb-3">
                                <label for="created_at">Registration Date</label>
                                <input id="created_at" name="created_at" type="text" class="form-control"  placeholder="Postal Code" value="{{ isset($customer)?$customer->created_at->format('d-m-Y'):old('created_at')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($customer)?$customer->email:old('email')}}">
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="horizontal-password-input">Password</label>
                                <input type="password" name="password" class="form-control" id="horizontal-password-input" placeholder="Enter Your Password">
                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div> --}}
        </div>
</div>
<!-- end row -->
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('input').attr('disabled','disabled')
    });
</script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
