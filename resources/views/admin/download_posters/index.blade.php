@extends('layouts.master')
@section('title')
Download Poster List
@endsection

@section('css')
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title') Download Posters @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <div></div>

                    <div>
                        <a href="{{ route('download_posters.create') }}" class="btn btn-primary">
                            Add
                        </a>
                    </div>
                </div>

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">

                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Title</th>
                            <th>Poster Image</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($posters as $key => $poster)

                        <tr>

                            <td>{{ $key+1 }}</td>

                            <td>{{ $poster->title }}</td>

                            <td>

                                @if($poster->poster_image)

                                <img src="{{ Storage::disk('s3')->url('DownloadPosters/Image/'.$poster->poster_image) }}"
                                    width="80">

                                @endif

                            </td>

                            <td>

                                @if($poster->poster_pdf)

                                <a href="{{ Storage::disk('s3')->url('DownloadPosters/PDF/'.$poster->poster_pdf) }}"
                                    target="_blank"
                                    class="btn btn-info btn-sm">
                                    View PDF
                                </a>

                                @endif

                            </td>

                            <td>

                                <div class="form-check form-switch">

                                    <input class="form-check-input statusToggle"
                                        type="checkbox"
                                        data-id="{{ $poster->id }}"
                                        {{ $poster->status ? 'checked' : '' }}>

                                </div>

                            </td>

                            <td>

                                <a href="{{ route('download_posters.edit',$poster->id) }}"
                                    class="btn btn-outline-success btn-sm">

                                    <i class="fas fa-pencil-alt"></i>

                                </a>

                                <a href="{{ route('download_posters.delete',$poster->id) }}"
                                    onclick="return confirm('Are you sure?')"
                                    class="btn btn-outline-danger btn-sm">

                                    <i class="fas fa-trash-alt"></i>

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@endsection

@section('script')

<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>

<script>

$('#datatable').DataTable({
    searching:false,
    lengthChange:false
});

$('.statusToggle').change(function(){

    $.ajax({

        url:"{{ route('download_posters.status') }}",

        type:"POST",

        data:{
            _token:"{{ csrf_token() }}",
            id:$(this).data('id')
        }

    });

});

</script>

@endsection