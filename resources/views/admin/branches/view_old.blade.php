@extends('layouts.master')
@section('title') @lang('translation.Branch_Details') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Branch_Manage') @endslot
@slot('li_2') @lang('translation.Branch_Details') @endslot
@slot('title') Details of {{ $branch->name }} @endslot
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
                            <label for="name">@lang('translation.Branch_Name')</label>
                            <input id="name" name="name" type="text" class="form-control"  placeholder="@lang('translation.Branch_Name')" value="{{ isset($branch)?$branch->name:old('name')}}">
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name_ar">@lang('translation.Branch_Name_Arabic')</label>
                            <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="@lang('translation.Branch_Name_Arabic')" value="{{ isset($branch)?$branch->name_ar:old('name_ar')}}">
                            @error('name_ar') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone" value="{{ isset($branch)?$branch->phone:old('phone')}}">
                            @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="building_no">Building No</label>
                            <input id="building_no" name="building_no" type="text" class="form-control"  placeholder="building_no" value="{{ isset($branch)?$branch->building_no:old('building_no')}}">
                            @error('building_no') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="street">Street</label>
                            <input id="street" name="street" type="text" class="form-control"  placeholder="street" value="{{ isset($branch)?$branch->street:old('street')}}">
                            @error('street') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="district">District</label>
                            <input id="district" name="district" type="text" class="form-control"  placeholder="district" value="{{ isset($branch)?$branch->district:old('district')}}">
                            @error('district') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city">City</label>
                            <input id="city" name="city" type="text" class="form-control"  placeholder="city" value="{{ isset($branch)?$branch->city:old('city')}}">
                            @error('city') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="postal_code">Postal Code</label>
                            <input id="postal_code" name="postal_code" type="text" class="form-control"  placeholder="postal_code" value="{{ isset($branch)?$branch->postal_code:old('postal_code')}}">
                            @error('postal_code') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if(isset($branch)&&!empty($branch->image))
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Warehouse Image</h4>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <span id="imageContainer" >
                                        <img src="{{ URL::asset(App\Models\Branch::DIR_STORAGE . $branch->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                        <button type="button" class="btn-close" aria-label="Close"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>

            </div> <!-- end card-->
        @endif

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
                            <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($branch)?$branch->email:old('email')}}">
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


    </div>

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
        $('input').attr('disabled','disabled')
    });
</script>
@endsection
