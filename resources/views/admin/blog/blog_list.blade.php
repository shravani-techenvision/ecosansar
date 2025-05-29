@extends('layouts.master')
@section('title')
   Blog List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Blog @endslot
    @endcomponent



    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                    <div >
                        <a href="{{ route('admin_blog_add') }}" class="btn btn-primary waves-effect waves-light" >Add</a>
                    </div>
                </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Blog Name</th>
                                <th>Category</th>
                                <!--<th>Image</th>-->
                                <th>Action</th>
                                <th>Active/Inactive</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                  @foreach ($blog_list as $res)
                                    <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $res->blog_name }} </td>
                                            <!-- <td>-->
                                            <!--    <img id="f_image" src="{{ asset('assets/images/Blog/'.$res->featured_image) }}" alt="Upload Photo" width="150" height="100">-->
                                            <!--</td>-->
                                           <td>{{ $res->category_name }}</td>
                                            <td>
                                                  <a title="View" href="{{ route('admin_blog_view', $res->id) }}" class="btn btn-outline-primary btn-sm "><i class="fas fa-eye"></i></a> 
                                                <a title="Edit" href="{{ route('admin_blog_edit', $res->id) }}" class="btn btn-outline-success btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a title="Delete" href="{{ route('admin_blog_delete', $res->id) }}" onclick="return confirm('Are you sure you want to delete this blog?');" class="btn btn-outline-danger btn-sm deleteAttr"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input toggle-checkbox"
                                                           data-id="{{$res->id}}" {{ $res->active ? 'checked' : '' }}>
                                                </div>
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
<script>
  $(function() {
    $('.toggle-checkbox').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/changeBlogStatus')}}",
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
@endsection
