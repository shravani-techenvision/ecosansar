
@include('frontend.include.header')
<style>
  .controls-more:after {
    content: none !important;
}

.btn{
    font-size: 16px !important;
}
    .hero-section {
    background-image: url('frontend/assets/img/new.jpg');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 570px; /* Ensure this matches your desired height */
}
#rotating-messages {
    display: inline-block;
    color: #63f039ab; /* Set your desired color here */
    font-size: 35px;
    font-style: italic;
}

.typewriter {
    overflow: hidden; /* Ensures the content is not revealed until the animation */
    border-right: .15em solid orange; /* The typewriter cursor */
    white-space: nowrap; /* Keeps the content on a single line */
    margin: 0 auto; /* Gives that scrolling effect as the typing happens */
    letter-spacing: .15em; /* Adjust as needed */
    animation:
        typing 3.5s steps(40, end),
        blink-caret .75s step-end infinite;
}

/* The typing effect */
@keyframes typing {
    from {
        width: 0
    }
    to {
        width: 100%
    }
}

/* The typewriter cursor effect */
@keyframes blink-caret {
    from, to {
        border-color: transparent
    }
    50% {
        border-color: orange
    }
}
.section-title {
    text-align: center;
}
.headcolor{
   color: black !important;
}
.hcolor{
   color: white !important;
}
.hero-section.has-background h1{
    color: black !important;
}
@media screen and (max-width: 600px) {
  .hide-mob {
     margin-left: -1px !important;
  }
}
@media (max-width: 767px) {
.find{
    margin-top: 15px!important;
}
}
@media (max-width: 767px) {
.mobheight{
    height: 343px !important;

}
.connect{
  margin-top: 0px !important;
}
.findcenter{
    padding-left: 12px;
}
}

.connect{
    margin-top:102px;
}
.mobheight{
    height:570px
}
.custom-card {
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fafafa;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow */
    padding: 15px; /* Padding for content */
    margin-bottom: 20px; /* Margin for spacing */
}

.card-body {
    padding: 10px 15px;
}

.mb-3 {
    margin-bottom: 15px;
}

.text-danger {
    color: #d9534f; /* Bootstrap 3 danger color */
}

.text-muted {
    color: #777; /* Bootstrap 3 muted text color */
}

.mb-4 {
    margin-bottom: 30px;
}

</style>
    <div id="page-content">
        <div class="row">
        <div class="col-md-8" style="padding-right: 0px;">
        <div class="hero-section has-background height-570px">
            <div class="wrapper">
                <div class="inner">
                    <div class="center">
                        <!--135px earlier-->
                        <div class="page-title" style="margin-bottom:224px;">
                            <h1>The ZeroWaste Community Tool</h1>

                             <h2 class="headcolor">It’s not waste until it’s wasted! Most of what we think is waste can be Reused or Recycled
                            </h2>
                            <h2 class="hcolor">GIVE it clean, don’t THROW it dirty.</h2>
                            <!--<h2>That’s how you can Use longer and Reduce waste</h2>-->
                            <h2 class="hcolor">It just makes everything better</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-wrapper">
                <div class="bg-transfer opacity-30"><img src="frontend/assets/img/background-03.jpg" alt=""></div>
                <div class="background-color background-color-black"></div>
            </div>
            <!--end background-wrapper-->
        </div>
        </div>
        <div class="col-md-4 hide-mob" style="padding-left: 0px;">
             <section class="block background-is-dark mobheight" style="background-color: #8eb66f;">
            <div class="form search-form">

                    <div class="section-title connect" >
                        <!--<h2 class="center">Find and Connect with your local workforce here!</h2>-->
                        <h2 class="findcenter"><b>FIND and CONNECT with your Local Waste Warriors</b></h2>
                    </div>
                   <form action="{{route('filter.waste')}}" method="post" >
                        @csrf
                         <div class="row">
                             <div class="col-md-1"></div>
                             <div class="col-md-5">
                         <div class="text-center">

                       @if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    @if ($userType == 'sab')
        <a href="{{ route('sab_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Add Your Post</a>
    @elseif ($userType == 'consumer')
        <a href="{{ route('consumer_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Add Your Post</a>
    @else
        <a href="{{ route('business_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Add Your Post</a>

    @endif
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
    <a href="{{ route('consumer_login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Add Your Post</a>
