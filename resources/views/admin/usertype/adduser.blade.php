@extends('layouts.master')
@section('title')
User Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   User @endslot
@slot('title') User @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            {{--  <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i>Form groups</h5>  --}}

                            <form action="{{ $url }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="User name" value="@if(isset($user->name)){{ $user->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="formrow-password-input">Who you are<span style="color:red;">*</span></label>
                                        <select class="form-select" name="user_type" id="user_type">
                                            <option value="">Select</option>
                                            <option value="consumer" {{ (isset($user) && $user->user_type == 'consumer') || old('user_type') == 'consumer' ? 'selected' : '' }}>Contributor</option>
                                            <option value="sab" {{ (isset($user) && $user->user_type == 'sab') || old('user_type') == 'sab' ? 'selected' : '' }}>Resource Collector</option>
                                            <option value="business" {{ (isset($user) && $user->user_type == 'business') || old('user_type') == 'business' ? 'selected' : '' }}>Corporate</option>
                                        </select>
                                        @if ($errors->has('user_type'))
                                            <span class="text-danger">{{ $errors->first('user_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Mobile no<span style="color:red;">*</span></label>
                                        <input onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile no" value="@if(isset($user->mobile)){{ $user->mobile }}@else{{ old('mobile')}}@endif" readonly>
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                     @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Pincode<span style="color:red;">*</span></label>
                                        <input onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode no" value="@if(isset($user->pincode)){{ $user->pincode }}@else{{ old('pincode')}}@endif">
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                     @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Address<span style="color:red;">*</span></label>
                                        <textarea 
                                        class="form-control" 
                                        rows="4" 
                                        cols="50" 
                                        name="address" 
                                        id="address" 
                                        placeholder="Address"
                                       >@if(isset($user->address)){{ $user->address }}@else{{ old('address')}}@endif</textarea>
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                     @endif
                                    </div>
                                </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="type_of_residences">Type of Residences<span style="color:red;">*</span></label>
                                    <select class="form-select" name="type_of_residences" id="type_of_residences">
                                        <option value="">Select</option>
                                        <option value="Gated community apartment" {{ $user->type_of_residences == 'Gated community apartment' ? 'selected' : '' }}>Gated community apartment</option>
                                        <option value="Gated community villa" {{ $user->type_of_residences == 'Gated community villa' ? 'selected' : '' }}>Gated community villa</option>
                                        <option value="Independent house apartment" {{ $user->type_of_residences == 'Independent house apartment' ? 'selected' : '' }}>Independent house apartment</option>
                                        <option value="Independent villa" {{ $user->type_of_residences == 'Independent villa' ? 'selected' : '' }}>Independent villa</option>
                                    </select>
                                    @if ($errors->has('type_of_residences'))
                                        <span class="text-danger">{{ $errors->first('type_of_residences') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group" id="hide-em">
                                    <label for="confirm_password">Email id<span style="color:red;">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($user->email)){{ $user->email }}@else{{ old('email')}}@endif" readonly>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                 @endif
                                </div>
                            </div>
                                    
                                </div><br>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            @if($user->user_type == 'business')
                                              <a href="{{route('user.businesslist')}}" class="btn btn-primary">Cancel</a>
                                            @elseif($user->user_type == 'sab')
                                                <a href="{{route('user.sablist')}}" class="btn btn-primary">Cancel</a>
                                            @elseif($user->user_type == 'consumer')
                                                <a href="{{route('user.consumerlist')}}" class="btn btn-primary">Cancel</a>
                                             @endif
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
