@include('frontend.include.header')
@include('sweetalert::alert')
<style>
.mt-1 {
  margin-top: .25rem;
}

.mb-1 {
  margin-bottom: .25rem;
}
input[type="text"],input[type="email"]{
    padding:5px;
}
.item.item-row > a .image img{
        width:239px !important;
        border-radius: 10px !important;
    }
    .item.item-row > a .description {
    padding-left:80px !important;
       color:black !important;
    }
textarea.form-control {
    padding:5px;
}

    .item.item-row > a .image{
        width:239px !important;
        border-radius: 10px !important;
    }
    .item.item-row > a .description {
    padding-left:80px !important;

    }
    .btn-dropdown {
    width: 100% !important;
    text-align: left !important;
    margin-top:16px !important;
    background-color: white;
    border-color: #f0f0f0;
    color: rgba(0, 0, 0, 0.3);
    text-transform: none !important;
    font-size:14px !important;
}
 .btn-dropdown:hover{
     color: rgba(0, 0, 0, 0.3);
 }

/* Style for the dropdown caret icon */
.btn-dropdown .caret {
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -2px;
    margin-bottom: 2px solid rgba(0, 0, 0, 0.08);
}

/* Style for the dropdown menu */
.checkbox-menu {
    padding: 5px 10px !important;
    max-height: 200px !important; /* Adjust height as needed */
    overflow-y: auto !important;;
}

.checkbox-menu li {
    list-style: none;
    margin-bottom: 5px;
}

.checkbox-menu label {
    display: block;
    cursor: pointer;
}

.checkbox-menu label:hover {
    background-color: #f5f5f5;
}

.checkbox-menu input[type="checkbox"] {
    margin-right: 5px;
}
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
.star-ratings1 i{
    margin-right: 5px;
}
.wp{
    clear: both;
    margin-top: 75px;
}
@media screen and (max-width: 786px) {
.wp{
    margin-top: 50px !important;
}
}
</style>



    <div id="page-content">
        <div class="container">
            <ol class="breadcrumb">
                <!--<li><a href="#">Home</a></li>-->
                <!--<li><a href="#">Pages</a></li>-->
                <!--<li class="active">Contact</li>-->
            </ol>

             @if( $user_type == 'consumer')

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
    <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
    <div class="wp"> <!-- This ensures the WhatsApp button goes below the Connect button -->
        @if (session()->has('user_id'))
          Share&nbsp; .&nbsp; <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i>
            </a>
        @else
            <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i> Share on WhatsApp
            </a>
        @endif
    </div>
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
            @else
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <aside class="sidebar">
                        <section>
                            <h2>Search Filter</h2>
                              <form id="filterForm" class="form inputs-underline" action="{{route('bus_all_posts_filter')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pincode" placeholder="Enter Pickup Pincode">
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                               <div class="dropdown">
    <button class="btn  btn-dropdown " type="button" id="resourceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Select resources <span class="caret"></span>
    </button>
    <ul class="dropdown-menu checkbox-menu" aria-labelledby="resourceDropdown">
        @foreach($res as $project)
            <li>
                <label>
                    <input type="checkbox" class="resource-checkbox" name="resource[]" value="{{ $project->id }}"> {{ $project->resource_name }}
                </label>
            </li>
        @endforeach
    </ul>
