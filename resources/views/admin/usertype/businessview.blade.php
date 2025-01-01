@extends('layouts.master')
@section('title')
Corporate View
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   View @endslot
@slot('title') Corporate  @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <h4 class="card-title">Corporate Details</h4>
                {{--  <p class="card-title-desc">See how aspects of the Bootstrap grid system work across multiple devices with a handy table.</p>  --}}
                <section class="basic-details pt-2 pb-0 px-3" style="border: 1px solid #ccc;border-radius:5px;">
                <div class="row">
                    <div class="col-4">
                        <p class="mb-0"><strong> Unique ID:</strong><br>
                        <p>@isset($users->unique_id){{ $users->unique_id }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Business name:</strong><br>
                        <p>@isset($users->name){{ $users->name }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Address:</strong><br>
                        <p>@isset($users->address){{ $users->address }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Pincode:</strong><br>
                        <p>@isset($users->pincode){{ $users->pincode }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Contact person:</strong><br>
                        <p>@isset($users->contact_person){{ $users->contact_person }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Contact person phone:</strong><br>
                        <p>@isset($users->mobile){{ $users->mobile }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Email:</strong><br>
                        <p>@isset($users->email){{ $users->email }}@endisset</p>
                    </div>
                    <!--<div class="col-4">-->
                    <!--    <p class="mb-0"><strong>GST:</strong><br>-->
                    <!--    <p>@isset($users->gst){{ $users->gst }}@endisset</p>-->
                    <!--</div>-->

                     <div class="col-4">
                        <p class="mb-0"><strong>Weight:</strong><br>
                        <p>@isset($users->min_weight){{ $users->min_weight }} {{ $users->min_measure }} {{ $users->max_weight }} {{ $users->max_measure }}@endisset</p>
                    </div>

                    <div class="col-4">
                        <p class="mb-0"><strong>Resource name:</strong><br>
                        <p>@isset($users->resource_name){{ $users->resource_name }}@endisset</p>
                    </div>

                </div>
                </section>
                <div class="mt-3  text-center">
                        <a href="{{ route('user.businesslist') }}" class="btn btn-primary waves-effect waves-light" >Back</a>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
@endsection
