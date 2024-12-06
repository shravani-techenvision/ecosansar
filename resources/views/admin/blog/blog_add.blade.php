@extends('layouts.master')
@section('title')
    @lang('Ecosansar.About')
@endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Add @endslot
        @slot('title') About @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                       <div class="row">
                                            <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Volunteer<span style="color:red;">*</span></label>
                                             <select name="posted_by" id="posted_by" class=" form-control" >
                                                 <option value="">Select Volunteer</option>
                                               @foreach($volunteer as $project)
                                        <option value="{{ $project->id }}"
                                            @if(isset($blog) && $blog && $project->id == $blog->posted_by)
                                                selected
                                            @endif
                                        >{{ $project->name }}</option>
                                    @endforeach

                                            </select>
                                            @if ($errors->has('posted_by'))
                                                <span class="text-danger">{{ $errors->first('posted_by') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Blog Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="blog_name" id="blog_name" placeholder="Enter Blog Name" value="@if(isset($blog->blog_name)){{ $blog->blog_name }}@else{{ old('blog_name')}}@endif">
                                            @if ($errors->has('blog_name'))
                                                <span class="text-danger">{{ $errors->first('blog_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Blog Category<span style="color:red;">*</span></label>
                                             <select name="category[]" id="category" class="select2 form-control select2-multiple" multiple="multiple">
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->id }}" @if(in_array($cat->id, $categories)) selected @endif>
                                                        {{ $cat->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="text-danger">{{ $errors->first('category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Blog Tag<span style="color:red;">*</span></label>
                                               <select name="tag[]" id="tag" class="select2 form-control select2-multiple" multiple="multiple">
                                                    @foreach($tag as $tag)
                                                        <option value="{{ $tag->id }}" @if(in_array($tag->id, $tags)) selected @endif>
                                                            {{ $tag->tag_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @if ($errors->has('tag'))
                                                <span class="text-danger">{{ $errors->first('tag') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                        <textarea id="elm1" name="content" id="content">@if(isset($blog->content)){{$blog->content}}@else{{old('content')}}@endif</textarea>
                                        @if ($errors->has('content'))
                                                <span class="text-danger">{{ $errors->first('content') }}</span>
                                            @endif
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#category').select2({
            allowClear: true
        });
        $('#tag').select2({
            allowClear: true
        });
        
    });
</script>




@endsection