</div>
</div>
                                <div class="form-group">
                                    <select class="form-control selectpicker" name="sale_giveaway">
                                        <option value="">I am looking for :  </option>
                                            <option value="Sale">Sell Posts</option>
                                            <option value="Giveaway">Giveaway Posts</option>
                                             <option value="Buy">Buy Posts</option>

                                    </select>
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                                    <select class="form-control selectpicker" name="clean_unclean">
                                        <option value="">Condition </option>
                                            <option value="Clean">Clean</option>
                                            <option value="Unclean">Unclean</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control selectpicker" name="packaged">
                                        <option value="">Packaged </option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control selectpicker" name="weight">
                                        <option value="">Select quantity</option>
                                        @foreach($weight as $project)
                                        <option value="{{ $project->id }}"

                                        >{{ $project->min_weight }} {{ $project->min_measure}} {{'to'}} {{ $project->max_weight }}{{ $project->max_measure }}</option>
                                    @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                     <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Search <i class="fa fa-search"></i></button>
                                    <button id="clear-button" type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing  pull-right">Clear<i class="fa fa-clear"></i></button>

                                </div>
                                <!--end form-group-->
                            </form>
                        </section>
                        <section>



                        </section>
                    </aside>
                    <!--end sidebar-->
                </div>
                <!--end col-md-4-->

                <div class="col-md-9 col-sm-9" id="postListings">
                    <section>
                        <div class="search-results-controls clearfix">

                            <!--end left-->
                            <div class="pull-right">
    <div class="input-group inputs-underline min-width-150px">
        <select id="sortDropdown" class="form-control selectpicker" name="sort">
        <option value="">Sort by</option>
        <option value="1">Newest first</option>
        <option value="2">Oldest first</option>
        <option value="3">Smallest quantity</option>
        <option value="4">Largest quantity</option>
        <option value="5">Highest ratings</option>
        <option value="6">Lowest ratings</option>
    </select>
    </div>
</div>
                            <!--end right-->
                        </div>
                        <!--end search-results-controls-->
                    </section>
                       <section class="page-title">
                        <h1>Corporate Posts</h1>
                       @if (isset($busuniqueListings) && $busuniqueListings->isNotEmpty())
                      @if (!empty($appliedFilters))
    <h4>You have searched for:</h4>
    <ul>
        @if (!empty($appliedFilters['pincode']))
            <li>Pincode: {{ $appliedFilters['pincode'] }}</li>
        @endif
       @if (!empty($appliedFilters['resource']))
            <li>Resource:
                @foreach ($appliedFilters['resource'] as $resourceId)
                    {{ $res->where('id', $resourceId)->pluck('resource_name')->first() }} ,
                @endforeach
            </li>
        @endif
        @if (!empty($appliedFilters['sale_giveaway']))
            <li>Sale giveaway: {{ $appliedFilters['sale_giveaway'] }}</li>
        @endif
        @if (!empty($appliedFilters['clean_unclean']))
            <li>Clean unclean: {{ $appliedFilters['clean_unclean'] }}</li>
        @endif
        @if (!empty($appliedFilters['packaged']))
            <li>Packaged: {{ $appliedFilters['packaged'] }}</li>
        @endif
         @if (!empty($appliedFilters['weight']))
            <li>Quantity: {{ $appliedFilters['weight'] }}</li>
        @endif
    </ul>
@endif
@else
 <p>No results found for the applied filters.</p>
 @endif


                    </section>
                    <!--end section-title-->
                    <section>
                        @php
function displayStars($rating) {
    $fullStars = floor($rating);
    $halfStar = ceil($rating) - $fullStars;
    $emptyStars = 5 - $fullStars - $halfStar;

    $stars = str_repeat('<i class="fa fa-star"></i>', $fullStars);
    if ($halfStar) {
        $stars .= '<i class="fa fa-star-half-o"></i>';
    }
    $stars .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);

    return $stars;
}


