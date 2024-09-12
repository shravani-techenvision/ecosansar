@extends('layouts.master')
@section('title')
   Report
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

<style>

    button.btn.btn-secondary.buttons-copy.buttons-html5 {
    display: none !important;
}

button.btn.btn-secondary.buttons-pdf.buttons-html5 {
    display: none;
}

button.btn.btn-secondary.buttons-collection.dropdown-toggle.buttons-colvis {
    display: none;
}

</style>

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Post @endslot
        @slot('title') Report @endslot
    @endcomponent
    
    <div class="row mb-3">
        <div class="col-12">
            <!-- Date Filter Form -->
            <form method="POST" action="{{ route('user.shortBusinessconnectReportList') }}">
                @csrf
                <div class="form-row">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="col">
                        <label class="form-label" >Start date<span style="color:red;">*</span></label>
                        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                    </div>
                    </div>
                    
                   <div class="col-md-6">
                    <div class="col">
                        <label class="form-label" >End date<span style="color:red;">*</span></label>
                        <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                    </div>
                    </div>
                    
                    </div><br>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{route('user.Businessconnectreportlist')}}" class="btn btn-primary">Cancel</a>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div>
                        
                    {{--  <div >
                        <a href="{{ route('category.add') }}" class="btn btn-primary waves-effect waves-light" >Add</a>
                    </div>  --}}
                </div>
                    <!--<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"-->
                    <!--    style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Post Name</th>
                                <th>Message</th>
                                <!--<th>Ip ddress</th>-->
                                <th>Date</th>
                                <!--<th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($result as $res)
                                <tr>
                                        <td>{{ $i++ }}</td>
                                        <!--<td>{{ $res->username }}</td>-->
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->postname }}</td>
                                        <td>{{ $res->message }}</td>
                                        <!--<td>{{ $res->ip_address }}</td>-->
                                        <td>{{ \Carbon\Carbon::parse($res->created_at)->format('F j, Y \a\t g:i A') }}</td>
                                       <!--<td>-->
                                            <!--<a title="View" href="{{ route('user.consumerpostsview',$res->id) }}" class="btn btn-outline-primary btn-sm "><i class="fas fa-eye"></i></a>-->
                                       <!--     {{--  <a title="Edit" href="{{ route('user.edit', $res->id) }}" class="btn btn-outline-success btn-sm edit"><i class="fas fa-pencil-alt"></i></a>-->
                                       <!--     <a title="Delete" href="{{ route('user.delete', $res->id) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-outline-danger btn-sm deleteAttr"><i class="fas fa-trash-alt"></i></a>  --}}-->
                                       <!-- </td>-->
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
