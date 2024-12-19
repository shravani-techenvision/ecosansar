
@include('frontend.include.header')

<style>
    .controls-more:after {
    content: none !important;
}
.modal-header {
    position: relative;
}

.hr-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.hr-wrapper hr {
    flex: 1;
    border: none;
    border-top: 1px solid #ccc;
    margin: 0 10px; /* Adjust margin as needed */
}

.hr-wrapper h2 {
    margin: 0;
    padding: 0 10px;
    white-space: nowrap;
}
.controls-more {
right: 5px !important;
}
.controls-more .fa {
    margin-top:6px !important;
    font-size: larger !important;
}
.controls-more{
    margin:20px 0;
}
.text-warning {
    color: #8eb66f;
}
.wp-dis {
    display: flex;
    align-items: center;
    gap: 25px;
}
.wp-dis-own {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-top: 50px;
}
.hide-show {
display:grid;
}
.gradient-icon {
        background: linear-gradient(to right, #25d366, #128c7e, #075e54);
        -webkit-background-clip: text;
        color: transparent;
    }
@media screen and (max-width: 786px) {
    .hide-show {
        display:flex;
        margin-top: 7px !important;
    }
    .additional-info .btn.btn-small {
        padding: 10px 9px !important;
    }
    }
</style>



<div id="page-content">
    <div class="container">
        <ol class="breadcrumb">
            {{--  <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Contact</li>  --}}
        </ol>
        <div class="row">

            <div class="col-md-12 col-sm-12">
                <!--Consumer own posts  start     -->
                @if( $user_type == 'consumer')
                <h1>Contributor Own Posts</h1>
               <div class="row">
                       @foreach($ownuniqueListings as $listing)
                           <div class="col-md-4 col-sm-4">
                               <div class="item" data-id="{{ $listing->id }}">
                                   <a href="{{ url('con_listing_details/'.$listing->id) }}">
                                       <div class="description">

                                       </div>
                                       <!--end description-->
                                       <!--<div class="image bg-transfer">-->
                                       <!--     <img src="{{ Storage::disk('s3')->url('Consumerposts/' . $listing->resource_img) }}" alt="abc">-->

                                       <!--</div>-->
                                        <div class="image bg-transfer">
                   @php
                       // Check if $listing->resource_img is set and not empty
                       $imagePath = !empty($listing->resource_img) ? 'Consumerposts/' . $listing->resource_img : null;

                       // Check if the image exists in the S3 bucket or fallback to default
                       $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                   ? Storage::disk('s3')->url($imagePath)
                                   : asset('frontend/assets/img/ecosansar.png');
                   @endphp
                   <img src="{{ $imageUrl }}" alt="abc">
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

                                           <!--<h4>{{ $listing->address }}</h4>-->

                                                       @if (session()->has('user_id'))
                                                           <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 30) }} </h4>
                                                           @else
                                                           <h4>{{ $listing->sale_giveaway }}</h4>
                                                           @endif

                                         <!-- Display the average rating as stars -->
                   @if(isset($listing->average_rating))
                       <div class="rating">
                           @php
                               $roundedRating = round($listing->average_rating);
                           @endphp

                           @for ($i = 1; $i <= 5; $i++)
                               @if($i <= $roundedRating)
                                   <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                               @else
                                   <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                               @endif
                           @endfor

                           <!-- Optionally, display the average rating value -->
                           <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                       </div>
                       @else
                   <div class="rating">
                       @for ($i = 1; $i <= 5; $i++)
                           <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                       @endfor
                   </div>
                   @endif
                                       <div class="controls-more hide-show"  >
                                            @if (session()->has('user_id'))
                                           <!-- <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow consumer-connect-listing" style="float:right;">-->

                                           <!--    <span>Connect</span>-->
                                           <!--</a> -->
                                          <span class="wp-dis-own">Share on:
                                           <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('con_listing_details/'.$listing->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">

                                                                   <!--<i class="fa fa-share-alt"></i> Share on WhatsApp-->
                                                                     <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                                                               </a></span>
                                       @else
                                        <a href="{{ route('consumer_login', ['redirect_wp' => url('con_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                                                               <i class="fa fa-whatsapp"></i> Share on WhatsApp
                                                           </a>
                                                                 <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                                                               @endif
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
                <div class="row">
                                           <div class="col-md-12 col-sm-12 text-center">
                                                @if (session()->has('user_id'))
                                            <a href="{{route('consumer_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                            <hr>
                                             @else
                                           <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                       @endif
                                               </div>
                                       </div>

               @endif

               <!--Consumer own post end -->
               <!--Resource Collector own post start -->
                @if( $user_type == 'sab')
               <h1>Resource Collector Own Posts</h1>
                                   <div class="row">

                                       @foreach($ownsabuniqueListings as $listing)
                                           <div class="col-md-4 col-sm-4">
                                               <div class="item" data-id="{{ $listing->id }}">
                                                   <a href="{{ url('sabs_listing_details/'.$listing->id) }}">
                                                       <div class="description">

                                                       </div>
                                                       <!--end description-->
                                                       <!--<div class="image bg-transfer">-->
                                                       <!--     <img src="{{ Storage::disk('s3')->url('SABposts/' . $listing->resource_img) }}" alt="abc">-->

                                                       <!--</div>-->
                                                        <div class="image bg-transfer">
                   @php
                       // Check if $listing->resource_img is set and not empty
                       $imagePath = !empty($listing->resource_img) ? 'SABposts/' . $listing->resource_img : null;

                       // Check if the image exists in the S3 bucket or fallback to default
                       $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                   ? Storage::disk('s3')->url($imagePath)
                                   : asset('frontend/assets/img/ecosansar.png');
                   @endphp
                   <img src="{{ $imageUrl }}" alt="abc">
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
                                                           <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 30) }}  </h4>
                                                           @else
                                                           <h4>{{ $listing->sale_giveaway }}</h4>
                                                           @endif

                                                         <!-- Display the average rating as stars -->
                   @if(isset($listing->average_rating))
                       <div class="rating">
                           @php
                               $roundedRating = round($listing->average_rating);
                           @endphp

                           @for ($i = 1; $i <= 5; $i++)
                               @if($i <= $roundedRating)
                                   <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                               @else
                                   <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                               @endif
                           @endfor

                           <!-- Optionally, display the average rating value -->
                           <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                       </div>
                       @else
                   <div class="rating">
                       @for ($i = 1; $i <= 5; $i++)
                           <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                       @endfor
                   </div>
                   @endif
                                                       <div class="controls-more hide-show" >
                                                            @if (session()->has('user_id'))
                   <!--                                        <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#sabenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow sab-connect-listing" style="float:right;">-->

                   <!--    <span>Connect</span>-->
                   <!--</a>-->
                    <span class="wp-dis-own">Share on:
                   <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('sabs_listing_details/'.$listing->id)) }}" target="_blank"  style="float:right">

                                            <!--<i class="fa fa-share-alt"></i>  -->
                                             <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                                       </a> </span>
                   @else
                    <a href="{{ route('consumer_login', ['redirect_wp' => url('sabs_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                                           <i class="fa fa-whatsapp"></i> Share on WhatsApp
                                       </a>

                                                            <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                                                           @endif

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
               <div class="row">
                                           <div class="col-md-12 col-sm-12 text-center">
                                                @if (session()->has('user_id'))
                                            <a href="{{route('sab_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                            <hr>
                                             @else
                                           <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                       @endif
                                               </div>
                                       </div>

                                       @endif
               <!--Resource Collector own post end -->
               <!--Corporate own post start -->
                 @if( $user_type == 'business')
               <h1>Corporate Own Posts</h1>
                <div class="row">

                                       @foreach($ownbusuniqueListings as $listing)
                                           <div class="col-md-4 col-sm-4">
                                               <div class="item" data-id="{{ $listing->id }}">
                                                   <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                                       <div class="description">


                                                       </div>
                                                       <!--end description-->
                                                       <!--<div class="image bg-transfer">-->
                                                       <!--     <img src="{{ Storage::disk('s3')->url('Businessposts/' . $listing->resource_img) }}" alt="abc">-->

                                                       <!--</div>-->
                                                       <div class="image bg-transfer">
                   @php
                       // Check if $listing->resource_img is set and not empty
                       $imagePath = !empty($listing->resource_img) ? 'Businessposts/' . $listing->resource_img : null;

                       // Check if the image exists in the S3 bucket or fallback to default
                       $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                   ? Storage::disk('s3')->url($imagePath)
                                   : asset('frontend/assets/img/ecosansar.png');
                   @endphp
                   <img src="{{ $imageUrl }}" alt="abc">
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
                                                           <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 30) }}  </h4>
                                                           @else
                                                           <h4>{{ $listing->sale_giveaway }}</h4>
                                                           @endif

                                                         <!-- Display the average rating as stars -->
                   @if(isset($listing->average_rating))
                       <div class="rating">
                           @php
                               $roundedRating = round($listing->average_rating);
                           @endphp

                           @for ($i = 1; $i <= 5; $i++)
                               @if($i <= $roundedRating)
                                   <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                               @else
                                   <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                               @endif
                           @endfor

                           <!-- Optionally, display the average rating value -->
                           <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                       </div>
                       @else
                   <div class="rating">
                       @for ($i = 1; $i <= 5; $i++)
                           <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                       @endfor
                   </div>
                   @endif
                                                       <div class="controls-more hide-show" >
                                                            @if (session()->has('user_id'))
                   <!--                                         <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">-->
                   <!--    <span>Connect</span>-->
                   <!--</a>-->
                   <span class="wp-dis-own">Share on:
                     <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="float:right">

                                            <!--<i class="fa fa-share-alt"></i>  -->
                                           <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                                       </a> </span>
                    @else
                     <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                                           <i class="fa fa-whatsapp"></i> Share on WhatsApp
                                       </a>

                                             <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                                           @endif
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
               <div class="row">
                                           <div class="col-md-12 col-sm-12 text-center">
                                                @if (session()->has('user_id'))
                                            <a href="{{route('business_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                            <hr>
                                             @else
                                           <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
                                       @endif
                                               </div>
                                       </div>

                @endif
               <!--Corporate own post end -->
{{--  Consumer posts section start  --}}
<section>
     @if( $user_type !== 'business' && $user_type !== 'sab')


                @empty(!$conuniqueListings)

                         <h1>Contributor Posts</h1>

                     @endempty

    <div class="row">
        @foreach($conuniqueListings as $listing)
            <div class="col-md-4 col-sm-4">
                <div class="item" data-id="{{ $listing->id }}">
                    <a href="{{ url('con_listing_details/'.$listing->id) }}">
                        <div class="description">

                        </div>
                        <!--end description-->
                        <div class="image bg-transfer">
                            @php
                                // Check if $listing->resource_img is set and not empty
                                $imagePath = !empty($listing->resource_img) ? 'Consumerposts/' . $listing->resource_img : null;

                                // Check if the image exists in the S3 bucket or fallback to default
                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                            ? Storage::disk('s3')->url($imagePath)
                                            : asset('frontend/assets/img/ecosansar.png');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="abc">
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
                                {{--  {{ implode(', ', $resourceNames) }}  --}}
                                {{ $resourceNames[0] }}
                            @endif

                            <!--<h4>{{ $listing->address }}</h4>-->

                                        @if (session()->has('user_id'))
                                            <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 50) }} </h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
 <!-- Display the average rating as stars -->
    @if(isset($listing->average_rating))
        <div class="rating">
            @php
                $roundedRating = round($listing->average_rating);
            @endphp

            @for ($i = 1; $i <= 5; $i++)
                @if($i <= $roundedRating)
                    <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                @else
                    <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                @endif
            @endfor

            <!-- Optionally, display the average rating value -->
            <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
        </div>
        @else
    <div class="rating">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
        @endfor
    </div>
    @endif

                        <div class="controls-more hide-show">
                             @if (session()->has('user_id'))
                             <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow consumer-connect-listing" style="float:right;">

        <span>Connect</span>
    </a>
    {{--  <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('con_listing_details/'.$listing->id)) }}" target="_blank"  style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
        <!--<i class="fa fa-share-alt"></i> Share on WhatsApp-->
    </a>  --}}
    <span class="wp-dis">Share on:
        <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('con_listing_details/'.$listing->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="">

                                <!--<i class="fa fa-share-alt"></i> Share on WhatsApp-->
                                  <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                            </a></span>
    @else
    <a href="{{ route('consumer_login', ['redirect_wp' => url('con_listing_details/' . $listing->id)]) }}" target="_blank" class="" style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
    </a>
                              <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                            @endif
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
                        <div class="row">
        <div class="col-md-12 col-sm-12 text-center">
             @if (session()->has('user_id'))
         <a href="{{route('con_all_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
        <hr>
         @else
        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
    @endif
            </div>
    </div>

@endif
    <!--end row-->
</section>

<section>
     @if( $user_type == 'sab' || $user_type == 'business')

     @empty(!$conuniqueListingsnotbuy)

            <h1>Contributor Posts </h1>

        @endempty


    <div class="row">
        @foreach($conuniqueListingsnotbuy as $listing)
            <div class="col-md-4 col-sm-4">
                <div class="item" data-id="{{ $listing->id }}">
                    <a href="{{ url('con_listing_details/'.$listing->id) }}">
                        <div class="description">

                        </div>
                        <!--end description-->
                        <div class="image bg-transfer">
                            @php
                                // Check if $listing->resource_img is set and not empty
                                $imagePath = !empty($listing->resource_img) ? 'Consumerposts/' . $listing->resource_img : null;

                                // Check if the image exists in the S3 bucket or fallback to default
                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                            ? Storage::disk('s3')->url($imagePath)
                                            : url('frontend/assets/img/ecosansar.png');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="abc">
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
    {{--  {{ implode(', ', $resourceNames) }}  --}}
    {{ $resourceNames[0] }}
@endif


                            <!--<h4>{{ $listing->address }}</h4>-->

                             @if (session()->has('user_id'))
                                            <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 35) }} </h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
 <!-- Display the average rating as stars -->
    @if(isset($listing->average_rating))
        <div class="rating">
            @php
                $roundedRating = round($listing->average_rating);
            @endphp

            @for ($i = 1; $i <= 5; $i++)
                @if($i <= $roundedRating)
                    <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                @else
                    <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                @endif
            @endfor

            <!-- Optionally, display the average rating value -->
            <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
        </div>
        @else
    <div class="rating">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
        @endfor
    </div>
    @endif

                        <div class="controls-more hide-show">
                             @if (session()->has('user_id'))
                             <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow consumer-connect-listing" style="float:right;">

        <span>Connect</span>
    </a>
    <span class="wp-dis">Share on:
        <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('con_listing_details/'.$listing->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style=" ">

                                <!--<i class="fa fa-share-alt"></i> Share on WhatsApp-->
                                  <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                            </a></span>
    @else
    <a href="{{ route('consumer_login', ['redirect_wp' => url('con_listing_details/' . $listing->id)]) }}" target="_blank" class="" style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
    </a>
                            <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                            @endif
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
                        <div class="row">
        <div class="col-md-12 col-sm-12 text-center">
             @if (session()->has('user_id'))
         <a href="{{route('con_all_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
        <hr>
         @else
        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
    @endif
            </div>
    </div>

@endif
    <!--end row-->
</section>
{{--  Consumer posts section end  --}}





                {{--  SAB posts section start  --}}
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
                                            @php
                                                // Check if $listing->resource_img is set and not empty
                                                $imagePath = !empty($listing->resource_img) ? 'SABposts/' . $listing->resource_img : null;

                                                // Check if the image exists in the S3 bucket or fallback to default
                                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                            ? Storage::disk('s3')->url($imagePath)
                                                            : asset('frontend/assets/img/ecosansar.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="abc">
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
    {{--  {{ implode(', ', $resourceNames) }}  --}}
    {{ $resourceNames[0] }}
@endif


                                       @if (session()->has('user_id'))
                                            <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 50) }}  </h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
                                            <!-- Display the average rating as stars -->
                                            @if(isset($listing->average_rating))
                                                <div class="rating">
                                                    @php
                                                        $roundedRating = round($listing->average_rating);
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if($i <= $roundedRating)
                                                            <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                                                        @else
                                                            <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                        @endif
                                                    @endfor

                                                    <!-- Optionally, display the average rating value -->
                                                    <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                                                </div>
                                                @else
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                @endfor
                                            </div>
                                            @endif

                                        <div class="controls-more  hide-show">
                                             @if (session()->has('user_id'))
                                            <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#sabenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow sab-connect-listing" style="float:right;">

        <span>Connect</span>
    </a>
    <span class="wp-dis">Share on:
        <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('sabs_listing_details/'.$listing->id)) }}" target="_blank"  style="float:right">

                                 <!--<i class="fa fa-share-alt"></i>  -->
                                  <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                            </a> </span>
    @else
    <a href="{{ route('consumer_login', ['redirect_wp' => url('sabs_listing_details/' . $listing->id)]) }}" target="_blank" class="" style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
    </a>
                                             <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                                            @endif
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
                        <div class="row">
