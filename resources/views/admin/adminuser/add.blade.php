@extends('layouts.master')
@section('title')
AdminUser Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') AdminUser @endslot
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

                            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">First Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="@if(isset($category->name)){{ $category->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('first_name'))
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Last Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="@if(isset($category->name)){{ $category->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Email<span style="color:red;">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($category->name)){{ $category->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Password<span style="color:red;">*</span></label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Email" value="@if(isset($category->name)){{ $category->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Image<span style="color:red;">*</span></label><br>
                                             
                                            <input type="file" class="form-control" name="profile_pic" id="profile_pic" placeholder="Category name" >
                                            @if ($errors->has('profile_pic'))
                                                <span class="text-danger">{{ $errors->first('profile_pic') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('volunteer.list')}}" class="btn btn-primary">Cancel</a>
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
