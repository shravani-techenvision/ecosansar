@extends('layouts.master')
@section('title')
Google Adsense Add
@endsection
<style>
    .hr-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.hr-wrapper hr {
    flex: 1;
    border: none;
    border-top: 1px solid #ccc;
    margin: 0 10px; /* Adjust margin as needed */
}

.hr-wrapper h2 {
    margin: 0;
    padding: 0 10px;
    white-space: nowrap;
}
</style>
@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Google Adsense @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Place of Adsense<span style="color:red;">*</span></label>
                                            <select class="form-select" name="place_of_adsense" id="place_of_adsense">
                                                <option value="">Select</option>
                                                <option @if(isset($gadsense->place_of_adsense) && ($gadsense->place_of_adsense == "After banner image")) selected @else @endif  value="After banner image">After banner image</option>
                                                <option @if(isset($gadsense->place_of_adsense) && ($gadsense->place_of_adsense == "Before our statistics")) selected @else @endif  value="Before our statistics">Before our statistics</option>
                                                <option @if(isset($gadsense->place_of_adsense) && ($gadsense->place_of_adsense == "After search filter")) selected @else @endif  value="After search filter">After search filter</option>
                                                <option @if(isset($gadsense->place_of_adsense) && ($gadsense->place_of_adsense == "After about breadcrumb")) selected @else @endif  value="After about breadcrumb">After about breadcrumb</option>
                                            </select>
                                            @if ($errors->has('place_of_adsense'))
                                                <span class="text-danger">{{ $errors->first('place_of_adsense') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Google Adsense Script</label>
                                            <textarea class="form-control" name="adsense_script" id="adsense_script" placeholder="Enter Script">@if(isset($gadsense->adsense_script)){{ $gadsense->adsense_script }}@else{{ old('adsense_script')}}@endif</textarea>
                                            @if ($errors->has('adsense_script'))
                                                <span class="text-danger">{{ $errors->first('adsense_script') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="hr-wrapper">
        <hr>
        <h2 class="modal-title text-center"><strong>OR</strong></h2>
        <hr>
    </div>
                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Google Adsense Image</label>
                                             @if(isset($gadsense->adsense_image))
                                            <img src="{{ asset('assets/images/Googleadsense/' . $gadsense->adsense_image) }}" alt="Current Profile Image" class="img-thumbnail mb-2" style="max-width: 200px;">
                                        @else
                                            <p>No image available.</p>
                                        @endif
                                            <input type="file" class="form-control" name="adsense_image" id="adsense_image" placeholder="Enter maximum weight">
                                            @if ($errors->has('adsense_image'))
                                                <span class="text-danger">{{ $errors->first('adsense_image') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('googleadsense.list')}}" class="btn btn-primary">Cancel</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
@endsection