<div class="col-md-12 col-sm-12 text-center">
    @if (session()->has('user_id'))
        <a href="{{ route('sab_all_posts') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
   <hr>
        @else
        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
    @endif
</div>
                    </div>


                    <!--end row-->
                </section>
{{--  SAB posts section end  --}}





{{--  Business post section start  --}}

<section>
                     @if( $user_type == 'business')


                    <h1>Corporate Posts </h1>

                    <div class="row">

                        @foreach($busuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                        <div class="description">


                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            @php
                                                // Check if $listing->resource_img is set and not empty
                                                $imagePath = !empty($listing->resource_img) ? 'Businessposts/' . $listing->resource_img : null;

                                                // Check if the image exists in the S3 bucket or fallback to default
                                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                            ? Storage::disk('s3')->url($imagePath)
                                                            : asset('frontend/assets/img/ecosansar.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="abc">
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
    {{--  {{ implode(', ', $resourceNames) }}  --}}
    {{ $resourceNames[0] }}
@endif


                                              @if (session()->has('user_id'))
                                            <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 50) }}  </h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
                                            <!-- Display the average rating as stars -->
                                            @if(isset($listing->average_rating))
                                                <div class="rating">
                                                    @php
                                                        $roundedRating = round($listing->average_rating);
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if($i <= $roundedRating)
                                                            <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                                                        @else
                                                            <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                        @endif
                                                    @endfor

                                                    <!-- Optionally, display the average rating value -->
                                                    <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                                                </div>
                                                @else
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                @endfor
                                            </div>
                                            @endif

                                        <div class="controls-more hide-show">
                                             @if (session()->has('user_id'))
                                             <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
    <span class="wp-dis">Share on:
        <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="float:right">

                               <!--<i class="fa fa-share-alt"></i>  -->
                              <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                          </a> </span>
     @else
     <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="" style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
    </a>
                              <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                            @endif
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
                        <div class="row">
  <div class="col-md-12 col-sm-12 text-center">
       @if (session()->has('user_id'))
         <a href="{{route('bus_all_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
         @else
        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
    @endif
      </div>
                    </div>
                     @endif
                    <!--end row-->
                </section>

                <section>
                     @if($user_type !== 'business')

                      @empty(!$busuniqueListingsnotsell)

                        <h1>Corporate Posts</h1>

                    @endempty

                    <div class="row">

                        @foreach($busuniqueListingsnotsell as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            @php
                                                // Check if $listing->resource_img is set and not empty
                                                $imagePath = !empty($listing->resource_img) ? 'Businessposts/' . $listing->resource_img : null;

                                                // Check if the image exists in the S3 bucket or fallback to default
                                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                            ? Storage::disk('s3')->url($imagePath)
                                                            : asset('frontend/assets/img/ecosansar.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="abc">
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
    {{--  {{ implode(', ', $resourceNames) }}  --}}
    {{ $resourceNames[0] }}
@endif


                                              @if (session()->has('user_id'))
                                            <h4 style="word-wrap: break-word !important;white-space: normal; max-width: 200px;">{{ Str::limit($listing->address, 50) }}  </h4>
                                            @else
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            @endif
                                            <!-- Display the average rating as stars -->
                                            @if(isset($listing->average_rating))
                                                <div class="rating">
                                                    @php
                                                        $roundedRating = round($listing->average_rating);
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if($i <= $roundedRating)
                                                            <i class="fa fa-star text-warning"></i> <!-- Filled star -->
                                                        @else
                                                            <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                        @endif
                                                    @endfor

                                                    <!-- Optionally, display the average rating value -->
                                                    <!--<span>({{ number_format($listing->average_rating, 1) }})</span>-->
                                                </div>
                                                @else
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star-o text-muted"></i> <!-- Empty star -->
                                                @endfor
                                            </div>
                                            @endif

                                        <div class="controls-more hide-show">
                                                @if (session()->has('user_id'))
                                             <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
    <span class="wp-dis">Share on:
        <a class=" " href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="float:right">

                                <!--<i class="fa fa-share-alt"></i>  -->
                             <i class="fa fa-whatsapp" style="color: #25d366; font-size: 30px;"></i>

                           </a> </span>
     @else
     <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="" style="margin-bottom:10px;">
        <i class="fa fa-whatsapp"></i>
    </a>
                              <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Connect</a>
                            @endif
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
                        <div class="row">
  <div class="col-md-12 col-sm-12 text-center">
       @if (session()->has('user_id'))
         <a href="{{route('bus_all_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
         @else
        <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse More</a>
    @endif
      </div>
                    </div>
                     @endif
                    <!--end row-->
                </section>

{{--  Business post section end  --}}
                <section>
                    <div class="center">
                        {{--  <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="disabled previous">
                                    <a href="#" aria-label="Previous">
                                        <i class="arrow_left"></i>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="active"><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li class="next">
                                    <a href="#" aria-label="Next">
                                        <i class="arrow_right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>  --}}
                    </div>
                </section>
            </div>
            <!--end col-md-9-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>
<!--consumer modal start-->
 <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="enquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="user-details" class="mb-1" style="line-height:1.75">

                    <!-- User details will be appended here -->
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="hr-wrapper">
        <hr>
        <h2 class="modal-title text-center"><strong>OR</strong></h2>
        <hr>
    </div>
            <h2 class="modal-title text-center mt-1" id="enquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.consumer_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="postid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="message" rows="3" name="message" placeholder="Enter message"></textarea>
                        @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!--consumer modal end-->

<!--sab modal start-->
 <div class="modal fade" id="sabenquiryModal" tabindex="-1" role="dialog" aria-labelledby="sabenquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="sabenquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="sab-user-details" class="mb-1" style="line-height:1.75">

                    <!-- User details will be appended here -->
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="hr-wrapper">
        <hr>
        <h2 class="modal-title text-center"><strong>OR</strong></h2>
        <hr>
    </div>
            <h2 class="modal-title text-center mt-1" id="sabenquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.sab_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="sabpostid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="sabname" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="sabemail" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="sabmobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="sabmessage" rows="3" name="message" placeholder="Enter message"></textarea>
                        @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!--sab modal end-->

<!--business modal start-->
 <div class="modal fade" id="businessenquiryModal" tabindex="-1" role="dialog" aria-labelledby="busenquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="busenquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="bus-user-details" class="mb-1" style="line-height:1.75">

                    <!-- User details will be appended here -->
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="hr-wrapper">
        <hr>
        <h2 class="modal-title text-center"><strong>OR</strong></h2>
        <hr>
    </div>
            <h2 class="modal-title text-center mt-1" id="busenquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.business_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="buspostid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="busname" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="busemail" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="busmobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="busmessage" rows="3" name="message" placeholder="Enter message"></textarea>
                        @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!--business modal end-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.consumer-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#postid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_consumer_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#name').val(post.name);
                        $('#email').val(post.email);
                        $('#mobile').val(post.mobile);
                        $('#message').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#user-details').html(userDetails);
                    } else {
                        //alert(response.message); // Alert if status is not success
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.'); // Alert on AJAX error
                }
            });
        });
    });
</script>

 <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.sab-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#sabpostid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#sabname').val(post.name);
                        $('#sabemail').val(post.email);
                        $('#sabmobile').val(post.mobile);
                        $('#sabmessage').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#sab-user-details').html(userDetails);
                    } else {
                       // alert(response.message); // Alert if status is not success
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.'); // Alert on AJAX error
                }
            });
        });
    });
</script>

 <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.bus-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#buspostid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_business_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#busname').val(post.name);
                        $('#busemail').val(post.email);
                        $('#busmobile').val(post.mobile);
                        $('#busmessage').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#bus-user-details').html(userDetails);
                    } else {
                        //alert(response.message); // Alert if status is not success
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.'); // Alert on AJAX error
                }
            });
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
            });
        @endif

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ Session::get('info') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ Session::get('warning') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    });
</script>

@include('frontend.include.footer')
