@extends('layouts.master')
@section('title')
    Subscription Module
@endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Add @endslot
        @slot('title')  Subscription Module @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                         <div class="col-4">
                            <p class="mb-0"><strong>Plan Name:</strong><br>
                            <p>@isset($subscription->plan_name){{ $subscription->plan_name }}@endisset</p>
                        </div>
                         <div class="col-4">
                            <p class="mb-0"><strong>Plan Price:</strong><br>
                            <p>@isset($subscription->plan_price){{ $subscription->plan_price }}@endisset</p>
                        </div>
                         <div class="col-4">
                            <p class="mb-0"><strong>Plan Validity:</strong><br>
                            <p>@isset($subscription->plan_validity)
                                @if($subscription->plan_validity == 1)
                                    1 Month
                                 @elseif($subscription->plan_validity == 15)
                                                15 Days
                                @else
                                    {{ $subscription->plan_validity }} Months
                                @endif
                            @else
                                Not Specified
                            @endisset</p>
                        </div>
                        
                        
                    </div> <!-- end row -->
                    <div class="row">
                    <div class="col-12">
                            <p class="mb-0"><strong>Description:</strong><br>
                            {!! $subscription->plan_description !!} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
 




@endsection
