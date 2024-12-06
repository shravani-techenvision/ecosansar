
@include('frontend.include.header1')
@include('sweetalert::alert')

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .formob .btn.btn-small{
        padding: 7px 7px !important;

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

    <div class="formob" style="float: inline-end; margin-top: -35px !important;">
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

<section>

    @if( $utype == 'consumer')

     <h2>What Others Say About Me</h2>

     <div class="row">
         <div class="col-12"  >
             <div class="review-container">
    <div class="review">
         @if($conrev->isEmpty())
        <p>No reviews available.</p>
        @else
        @foreach($conrev as $review)
        <div class="description" data-id="{{ $review->id }}">
            <figure>
                <div class="rating-passive" data-rating="{{ $review->rating }}">
                     <span class="name">{{ $review->name }}</span>  <a class="btn btn-primary   btn-rounded icon shadow add-listing change-review">change review</a>    <br>
                    <span class=" ">{{ $review->title }}</span>
                    <span class="stars"></span>

                </div>
            </figure>
            <span>{{ $review->message }}</span> <!-- Assuming content is your review content -->
        </div>
        <hr>
        @endforeach
        @endif
    </div>
    </div>
    </div>
    </div>
    <hr>

    <div class="row">
    <div class="col-12" style="">
         <div class="review-container">
         <div class="table-section">
<!-- Your Table Code Goes Here -->
<h2>People I Know</h2>
     <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody><span hidden>{{ $i=1; }}</span>
                     @foreach($conenq as $data)
                        <tr>
                             <td>{{ $i++ }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->mobile }}</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-small btn-rounded icon shadow add-listing conreview @if($data->flag == 'asked') disabled @endif"
                                    data-id="{{ $data->id }}"
                                    @if($data->flag == 'asked') data-disabled="true" @endif
                                >
                                    <strong>{{ $data->flag == 'asked' ? 'Asked for review' : 'Ask for review' }}</strong>
                                </a>
                            </td>

                        </tr>
                     @endforeach
         </tbody>
     </table>

</div>
</div>
</div>
</div>
    @elseif( $utype == 'business' )
    <h2>What Others Say About Me</h2>
    <div class="row">
         <div class="col-12" style="" >
             <div class="review-container">
    <div class="review busrev">
         @if($busrev->isEmpty())
        <p>No reviews available.</p>
        @else
        @foreach($busrev as $review)
        <div class="description  busdes" data-id="{{ $review->id }}">
            <figure>
                <div class="rating-passive" data-rating="{{ $review->rating }}">
                      <span class="name">{{ $review->name }}</span> <a class="btn btn-primary   btn-rounded icon shadow add-listing bus-change-review">change review</a> <br>
                    <span class=" ">{{ $review->title }}</span>
                    <span class="stars"></span>

                </div>
            </figure>
            <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->
        </div>
        @endforeach
        @endif
    </div>
    </div>
    </div>
    </div>
    <hr>
    <div class="row">
    <div class="col-12" style="">
         <div class="review-container">
              <div class="table-section">
<!-- Your Table Code Goes Here -->
<h2>People I Know</h2>
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<th>Sr. No</th>
<th>Name</th>
<th>Mobile</th>
<th>Action</th>

</tr>
</thead>
<tbody><span hidden>{{ $i=1; }}</span>
@foreach($busenq as $data)
        <tr>
             <td>{{ $i++ }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->mobile }}</td>
            <td>
<a
class="btn btn-primary btn-small btn-rounded icon shadow add-listing busreview @if($data->flag == 'asked') disabled @endif"
data-id="{{ $data->id }}"
@if($data->flag == 'asked') data-disabled="true" @endif
>
<strong>{{ $data->flag == 'asked' ? 'Asked for review' : 'Ask for review' }}</strong>
</a>
</td>

        </tr>
        @endforeach
</tbody>

</table>




