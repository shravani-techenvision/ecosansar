@extends('layouts.master')
@section('title')
   Weight List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Weight @endslot
    @endcomponent



    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                    <div >
                        <a href="{{ route('weight.add') }}" class="btn btn-primary waves-effect waves-light" >Add</a>
                    </div>
                </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Weight</th>
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
                                            <td>{{ $res->min_weight }} {{ $res->min_measure }}  {{ 'to' }} {{ $res->max_weight }} {{ $res->max_measure }}</td>
                                            <td>
                                                {{--  <a title="View" href="{{ route('faq.', $m->id) }}" class="btn btn-outline-primary btn-sm "><i class="fas fa-eye"></i></a>  --}}
                                                <a title="Edit" href="{{ route('weight.edit', $res->id) }}" class="btn btn-outline-success btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a title="Delete" href="{{ route('weight.delete', $res->id) }}" onclick="return confirm('Are you sure you want to delete this weight?');" class="btn btn-outline-danger btn-sm deleteAttr"><i class="fas fa-trash-alt"></i></a>
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
