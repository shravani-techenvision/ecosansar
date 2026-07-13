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
    @slot('title') Download Posters Enquiries @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">

                <!--<div class="d-flex justify-content-between mb-3">-->
                <!--    <div></div>-->

                <!--    <div>-->
                <!--        <a href="{{ route('download_posters.create') }}" class="btn btn-primary">-->
                <!--            Add-->
                <!--        </a>-->
                <!--    </div>-->
                <!--</div>-->

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Poster ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @foreach($postersenquiry as $key => $enquiry)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                
                            <td>{{ $enquiry->download_poster_id }}</td>
                            <td>{{ $enquiry->name }}</td>
                
                            <td>{{ $enquiry->email }}</td>
                
                            <td>{{ $enquiry->mobile }}</td>
                
                            <td>{{ $enquiry->notes ?? '-' }}</td>
                
                            <td>
                                {{ $enquiry->created_at ? $enquiry->created_at->format('d M Y h:i A') : '-' }}
                            </td>
                            
                            <td>
                                <a href="{{ route('download_posters.enquiry.delete',$enquiry->id) }}"
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

    </div>
</div>

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
                lengthChange: false
            });
        });

</script>
@endsection