@endphp

                        @if( $user_type == 'business')
                           @foreach($busuniqueListings as $listing)
                        <div class="row corprow"  data-latitude="40.71447628" data-longitude="-73.8821125">
                            <div class="col-md-3">
                            <!--<figure class="ribbon">Sale</figure>-->
                            <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                <div>
                                     <img class="corpimage" src="{{ asset('frontend/assets/img/Businessposts/'.$listing->resource_img) }}" alt="abc">
                                </div>
                                 </a>
                                </div>
                                <!--end image-->
                                 <div class="col-md-6">
                                <div class="description">
                                    @php
                                    $resourceNames = explode(', ', $listing->resource_names);
                                @endphp

                                @if(!empty($resourceNames))
                                    {{ implode(', ', $resourceNames) }}
                                @endif


                                           <h4>{{ $listing->min_weight}} {{ $listing->min_measure}} {{'to'}} {{ $listing->max_weight}} {{ $listing->max_measure}}</h4>

                                            <h4>{{ $listing->address }}</h4> <br>
                                             <!--<h4 class="star-ratings1">{!! displayStars($listing->averageRating) !!}</h4>-->
                                           <h4> Posted on:  {{ date('jS F Y', strtotime($listing->created_at)) }}</h4>
                                </div>
                                </div>
                                <!--end description-->
                            <div class="col-md-3">
                        <div class="controls-more">
    <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
    <div class="wp"> <!-- This ensures the WhatsApp button goes below the Connect button -->
        @if (session()->has('user_id'))
          Share&nbsp; .&nbsp; <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i>
            </a>
        @else
            <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i> Share on WhatsApp
            </a>
        @endif
    </div>
</div>
</div>
                            <!--end controls-more-->
                        </div>
                        @endforeach
                        @else
                         @foreach($busuniqueListingsnotsell as $listing)
                        <div class="row corprow"  data-latitude="40.71447628" data-longitude="-73.8821125">
                            <div class="col-md-3">
                            <!--<figure class="ribbon">Sale</figure>-->
                            <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                                <div>
                                     <img class="corpimage" src="{{ asset('frontend/assets/img/Businessposts/'.$listing->resource_img) }}" alt="abc">
                                </div>
                                 </a>
                                </div>
                                <!--end image-->
                                 <div class="col-md-6">
                                <div class="description">
                                    @php
                                    $resourceNames = explode(', ', $listing->resource_names);
                                @endphp

                                @if(!empty($resourceNames))
                                    {{ implode(', ', $resourceNames) }}
                                @endif


                                           <h4>{{ $listing->min_weight}} {{ $listing->min_measure}} {{'to'}} {{ $listing->max_weight}} {{ $listing->max_measure}}</h4>

                                            <h4>{{ $listing->address }}</h4> <br>
                                             <!--<h4 class="star-ratings1">{!! displayStars($listing->averageRating) !!}</h4>-->
                                           <h4> Posted on:  {{ date('jS F Y', strtotime($listing->created_at)) }}</h4>
                                </div>
                                </div>
                                <!--end description-->
                            <div class="col-md-3">
                        <div class="controls-more">
    <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
    <div class="wp"> <!-- This ensures the WhatsApp button goes below the Connect button -->
        @if (session()->has('user_id'))
          Share&nbsp; .&nbsp; <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$listing->id)) }}" target="_blank"  style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i>
            </a>
        @else
            <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $listing->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                <i class="fa fa-whatsapp"></i> Share on WhatsApp
            </a>
        @endif
    </div>
