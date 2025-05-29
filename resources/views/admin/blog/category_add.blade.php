@extends('layouts.master')
@section('title')
Category Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Category @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            <form action="{{ $url }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Category Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category" value="@if(isset($blogcategory->category_name)){{ $blogcategory->category_name }}@else{{ old('category_name')}}@endif">
                                            @if ($errors->has('category_name'))
                                                <span class="text-danger">{{ $errors->first('category_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('blog.blog_category_list')}}" class="btn btn-primary">Cancel</a>
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
