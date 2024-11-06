
@include('frontend.include.header1')
@include('sweetalert::alert')

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .btn.btn-small{
        padding: 7px 10px !important;

    }
     .row{
        margin-right: 0px;
        margin-left: 0px;
    }
    .input-group-addon{
        background-color:white !important;
        border:none !important;
        border-bottom: 2px solid #cccccc6e !important;
    }
</style>
</head>
    <div id="page-content">
        <div class="container">
            <div class="row" >
                <div class=" ">
                    <section class="page-title">
                        <br>
                        <h1>Profile Details</h1>
                    </section

                    <!--end page-title-->
                    <section id="business">
                        <form class="form inputs-underline" action="{{ $url }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input   type="text" class="form-control" name="name" id="name" placeholder=" Name" value="@if(isset($users->name)){{ $users->name }}@else{{ old('name')}}@endif">
                                        @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                    </div>
                                </div>
                                    <!--end form-group-->
                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label for="mobile">Phone number<span style="color:red;">*</span></label>-->
                                    <!--        <input type="text" minlength="10" maxlength="10" class="form-control" name="mobile" id="mobile" placeholder="Phone number" value="@if(isset($users->mobile)){{ $users->mobile }}@else{{ old('mobile')}}@endif">-->
                                    <!--        @if ($errors->has('mobile'))-->
                                    <!--                <span class="text-danger">{{ $errors->first('mobile') }}</span>-->
                                    <!--            @endif-->
                                    <!--    </div>-->
                                    <!--    </div>-->

                                         <div class="col-md-6">
                                   <div class="form-group" id="contact-group">
                                        <label for="contact">Phone<span style="color:red;">*</span></label><br>
                                        <div class="input-group" id="phone91">
                                            <!--<label for="last_name">Phone number<span style="color:red;">*</span> </label><br><br>-->
                                                <div class="input-group">
                                                    <span class="input-group-addon">+91 </span>
                                                        <input readonly onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 8" type="text" class="form-control" name="mobile" id="mobile" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value="@if(isset($users->mobile)) {{ $users->mobile }}@else{{ old('mobile')}}@endif">
                                                       <div id="contact-error" class="invalid-feedback text-danger" style="display: none;"></div>
                                                        @if ($errors->has('mobile'))
                                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                                     @endif
                                                    </div>
                                            <!-- Error message -->
                                        </div>
                                    </div>

                                    </div>

                                        <!--end form-group-->
                            </div>
                            <div class="row">
                                    <!--end col-md-6-->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email id</label>
                                        <input   type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($users->email)){{ $users->email }}@else{{ old('email')}}@endif">
                                        @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                    </div>
                                    </div>
                                <div class="col-md-6">
                               <div class="form-group">
                                  <label for="address">
                                    Address<span class="text-danger">*</span>
                                  </label>
                                  <textarea
                                    class="form-control"
                                    rows="4"
                                    cols="50"
                                    name="address"
                                    id="address"
                                    placeholder="Address">{{ old('address', $users->address ?? '') }}</textarea>
                                  @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                  @endif
                                </div>
                            </div>
                        </div>




                            <!--enr row-->





                            <!--end form-group-->

                                <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Save profile  </button>
                                <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                                </div>
                            <!--end form-group-->
                        </form>

                        {{--  <hr>

                        <p class="center">By clicking on “Register Now” button you are accepting the <a href="terms-conditions.html">Terms & Conditions</a></p>  --}}
                    </section>


                </div>
                <!--col-md-4-->
            </div>
             <!--<div class="row" style="margin-right:-9px !important; margin-left:-3px !important;">-->
                                    <!--end col-md-6-->


             <!--                   <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Add your post  </button>-->

             <!--                   <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Browse listings</a>-->

             <!--                    </div>-->
               @if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    <div class="formob">
        @if ($userType == 'sab')
            <a href="{{ route('sab_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
        @elseif ($userType == 'consumer')
            <a href="{{ route('consumer_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
        @else
            <a href="{{ route('business_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
        @endif
    </div>
@else
    @php
        $redirectUrl = '';
        $userType = session('user_type'); // Assuming you have stored the user type in the session

        if ($userType == 'sab') {
            $redirectUrl = route('sab_details');
        } elseif ($userType == 'consumer') {
            $redirectUrl = route('consumer_details');
        } else {
            $redirectUrl = route('business_details');
        }
    @endphp
    <div class="formob">
        <a href="{{ route('consumer_login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
    </div>

@endif

@if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    <div class="formob" style="float: inline-end; margin-top: -31px !important;">
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
    </div>
