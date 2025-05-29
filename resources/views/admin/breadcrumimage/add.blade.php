@extends('layouts.master')
@section('title')
Breadcrumb Image Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Breadcrumb Image @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Breadcrumb Image<span style="color:red;">*</span></label>
                                            <input type="file" class="form-control" name="breadcrumb_image" id="breadcrumb_image" placeholder="Enter Category" value="">
                                            @if ($errors->has('breadcrumb_image'))
                                                <span class="text-danger">{{ $errors->first('breadcrumb_image') }}</span>
                                            @endif
                                           @isset($breadcrumbimage)
    <div class="mt-2">
        <img src="{{ Storage::disk('s3')->url('Breadcrumbimage/' . $breadcrumbimage->breadcrumb_image) }}" alt="Breadcrumb Image" width="150">
    </div>
@endisset

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                             
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
