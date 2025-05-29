@extends('layouts.master')
@section('title')
   Contributor List
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Contributor @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        </div>
                    {{--  <div >
                        <a href="{{ route('category.add') }}" class="btn btn-primary waves-effect waves-light" >Add</a>
                    </div>  --}}
                </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Unique ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Date Time</th>
                                <!--<th>Status</th>-->
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
                                         <td>{{ $res->unique_id }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->email }}</td>
                                        <td>{{ $res->mobile }}</td>
                                        <td>{{ \Carbon\Carbon::parse($res->created_at)->format('F j, Y \a\t g:i A') }}</td>
                                        
                                       
                                        <td>
                                             
                                            <a title="View" href="{{ route('user.consumerview', $res->id) }}" class="btn btn-outline-primary btn-sm "><i class="fas fa-eye"></i></a>
                                             <a title="Edit" href="{{ route('user.edituser', $res->id) }}" class="btn btn-outline-success btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                            <a title="Delete" href="{{ route('user.deleteuser', $res->id) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-outline-danger btn-sm deleteAttr"><i class="fas fa-trash-alt"></i></a> 
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
<div class="modal fade" id="assignPlanModal" tabindex="-1" aria-labelledby="assignPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignPlanModalLabel">Assign Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignPlanForm" method="POST" action="{{ route('user.businessassignplan') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                     <input type="hidden" name="plan_validity" id="plan_validity">
                    <div class="mb-3">
                        <label for="plan" class="form-label">Select Plan</label>
                        <select name="plan" id="plan" class="form-control" required>
                            <option value="">-- Select Plan --</option>
                           @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" data-plan-validity="{{ $plan->plan_validity }}">{{ $plan->plan_name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Assign Plan</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                   
                </div>
            </form>
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
              url: "{{url('/changeStatus')}}",
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const assignPlanModal = document.getElementById('assignPlanModal');
        const planSelect = document.getElementById('plan');
        const planValidityInput = document.getElementById('plan_validity');

        // When the modal is about to be shown
        assignPlanModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const userId = button.getAttribute('data-user-id'); // Extract info from data-* attributes
            const userIdInput = assignPlanModal.querySelector('#user_id');
            userIdInput.value = userId; // Set the user ID in the hidden input field
        });

        // Update the plan_validity when a plan is selected
        planSelect.addEventListener('change', function () {
            const selectedOption = planSelect.options[planSelect.selectedIndex];
            const planValidity = selectedOption.getAttribute('data-plan-validity'); // Get plan validity
            planValidityInput.value = planValidity || ''; // Set the plan_validity hidden field
        });
    });
</script>

@endsection
