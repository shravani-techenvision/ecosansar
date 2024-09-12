@extends('layouts.master')
@section('title')
    Contact List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Contact @endslot
    @endcomponent


    @include('sweetalert::alert')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                    <div >
                        <a href="{{ route('contact.add') }}" class="btn btn-primary waves-effect waves-light" >Add</a>
                    </div>
                </div>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Google Map</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody><span hidden>{{ $i=1; }}</span>
                            @foreach ($contacts as $c)


                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->mobile }}</td>
                                <td>{{ $c->address }}</td>
                                <td>{{ $c->map }}</td>
                                <td>
                                    <a title="Edit" href="{{ route('contact.edit', $c->id) }}" class="btn btn-outline-success btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a title="Delete" href="{{ route('contact.delete', $c->id) }}" class="btn btn-outline-danger btn-sm deleteAttr" onclick="return confirm('Are you sure you want to delete?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
