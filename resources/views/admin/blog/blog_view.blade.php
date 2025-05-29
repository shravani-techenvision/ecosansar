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
                         <div class="col-4">
                            <p class="mb-0"><strong>Blog Name:</strong><br>
                            <p>@isset($blog->blog_name){{ $blog->blog_name }}@endisset</p>
                        </div>
                        <div class="col-4">
                            <p class="mb-0"><strong>Category:</strong><br>
                            <p> @isset($categories)
                @foreach($categories as $category)
                    <span class="badge bg-primary">{{ $category }}</span>
                @endforeach
            @endisset</p>
                        </div>
                        <div class="col-4">
                            <p class="mb-0"><strong>Tag:</strong><br>
                            <p> @isset($tags)
                @foreach($tags as $tag)
                    <span class="badge bg-secondary">{{ $tag }}</span>
                @endforeach
            @endisset</p>
                        </div>
                        <div class="col-4">
                            <p class="mb-0"><strong>Posted By:</strong><br>
                            <p>@isset($blog->posted_by){{  $posted_by_name }}@endisset</p>
                        </div>
                        
                    </div> <!-- end row -->
                    <div class="row">
                    <div class="col-12">
                            <p class="mb-0"><strong>Description:</strong><br>
                            {!! $blog->content !!} 
                        </div>
                    </div>
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