@endif




                        </div>
                        </div>
                         <div class="col-md-5 find">
                         <div class="text-center">
                     @if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    @if ($userType == 'sab')
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Browse Listings</a>
    @elseif ($userType == 'consumer')
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Browse Listings</a>
    @else
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Browse Listings</a>
    @endif
@else
    <a href="{{ route('consumer_login', ['redirect_list' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing darker">Browse Listings</a>
@endif

                        </div>
                        </div>
                        <div class="col-md-1"></div>
                        </div>
                    </form>
                    <!--end form-hero-->

            </div>
            <!--end search-form-->
            <div class="background-wrapper">
                <div class="background-color background-color-default"></div>
                <div class="bg-transfer opacity-40"><img src="frontend/assets/img/background-04.jpg" alt=""></div>
            </div>
        </section>
        </div>
        </div>
        <!--end hero-section-->



    @if(isset($afterbanner))
    @if(!empty($afterbanner->adsense_script))
        <!-- Output the entire AdSense Script -->
        <section class="block">
            <div class="container">
                <div class="center">
        {!! $afterbanner->adsense_script !!}
                </div>
            </div>
        </section>
    @elseif(!empty($afterbanner->adsense_image))
        <!-- Output the AdSense Image -->
        <section class="block">
            <div class="container">
                <div class="center">
                    <img class="center-block img-responsive" src="{{ asset('assets/images/Googleadsense/'.$afterbanner->adsense_image) }}" alt="" height="125" width="1000">
                </div>
            </div>
        </section>
    @endif
@endif
        <section class="block">
            <div class="container">
                <div class="center">
                    <div class="section-title">
                        <div class="center">
                            <h1>Recent Posts </h1>
                            <!--<h3 class="subtitle">Fusce eu mollis dui, varius convallis mauris. Nam dictum id</h3>-->
                        </div>
                    </div>
                    <!--end section-title-->
                </div>
                <!--end center-->
                {{--  Consumer posts section start  --}}
<section>
      @if( $user_type !== 'business' && $user_type !== 'sab')
    <h1>Contributor Posts</h1>
    <div class="row">
        @foreach($conuniqueListings as $listing)
            <div class="col-md-4 col-sm-4">
                <div class="item" data-id="{{ $listing->id }}">
                    <a href="{{ url('con_listing_details/'.$listing->id) }}">
                        <div class="description">
                        </div>
                        <!--end description-->
                        <div class="image bg-transfer">
                            <img src="{{ asset('frontend/assets/img/Consumerposts/'.$listing->resource_img) }}" alt="abc">
                        </div>
                        <!--end image-->
                    </a>
                    <div class="additional-info">

                                <!--@foreach(explode(', ', $listing->resource_names) as $resourceName)-->
                                <!--    {{ $resourceName }} ,-->
                                <!--@endforeach-->
                            @php
                            $resourceNames = explode(', ', $listing->resource_names);
                        @endphp

                        @if(!empty($resourceNames))
                            {{ implode(', ', $resourceNames) }}
                        @endif



                              <!--<h4>{{ $listing->address }}</h4>-->

                              <h4>{{ $listing->sale_giveaway }}</h4>



                        <div class="rating-passive" data-rating="{{ $listing->rating }}">
                            <!--<span class="stars"></span>-->
                            <!--<span class="reviews">{{ $listing->reviews_count }}</span>-->
                        </div>
                        <!--<div class="controls-more">-->
                        <!--    <ul>-->
                        <!--        <li><a href="#">Add to favorites</a></li>-->
                        <!--        <li><a href="#">Add to watchlist</a></li>-->
                        <!--        <li><a href="#" class="quick-detail">Quick detail</a></li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <!--end controls-more-->
                    </div>
                    <!--end additional-info -->
                </div>
                <!--end item-->
            </div>
            <!--end col-md-4-->
        @endforeach
    </div>
 @endif
    <!--end row-->
</section>