@else
    <div class="formob">
        <a href="{{ route('consumer_login', ['redirect_list' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
    </div>
@endif

            <div class="rows">
  @if( $utype == 'consumer')
 <section>
     <br>
                     <h2>Contributor Active Listings </h2>
                    <div class="row">
                        @foreach($uniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('consumer_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('Consumerposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                         <a href="#" class="con-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a>
                                          <a href="#" class="con-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing pull-right" data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>



                     <h2>Contributor Deactive Listings </h2>
                    <div class="row">
                        @foreach($deactiveuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('consumer_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('Consumerposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                         <!--<a href="#" class="con-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a>-->
                                          <a href="#" class="con-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing  " data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>

                    <!--end row-->
                </section>
@elseif($utype == 'sab')
<section>
                     <h2>Resource Collector Active Listings</h2>
                    <div class="row">
                        @foreach($sabuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sab_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('SABposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                         <a href="#" class="sab-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a>
                                          <a href="#" class="sab-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing pull-right" data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>

                                         <h2>Resource Collector Deactive Listings</h2>
                    <div class="row">
                        @foreach($deactivesabuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sab_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('SABposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                         <!--<a href="#" class="sab-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a> -->
                                          <a href="#" class="sab-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing " data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>

                    <!--end row-->
                </section>
@else
<section>
                     <h2>Corporate Active Listings </h2>
                    <div class="row">
                        @foreach($busuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('business_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <h4>{{ $listing->address }}</h4>
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('Businessposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                        <!--<h4>{{ $listing->active }}</h4>-->
                                        <a href="#" class="bus-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a>
                                         <a href="#" class="bus-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing pull-right" data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>


                     <h2>Corporate Deactive Listings </h2>
                    <div class="row">
                        @foreach($deactivebusuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('business_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <h4>{{ $listing->address }}</h4>
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ Storage::disk('s3')->url('Businessposts/' . $listing->resource_img) }}" alt="abc">

                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<div class="rating-passive" data-rating="{{ $listing->rating }}">-->
                                        <!--    <span class="stars"></span>-->
                                        <!--    <span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        <!--</div>-->
                                        <!--<a href="#" class="bus-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a> -->
                                         <a href="#" class="bus-reactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing " data-post-id="{{ $listing->id }}">Reactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>

                    <!--end row-->
                </section>
@endif



                <!--<section>-->

                <!--    @if( $utype == 'consumer')-->
                <!--     <h2>Reviews</h2>-->
                <!--    <div class="review">-->

                <!--        @foreach($conrev as $review)-->
                <!--        <div class="description">-->
                <!--            <figure>-->
                <!--                <div class="rating-passive" data-rating="{{ $review->rating }}">-->
                <!--                    <span class=" ">{{ $review->title }}</span>-->
                <!--                    <span class="stars"></span>-->
                <!--                    <span class="reviews">{{ $review->rating }}</span>-->
                <!--                </div>-->
                <!--            </figure>-->
                <!--            <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->-->
                <!--        </div>-->
                <!--        @endforeach-->

                <!--    </div>-->

                <!--    @else-->
                <!--    <div class="review">-->

                <!--        @foreach($sabrev as $review)-->
                <!--        <div class="description">-->
                <!--            <figure>-->
                <!--                <div class="rating-passive" data-rating="{{ $review->rating }}">-->
                <!--                    <span class=" ">{{ $review->title }}</span>-->
                <!--                    <span class="stars"></span>-->
                <!--                    <span class="reviews">{{ $review->rating }}</span>-->
                <!--                </div>-->
                <!--            </figure>-->
                <!--            <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->-->
                <!--        </div>-->
                <!--        @endforeach-->

                <!--    </div>-->
                <!--    @endif-->
                    <!--end review-->


                <!--</section>-->
            </div>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->


 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <script>
        $(document).ready(function() {
            $('.con-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('consumer-posts.deactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

       <script>
        $(document).ready(function() {
            $('.sab-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('sab-posts.deactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

           <script>
        $(document).ready(function() {
            $('.bus-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('bus-posts.deactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            $('.bus-reactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to reactivate this post?')) {
                    $.ajax({
                        url: '{{ route('bus-posts.reactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            $('.sab-reactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to reactivate this post?')) {
                    $.ajax({
                        url: '{{ route('sab-posts.reactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.con-reactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to reactivate this post?')) {
                    $.ajax({
                        url: '{{ route('consumer-posts.reactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 5000
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        @endif
    });
</script>

 @include('frontend.include.footer')

