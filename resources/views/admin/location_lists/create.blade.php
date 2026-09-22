@extends('layouts.master')

@section('title')
    Add Location
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') Location @endslot
    @slot('title') Add Location @endslot
@endcomponent

<div class="row justify-content-center align-items-center" style="margin-top: 50px;">
    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('location-list.save') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter name"
                                required
                            >

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Enter phone number"
                                maxlength="20"
                                required
                            >

                            @if ($errors->has('phone'))
                                <span class="text-danger">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Address <span class="text-danger">*</span>
                            </label>

                            <textarea
                                class="form-control"
                                name="address"
                                rows="3"
                                placeholder="Enter address"
                                required
                            >{{ old('address') }}</textarea>

                            @if ($errors->has('address'))
                                <span class="text-danger">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>

                        {{-- Pincode --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                Pincode <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="pincode"
                                value="{{ old('pincode') }}"
                                placeholder="Enter 6 digit pincode"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                required
                            >

                            @if ($errors->has('pincode'))
                                <span class="text-danger">
                                    {{ $errors->first('pincode') }}
                                </span>
                            @endif
                        </div>
                        {{-- Get Latitude Longitude Button --}}
                        <div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button
                                type="button"
                                class="btn btn-info w-100"
                                id="getLatLongBtn"
                            >
                                Get Latitude & Longitude
                            </button>
                        </div>
                        </div>

                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Latitude
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="latitude"
                                id="latitude"
                                value="{{ old('latitude') }}"
                                placeholder="Latitude"
                            >

                            @if ($errors->has('latitude'))
                                <span class="text-danger">
                                    {{ $errors->first('latitude') }}
                                </span>
                            @endif
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Longitude
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="longitude"
                                id="longitude"
                                value="{{ old('longitude') }}"
                                placeholder="Longitude"
                            >

                            @if ($errors->has('longitude'))
                                <span class="text-danger">
                                    {{ $errors->first('longitude') }}
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            Rating <span class="text-danger">*</span>
                        </label>
                    
                        <select class="form-select" name="rating" required>
                            <option value="">Select Rating</option>
                    
                            <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1.0</option>
                            <option value="1.5" {{ old('rating') == '1.5' ? 'selected' : '' }}>1.5</option>
                            <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2.0</option>
                            <option value="2.5" {{ old('rating') == '2.5' ? 'selected' : '' }}>2.5</option>
                            <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3.0</option>
                            <option value="3.5" {{ old('rating') == '3.5' ? 'selected' : '' }}>3.5</option>
                            <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4.0</option>
                            <option value="4.5" {{ old('rating') == '4.5' ? 'selected' : '' }}>4.5</option>
                            <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5.0</option>
                        </select>
                    
                        @if ($errors->has('rating'))
                            <span class="text-danger">
                                {{ $errors->first('rating') }}
                            </span>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Save
                            </button>

                            <a
                                href="{{ route('user.location-list') }}"
                                class="btn btn-secondary">
                                Cancel
                            </a>

                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
@section('script')
<script>
$(document).ready(function () {

    $('#getLatLongBtn').on('click', function () {

        let pincode = $('input[name="pincode"]').val();

        if (!pincode) {
            alert('Please enter pincode.');
            $('input[name="pincode"]').focus();
            return;
        }

        pincode = pincode.trim();

        if (!/^\d{6}$/.test(pincode)) {
            alert('Please enter a valid 6 digit pincode.');
            $('input[name="pincode"]').focus();
            return;
        }

        let button = $(this);

        button.prop('disabled', true);
        button.text('Getting Location...');

        $.ajax({
            url: "{{ route('location.get-lat-long') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                pincode: pincode
            },

            success: function (response) {

                if (response.success) {

                    $('#latitude').val(response.latitude);
                    $('#longitude').val(response.longitude);

                    alert('Latitude and Longitude calculated successfully.');

                } else {

                    alert(response.message || 'Unable to find location.');
                }
            },

            error: function (xhr) {

                console.log(xhr.responseJSON);

                let message = 'Unable to find location.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                alert(message);
            },

            complete: function () {
                button.prop('disabled', false);
                button.text('Get Latitude & Longitude');
            }
        });
    });

});
</script>
@endsection