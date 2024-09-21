@extends('layouts.master')
@section('title') @lang('translation.Add_Vehicle') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Shipping_Manage') @endslot
@slot('title') @lang('translation.Add_Vehicle') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($vehicle)? route('admin.vehicles.update',encrypt($vehicle->id)) : route('admin.vehicles.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($vehicle))

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
                                <label class="control-label">Driver</label>
                                <select id="driver_id" name="driver_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($drivers as $driver )
                                        <option value="{{ $driver->id }}" {{ isset($vehicle)&&($vehicle->driver_id==$driver->id)?'selected':''}}>{{ $driver->name }}</option>
                                    @endforeach
                                </select>
                                @error('driver_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="manufacture">Manufacture</label>
                                <input id="manufacture" name="manufacture" type="text" class="form-control" placeholder="Manufacture" value="{{ isset($vehicle)?$vehicle->manufacture:old('manufacture')}}">
                            </div>

                            <div class="mb-3">
                                <label for="model">Model</label>
                                <input id="model" name="model" type="text" class="form-control" placeholder="Model" value="{{ isset($vehicle)?$vehicle->model:old('model')}}">
                            </div>

                            <div class="mb-3">
                                <label for="vnumber">Number</label>
                                <input id="vnumber" name="vnumber" type="text" class="form-control" placeholder="Number" value="{{ isset($vehicle)?$vehicle->vnumber:old('vnumber')}}">
                                @error('vnumber') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="chase_no">Chasis Number</label>
                                <input id="chase_no" name="chase_no" type="text" class="form-control" placeholder="Chasis Number" value="{{ isset($vehicle)?$vehicle->chase_no:old('chase_no')}}">
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="width">width</label>
                                <input id="width" name="width" type="text" class="form-control"  placeholder="width" value="{{ isset($vehicle)?$vehicle->width:old('width')}}">
                            </div>

                            <div class="mb-3">
                                <label for="length">Length</label>
                                <input id="length" name="length" type="text" class="form-control"  placeholder="length" value="{{ isset($vehicle)?$vehicle->length:old('length')}}">
                            </div>

                            <div class="mb-3">
                                <label for="height">Height</label>
                                <input type="text"  class="form-control" id="height" name="height"  placeholder="Height" value="{{ isset($vehicle)?$vehicle->height:old('height')}}">
                            </div>

                            <div class="mb-3">
                                <label for="capacity">Capacity</label>
                                <input type="text"  class="form-control" id="capacity" name="capacity"  placeholder="Capacity" value="{{ isset($vehicle)?$vehicle->capacity:old('capacity')}}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry" name="expiry" value="{{ isset($vehicle)?$vehicle->expiry->format('Y-m-d'):old('expiry')}}">
                                @error('expiry') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Vehicle Image</h4>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <br><span id="imageContainer" @if(isset($vehicle)&&empty($vehicle->image)) style="display: none" @endif>
                                        @if(isset($vehicle)&&!empty($vehicle->image))
                                            <img src="{{ URL::asset(App\Models\Brand::DIR_STORAGE . $vehicle->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($vehicle)&&!empty($vehicle->image)) style="display: none" @endif>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        @if(isset($vehicle)&&!empty($vehicle->image))
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
    flatpickr('#expiry', {
        dateFormat: "d-m-Y",
        @if (!isset($vehicle))
            defaultDate: new Date()
        @endif
    });
</script>

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
