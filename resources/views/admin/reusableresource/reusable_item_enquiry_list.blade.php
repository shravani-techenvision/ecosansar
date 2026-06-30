@extends('layouts.master')

@section('title')
Reusable Item Enquiries
@endsection

@section('css')
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title') Reusable Item Enquiries @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">

                <table id="datatable"
                       class="table table-striped table-bordered dt-responsive nowrap"
                       style="width:100%;">

                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Quantity</th>
                            <th>Lid Colour</th>
                            <th>Delivery Place</th>
                            <th>Required By</th>
                            <th>Notes</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($result as $key => $row)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->mobile }}</td>
                            <td>{{ $row->quantity }}</td>
                            <td>{{ $row->lid_colour }}</td>
                            <td>{{ $row->delivery_place }}</td>
                            <td>{{ $row->required_by_date }}</td>
                            <td>{{ $row->notes }}</td>
                            <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                                                        <td>
                                                
                                                
                                                <a title="Delete" href="{{ route('reusable_resource_enquiry.delete', $row->id) }}" onclick="return confirm('Are you sure you want to delete this resource enquiry?');" class="btn btn-outline-danger btn-sm deleteAttr"><i class="fas fa-trash-alt"></i></a>
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

$(document).ready(function () {

    if ($.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable().destroy();
    }

    $('#datatable').DataTable({
        searching: true,
        lengthChange: false,
        ordering: true,
        pageLength: 10
    });

});

</script>

@endsection