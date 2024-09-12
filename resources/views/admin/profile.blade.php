@extends('layouts.master')
@section('title')
Profile Edit
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Edit @endslot
@slot('title') Profile @endslot
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

                            <form class="needs-validation" novalidate action="{{ $url }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">First Name</label>
                                            <input required type="text" class="form-control" name="first_name" id="first_name"   value="@if(isset($user->first_name)){{ $user->first_name }}@else{{ old('first_name')}}@endif">
                                           <div class="invalid-feedback">
                                                Please provide question.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Last Name</label>
                                            <input required type="text" class="form-control" name="last_name" id="last_name"   value="@if(isset($user->last_name)){{ $user->last_name }}@else{{ old('last_name')}}@endif">
                                           <div class="invalid-feedback">
                                                Please provide question.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Email</label>
                                            <input required type="email" class="form-control" name="email" id="email"   value="@if(isset($user->email)){{ $user->email }}@else{{ old('email')}}@endif">
                                           <div class="invalid-feedback">
                                                Please provide answer.
                                            </div>
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Password</label>
                                            <input  type="password" class="form-control" name="password" id="password"   value="{{ isset($user) ? '' : old('password') }}">

                                        </div>
                                    </div>  --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Profile picture</label> <br>
                                            @if(Auth::user()->profile_pic)
                                            <img src="{{ asset('assets/images/Adminprofile/' . $user->profile_pic) }}" alt="Current Profile Image" class="img-thumbnail mb-2" style="max-width: 200px;">
                                        @else
                                            <p>No profile image available.</p>
                                        @endif
                                            <input required type="file" class="form-control" name="profile_pic" id="profile_pic" >
                                           <div class="invalid-feedback">
                                                Please provide answer.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('admin_dashboard')}}" class="btn btn-primary">Cancel</a>
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
