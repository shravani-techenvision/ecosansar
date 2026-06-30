@extends('layouts.master')

@section('title')
    Download Poster
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            {{ isset($poster) ? 'Edit' : 'Add' }}
        @endslot

        @slot('title')
            Download Poster
        @endslot
    @endcomponent

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card">

                <div class="card-body">

                    <form action="{{ $url }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        @if (isset($poster))
                            @method('PUT')
                        @endif

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label>

                                        Poster Title
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $poster->title ?? '') }}">

                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label>

                                        Poster Image

                                        @if (!isset($poster))
                                            <span class="text-danger">*</span>
                                        @endif

                                    </label>

                                    <input type="file" name="poster_image" class="form-control">

                                    @error('poster_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @if (isset($poster) && $poster->poster_image)
                                        <br>

                                        <img src="{{ Storage::disk('s3')->url('DownloadPosters/Image/' . $poster->poster_image) }}"
                                            width="120">
                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label>

                                        PDF File

                                        @if (!isset($poster))
                                            <span class="text-danger">*</span>
                                        @endif

                                    </label>

                                    <input type="file" name="poster_pdf" class="form-control">

                                    @error('poster_pdf')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @if (isset($poster) && $poster->poster_pdf)
                                        <br>

                                        <a href="{{ Storage::disk('s3')->url('DownloadPosters/PDF/' . $poster->poster_pdf) }}"
                                            target="_blank">

                                            View Current PDF

                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <button class="btn btn-primary">

                                    Submit

                                </button>

                                <a href="{{ route('download_posters.index') }}" class="btn btn-secondary">

                                    Cancel

                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
@endsection
