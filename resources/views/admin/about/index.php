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

                    <label>Image</label>

                    <input type="file"
                           class="form-control"
                           name="image">

                    @if(isset($about->image))

                        <img src="{{ asset($about->image) }}"
                             width="150"
                             class="mt-2">

                    @endif

                </div>

                <button class="btn btn-success">

                    Update About

                </button>

            </form>

        </div>

    </div>



    <!-- ================= JOURNEY SECTION ================= -->

    <div class="card mb-4">

        <div class="card-header text-white" style="background-color:#f3f8fb;">

            <h4>Add Journey</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.journey.save') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-md-6">

                        <input class="form-control"
                               name="title"
                               placeholder="Journey Title">

                    </div>

                    <div class="col-md-6">

                        <input class="form-control"
                               name="date"
                               placeholder="December 2017">

                    </div>

                </div>

                <br>

                <textarea class="form-control"
                          rows="5"
                          name="description"
                          placeholder="Description"></textarea>

                <br>

                <input type="number"
                       class="form-control"
                       name="position"
                       placeholder="Display Order">

                <br>

                <input type="file"
                       class="form-control"
                       name="image">

                <br>

                <button class="btn btn-primary">

                    Add Journey

                </button>

            </form>

        </div>

    </div>



    <!-- Journey List -->

    <div class="card">

        <div class="card-header">

            <h4>Journey List</h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th>Image</th>

                    <th>Title</th>

                    <th>Date</th>

                    <th>Action</th>

                </tr>

                @foreach($journeys as $journey)

                    <tr>

                        <td>

                            <img src="{{ asset($journey->image) }}"
                                 width="100">

                        </td>

                        <td>{{ $journey->title }}</td>

                        <td>{{ $journey->date }}</td>

                        <td>

                            <a href="{{ route('admin.journey.delete',$journey->id) }}"
                               class="btn btn-danger btn-sm">

                                Delete

                            </a>

                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

    </div>


    <br>


    <!-- ================= TEAM ================= -->

    <div class="card">

        <div class="card-header" style="background-color:#f3f8fb;">

            <h4>Add Team Member</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.team.save') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input class="form-control"
                       name="name"
                       placeholder="Name">

                <br>

                <input class="form-control"
                       name="designation"
                       placeholder="Designation">

                <br>

                <input class="form-control"
                       name="linkedin"
                       placeholder="Linkedin URL">

                <br>

                <input class="form-control"
                       type="number"
                       name="position"
                       placeholder="Position">

                <br>

                <select class="form-control"
                        name="status">

                    <option value="1">

                        Active

                    </option>

                    <option value="0">

                        Inactive

                    </option>

                </select>

                <br>

                <input type="file"
                       class="form-control"
                       name="image">

                <br>

                <button class="btn btn-success">

                    Add Member

                </button>

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

            <table class="table table-bordered">

                <tr>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Designation</th>

                    <th>Action</th>

                </tr>

                @foreach($teams as $team)

                    <tr>

                        <td>

                            <img src="{{ asset($team->image) }}"
                                 width="100">

                        </td>

                        <td>{{ $team->name }}</td>

                        <td>{{ $team->designation }}</td>

                        <td>

                            <a href="{{ route('admin.team.delete',$team->id) }}"
                               class="btn btn-danger btn-sm">

                                Delete

                            </a>

                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

    </div>

</div>

@endsection