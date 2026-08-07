@extends('layouts.master')

@section('title')
About Us Management
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') Admin @endslot
    @slot('title') About Us Management @endslot
@endcomponent


<div class="container-fluid">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ================= ABOUT SECTION ================= -->

    <div class="card mb-4">

        <div class="card-header text-white" style="background-color:#f3f8fb;">

            <h4>About Section</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.about.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label>Title</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ $about->title ?? '' }}">

                </div>

                <div class="mb-3">

                    <label>Subtitle</label>

                    <input type="text"
                           name="subtitle"
                           class="form-control"
                           value="{{ $about->subtitle ?? '' }}">

                </div>

                <div class="mb-3">

                    <label>Description 1</label>

                    <textarea class="form-control"
                              rows="5"
                              name="description1">{{ $about->description1 ?? '' }}</textarea>

                </div>

                <div class="mb-3">

                    <label>Description 2</label>

                    <textarea class="form-control"
                              rows="5"
                              name="description2">{{ $about->description2 ?? '' }}</textarea>

                </div>

                <div class="mb-3">

                    <label for="about_image">Image</label>
                
                    <input type="file"
                           id="about_image"
                           class="form-control"
                           name="image"
                           accept="image/*">
                
                    <div class="mt-2">
                        <img id="aboutImagePreview"
                             src="{{ asset('storage/' .$about->image) }}"
                             width="150"
                             style="object-fit:cover; border-radius:5px; {{ !empty($about->image) ? '' : 'display:none;' }}">
                    </div>
                
                </div>
                
                <button class="btn btn-primary">
                    Update About
                </button>
            </form>

        </div>

    </div>



    <!-- ================= JOURNEY SECTION ================= -->

    <div class="card mb-4">

        <div class="card-header text-white" style="background-color:#f3f8fb;">
            <h4>{{ isset($editJourney) ? 'Update Journey' : 'Add Journey' }}</h4>
        </div>
    
        <div class="card-body">
    
            <form action="{{ route('admin.journey.save') }}"
                  method="POST"
                  enctype="multipart/form-data">
    
                @csrf
    
                <input type="hidden" name="id" value="{{ $editJourney->id ?? '' }}">
    
                <div class="row">
    
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">
                            Journey Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               class="form-control"
                               name="title"
                               value="{{ $editJourney->title ?? '' }}"
                               placeholder="Enter Journey Title">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror       
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">
                            Journey Date <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="date"
                               class="form-control"
                               name="date"
                               value="{{ $editJourney->date ?? '' }}"
                               placeholder="e.g. December 2017">
                               
                               @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                    </div>
    
                </div>
    
                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea id="description"
                              class="form-control"
                              name="description"
                              rows="5"
                              placeholder="Enter Journey Description">{{ $editJourney->description ?? '' }}</textarea>
                              
                              @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                </div>
    
                <div class="row">
    
                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <label for="position" class="form-label">
                                Display Order <span class="text-danger">*</span>
                            </label>
                        
                            <input type="number"
                                   id="position"
                                   class="form-control @error('position') is-invalid @enderror"
                                   name="position"
                                   value="{{ old('position', $editJourney->position ?? '') }}"
                                   placeholder="Enter Display Order">
                        
                            @error('position')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="journey_image" class="form-label">
                            Journey Image
                        </label>
                    
                        <input type="file"
                               id="journey_image"
                               class="form-control @error('image') is-invalid @enderror"
                               name="image"
                               accept="image/*">
                        
                        @error('image')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                        
                        <div class="mt-3">
                            <img id="journeyImagePreview"
                                 src="{{ isset($editJourney) && $editJourney->image 
                                    ? asset('storage/' . $editJourney->image) 
                                    : '' }}"
                                 width="120"
                                 height="80"
                                 style="object-fit:cover;border-radius:5px;{{ isset($editJourney) && $editJourney->image ? '' : 'display:none;' }}">
                        </div>
                    </div>
                </div>
    
                <button type="submit" class="btn btn-primary">
                    {{ isset($editJourney) ? 'Update Journey' : 'Add Journey' }}
                </button>
    
                @if(isset($editJourney))
                    <a href="{{ route('admin.about.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                @endif
    
            </form>
    
        </div>
    
    </div>



    <!-- Journey List -->

    <div class="card">

        <div class="card-header">

            <h4>Journey List</h4>

        </div>

        <div class="card-body">

            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
    
                        <th>Image</th>
    
                        <th>Title</th>
    
                        <th>Date</th>
    
                        <th>Action</th>
    
                    </tr>
                </thead>
                <tbody>

                    @foreach($journeys as $journey)
    
                        <tr>
    
                            <td>
    
                               @if(!empty($journey->image))
                                   <img src="{{ asset('storage/' . $journey->image) }}"
                                        width="100"
                                        height="70"
                                        style="object-fit: cover;">
                                @endif
    
                            </td>
    
                            <td>{{ $journey->title }}</td>
    
                            <td>{{ $journey->date }}</td>
                            
                            <td>
                                <a href="{{ route('admin.journey.edit',$journey->id) }}"
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.journey.delete',$journey->id) }}"
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


    <br>


    <!-- ================= TEAM ================= -->

    <div class="card">

        <div class="card-header" style="background-color:#f3f8fb;">
            <h4>{{ isset($editTeam) ? 'Update Team Member' : 'Add Team Member' }}</h4>
        </div>
    
        <div class="card-body">
    
            <form action="{{ route('admin.team.save') }}"
                  method="POST"
                  enctype="multipart/form-data">
    
                @csrf
    
                <input type="hidden" name="id" value="{{ $editTeam->id ?? '' }}">
    
                <div class="row">
    
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               class="form-control"
                               name="name"
                               value="{{ $editTeam->name ?? '' }}"
                               placeholder="Enter Member Name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror    
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label for="designation" class="form-label">
                            Designation <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="designation"
                               class="form-control"
                               name="designation"
                               value="{{ $editTeam->designation ?? '' }}"
                               placeholder="Enter Designation">
                        @error('designation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror 
                    </div>
    
                </div>
    
                <div class="row">
    
                    <div class="col-md-6 mb-3">
                        <label for="linkedin" class="form-label">
                            LinkedIn URL
                        </label>
                        <input type="url"
                               id="linkedin"
                               class="form-control"
                               name="linkedin"
                               value="{{ $editTeam->linkedin ?? '' }}"
                               placeholder="https://www.linkedin.com/in/username">
                        @error('linkedin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror   
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label for="member_position" class="form-label">
                            Display Order <span class="text-danger">*</span>
                        </label>
                    
                        <input type="number"
                               id="member_position"
                               class="form-control @error('member_position') is-invalid @enderror"
                               name="member_position"
                               value="{{ old('member_position', $editTeam->member_position ?? '') }}"
                               placeholder="Enter Display Order">
                    
                        @error('position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                </div>
    
                <div class="row">
    
                    <!--<div class="col-md-6 mb-3">-->
                    <!--    <label for="status" class="form-label">-->
                    <!--        Status <span class="text-danger">*</span>-->
                    <!--    </label>-->
    
                    <!--    <select id="status"-->
                    <!--            class="form-control"-->
                    <!--            name="status">-->
                    <!--        <option value="1" {{ isset($editTeam) && $editTeam->status == 1 ? 'selected' : '' }}>-->
                    <!--            Active-->
                    <!--        </option>-->
                    <!--        <option value="0" {{ isset($editTeam) && $editTeam->status == 0 ? 'selected' : '' }}>-->
                    <!--            Inactive-->
                    <!--        </option>-->
                    <!--    </select>-->
                    <!--</div>-->
                    <input type="hidden" name="status" value="1">
                    <div class="col-md-6 mb-3">
                        <label for="team_image" class="form-label">
                            Profile Image <span class="text-danger">*</span>
                        </label>
                    
                        <input type="file"
                               id="team_image"
                               class="form-control @error('image') is-invalid @enderror"
                               name="image"
                               accept="image/*">
                    
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    
                        <div class="mt-2">
                            <img id="teamImagePreview"
                                 src="{{ isset($editTeam) && $editTeam->image 
                                    ? asset('storage/' . $editTeam->image) 
                                    : '' }}"
                                 width="120"
                                 height="120"
                                 style="object-fit:cover; border-radius:8px; {{ isset($editTeam) && $editTeam->image ? '' : 'display:none;' }}">
                        </div>
                    </div>
    
                </div>
    
                <button type="submit" class="btn btn-primary">
                    {{ isset($editTeam) ? 'Update Member' : 'Add Member' }}
                </button>
    
                @if(isset($editTeam))
                    <a href="{{ route('admin.about.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                @endif
    
            </form>
    
        </div>
    
    </div>


    <br>


    <!-- Team List -->

    <div class="card">

        <div class="card-header">

            <h4>Team Members</h4>

        </div>

        <div class="card-body">

            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
    
                        <th>Image</th>
    
                        <th>Name</th>
    
                        <th>Designation</th>
    
                        <th>Action</th>
    
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
    
                        <tr>
    
                            <td>
    
                                @if(!empty($team->image))
                                    <img src="{{ asset('storage/' .$team->image) }}"
                                         width="100"
                                         height="100"
                                         style="object-fit:cover;">
                                @endif
    
                            </td>
    
                            <td>{{ $team->name }}</td>
    
                            <td>{{ $team->designation }}</td>
    
                            <td>
    
                                <a href="{{ route('admin.team.edit',$team->id) }}"
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.team.delete',$team->id) }}"
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

    $('#about_image').on('change', function () {

        const file = this.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function (e) {

                $('#aboutImagePreview')
                    .attr('src', e.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        }

    });
    $('#journey_image').on('change', function () {

        const file = this.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function (e) {

                $('#journeyImagePreview')
                    .attr('src', e.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        }

    });
    $('#team_image').on('change', function () {

        const file = this.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function (e) {

                $('#teamImagePreview')
                    .attr('src', e.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        }

    });


});
</script>
@endsection