</div>
        </div>
    </div>
    </div>
    @else
     <h2  >What Others Say About Me</h2>
    <div class="row">




         <div class="col-12" style="" >

             <div class="review-container">
    <div class="review sabrev">
         @if($sabrev->isEmpty())
        <p>No reviews available.</p>
        @else
        @foreach($sabrev as $review)
        <div class="description sabdes" data-id="{{ $review->id }}">
            <figure>
                <div class="rating-passive" data-rating="{{ $review->rating }}">
                      <span class="name">{{ $review->name }}</span> <a class="btn btn-primary   btn-rounded icon shadow add-listing sab-change-review">change review</a>   <br>
                    <span class=" ">{{ $review->title }}</span>
                    <span class="stars"></span>

                </div>
            </figure>
            <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->
        </div>
        @endforeach
        @endif
    </div>
    </div>
    </div>
    </div>
    <hr>

<div class="row">
    <div class="col-12" style="">

         <div class="review-container">
              <div class="table-section">
<!-- Your Table Code Goes Here -->
<h2  > People I Know</h2>
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<th>Sr. No</th>
<th>Name</th>
<th>Mobile</th>
<th>Action</th>

</tr>
</thead>
<tbody><span hidden>{{ $i=1; }}</span>
@foreach($sabenq as $data)
        <tr>
             <td>{{ $i++ }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->mobile }}</td>
            <td>
<a
class="btn btn-primary btn-small btn-rounded icon shadow add-listing sabreview @if($data->flag == 'asked') disabled @endif"
data-id="{{ $data->id }}"
@if($data->flag == 'asked') data-disabled="true" @endif
>
<strong>{{ $data->flag == 'asked' ? 'Asked for review' : 'Ask for review' }}</strong>
</a>
</td>

        </tr>
        @endforeach
</tbody>

</table>




</div>
        </div>
    </div>
    </div>
    @endif
    <!--end review-->


</section>
<hr>
<section>

  <div class="row"  >
      <div class="col-12">
         <div class="table-section">
<!-- Your Table Code Goes Here -->
<h2>What I Say About Others</h2><br>
  <div class="table-responsive">
     <table id="example1" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th style="word-wrap: break-word !important;white-space: normal; word-break: break-word">Title</th>
                <th>Ratings</th>
                <th>Review</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody><span hidden>{{ $i=1; }}</span>
                     @foreach($reviews as $data)
                        <tr data-source="{{ $data->type }}" data-id="{{ $data->id }}">
                             <td>{{ $i++ }}</td>
                             <td>
    <!-- Make the title editable on click -->
    <span style="word-wrap: break-word !important;white-space: normal; word-break: break-word" class="editable-title" data-id="{{ $data->id }}">{{ $data->title }}</span>
     <textarea class="edit-title-textarea" style="display: none;"></textarea>
</td>
<td>
    <!-- Display rating as stars, initially visible -->
    <div class="editable-rating" data-id="{{ $data->id }}" data-rating="{{ $data->rating }}">
        <!-- Stars will be dynamically generated here -->
    </div>
</td>
<td>
    <!-- Use a textarea for editing the review -->
    <span style="word-wrap: break-word !important;white-space: normal; word-break: break-word" class="editable-review" data-id="{{ $data->id }}">{{ $data->message }}</span>
    <textarea class="edit-review-textarea" style="display:none;"></textarea>
</td>

<!-- Action Column -->
<td>
<!-- Action buttons for editing the review -->
<i class="fa fa-pencil edit-review" style="cursor: pointer; color: #8eb66f;"></i>
    <i class="fa fa-check save-review" style="cursor: pointer; color: #8eb66f; display: none;"></i>
    <i class="fa fa-times cancel-edit" style="cursor: pointer; color: #dc3545; display: none;"></i>

</td>

                        </tr>
                     @endforeach
         </tbody>
     </table>
</div>
</div>
</div>

</div>