<section>
     @if( $user_type == 'sab' || $user_type == 'business')
    <h1>Contributor Posts </h1>
    <div class="row">
        @foreach($conuniqueListingsnotbuy as $listing)
            <div class="col-md-4 col-sm-4">
                <div class="item" data-id="{{ $listing->id }}">
                    <a href="{{ url('con_listing_details/'.$listing->id) }}">
                        <div class="description">

                        </div>
                        <!--end description-->
                        <div class="image bg-transfer">
                            <img src="{{ asset('frontend/assets/img/Consumerposts/'.$listing->resource_img) }}" alt="abc">
                        </div>
                        <!--end image-->
                    </a>
                    <div class="additional-info">

                                <!--@foreach(explode(', ', $listing->resource_names) as $resourceName)-->
                                <!--     {{ $resourceName }} ,-->
                                <!--@endforeach-->
                                @php
    $resourceNames = explode(', ', $listing->resource_names);
@endphp

@if(!empty($resourceNames))
    {{ implode(', ', $resourceNames) }}
@endif


                            <h4>{{ $listing->address }}</h4>


                        <div class="controls-more">
    <!--                         @if (session()->has('user_id'))-->
    <!--                         <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow consumer-connect-listing" style="float:right;">-->

    <!--    <span>Connect</span>-->
    <!--</a>-->
    <!--@else-->
    <!--                        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>-->
    <!--                        @endif-->
                        </div>
                        <!--end controls-more-->
                    </div>
                    <!--end additional-info-->
                </div>
                <!--end item-->
            </div>
            <!--end col-md-4-->
        @endforeach
         </div>


@endif
    <!--end row-->
