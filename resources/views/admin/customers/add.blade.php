@extends('layouts.master')
@section('title') @lang('translation.Add_Customer') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Customer_Manage') @endslot
@slot('title') @lang('translation.Add_Customer') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($customer)? route('admin.customers.update') : route('admin.customers.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($customer))
            <input type="hidden" name="customer_id" value="{{ encrypt($customer->id) }}" />
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
                                <label for="name">@lang('translation.Name')</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="@lang('translation.Name')" value="{{ isset($customer)?$customer->name:old('name')}}">
                                {{-- @error('name') <p class="text-danger">{{ $message }}</p> @enderror --}}
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
