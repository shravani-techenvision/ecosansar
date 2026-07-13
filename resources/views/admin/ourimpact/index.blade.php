@extends('layouts.master')

@section('title')
Our Impact Management
@endsection

@section('content')

@component('common-components.breadcrumb')
    @slot('pagetitle') Admin @endslot
    @slot('title') Our Impact @endslot
@endcomponent

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ADD / EDIT -->
    <div class="card mb-4">

        <div class="card-header" style="background-color:#f3f8fb;">
            <h4>Add / Update Impact</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.ourimpact.save') }}" method="POST">

                @csrf

                <input type="hidden" name="id" value="{{ $editImpact->id ?? '' }}">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                    
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $editImpact->title ?? '') }}"
                               placeholder="Enter Title">
                    
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Count <span class="text-danger">*</span></label>
                    
                        <input type="number"
                               name="count"
                               class="form-control @error('count') is-invalid @enderror"
                               value="{{ old('count', $editImpact->count ?? '') }}"
                               placeholder="Enter Count">
                    
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Suffix</label>
                    
                        <input type="text"
                               name="suffix"
                               class="form-control @error('suffix') is-invalid @enderror"
                               value="{{ old('suffix', $editImpact->suffix ?? '+') }}">
                    
                        @error('suffix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-8 mb-3">
                        <label>Description <span class="text-danger">*</span></label>
                    
                        <textarea
                            name="description"
                            rows="3"
                            class="form-control @error('description') is-invalid @enderror"
                        >{{ old('description', $editImpact->description ?? '') }}</textarea>
                    
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Display Order <span class="text-danger">*</span></label>
                    
                        <input type="number"
                               name="display_order"
                               class="form-control @error('display_order') is-invalid @enderror"
                               value="{{ old('display_order', $editImpact->display_order ?? '') }}">
                    
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                    
                        <select
                            name="status"
                            class="form-control @error('status') is-invalid @enderror">
                    
                            <option value="1"
                                {{ old('status', $editImpact->status ?? 1) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                    
                            <option value="0"
                                {{ old('status', $editImpact->status ?? 1) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                    
                        </select>
                    
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="col-3 m-5">
                    <button class="btn btn-primary">
                        {{ isset($editImpact) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>

        </div>

    </div>

    <!-- LIST -->

    <div class="card">

        <div class="card-header">
            <h4>Impact List</h4>
        </div>

        <div class="card-body">

            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <thead>

                    <tr>
                        <th>Title</th>
                        <th>Count</th>
                        <th>Suffix</th>
                        <th>Description</th>
                        <th>Display Order</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($impacts as $item)

                    <tr>

                        <td>{{ $item->title }}</td>
                        <td>{{ $item->count }}</td>
                        <td>{{ $item->suffix }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->display_order }}</td>

                        <td>
                            @if($item->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.ourimpact.edit',$item->id) }}"
                               class="btn btn-outline-success btn-sm edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        
                            <a href="{{ route('admin.ourimpact.delete',$item->id) }}"
                               class="btn btn-outline-danger btn-sm deleteAttr"
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
@endsection