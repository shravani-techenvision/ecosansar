@extends('layouts.master')
@section('title')
Change Password
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle') Change  Password @endslot
@slot('title') Change password @endslot
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



                            <form  action="{{ route('changepassword_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Current password<span style="color:red;">*</span></label>


                                            <input type="password" class="form-control" name="password" id="password" placeholder="Current password"  >
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">New password<span style="color:red;">*</span></label>
                                            <input  type="password" class="form-control" name="new_password" id="new_password"  placeholder="New password">
                                            @error('new_password')
                                            <span style="color:red;">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Confirm password<span style="color:red;">*</span></label>
                                            <input  type="password" class="form-control" name="confirm_password" id="confirm_password"   placeholder="Confirm password">
                                            @error('confirm_password')
                                            <span style="color:red;">{{ $message }}</span>
                                        @enderror
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
