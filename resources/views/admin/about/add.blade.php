@extends('layouts.master')
@section('title')
    @lang('Ecosansar.About')
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
                                    <form action="{{ $url }}" method="post">
                                    @csrf
                                        <textarea id="elm1" name="content" id="content">@if(isset($about->content)){{$about->content}}@else{{old('content')}}@endif</textarea>
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
<script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>




@endsection
