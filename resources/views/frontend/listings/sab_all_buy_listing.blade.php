<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">

       <link href="{{ asset('frontend/assets/fonts/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/assets/fonts/elegant-fonts.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('frontend/assets/bootstrap/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/zabuto_calendar.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.nouislider.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" type="text/css">
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>EcoSansar</title>
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
textarea.form-control {
    padding:5px;
}

    .item.item-row > a .image{
        width:239px !important;
        border-radius: 10px !important;
    }
    .item.item-row > a .description {
    padding-left:80px !important;
         color:black !important; 
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

</style>

</head>

<body>
    
<div class="page-wrapper">
    <header id="page-header">
        <nav style="height:93px;">
            <div class="col-md-2"></div>
            <div class="left">
                <a href="{{url('/')}}" class="brand"><img src="{{ asset('frontend/assets/img/logo-one.png') }}" alt="" height="50"></a>
            </div>
            <!--end left-->
            <div class="right">
                <div class="primary-nav has-mega-menu">
                    <ul class="navigation">
                         
                       

                       
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{route('about')}}">About</a></li>
                          <li><a href={{ route('listings') }}>Browse Sellers</a></li>
                           <li><a href={{ route('buy_listings') }}>Browse Buyers</a></li>
                           <li><a href={{ route('buy_listings') }}>Buy</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href={{route('contact')}}">Contact</a></li>
                    </ul>
                    <!--end navigation-->
                </div>
                <!--end primary-nav-->
                 <div class="secondary-nav">
                    @php
                    $user_id = session('user_id');
                    if(null !== $user_id && $user_id != ''){
                        echo "<span style='background-color: #6ab04c;'>".session('user')."</span>";
                    } else {
                    @endphp
                        <a href="{{ route('consumer_login') }}" class="promoted" >Sign In</a>
                        <a href="{{ route('user_register') }}" class="promoted" >Register</a>
                    @php
                    }
                    @endphp

                    @php
                  $user_id = session()->get('user_id'); 
                  $userdet = null;

    if(isset($user_id) && !empty($user_id)) {
        $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
        
         $type = $userdet->user_type; 
    }
                if(isset($user_id) && !empty($user_id)) {
            @endphp
              <a class="  " href="{{ url('profile'). "/".$user_id }}" >  My Profile </a>
            <a class="  " href="{{ route('user_logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">  {{ __('Logout') }} </a>
            <form id="logout-form" action="{{ route('user_logout') }}"   class="d-none">
                @csrf
            </form>
            @php
                }
            @endphp
                </div>
                <!--end secondary-nav-->
               @if(session()->has('user_id'))
                 @if($type == 'consumer')
                    <a href="{{route('consumer_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">
                        <i class="fa fa-plus"></i><span>My listings</span>
                    </a>
                @elseif($type == 'sab')
                 <a href="{{route('sab_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">
                        <i class="fa fa-plus"></i><span>My listings</span>
                    </a>
                    @else
                 <a href="{{route('business_own_posts')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">
                        <i class="fa fa-plus"></i><span>My listings</span>
                    </a>
                @endif
@else
    <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">
        <i class="fa fa-sign-in"></i><span>Add listing</span>
    </a>
@endif
                <div class="nav-btn">
                    <i></i>
                    <i></i>
                    <i></i>
                </div>
                <!--end nav-btn-->
            </div>
            <!--end right-->
            <div class="col-md-2"></div>
        </nav>
        <!--end nav-->
    </header>
    <!--end page-header-->

    <div id="page-content">
        <div class="container">
            <ol class="breadcrumb">
                <!--<li><a href="#">Home</a></li>-->
                <!--<li><a href="#">Pages</a></li>-->
                <!--<li class="active">Contact</li>-->
            </ol>
         
            
            
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <aside class="sidebar">
                        <section>
                            <h2>Search Filter</h2>
                              <form id="filterForm" class="form inputs-underline" action="{{route('sab_all_buy_posts_filter')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pincode" placeholder="Enter pincode">
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
                                <!--<div class="form-group">-->
                                <!--    <select class="form-control selectpicker" name="sale_giveaway">-->
                                <!--        <option value="">Type </option>-->
                                <!--            <option value="Sale">Sell</option>-->
                                <!--             <option value="Buy">Buy</option>-->
                                <!--            <option value="Giveaway">Giveaway</option>-->
                                             
                                <!--    </select>-->
                                <!--</div>-->
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
                                     <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Search Buyers<i class="fa fa-search"></i></button>
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

                <div class="col-md-9 col-sm-9"  id="postListings">
                       <section class="page-title"  >
                        <h1>Resource Collector Posts</h1>
                       @if (isset($sabuniqueListings) && $sabuniqueListings->isNotEmpty()) 
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
    </ul>