</section>
{{--  Consumer posts section end  --}}
 {{--  SAB posts section start  --}}
 @if($sabuniqueListings->isNotEmpty())
                <section>
                    <h1>Resource Collector Posts</h1>
                    <div class="row">
                        @foreach($sabuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sabs_listing_details/'.$listing->id) }}">
                                        <div class="description">


                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/SABposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">

                                                <!--@foreach(explode(', ', $listing->resource_names) as $resourceName)-->
                                                <!--     {{ $resourceName }} ,-->
                                                <!--@endforeach-->
                                            @php
                                            $resourceNames = explode(', ', $listing->resource_names);
                                        @endphp

                                        @if(!empty($resourceNames))
                                            {{ implode(', ', $resourceNames) }}
                                        @endif

                                             @if (session()->has('user_id'))
                                            <h4>{{ $listing->address }}</h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
                                        <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <!--<span class="stars"></span>-->
                                            <!--<span class="reviews">{{ $listing->reviews_count }}</span>-->
                                        </div>
                                        <!--<div class="controls-more">-->
                                        <!--    <ul>-->
                                        <!--        <li><a href="#">Add to favorites</a></li>-->
                                        <!--        <li><a href="#">Add to watchlist</a></li>-->
                                        <!--        <li><a href="#" class="quick-detail">Quick detail</a></li>-->
                                        <!--    </ul>-->
                                        <!--</div>-->
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
{{--  SAB posts section end  --}}
               {{--  Business post section start  --}}

               <section>
                     @if( $user_type == 'business')
                    <h1>Corporate Posts</h1>
                    <div class="row">
                        @foreach($busuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/Businessposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                            <!--@foreach(explode(', ', $listing->resource_names) as $index => $resourceName)-->
                                            <!--    @if($index < 2)-->
                                            <!--         {{ $resourceName }} ,-->
                                            <!--    @else-->
                                            <!--        @break-->
                                            <!--    @endif-->
                                            <!--@endforeach-->
                                        @php
    $resourceNames = explode(', ', $listing->resource_names);
@endphp

@if(!empty($resourceNames))
    {{ implode(', ', $resourceNames) }}
@endif


                                            @if (session()->has('user_id'))
                                            <h4>{{ $listing->address }}</h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif


                                        <div class="controls-more">
    <!--                                         @if (session()->has('user_id'))-->
    <!--                                         <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">-->
    <!--    <span>Connect</span>-->
    <!--</a>-->
    <!-- @else-->
    <!--                          <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>-->
    <!--                        @endif-->
                                        </div>
                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                         </div>
                    <!--    <div class="row">-->
                    <!--      <div class="col-md-4 col-sm-4">-->
                    <!--           @if (session()->has('user_id'))-->
                    <!--             <a href="{{route('bus_all_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a> -->
                    <!--             @else-->
                    <!--            <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>-->
                    <!--        @endif-->
                    <!--          </div>-->
                    <!--</div>-->
                     @endif
                    <!--end row-->
                </section>

                 <section>
                     @if( $user_type !== 'business')
                    <h1>Corporate Posts</h1>
                    <div class="row">

                        @foreach($busuniqueListingsnotsell as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                        <div class="description">


                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/Businessposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">

                                            <!--@foreach(explode(', ', $listing->resource_names) as $index => $resourceName)-->
                                            <!--    @if($index < 2)-->
                                            <!--         {{ $resourceName }} ,-->
                                            <!--    @else-->
                                            <!--        @break-->
                                            <!--    @endif-->
                                            <!--@endforeach-->
                                        @php
                                            $resourceNames = explode(', ', $listing->resource_names);
                                        @endphp

                                        @if(!empty($resourceNames))
                                            {{ implode(', ', $resourceNames) }}
                                        @endif

                                             @if (session()->has('user_id'))
                                            <h4>{{ $listing->address }}</h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif


                                        <div class="controls-more">
    <!--                                            @if (session()->has('user_id'))-->
    <!--                                         <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">-->
    <!--    <span>Connect</span>-->
    <!--</a>-->
    <!-- @else-->
    <!--                          <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>-->
    <!--                        @endif-->
                                        </div>
                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info kkkkkk-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                         </div>

                     @endif
                    <!--end row-->
                </section>

{{--  Business post section end  --}}



                <!--end row-->
                <div class="center">
                    <a href="{{route('listings')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">View all listings</a>
                </div>

            <!--end center-->
            </div>
            <!--end container-->
        </section>
        <!--end block-->


        <!-- <section class="block">-->
        <!--    <div class="container">-->
        <!--        <div class="section-title">-->
        <!--            <div class="center">-->
        <!--                <h2>Our count</h2>-->
        <!--            </div>-->
        <!--        </div>-->


        <!--        <div class="row">-->
        <!--        <div class="col-md-3"><div class="box center">-->
        <!--                <div class="title">-->

        <!--                            <div class="icon"><h2><i class="fa fa-users"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Users</a> : {{ $users }} </h3>-->
        <!--                            <hr>-->
        <!--                            <div class="icon"><h2><i class="fa fa-file"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Posts</a> : {{ $totalpostCount }}</h3>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--        </div>-->

        <!--        <div class="col-md-3"><div class="box center">-->
        <!--                <div class="title">-->
        <!--                            <div class="icon"><h2><i class="fa fa-users"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Corporate Users</a> : {{ $Corporateusers }} </h3>-->
        <!--                            <hr>-->
        <!--                            <div class="icon"><h2><i class="fa fa-file"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Corporate Posts</a> : {{ $Corporatepost }}</h3>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--        </div>-->

        <!--        <div class="col-md-3"><div class="box center">-->
        <!--                <div class="title">-->
        <!--                            <div class="icon"><h2><i class="fa fa-users"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Contributor Users</a> : {{ $Contributorusers }} </h3>-->
        <!--                            <hr>-->
        <!--                            <div class="icon"><h2><i class="fa fa-file"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Contributor Posts</a> : {{ $Contributorpost }}</h3>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--        </div>-->

        <!--        <div class="col-md-3"><div class="box center">-->
        <!--                <div class="title">-->
        <!--                            <div class="icon"><h2><i class="fa fa-users"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Resource Users</a> : {{ $Resourceusers }} </h3>-->
        <!--                            <hr>-->
        <!--                            <div class="icon"><h2><i class="fa fa-file"></i></h2></div>-->
        <!--                            <h3><a href="#">Total Resource Posts</a> : {{ $Resourcepost }}</h3>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--        </div>-->

        <!--    </div>-->

        <!--    </div>-->
            <!--end container-->
        <!--</section>-->



<!--        <section class="block py-5 bg-light">-->
<!--    <div class="container">-->
<!--        <div class="section-title text-center mb-5">-->
<!--            <h1 class="display-4">Our Statistics</h1>-->
<!--        </div>-->

<!--        <div class="row text-center">-->
            <!-- Total Users -->
<!--            <div class="col-lg-3 col-md-6 mb-4">-->
<!--                <div class="custom-card">-->
<!--                    <div class="card-body">-->
<!--                        <div class="mb-3">-->
<!--                            <i class="fa fa-users fa-3x text-primary"></i>-->
<!--                        </div>-->
<!--                        <h4 class="card-title">Total Users</h4>-->
<!--                        <p class="card-text display-6"><h2><strong>{{ $users }}</strong></h2></p>-->


<!--                        <small class="text-muted">-->
<!--                           <h4 class="card-title">   Total Posts </h4>-->
<!--                          <p class="card-text display-6"><h2><strong>  {{ $totalpostCount }} </strong></h2></p>-->
<!--                        </small>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- Total Corporate Users -->
<!--            <div class="col-lg-3 col-md-6 mb-4">-->
<!--                <div class="custom-card">-->
<!--                    <div class="card-body">-->
<!--                        <div class="mb-3">-->
<!--                            <i class="fa fa-briefcase fa-3x text-success"></i>-->
<!--                        </div>-->
<!--                        <h4 class="card-title">Total Corporates</h4>-->
<!--                        <p class="card-text display-6"><h2><strong>{{ $Corporateusers }}</strong></h2></p>-->


<!--                        <small class="text-muted">-->
<!--                           <h4 class="card-title">  Total Corporate Posts</h4>-->
<!--                          <p class="card-text display-6"><h2><strong> {{ $Corporatepost }}</strong></h2></p> -->
<!--                        </small>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- Total Contributor Users -->
<!--            <div class="col-lg-3 col-md-6 mb-4">-->
<!--                <div class="custom-card">-->
<!--                    <div class="card-body">-->
<!--                        <div class="mb-3">-->
<!--                            <i class="fa fa-users fa-3x text-warning"></i>-->
<!--                        </div>-->
<!--                        <h4 class="card-title">Total Contributors </h4>-->
<!--                        <p class="card-text display-6"><h2><strong>{{ $Contributorusers }}</strong></h2></p>-->


<!--                        <small class="text-muted">-->
<!--                           <h4 class="card-title">   Total Contributor Posts </h4>-->
<!--                           <p class="card-text display-6"><h2><strong> {{ $Contributorpost }} </strong></h2></p>-->
<!--                        </small>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- Total Resource Users -->
<!--            <div class="col-lg-3 col-md-6 mb-4">-->
<!--                <div class="custom-card">-->
<!--                    <div class="card-body">-->
<!--                        <div class="mb-3">-->
<!--                            <i class="fa fa-cogs fa-3x text-danger"></i>-->
<!--                        </div>-->
<!--                        <h4 class="card-title">Total Resource Collectors</h4>-->
<!--                        <p class="card-text display-6"><h2><strong>{{ $Resourceusers }}</strong></h2></p>-->



<!--                        <small class="text-muted">-->
<!--                           <h4 class="card-title">  Total Resource Posts </h4><p class="card-text display-6"><h2><strong> {{ $Resourcepost }} </strong></h2></p>-->
<!--                        </small>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
@if(!empty($beforestatistics->adsense_image))
    <section class="block">
        <div class="container">
            <div class="center">
                <img class="center-block img-responsive" src="{{ asset('assets/images/Googleadsense/'.$beforestatistics->adsense_image) }}" alt="Google Adsense Image" height="125" width="1000">
            </div>
        </div>
    </section>
@endif

   <section class="block py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h1 class="display-4">Our Statistics</h1>
        </div>

        <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                </div>
            <!-- Total Users -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="custom-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <!--<i class="fa fa-users fa-3x text-primary"></i>-->
                            <img src="{{ asset('frontend/assets/img/users.png') }}" alt="" height="50">
                        </div>
                        <h4 class="card-title">Total Users</h4>
                        <p class="card-text display-6"><h2><strong>{{ $users }}</strong></h2></p>


                        <small class="">
                           <h4 class="card-title">   Total Posts </h4>
                          <p class="card-text display-6"><h2><strong>  {{ $totalpostCount }} </strong></h2></p>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Total Corporate Users -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="custom-card" style="height:237px;">
                    <div class="card-body">
                        <div class="mb-3">
                            <!--<i class="fa fa-briefcase fa-3x text-success"></i>-->
                            <img src="{{ asset('frontend/assets/img/resources.png') }}" alt="" height="50"><br>
                        </div>
                        <h4 class="card-title">Total Resources Handled</h4><br>
                        <p class="card-text display-6"><h2><strong>{{ $totalMinWeight }} <span style="font-size:16px !important;">{{'Kg'}}</span></strong></h2></p>



                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-md-6 mb-4">
                </div>


        </div>
    </div>
</section>

<section class=" py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h1 class="display-4">Communication Partners</h1>
        </div>
                <div class="logos">
                    <div class="logo">
                        <a href="#"><img src="{{ asset('assets/images/msg91-original_Logo.svg') }}" alt=""></a>
                    </div>

                </div>
                <!--/ .logos-->
            </div>
            <!--end container-->
        </section>


<!--        <section class="block background-is-dark" style="background-color: #8eb66f;">-->
<!--            <div class="container">-->
<!--                <div class="section-title vertical-aligned-elements">-->
<!--                    <div class="element">-->
<!--                        <h2>Promoted Locations</h2>-->
<!--                    </div>-->
<!--                    <div class="element text-align-right">-->
                        <!--<a href="#" class="btn btn-framed btn-rounded btn-default invisible-on-mobile">Promote yours</a>-->
<!--                        <div id="gallery-nav"></div>-->
<!--                    </div>-->
<!--                </div>-->
                <!--end section-title-->
<!--            </div>-->
<!--<div class="gallery featured">-->
<!--    <div class="owl-carousel" data-owl-items="6" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="1" data-owl-nav-container="#gallery-nav">-->
<!--        {{-- Loop through all listings --}}-->
<!--        @foreach ($alllistings as $listing)-->
<!--            <div class="item featured" data-id="{{ $listing->id }}">-->
                <!-- Display listing details -->
<!--                <a href="#">-->
<!--                    <div class="description">-->
<!--                        <figure>Average Price: {{ $listing->price }}</figure>-->
<!--                        <div class="label label-default">{{ $listing->category }}</div>-->
<!--                        <h3>{{ $listing->name }}</h3>-->
<!--                        <h4>{{ $listing->address }}</h4>-->
<!--                    </div>-->
                    <!--end description-->
<!--                    <div class="image bg-transfer">-->
<!--    @if ($listing->type == 'business')-->
<!--        <img src="{{ asset('frontend/assets/img/Businesspostimages/' . $listing->post_pic) }}" alt="Business Post">-->
<!--    @elseif ($listing->type == 'sab')-->
<!--        <img src="{{ asset('frontend/assets/img/SABpostimages/' . $listing->post_pic) }}" alt="SAB Post">-->
<!--    @elseif ($listing->type == 'consumer')-->
<!--        <img src="{{ asset('frontend/assets/img/Consumerpostimages/' . $listing->post_pic) }}" alt="Consumer Post">-->
<!--    @endif-->
<!--</div>-->

                    <!--end image-->
<!--                </a>-->

                <!--end additional-info-->
<!--            </div>-->
            <!--end item-->
<!--        @endforeach-->
<!--    </div>-->
<!--</div>-->
            <!--end gallery-->
<!--            <div class="background-wrapper">-->
<!--                <div class="background-color background-color-default"></div>-->
<!--            </div>-->
            <!--end background-wrapper-->
<!--        </section>-->
        <!--end block-->

        <!--<section class="block">-->
        <!--    <div class="container">-->
        <!--        <div class="section-title">-->
        <!--            <h2>Events Near You</h2>-->
        <!--        </div>-->
                <!--end section-title-->
        <!--        <div class="row">-->
        <!--            <div class="col-md-4 col-sm-4">-->
        <!--                <div class="text-element event">-->
        <!--                    <div class="date-icon">-->
        <!--                        <figure class="day">22</figure>-->
        <!--                        <figure class="month">Jun</figure>-->
        <!--                    </div>-->
        <!--                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>-->
        <!--                    <figure class="date"><i class="icon_clock_alt"></i>08:00</figure>-->
        <!--                    <p>Ut nec vulputate enim. Nulla faucibus convallis dui. Donec arcu enim, scelerisque.</p>-->
        <!--                    <a href="#" class="link arrow">More</a>-->
        <!--                </div>-->
                        <!--end text-element-->
        <!--            </div>-->
                    <!--end col-md-4-->
        <!--            <div class="col-md-4 col-sm-4">-->
        <!--                <div class="text-element event">-->
        <!--                    <div class="date-icon">-->
        <!--                        <figure class="day">04</figure>-->
        <!--                        <figure class="month">Jul</figure>-->
        <!--                    </div>-->
        <!--                    <h4><a href="#">Donec mattis mi vitae volutpat</a></h4>-->
        <!--                    <figure class="date"><i class="icon_clock_alt"></i>12:00</figure>-->
        <!--                    <p>Nullam vitae ex ac neque viverra ullamcorper eu at nunc. Morbi imperdiet.</p>-->
        <!--                    <a href="#" class="link arrow">More</a>-->
        <!--                </div>-->
                        <!--end text-element-->
        <!--            </div>-->
                    <!--end col-md-4-->
        <!--            <div class="col-md-4 col-sm-4">-->
        <!--                <div class="text-element event">-->
        <!--                    <div class="date-icon">-->
        <!--                        <figure class="day">12</figure>-->
        <!--                        <figure class="month">Aug</figure>-->
        <!--                    </div>-->
        <!--                    <h4><a href="#">Vivamus placerat</a></h4>-->
        <!--                    <figure class="date"><i class="icon_clock_alt"></i>12:00</figure>-->
        <!--                    <p>Aenean sed purus ut massa scelerisque bibendum eget vel massa.</p>-->
        <!--                    <a href="#" class="link arrow">More</a>-->
        <!--                </div>-->
                        <!--end text-element-->
        <!--            </div>-->
                    <!--end col-md-4-->
        <!--        </div>-->
                <!--end row-->
        <!--        <div class="background-wrapper">-->
        <!--            <div class="background-color background-color-black opacity-5"></div>-->
        <!--        </div>-->
                <!--end background-wrapper-->
        <!--    </div>-->
            <!--end container-->
        <!--</section>-->
        <!--end block-->




        <!--end container-->


        <!--end block-->
    </div>
    <!--end page-content-->


<script>

// public/js/app.js
document.addEventListener('DOMContentLoaded', function() {
    const messages = [
        "Convert Waste into a Resource",
        "Empower Waste Pickers to become Resource Collectors",
        "Reduce your waste",
        "Support Local"
    ];
    let currentIndex = 0;
    const rotatingElement = document.getElementById('rotating-messages');

    function typeMessage(message) {
        rotatingElement.innerHTML = ''; // Clear existing content
        const characters = message.split('');
        characters.forEach((char, index) => {
            setTimeout(() => {
                rotatingElement.innerHTML += char;
            }, 50 * index); // Adjust the speed of typing
        });

        // After typing, start erasing after a brief pause
        setTimeout(() => {
            eraseMessage(message);
        }, 5000); // Adjust the delay before erasing
    }

    function eraseMessage(message) {
        const characters = message.split('');
        characters.reverse().forEach((char, index) => {
            setTimeout(() => {
                rotatingElement.innerHTML = rotatingElement.innerHTML.slice(0, -1);
            }, 50 * index); // Adjust the speed of erasing
        });

        // After erasing, proceed to the next message
        setTimeout(() => {
            showNextMessage();
        }, 3000); // Adjust the delay before showing the next message
    }

    function showNextMessage() {
        currentIndex = (currentIndex + 1) % messages.length;
        typeMessage(messages[currentIndex]);
    }

    typeMessage(messages[currentIndex]);
});




</script>
 @include('frontend.include.footer')
