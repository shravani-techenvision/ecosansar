@extends('layouts.master')
@section('title')
   Comment List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Comment @endslot
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
                                <th>Sr. No</th>
                                <th>Comments</th>
                                <th>Active/Inactive</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i=1;
                                @endphp
                                 @foreach ($comment_list as $res)
                                    <tr>
                                            <td>{{ $i++ }}</td>
                                            <td style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ $res->comment }}</td>
                                            <td class="d-flex align-items-center">
                                                <a title="View" href="#" class="btn btn-outline-primary btn-sm me-2" 
                                                   data-comment="{{ $res->comment }}" onclick="showComment(this)">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <div class="form-check form-switch form-switch-lg mb-0" dir="ltr">
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
    
<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="commentContent">
                <!-- Comment will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            url: "{{url('/changeCommentStatus')}}",
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
<script>
function showComment(button) {
    // Get the comment from the button's data-comment attribute
    var comment = button.getAttribute('data-comment');
    
    // Set the comment in the modal's body
    document.getElementById('commentContent').textContent = comment;
    
    // Show the modal
    var commentModal = new bootstrap.Modal(document.getElementById('commentModal'));
    commentModal.show();
}

</script>
@endsection
