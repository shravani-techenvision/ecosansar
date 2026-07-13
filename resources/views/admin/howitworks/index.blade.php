@extends('layouts.master')

@section('title')
How It Works Management
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') Admin @endslot
    @slot('title') How It Works @endslot
@endcomponent

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ADD / EDIT SECTION -->
   <div class="card mb-4">

    <div class="card-header" style="background-color:#f3f8fb;">
        <h4>{{ isset($editSection) ? 'Update Step' : 'Add Step' }}</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.howitworks.save') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden"
                   name="id"
                   value="{{ $editSection->id ?? '' }}">

            <div class="row">

                <!-- Step Number -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Step Number <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="step_number"
                           class="form-control @error('step_number') is-invalid @enderror"
                           value="{{ old('step_number', $editSection->step_number ?? '') }}"
                           placeholder="Step Number (01)">

                    @error('step_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- Title -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Title <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $editSection->title ?? '') }}"
                           placeholder="Enter Title">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- Display Order -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Display Order <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="position"
                           class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position', $editSection->position ?? '') }}"
                           placeholder="Enter Display Order">

                    @error('position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <!-- Description -->

            <div class="mb-3">

                <label class="form-label">
                    Description <span class="text-danger">*</span>
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Enter Description">{{ old('description', $editSection->description ?? '') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Image -->

            <div class="mb-3">

                <label class="form-label">
                    Image
                    @if(!isset($editSection))
                        <span class="text-danger">*</span>
                    @endif
                </label>

                <input type="file"
                       id="howitworks_image"
                       name="image"
                       accept="image/*"
                       class="form-control @error('image') is-invalid @enderror">

                @error('image')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mt-3">
                    <img id="howitworksImagePreview"
                         src="{{ isset($editSection) && $editSection->image ? Storage::disk('s3')->url('howitworks/'.$editSection->image) : '' }}"
                         width="120"
                         height="80"
                         style="object-fit:cover;border-radius:5px;{{ isset($editSection) && $editSection->image ? '' : 'display:none;' }}">
                </div>

            </div>

            <button class="btn btn-primary">
                {{ isset($editSection) ? 'Update' : 'Save' }}
            </button>

        </form>

    </div>

</div>

    <!-- LIST -->
    <div class="card">

        <div class="card-header">
            <h4>Steps List</h4>
        </div>

        <div class="card-body">

            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Step</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
            
                <tbody>
                    @foreach($sections as $item)
                        <tr>
            
                            <td>
                                @if($item->image)
                                    <img src="{{ Storage::disk('s3')->url('howitworks/'.$item->image) }}"
                                         width="80"
                                         height="60"
                                         style="object-fit:cover;">
                                @endif
                            </td>
            
                            <td>{{ $item->step_number }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->position }}</td>
            
                            <td>
                                <a href="{{ route('admin.howitworks.edit',$item->id) }}"
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
            
                                <a href="{{ route('admin.howitworks.delete',$item->id) }}"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Are you sure?')">
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
$(document).ready(function () {

    $('#howitworks_image').on('change', function () {

        const file = this.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function (e) {

                $('#howitworksImagePreview')
                    .attr('src', e.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        }

    });

});
</script>
@endsection