@endif
@else
 <p>No results found for the applied filters.</p>
 @endif


                    </section>
                    <!--end section-title-->
                    <section>
                           @foreach($sabuniqueListings as $listing)
                        <div class="item item-row"  data-latitude="40.71447628" data-longitude="-73.8821125">
                            <!--<figure class="ribbon">Sale</figure>-->
                            <a href="{{ url('sabs_listing_details/'.$listing->id) }}">
                                <div class="image ">
                                     <img src="{{ asset('frontend/assets/img/SABposts/'.$listing->resource_img) }}" alt="abc">
                                </div>
                                <!--end image-->
                                
                                <div class="description">
                                    @php
                                    $resourceNames = explode(', ', $listing->resource_names);
                                @endphp
                                
                                @if(!empty($resourceNames))
                                    {{ implode(', ', $resourceNames) }}
                                @endif
                                             
                                            
                                            <h4>{{ $listing->min_weight}} {{ $listing->min_measure}} {{'to'}} {{ $listing->max_weight}} {{ $listing->max_measure}}</h4>
                                            
                                            <h4>{{ $listing->address }}</h4><br><br>
                                          <h4> Posted by: {{ $listing->name }} | On {{ date('jS F Y', strtotime($listing->created_at)) }}</h4>
                                </div>
                                <!--end description-->
                            </a>
                        <div class="controls-more">
    <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">
        <span>Connect</span>
    </a>
</div>
                            <!--end controls-more-->
                        </div>
                        @endforeach
                        <!--end item.row-->
                    </section>

                    
                </div>
                <!--end col-md-9-->
            </div>
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
                
               <form class="form form-email inputs-underline"  action="{{ route('enquiry.sab_save') }}" method="POST">
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
 
   @include('frontend.include.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
  $(document).ready(function() {
    // Submit form using AJAX for filtering
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json', // Specify JSON dataType for response parsing
                success: function(response) {
    console.log(response.sabuniqueListings); // Log the response to console
     
    // Clear existing listings
    $('#postListings').empty();
    
    // Display applied filters
    var filtersHtml = '<section class="page-title"><h1>Resource Collector Listings</h1>';
    if (response.sabuniqueListings.length > 0) {
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
            filtersHtml += '<li>Sale giveaway: ' + response.appliedFilters.sale_giveaway + '</li>';
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
    
    // Iterate through filtered listings and append to #postListings
    $.each(response.sabuniqueListings, function(index, listing) {
        var html = '<div class="item item-row" data-latitude="40.71447628" data-longitude="-73.8821125">';
        html += '<a href="{{ url('sabs_listing_details/') }}/' + listing.id + '">';
        html += '<div class="image">';
        html += '<img src="{{ asset('frontend/assets/img/SABposts/') }}/' + listing.resource_img + '" alt="abc">';
        html += '</div>';
        html += '<div class="description">';
        
        // PHP-like conditional check in JavaScript
        var resourceNames = listing.resource_names ? listing.resource_names.split(', ') : [];
        if (resourceNames.length > 0) {
            html += resourceNames.join(', ');
        }
        
        html += '<h4>' + listing.weight_details  + '</h4>';
        html += '<h4>' + listing.address + '</h4><br><br>';
        html += '<h4>' + 'Posted by: ' + listing.name + ' | On ' + listing.formatted_date + '</h4>';
        html += '</div>';
        html += '</a>';
        html += '<div class="controls-more">';
        html += '<a href="#" data-id="' + listing.id + '" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">';
        html += '<span>Connect</span>';
        html += '</a>';
        html += '</div>';
        html += '</div>';
        
        // Append the constructed HTML to #postListings
        $('#postListings').append(html);
    });
},

            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>
 <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior
            
            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#postid').val(dataId); // Assuming you're setting some value to #postid element
            
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
                        alert(response.message); // Alert if status is not success
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
    document.getElementById('clear-button').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = "{{ route('sab_all_buy_posts') }}";
    });
</script>
 

 
<!--// <script>-->
<!--// $(document).ready(function() {-->
<!--//     $('.connect-listing').on('show.bs.modal', function(event) {-->
<!--//         var button = $(event.relatedTarget); // Button that triggered the modal-->
<!--//         console.log('Modal Trigger Button:', button);-->

<!--//         var listingId = button.data('id'); // Extract info from data-* attributes-->
<!--//         console.log('Listing ID:', listingId);-->

<!--//         // Alert the listingId to verify-->
<!--//         alert('Listing ID: ' + listingId);-->

<!--//         // Populate the hidden input with the listingId-->
<!--//         $('#modal-enquiryid').val(listingId);-->

<!--//         // Adjust z-index of the modal and backdrop-->
<!--//         $(this).css('z-index', '-1039');-->
<!--//         $('.modal-backdrop').css('z-index', '-1040');-->
<!--//     });-->

<!--//     // Reset z-index when the modal is hidden-->
<!--//     $('#enquiryModal').on('hidden.bs.modal', function(event) {-->
<!--//         $(this).css('z-index', '');-->
<!--//         $('.modal-backdrop').css('z-index', '');-->
<!--//     });-->
<!--// });-->
<!--// </script>-->


 






