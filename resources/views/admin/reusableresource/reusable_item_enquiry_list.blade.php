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
                            <th>Reusable Resource</th>
                            <th>Quantity</th>
                            <!--<th>Lid Colour</th>-->
                            <th>Delivery Place</th>
                            <th>Required By</th>
                            <!--<th>Notes</th>-->
                            <!--<th>Date</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($result as $key => $row)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->mobile }}</td>
                            <td>{{ $row->reusablePost->description ?? ''}}</td>
                            <td>{{ $row->quantity }}</td>
                            <!--<td>{{ $row->lid_colour }}</td>-->
                            <td>{{ $row->delivery_place }}</td>
                            <td>{{ $row->required_by_date }}</td>
                            <!--<td>{{ $row->notes }}</td>-->
                            <!--<td>{{ $row->created_at->format('d-m-Y') }}</td>-->
                            <td>
                                <button
                                    class="btn btn-outline-info btn-sm view-enquiry"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewEnquiryModal"
                            
                                    data-name="{{ $row->name }}"
                                    data-mobile="{{ $row->mobile }}"
                                    data-quantity="{{ $row->quantity }}"
                                    data-lid_colour="{{ $row->lid_colour }}"
                                    data-delivery_place="{{ $row->delivery_place }}"
                                    data-required_by_date="{{ $row->required_by_date }}"
                                    data-notes="{{ $row->notes }}"
                            
                                    data-user_name="{{ optional($row->user)->name }}"
                                    data-user_mobile="{{ optional($row->user)->mobile }}"
                                    data-user_email="{{ optional($row->user)->email }}"
                            
                                    data-resource_name="{{ optional($row->reusablePost)->description }}"
                                    data-resource_type="{{ optional(optional($row->reusablePost)->resource)->reusable_resource_name }}"
                                    data-resource_price="{{ optional($row->reusablePost)->resource_price }}"
                                    data-resource_image="{{ optional($row->reusablePost)->resource_img ? Storage::disk('s3')->url('Reusableposts/' . $row->reusablePost->resource_img) : '' }}"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                                
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
<div class="modal fade" id="viewEnquiryModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5>Reusable Item Enquiry Details</h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mt-3">
                        <h5>User Details</h5>
                    </div>

                    <div class="col-md-4">
                        <b>Name :</b>
                        <p id="u_name"></p>
                    </div>

                    <div class="col-md-4">
                        <b>Mobile :</b>
                        <p id="u_mobile"></p>
                    </div>

                    <div class="col-md-4">
                        <b>Email :</b>
                        <p id="u_email"></p>
                    </div>

                    <hr>

                    <div class="col-md-12 mt-3">
                        <h5>Resource Details</h5>
                    </div>

                    <div class="col-md-3">
                        <img
                            id="resource_image"
                            class="img-fluid rounded border">
                    </div>

                    <div class="col-md-9">

                        <p><b>Title :</b> <span id="resource_name"></span></p>

                        <p><b>Type :</b> <span id="resource_type"></span></p>

                        <p><b>Resource Price :</b> <span id="resource_price"></span></p>

                    </div>
                    
                    <hr>
                    <div class="col-md-12 mt-3" >
                        <h5>Enquiry Details</h5>
                    </div>

                    <div class="col-md-4">
                        <b>Quantity :</b>
                        <p id="e_quantity"></p>
                    </div>

                    <div class="col-md-4">
                        <b>Lid Colour :</b>
                        <p id="e_lid_colour"></p>
                    </div>

                    <div class="col-md-4">
                        <b>Delivery Place :</b>
                        <p id="e_delivery_place"></p>
                    </div>

                    <div class="col-md-4">
                        <b>Required By :</b>
                        <p id="e_required_by_date"></p>
                    </div>

                    <div class="col-md-8">
                        <b>Notes :</b>
                        <p id="e_notes"></p>
                    </div>

                </div>

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
$(document).on('click','.view-enquiry',function(){

    $('#e_name').text($(this).data('name'));
    $('#e_mobile').text($(this).data('mobile'));
    $('#e_quantity').text($(this).data('quantity'));
    $('#e_lid_colour').text($(this).data('lid_colour'));
    $('#e_delivery_place').text($(this).data('delivery_place'));
    $('#e_required_by_date').text($(this).data('required_by_date'));
    $('#e_notes').text($(this).data('notes'));

    $('#u_name').text($(this).data('user_name'));
    $('#u_mobile').text($(this).data('user_mobile'));
    $('#u_email').text($(this).data('user_email'));

    $('#resource_name').text($(this).data('resource_name'));
    $('#resource_type').text($(this).data('resource_type'));
    $('#resource_price').text($(this).data('resource_price'));

    $('#resource_image').attr('src', $(this).data('resource_image'));

});
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