</div>
</div>
                            <!--end controls-more-->
                        </div>
                        @endforeach
                        @endif
                        <!--end item.row-->
                    </section>


                </div>
                <!--end col-md-9-->
            </div>
            @endif
            <!--end row-->

        </div>
        <!--end container-->
    </div>
    <!--end page-content-->
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

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.business_save') }}" method="POST">
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <script>
  $(document).ready(function() {
    // Submit form using AJAX for filtering
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var sessionUserId = '{{ session('user_id') }}';
        var baseUrl = "{{ url('/') }}";
   var consumerLoginRoute = "{{ route('consumer_login') }}";
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json', // Specify JSON dataType for response parsing
                success: function(response) {
    console.log(response.busuniqueListings); // Log the response to console

    // Clear existing listings
    $('#postListings').empty();

    // Display applied filters
    if (response.user_type === 'business') {
    var filtersHtml = '<section class="page-title"><h1>Corporate Listings</h1>';
    if (response.busuniqueListings.length > 0) {
        filtersHtml += '<h4>You have searched for:</h4><ul>';

        if (response.appliedFilters.pincode) {
            filtersHtml += '<li>Pincode: ' + response.appliedFilters.pincode + '</li>';
        }

        if (response.appliedFilters.resource) {
            filtersHtml += '<li>Resource: ';
            $.each(response.appliedFilters.resource, function(index, resourceId) {
                var resourceName = response.res.find(function(resource) {
                    return resource.id == resourceId;
                }).resource_name;
                filtersHtml += resourceName + ', ';
            });
            filtersHtml = filtersHtml.slice(0, -2); // Remove trailing comma and space
            filtersHtml += '</li>';
        }

       if (response.appliedFilters.sale_giveaway) {
    var saleGiveawayText = response.appliedFilters.sale_giveaway === 'Sale' ? 'Sell' : response.appliedFilters.sale_giveaway;
    filtersHtml += '<li>Sale giveaway: ' + saleGiveawayText + '</li>';
}

        if (response.appliedFilters.clean_unclean) {
            filtersHtml += '<li>Clean unclean: ' + response.appliedFilters.clean_unclean + '</li>';
        }

        if (response.appliedFilters.packaged) {
            filtersHtml += '<li>Packaged: ' + response.appliedFilters.packaged + '</li>';
        }

          if (response.appliedFilters.weight) {
            filtersHtml += '<li>Quantity: ' + response.appliedFilters.min_weight +  ' ' +response.appliedFilters.min_measure +  ' to ' +response.appliedFilters.max_weight +  ' ' +response.appliedFilters.max_measure +'</li>';
        }

        filtersHtml += '</ul>';
    } else {
        filtersHtml += '<p>No results found for the applied filters.</p>';
    }
    filtersHtml += '</section>';

    // Append filters HTML to #postListings
    $('#postListings').append(filtersHtml);
    }
    else{
       var filtersHtml = '<section class="page-title"><h1>Corporate Listings</h1>';
    if (response.busuniquebuyListings.length > 0) {
        filtersHtml += '<h4>You have searched for:</h4><ul>';

        if (response.appliedFilters.pincode) {
            filtersHtml += '<li>Pincode: ' + response.appliedFilters.pincode + '</li>';
        }

        if (response.appliedFilters.resource) {
            filtersHtml += '<li>Resource: ';
            $.each(response.appliedFilters.resource, function(index, resourceId) {
                var resourceName = response.res.find(function(resource) {
                    return resource.id == resourceId;
                }).resource_name;
                filtersHtml += resourceName + ', ';
            });
            filtersHtml = filtersHtml.slice(0, -2); // Remove trailing comma and space
            filtersHtml += '</li>';
        }

       if (response.appliedFilters.sale_giveaway) {
    var saleGiveawayText = response.appliedFilters.sale_giveaway === 'Sale' ? 'Sell' : response.appliedFilters.sale_giveaway;
    filtersHtml += '<li>Sale giveaway: ' + saleGiveawayText + '</li>';
}

        if (response.appliedFilters.clean_unclean) {
            filtersHtml += '<li>Clean unclean: ' + response.appliedFilters.clean_unclean + '</li>';
        }

        if (response.appliedFilters.packaged) {
            filtersHtml += '<li>Packaged: ' + response.appliedFilters.packaged + '</li>';
        }

          if (response.appliedFilters.weight) {
            filtersHtml += '<li>Quantity: ' + response.appliedFilters.min_weight +  ' ' +response.appliedFilters.min_measure +  ' to ' +response.appliedFilters.max_weight +  ' ' +response.appliedFilters.max_measure +'</li>';
        }

        filtersHtml += '</ul>';
    } else {
        filtersHtml += '<p>No results found for the applied filters.</p>';
    }
    filtersHtml += '</section>';

    // Append filters HTML to #postListings
    $('#postListings').append(filtersHtml);
    }
    // Iterate through filtered listings and append to #postListings
    if (response.user_type === 'business') {
    $.each(response.busuniqueListings, function(index, listing) {
        var html = '<div class="row corprow" data-latitude="40.71447628" data-longitude="-73.8821125">';
          html += '<div class="col-md-3">';
        html += '<a href="{{ url('bus_listing_details/') }}/' + listing.id + '">';
        html += '<div>';
        html += '<img class="corpimage" src="{{ asset('frontend/assets/img/Businessposts/') }}/' + listing.resource_img + '" alt="abc">';
        html += '</div>';
         html += '</a>';
         html += '</div>';
          html += '<div class="col-md-6">';
        html += '<div class="description">';

        // PHP-like conditional check in JavaScript
        var resourceNames = listing.resource_names ? listing.resource_names.split(', ') : [];
        if (resourceNames.length > 0) {
            html += resourceNames.join(', ');
        }

         html += '<h4>' + listing.weight_details  + '</h4>';
        html += '<h4>' + listing.address + '</h4>';
        html += '<h4>' + 'Posted by: '  + listing.formatted_date + '</h4>';
        html += '</div>';
         html += '</div>';
           html += '<div class="col-md-3">';
        html += '<div class="controls-more">';
        html += '<a href="#" data-id="' + listing.id + '" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">';
        html += '<span>Connect</span>';
        html += '</a>';
          // Add WhatsApp Share Button
html += '<div class="wp">'; // Ensure it goes below the "Connect" button
    if (sessionUserId) { // Assuming you have session user ID in JavaScript (e.g., passed from backend or retrieved via AJAX)
        html += 'Share&nbsp; .&nbsp;<a href="https://wa.me/?text=' + encodeURIComponent('This post from The ZeroWaste Community Tool might interest you, check it out : ' + baseUrl + 'bus_listing_details/' + listing.id) + '" target="_blank" style="margin-bottom:10px;">';
        html += '<i class="fa fa-whatsapp"></i></a>';
    } else {
        html += '<a href="' + consumerLoginRoute + '?redirect_wp=' + encodeURIComponent(baseUrl + 'bus_listing_details/' + listing.id) + '" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">';
        html += '<i class="fa fa-whatsapp"></i> Share on WhatsApp</a>';
    }
    html += '</div>';
        html += '</div>';
        html += '</div>';
         html += '</div>';
        // Append the constructed HTML to #postListings
        $('#postListings').append(html);
    });
    }
    else{
        $.each(response.busuniquebuyListings, function(index, listing) {
        var html = '<div class="row corprow" data-latitude="40.71447628" data-longitude="-73.8821125">';
          html += '<div class="col-md-3">';
        html += '<a href="{{ url('bus_listing_details/') }}/' + listing.id + '">';
        html += '<div>';
        html += '<img class="corpimage" src="{{ asset('frontend/assets/img/Businessposts/') }}/' + listing.resource_img + '" alt="abc">';
        html += '</div>';
         html += '</a>';
         html += '</div>';
          html += '<div class="col-md-6">';
        html += '<div class="description">';

        // PHP-like conditional check in JavaScript
        var resourceNames = listing.resource_names ? listing.resource_names.split(', ') : [];
        if (resourceNames.length > 0) {
            html += resourceNames.join(', ');
        }

         html += '<h4>' + listing.weight_details  + '</h4>';
        html += '<h4>' + listing.address + '</h4>';
        html += '<h4>' + 'Posted by: '  + listing.formatted_date + '</h4>';
        html += '</div>';
         html += '</div>';
           html += '<div class="col-md-3">';
        html += '<div class="controls-more">';
        html += '<a href="#" data-id="' + listing.id + '" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">';
        html += '<span>Connect</span>';
        html += '</a>';
         // Add WhatsApp Share Button
html += '<div class="wp">'; // Ensure it goes below the "Connect" button
    if (sessionUserId) { // Assuming you have session user ID in JavaScript (e.g., passed from backend or retrieved via AJAX)
        html += 'Share&nbsp; .&nbsp;<a href="https://wa.me/?text=' + encodeURIComponent('This post from The ZeroWaste Community Tool might interest you, check it out : ' + baseUrl + 'bus_listing_details/' + listing.id) + '" target="_blank" style="margin-bottom:10px;">';
        html += '<i class="fa fa-whatsapp"></i></a>';
    } else {
        html += '<a href="' + consumerLoginRoute + '?redirect_wp=' + encodeURIComponent(baseUrl + 'bus_listing_details/' + listing.id) + '" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">';
        html += '<i class="fa fa-whatsapp"></i> Share on WhatsApp</a>';
    }
    html += '</div>';
        html += '</div>';
        html += '</div>';
         html += '</div>';
        // Append the constructed HTML to #postListings
        $('#postListings').append(html);
    });
    }
},

            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>
   <script>
    $(document).ready(function(){
        // Event delegation for .connect-listing elements
        $(document).on('click', '.connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id');
            $('#postid').val(dataId);

             $.ajax({
        url: "{{ url('/get_business_post_details') }}",
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
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span>' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#user-details').html(userDetails);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.');
                }
             });
        });
    });
