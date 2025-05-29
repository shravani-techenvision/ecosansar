@extends('layouts.master')
@section('title')
   Subscription Module
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Add @endslot
        @slot('title') Subscription Module @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                                
                                    <form action="{{$url}}" method="post">
                                    @csrf
                                          <div class="row">
                                              <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Plan Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Plan name" value="@if(isset($subscription->plan_name)){{ $subscription->plan_name }}@else{{ old('plan_name')}}@endif">
                                            @if ($errors->has('plan_name'))
                                                <span class="text-danger">{{ $errors->first('plan_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Plan Price<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="plan_price" id="plan_price" placeholder="Plan Price" value="@if(isset($subscription->plan_price)){{ $subscription->plan_price }}@else{{ old('plan_price')}}@endif">
                                            @if ($errors->has('plan_price'))
                                                <span class="text-danger">{{ $errors->first('plan_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Plan Validity<span style="color:red;">*</span></label>
                                            <select class="form-select" name="plan_validity" id="plan_validity" @if(isset($isEdit) && $isEdit) disabled @endif>
                                                <option value="">Select</option>
                                                <option 
                value="15" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "15") 
                    selected disabled 
                @endif>
                15 Days
            </option>
            <option 
                value="1" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "1") 
                    selected 
                @endif>
                1 Month
            </option>
            <option 
                value="3" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "3") 
                    selected 
                @endif>
                3 Month
            </option>
            <option 
                value="6" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "6") 
                    selected 
                @endif>
                6 Month
            </option>
            <option 
                value="12" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "12") 
                    selected 
                @endif>
                12 Month
            </option>
            <option 
                value="24" 
                @if(isset($subscription->plan_validity) && $subscription->plan_validity == "24") 
                    selected 
                @endif>
                24 Month
            </option>
                                            </select>
                                            @if ($errors->has('plan_validity'))
                                                <span class="text-danger">{{ $errors->first('plan_validity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    </div>
                                        <textarea id="elm1" name="plan_description" id="plan_description">@if(isset($subscription->plan_description)){{$subscription->plan_description}}@else{{old('plan_description')}}@endif</textarea>
                                        @if ($errors->has('plan_description'))
                                                <span class="text-danger">{{ $errors->first('plan_description') }}</span>
                                            @endif
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                 
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>




@endsection
