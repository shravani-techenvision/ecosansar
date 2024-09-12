@extends('layouts.master')
@section('title')
SAB Posts View
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   View @endslot
@slot('title') SAB Posts @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <h4 class="card-title">SAB Posts Details</h4>
                {{--  <p class="card-title-desc">See how aspects of the Bootstrap grid system work across multiple devices with a handy table.</p>  --}}
                <section class="basic-details pt-2 pb-0 px-3" style="border: 1px solid #ccc;border-radius:5px;">
                <div class="row">
                    <div class="col-4">
                        <p class="mb-0"><strong>Name:</strong><br>
                        <p>@isset($users->name){{ $users->name }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Email:</strong><br>
                        <p>@isset($users->email){{ $users->email }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Mobile:</strong><br>
                        <p>@isset($users->mobile){{ $users->mobile }}@endisset</p>
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
                        <p class="mb-0"><strong>Latitude:</strong><br>
                        <p>@isset($users->latitude){{ $users->latitude }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Longitude:</strong><br>
                        <p>@isset($users->longitude){{ $users->longitude }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Sale/Giveaway:</strong><br>
                        <p>@isset($users->sale_giveaway){{ $users->sale_giveaway }}@endisset</p>
                    </div>
                    <!--<div class="col-4">-->
                    <!--    <p class="mb-0"><strong>Quantity:</strong><br>-->
                    <!--    <p>@isset($users->quantity){{ $users->quantity }}@endisset</p>-->
                    <!--</div>-->
                    <div class="col-4">
                        <p class="mb-0"><strong>Clean/Unclean:</strong><br>
                        <p>@isset($users->clean_unclean){{ $users->clean_unclean }}@endisset</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>Packaged:</strong><br>
                        <p>@isset($users->packaged){{ $users->packaged }}@endisset</p>
                    </div>
                    
                    <div class="col-4">
                        <p class="mb-0"><strong>Weight:</strong><br>
                        <p>@isset($users->min_weight){{ $users->min_weight }} {{ $users->min_measure }} {{'to'}} {{ $users->max_weight }} {{ $users->max_measure }}@endisset</p>
                    </div>
                    
                    <div class="col-4">
                        <p class="mb-0"><strong>Resource name:</strong><br>
                        <p> @foreach($postimg as $resource)
                          @isset($resource->resource_name){{ $resource->resource_name }} @endisset
                          @if(!$loop->last), @endif
                         @endforeach</p>
                    </div>
                    
                    <p class="mb-0"><strong>Post Image:</strong><br>
                      @foreach($postimg as $img)
                     <div class="col-4">
                        <p class="mb-0"><strong></strong>
                            <img src="{{ asset('frontend/assets/img/SABposts/' . $img->resource_img) }}" alt="Post Image" class="img-thumbnail mb-2" style="max-width: 200px;">
                        </p>
                    </div>
                     @endforeach
                    
                </div>
                </section>
                <div class="mt-3  text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-primary waves-effect waves-light" >Back</a>
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