</script>
 <script>
    document.getElementById('clear-button').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = "{{ route('bus_all_posts') }}";
    });
</script>
 <script>
$(document).ready(function() {
    // Handle sorting change
    $('#sortDropdown').on('change', function() {
        var sortValue = $(this).val();
        fetchSortedListings(sortValue);
    });

    function fetchSortedListings(sortValue) {
        $.ajax({
            type: 'GET',
            url: '{{ route("bus_all_posts_sort") }}',
            data: { sort: sortValue },
            dataType: 'json',
            success: function(response) {
                $('#postListings').empty();
             var filtersHtml = '<section class="page-title"><h1>Corporate Posts</h1></section>';
   filtersHtml += '<section>';
   filtersHtml += '<div class="search-results-controls clearfix">';
   filtersHtml += '<div class="pull-right">';
   filtersHtml += '<div class="input-group inputs-underline min-width-150px">';
   filtersHtml += '<select id="sortDropdown" class="form-control selectpicker" name="sort">';
   filtersHtml += '<option value="">Sort by</option>';
   filtersHtml += '<option value="1">Newest first</option>';
   filtersHtml += '<option value="2">Oldest first</option>';
   filtersHtml += '<option value="3">Smallest quantity</option>';
   filtersHtml += '<option value="4">Largest quantity</option>';
   filtersHtml += '<option value="5">Highest ratings</option>';
   filtersHtml += '<option value="6">Lowest ratings</option>';
   filtersHtml += '</select>';
   filtersHtml += '</div>';
   filtersHtml += '</div>';
   filtersHtml += '</div>';
   filtersHtml += '</section>';
                 $('#postListings').append(filtersHtml);
                // Iterate through sorted listings and append to #postListings
                $.each(response.busuniqueListings, function(index, listing) {
                    var html = '<div class="corprow" data-latitude="40.71447628" data-longitude="-73.8821125">';
                     html += '<div class="col-md-3">';
                    html += '<a href="{{ url('bus_listing_details/') }}/' + listing.id + '">';
                    html += '<div>';
                    html += '<img class="corpimage"src="{{ asset('frontend/assets/img/Businessposts/') }}/' + listing.resource_img + '" alt="abc">';
                    html += '</div>';
                      html += '</a>';
                     html += '</div>';
                      html += '<div class="col-md-6">';
                    html += '<div class="description">';
                    var resourceNames = listing.resource_names ? listing.resource_names.split(', ') : [];
                    if (resourceNames.length > 0) {
                        html += resourceNames.join(', ');
                    }
                    html += '<h4>' + listing.weight_details + '</h4>';
                    html += '<h4>' + listing.address + '</h4>';
                    html += '<h4>' + 'Posted by: ' + listing.formatted_date + '</h4>';
                    html += '</div>';
                     html += '</div>';
                     html += '<div class="col-md-3">';
                    html += '<div class="controls-more">';
                    html += '<a href="#" data-id="' + listing.id + '" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">';
                    html += '<span>Connect</span>';
                    html += '</a>';
                    html += '</div>';
                    html += '</div>';
                       html += '</div>';
                    $('#postListings').append(html);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
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













