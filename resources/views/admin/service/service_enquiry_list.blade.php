@extends('layouts.master')
@section('title')
   Service Enquiry List
@endsection
@section('css')
    <!-- DataTables -->
 
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Collection Drive Enquiry @endslot
    @endcomponent



    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                     
                </div>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Participants</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($result as $res)
                                    <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $res->name}}</td>
                                            <td>{{ $res->contact_number }}</td>
                                            <td>{{ $res->location }}</td>
                                            <td>{{ $res->participants }}</td>
                                            <td>
                                                <a href="{{ route('collection_drive.enquiry.delete',$res->id) }}"
                                                   class="btn btn-outline-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to delete this enquiry?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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
  
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection



