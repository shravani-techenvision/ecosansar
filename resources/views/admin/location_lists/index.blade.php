@extends('layouts.master')

@section('title')
    User Location List
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('pagetitle') User @endslot
        @slot('title') Location List @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('location-list.add') }}"
                           class="btn btn-primary waves-effect waves-light">
                            Add
                        </a>
                    </div>

                    <table id="datatable"
                           class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Rating</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp

                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>{{ $location->name }}</td>

                                    <td>{{ $location->phone }}</td>

                                    <td style="word-wrap: break-word !important;
                                               white-space: normal;
                                               max-width: 200px;">
                                        {{ $location->address }}
                                    </td>

                                    <td>{{ $location->pincode }}</td>

                                    <td>{{ $location->latitude }}</td>

                                    <td>{{ $location->longitude }}</td>
                                    
                                    <td>{{ $location->rating }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($location->created_at)->format('F j, Y \a\t g:i A') }}
                                    </td>

                                    <td>
                                        <a title="Edit"
                                           href="{{ route('location-list.edit', $location->id) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           href="{{ route('location-list.delete', $location->id) }}"
                                           onclick="return confirm('Are you sure you want to delete this location?');"
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
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        $(document).ready(function() {

            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            $('#datatable').DataTable({
                searching: false,
                lengthChange: false
            });

        });
    </script>

@endsection