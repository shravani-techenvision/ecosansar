@extends('layouts.master')
@section('title')
  Unavailable Pincode List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Unavailable Pincode @endslot
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
                                <th>Phone No</th>
                                <th>Email</th>
                                 <th>Pincode</th>
                                <th>Address</th>
                                <th>Message</th>
                               
                                
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($result as $res)
                                    <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $res->name }} </td>
                                            <td>{{ $res->phone_no }} </td>
                                            <td>{{ $res->email }}</td>
                                             <td>{{ $res->pincode }} </td>
                                            <td>{{ $res->address }} </td>
                                             <td>{{ $res->message }} </td>
                                           
                                            
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
 
<script>
        $(document).ready(function () {
            var table = $('#datatable-buttons').DataTable();

            // Check if DataTable is already initialized
            if ($.fn.DataTable.isDataTable('#datatable-buttons')) {
                table.destroy(); // Destroy the existing DataTable
            }

            // Initialize the DataTable with the new settings
            $('#datatable-buttons').DataTable({
                dom: 'Bfrtip', // Include buttons in the DOM
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export to Excel' // Customize button text if needed
                    },
                    {
                        extend: 'pdf',
                        text: 'Export to PDF' // Customize button text if needed
                    }
                    // The "Copy" button is omitted here, so it won't be displayed
                ]
            });
        });
    </script>
@endsection