</section>

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
    <!--consumer ask review start-->
    <script>
      $(document).on('click', '.conreview', function(event) {
          var button = $(this);  // Reference to the clicked button

          // Prevent click event if the button is already disabled
          if (button.is(':disabled')) {
              alert('in');
              event.preventDefault();  // Prevent default click behavior
              return;  // Exit the function, so no AJAX request is sent
          }

          var id = button.data('id');  // Get the ID of the record

          // Send AJAX request
          $.ajax({
              url: '{{ url('send-review-request') }}/' + id,  // The URL of the route with ID
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                      button.html('<strong>Asked for review</strong>'); // Change button text
                      button.prop('disabled', true); // Disable button after sending request
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  </script>
   <!--consumer ask review end-->

   <!--business ask review start-->
    <script>
      $(document).on('click', '.busreview', function(event) {
          var button = $(this);  // Reference to the clicked button

          // Prevent click event if the button is already disabled
          if (button.is(':disabled')) {
              alert('in');
              event.preventDefault();  // Prevent default click behavior
              return;  // Exit the function, so no AJAX request is sent
          }

          var id = button.data('id');  // Get the ID of the record

          // Send AJAX request
          $.ajax({
              url: '{{ url('bus-send-review-request') }}/' + id,  // The URL of the route with ID
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                      button.html('<strong>Asked for review</strong>'); // Change button text
                      button.prop('disabled', true); // Disable button after sending request
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  </script>
  <!--business ask review end-->

  <!--sab ask review start-->
   <script>
      $(document).on('click', '.sabreview', function(event) {
          var button = $(this);  // Reference to the clicked button

          // Prevent click event if the button is already disabled
          if (button.is(':disabled')) {
              alert('in');
              event.preventDefault();  // Prevent default click behavior
              return;  // Exit the function, so no AJAX request is sent
          }

          var id = button.data('id');  // Get the ID of the record

          // Send AJAX request
          $.ajax({
              url: '{{ url('sab-send-review-request') }}/' + id,  // The URL of the route with ID
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                      button.html('<strong>Asked for review</strong>'); // Change button text
                      button.prop('disabled', true); // Disable button after sending request
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  </script>
  <!--sab ask review end-->

  <!--consumer change review start-->
  <script>
  $(document).ready(function() {
      // Delegate the click event to dynamically bind the "Change Review" button
      $('.review').on('click', '.change-review', function() {
          // Get the review ID from the closest description div
          var reviewId = $(this).closest('.description').data('id');
  alert(reviewId);
          // Send AJAX request
          $.ajax({
              url: '{{ url('change-con-review-request') }}/' + reviewId,  // URL of the route with reviewId
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  });



  </script>
  <!--consumer change review end-->
  <!--sab review chnage start-->
  <script>
  $(document).ready(function() {
      // Delegate the click event to dynamically bind the "Change Review" button
      $('.sabrev').on('click', '.sab-change-review', function() {
          // Get the review ID from the closest description div
          var reviewId = $(this).closest('.sabdes').data('id');
  alert(reviewId);
          // Send AJAX request
          $.ajax({
              url: '{{ url('change-sab-review-request') }}/' + reviewId,  // URL of the route with reviewId
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  });



  </script>
  <!--sab review change end-->
  <!--business review chnage start-->
  <script>
  $(document).ready(function() {
      // Delegate the click event to dynamically bind the "Change Review" button
      $('.busrev').on('click', '.bus-change-review', function() {
          // Get the review ID from the closest description div
          var reviewId = $(this).closest('.busdes').data('id');
  alert(reviewId);
          // Send AJAX request
          $.ajax({
              url: '{{ url('change-bus-review-request') }}/' + reviewId,  // URL of the route with reviewId
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}'  // CSRF Token for security
              },
              success: function(response) {
                  if (response.status === 'success') {
                      alert('Review request sent successfully!');
                  } else {
                      alert('Error sending review request.');
                  }
              },
              error: function() {
                  alert('Something went wrong. Please try again later.');
              }
          });
      });
  });



  </script>
  <!--business review chnage end-->
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editIcons = document.querySelectorAll('.edit-review');

        // Display initial star ratings for all rows
        document.querySelectorAll('.editable-rating').forEach(ratingElement => {
            const rating = ratingElement.getAttribute('data-rating');
            generateStarRating(ratingElement, rating);
        });

        // Attach event listener to each edit icon
        editIcons.forEach(function (editIcon) {
            editIcon.addEventListener('click', function () {
                const row = this.closest('tr');
                const titleElement = row.querySelector('.editable-title');
                const titleTextarea = row.querySelector('.edit-title-textarea');
                const ratingElement = row.querySelector('.editable-rating');
                const reviewElement = row.querySelector('.editable-review');
                const reviewTextarea = row.querySelector('.edit-review-textarea');

                // Store original text in case of cancellation
                const originalTitle = titleElement.textContent;
                const originalRating = ratingElement.getAttribute('data-rating');
                const originalReview = reviewElement.textContent;

                // Make the title editable with a textarea
                titleTextarea.value = originalTitle;
                titleTextarea.style.display = 'block';
                titleElement.style.display = 'none';

                // Switch to textarea for review editing
                reviewTextarea.value = originalReview;
                reviewTextarea.style.display = 'block';
                reviewElement.style.display = 'none';

                // Generate star ratings for editing
                generateStarRating(ratingElement, originalRating);

                // Show Save and Cancel icons, hide the Edit icon
                const saveIcon = row.querySelector('.save-review');
                const cancelIcon = row.querySelector('.cancel-edit');
                editIcon.style.display = 'none'; // Hide the Edit icon
                saveIcon.style.display = 'inline-block';
                cancelIcon.style.display = 'inline-block';

                // Handle Save Icon Click
                saveIcon.addEventListener('click', () => {
                    // Get the updated text
                    const updatedTitle = titleTextarea.value;
                    const updatedRating = ratingElement.getAttribute('data-rating');
                    const updatedReview = reviewTextarea.value;
                    const reviewId = reviewElement.getAttribute('data-id');

                    // AJAX to save the updated data
                    saveReview(reviewId, updatedTitle, updatedRating, updatedReview, saveIcon, cancelIcon, editIcon);
                });

                // Handle Cancel Icon Click
                cancelIcon.addEventListener('click', () => {
                    // Revert back to original text
                    titleElement.textContent = originalTitle;
                    reviewElement.textContent = originalReview;

                    // Hide textareas and display original spans
                    titleTextarea.style.display = 'none';
                    titleElement.style.display = 'block';
                    reviewTextarea.style.display = 'none';
                    reviewElement.style.display = 'block';

                    // Hide Save and Cancel icons, show the Edit icon
                    saveIcon.style.display = 'none';
                    cancelIcon.style.display = 'none';
                    editIcon.style.display = 'inline-block';
                });
            });
        });

        // Function to generate star ratings for display and editing
        function generateStarRating(element, rating) {
            element.innerHTML = ''; // Clear existing stars
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                star.classList.add('fa', 'fa-star');
                star.style.cursor = 'pointer';
                star.style.color = i <= rating ? '#FFD700' : '#CCCCCC'; // Highlight based on rating

                // Handle star click for setting rating
                star.addEventListener('click', function () {
                    setStarRating(element, i);
                });

                element.appendChild(star);
            }
        }

        // Function to set star rating
        function setStarRating(element, rating) {
            element.setAttribute('data-rating', rating);
            generateStarRating(element, rating); // Refresh stars
        }

        // AJAX Function to save the review, title, and rating
        function saveReview(reviewId, updatedTitle, updatedRating, updatedReview, saveIcon, cancelIcon, editIcon) {
            const source = saveIcon.closest('tr').getAttribute('data-source');
            fetch('{{ route('update.review') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    review_id: reviewId,
                      source: source,
                    title: updatedTitle,
                    rating: updatedRating,
                    message: updatedReview
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success: update the UI with the new data
                    const row = saveIcon.closest('tr');
                    const reviewElement = row.querySelector('.editable-review');
                    const reviewTextarea = row.querySelector('.edit-review-textarea');
                    const titleElement = row.querySelector('.editable-title');
                    const titleTextarea = row.querySelector('.edit-title-textarea');

                    titleElement.textContent = updatedTitle;
                    reviewElement.textContent = updatedReview;

                    // Hide textareas and display spans
                    titleTextarea.style.display = 'none';
                    titleElement.style.display = 'block';
                    reviewTextarea.style.display = 'none';
                    reviewElement.style.display = 'block';

                    // Hide Save and Cancel icons, show the Edit icon
                    saveIcon.style.display = 'none';
                    cancelIcon.style.display = 'none';
                    editIcon.style.display = 'inline-block';
                } else {
                    alert('Error saving data. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving data. Please try again.');
            });
        }
    });
    </script>
 @include('frontend.include.footer')

