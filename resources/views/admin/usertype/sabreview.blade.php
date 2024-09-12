@extends('layouts.master')
@section('title')
   SAB Review
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Review @endslot
        @slot('title') SAB @endslot
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
                                <th>Post name</th>
                                <th>User name</th>
                                <th>Title</th>
                                <th>Rating</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;

                            // Check if the function displayStars() is not already defined
                            if (!function_exists('displayStars')) {
                                // Define the function to display stars based on rating
                                function displayStars($rating) {
                                    $fullStars = intval($rating); // Get the integer part of the rating
                                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0; // Check if there's a half star
                                    $emptyStars = 5 - $fullStars - $halfStar; // Calculate the number of empty stars

                                    // Display full stars
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="fa fa-star"></i>';
                                    }

                                    // Display half star if needed
                                    if ($halfStar) {
                                        echo '<i class="fa fa-star-half"></i>';
                                    }

                                    // Display empty stars
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="fa fa-star-o"></i>';
                                    }
                                }
                            }
                        @endphp
                                @foreach ($result as $res)
                                <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->username }}</td>
                                        <td>{{ $res->title }}</td>
                                        <td>
                                            <!-- Call the function to display stars -->
                                            <span>
                                                @php
                                                    displayStars($res->rating);
                                                @endphp
                                            </span>
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
