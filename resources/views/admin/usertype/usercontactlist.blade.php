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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                    
                </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="word-wrap: break-word !important; white-space: normal; max-width: 20px;">Sr. No</th>
                                <th>Name</th>
                                <th style="word-wrap: break-word !important; white-space: normal; max-width: 200px;">Email</th>
                                <th style="word-wrap: break-word !important; white-space: normal; max-width: 100px;">Mobile</th>
                                <th>Subject</th>
                                <th style="word-wrap: break-word !important; white-space: normal; max-width: 200px;">Message</th>
                                <!--<th>Status</th>-->
                                 
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($result as $res)
                                <tr>
                                        <td style="word-wrap: break-word !important; white-space: normal; max-width: 80px;">{{ $i++ }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td style="word-wrap: break-word !important; white-space: normal; max-width: 200px;">{{ $res->email }}</td>
                                        <td style="word-wrap: break-word !important; white-space: normal; max-width: 60px;">{{ $res->phone_no }}</td>
                                        <td>{{ $res->subject }}</td>
                                          <td style="word-wrap: break-word !important; white-space: normal; max-width: 200px;">{{ $res->message }}</td>
                                        
                                         
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
        $(document).ready(function() {
            // Check if the datatable has already been initialized
            if ($.fn.DataTable.isDataTable('#datatable')) {
                // Destroy the existing DataTable instance
                $('#datatable').DataTable().destroy();
            }

            // Initialize the datatable
            $('#datatable').DataTable({
                // Your DataTable initialization options here
                searching: false,
                lengthChange: false
            });
        });

</script>
 
@endsection
