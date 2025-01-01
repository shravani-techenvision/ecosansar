@extends('layouts.master')
@section('title')
User Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
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
                            {{--  <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups</h5>  --}}

                            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="@if(isset($category->name)){{ $category->name }}@else{{ old('name')}}@endif">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Image<span style="color:red;">*</span></label><br>
                                            @if($category->image)
                                            <img src="{{ Storage::disk('s3')->url('VolunteerImages/' . $category->image) }}" alt="Post Image" class="mb-2" style="width: 100px; height: 100px;">

                                     @else
                                         <p>No profile image available.</p>
                                     @endif
                                            <input type="file" class="form-control" name="image" id="image" placeholder="Category name" value="@if(isset($category->category_name)){{ $category->category_name }}@else{{ old('category_name')}}@endif">
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Description<span style="color:red;">*</span></label>
                                            <textarea class="form-control" name="description" id="description" placeholder="Description"  >@if(isset($category->description)){{ $category->description }}@else{{ old('description')}}@endif</textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
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
