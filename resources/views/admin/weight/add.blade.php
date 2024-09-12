@extends('layouts.master')
@section('title')
Weight Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Weight @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            {{--  <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups</h5>  --}}

                            <form action="{{ $url }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Min weight<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="min_weight" id="min_weight" placeholder="Enter minimum weight" value="@if(isset($weight->min_weight)){{ $weight->min_weight }}@else{{ old('min_weight')}}@endif">
                                            @if ($errors->has('min_weight'))
                                                <span class="text-danger">{{ $errors->first('min_weight') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Measurement<span style="color:red;">*</span></label>
                                            <select class="form-select" name="min_measure" id="min_measure">
                                                <option value="">Select</option>
                                                <option @if(isset($weight->min_measure) && ($weight->min_measure == "Kg")) selected @else @endif  value="Kg">Kg</option>
                                                <option @if(isset($weight->min_measure) && ($weight->min_measure == "Ton")) selected @else @endif  value="Ton">Ton</option>
                                            </select>
                                            @if ($errors->has('min_measure'))
                                                <span class="text-danger">{{ $errors->first('min_measure') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Max weight<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="max_weight" id="max_weight" placeholder="Enter maximum weight" value="@if(isset($weight->max_weight)){{ $weight->max_weight }}@else{{ old('max_weight')}}@endif">
                                            @if ($errors->has('max_weight'))
                                                <span class="text-danger">{{ $errors->first('max_weight') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Measurement<span style="color:red;">*</span></label>
                                            <select class="form-select" name="max_measure" id="max_measure">
                                                <option value="">Select</option>
                                                <option @if(isset($weight->max_measure) && ($weight->max_measure == "Kg")) selected @else @endif  value="Kg">Kg</option>
                                                <option @if(isset($weight->max_measure) && ($weight->max_measure == "Ton")) selected @else @endif  value="Ton">Ton</option>
                                            </select>
                                            @if ($errors->has('max_measure'))
                                                <span class="text-danger">{{ $errors->first('max_measure') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('weight.list')}}" class="btn btn-primary">Cancel</a>
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
