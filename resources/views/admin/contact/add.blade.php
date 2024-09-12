@extends('layouts.master')
@section('title')
Contact Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Contact @endslot
@endcomponent

@include('sweetalert::alert')
<div class="row justify-content-center align-items-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            {{--  <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups</h5>  --}}

                            <form class="needs-validation" novalidate action="{{ $url }}" Method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->email)) {{ $contact->email }} @endif" name="email" id="email" placeholder="Enter your Email">
                                            <div class="invalid-feedback">
                                               Please Enter Email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Mobile<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->mobile)) {{ $contact->mobile }} @endif" name="mobile" id="mobile" placeholder="Enter your Mobile">
                                           <div class="invalid-feedback">
                                                Please Enter Mobile.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address<span style="color:red;">*</span></label>
                                              <div>
                                                  <textarea required class="form-control" name="address" id="address" rows="5">@if (isset($contact->address)) {{ $contact->address }} @endif</textarea>
                                              </div>
                                           <div class="invalid-feedback">
                                                Please provide Address.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Google Map<span style="color:red;">*</span></label>
                                              <div>
                                                  <textarea required class="form-control" name="map" id="map" rows="5">@if (isset($contact->map)) {{ $contact->map }} @endif</textarea>
                                              </div>
                                           <div class="invalid-feedback">
                                                Please provide Map Address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="facebook">Facebook<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->facebook)) {{ $contact->facebook }} @endif" name="facebook" id="facebook" value="">
                                            <div class="invalid-feedback">
                                               Please Enter Your Facebook Page Url.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="insta">Instagram<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->insta)) {{ $contact->insta }} @endif" name="insta" id="insta" placeholder="Enter Your Instagram Page Url">
                                           <div class="invalid-feedback">
                                                Please Enter Your Instagram page Url.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="twitter">Twitter<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->twitter)) {{ $contact->twitter }} @endif" name="twitter" id="twitter" placeholder="Enter Your Twitter Page Url">
                                            <div class="invalid-feedback">
                                               Please Enter Your Twitter Page Url.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="linkedin">LinkedIn<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->linkedin)) {{ $contact->linkedin }} @endif" name="linkedin" id="linkedin" placeholder="Enter Your LinkedIn page Url">
                                           <div class="invalid-feedback">
                                                Please Enter Your LinkedIn page Url.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="utube">Youtube<span style="color:red;">*</span></label>
                                            <input required type="text" class="form-control" value="@if (isset($contact->utube)) {{ $contact->utube }} @endif" name="utube" id="utube" placeholder="Enter Your Youtube page Url">
                                           <div class="invalid-feedback">
                                                Please Enter Your Youtube page Url.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('contact.list')}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
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
