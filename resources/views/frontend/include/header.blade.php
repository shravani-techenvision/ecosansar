<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">
    <meta name="csrf-token" content="{{ csrf_token() }}">

 <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/images/favicon.png')}}">
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
        .dropdown:hover .dropdown-menu {
           display: block;
       }

       /* Prevent dropdown from closing when clicking inside */
       .dropdown-menu {
           margin-top: 0;
       }
       .dropdown-menu-left {
           right: 0; /* Aligns the right edge of the dropdown to the button */
           left: auto; /* Ensures the left property doesn't interfere */
       }
       @media (max-width: 767px) { /* Mobile view adjustments */

           .goog-te-gadget-simple {
               display:block !important;
                background-color:#8eb66f !important;
           }
           .goog-te-gadget-simple a {
               padding:0px !important;
             color: #fff !important;
           }
            .goog-te-gadget-simple span{
               color: #fff !important;
           }

       }
       @media (max-width: 375px) {
        .hide-addlistning{
            display:none !important;
        }
        }
           </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4322110929509521"
     crossorigin="anonymous"></script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CKNH10SE9V"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CKNH10SE9V');
</script>
</head>

<body class="">

<div class="page-wrapper">
    <header id="page-header" class="pheader">
        <nav style="height: 93px;">
           <div class="col-md-2"></div>

            <div class="left">
                <a href="{{url('/')}}" class="brand"><img src="{{ asset('frontend/assets/img/logo-one.png') }}" alt="" height="50"></a>
            </div>
            <!--end left-->
            <div class="right">
                <div class="primary-nav has-mega-menu">
                    <ul class="navigation">
                        <li ><a href="{{url('/')}}">Home</a>
                        </li>

                        <li class="has-child"><a href="#nav-listing">About</a>
                            <div class="wrapper">
                                <div id="nav-listing" class="nav-wrapper">
                                    <ul>
                                        <li class=" "><a href="{{route('about')}}">About Us</a></li>
                                                     <li class=" "><a href="{{route('howitsworks')}}">How it works </a></li>
                                                     <li class=" "><a href="{{route('faq')}}">FAQ</a></li>
                                                    <li class=" "><a href="{{route('service')}}">Services </a></li>

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class=" "><a href="{{route('blog')}}">Blog</a>
                        </li>
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li>
                            <div id="google_translate_element"></div>
                       </li>


                    </ul>
                    <!--end navigation-->
                </div>
                <!--end primary-nav-->

                <!--end secondary-nav-->
                <!--my listing start-->
               @php
    $user_id = session()->get('user_id');
    $userdet = null;

    if (isset($user_id) && !empty($user_id)) {
        $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
        $type = $userdet->user_type;
    }
@endphp
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
    <a href="{{ route('consumer_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing hide-addlistning">
        <i class="fa fa-sign-in"></i><span>Add listing</span>
    </a>
@endif
<!--my listing end-->
<!--notification display start-->
                                               @php
                  use App\Models\frontend\ConsumerAskReview;
                   use App\Models\frontend\ConsumerPost;
                   use App\Models\frontend\ConsumerReview;
                     use App\Models\frontend\SABReview;
                     use App\Models\frontend\BusinessReview;
       $userId = session()->get('user_id');
    $notifications = [];
    $notificationCount = 0;
$conreviews = ConsumerReview::where('login_user_id',$userId)->first();
$sabreviews = SABReview::where('login_user_id',$userId)->first();
$busreviews = BusinessReview::where('login_user_id',$userId)->first();
    if ($userId) {


        $notifications = ConsumerAskReview::where('user_id', $userId)
                        ->where(function($query) {
                            $query->where('flag', 'asked')
                                  ->whereNull('status')
                                  ->orWhere('change_review', 'changereview');
                        })
                        ->get();
        $notificationCount = $notifications->count();
    }
@endphp
 <div class="secondary-nav">
     @if(!session()->has('user_id'))
     @else
<div class="nav-item dropdown notification-icon" >
    <a href="#" id="notificationToggle" class="nav-link">
        <img src="{{asset('frontend/assets/img/Notification icon.png')}}" style="height: 33px;">
        @if($notificationCount > 0)
            <span class="badge badge-danger" style="position: absolute; top: 0; right: 0;">
                {{ $notificationCount }}
            </span>
        @endif
    </a>

    <div id="notificationDropdown" class="dropdown-menu dropdown-menu-left p-3 shadow-lg" style="display: none; position: absolute; right: 0; top: 100%; width: 300px; border-radius: 8px;">
    <span class="dropdown-header font-weight-bold text-primary">Review Requests</span>

    @if($notificationCount > 0)
        <ul class="list-group list-group-flush">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-start notification-item">
                    <div class="media">
                        <!-- Optional icon or avatar for a better UI -->
                        <div class="media-body">
                            <span class="mt-0 mb-1">
                               @if (is_null($notification->status))
                            <a href="{{ url(($notification->type == 'consumer' ? 'conpostprofile' : ($notification->type == 'business' ? 'buspostprofile' : 'sabpostprofile')) . '/' . $notification->login_user_id. '?review_id=' . $notification->id) }}" class="text-dark" data-id="{{ $notification->id }}">
                                {{ $notification->name }}
                            </a>
                            <small class="text-muted">asked for a review</small>
                        @elseif ($notification->change_review == 'changereview')

                           <a href="{{ url(($notification->type == 'consumer' ? 'edit-con-review/' . $notification->login_user_id . '/'. $conreviews->id : ($notification->type == 'business' ? 'edit-bus-review/' . $notification->login_user_id . '/'. $busreviews->id : 'edit-sab-review/' . $notification->login_user_id . '/'. $sabreviews->id)) . '?review_id=' . $notification->id) }}" class="text-dark" data-id="{{ $notification->id }}">
                           {{ $notification->name }}
                            </a>
                            <small class="text-muted">asked to change review</small>
                        @endif
                            </span>

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-3">
            <span class="text-muted">No new requests</span>
        </div>
    @endif
</div>

</div>
@endif
</div>
<!--notification display end-->
 @php
                    $user_id = session('user_id');
                    if(null !== $user_id && $user_id != ''){

                    } else {
                    @endphp
                        <a href="{{ route('consumer_login') }}" class="promoted btn btn-primary btn-small btn-rounded icon shadow add-listing" >Sign In</a>
                         <a href="{{ route('user_register') }}" class="promoted btn btn-primary btn-small btn-rounded icon shadow add-listing" >Register</a>
                    @php
                    }
                    @endphp
@if (isset($user_id) && !empty($user_id))
    <div class="dropdown" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
             <img  class="formobile-img" src="{{ URL::asset('frontend/assets/img/user.png') }}" alt="" > <!-- Profile Icon -->
        </a>
        <ul class="dropdown-menu dropdown-menu-left" role="menu">
            <li>
                <a href="{{ url('profile') . '/' . $user_id }}">My Profile</a>
            </li>
            <li>
                <a href="{{ route('user_logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('user_logout') }}"  class="d-none">
            @csrf
        </form>
    </div>
@endif

                <!--<a href="#" class="btn btn-primary btn-small btn-rounded icon shadow add-listing"    ><i class="fa fa-plus"></i><span>Add listing</span></a>-->
                <div class="nav-btn"  >
                    <i></i>
                    <i></i>
                    <i></i>
                </div>
                <!--end nav-btn-->

        </div>
        <div class="col-md-2"></div>
            <!--end right-->
        </nav>
        <!--end nav-->
    </header>
    <!--end page-header-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#notificationToggle').on('click', function(event) {
                event.preventDefault();
                $('#notificationDropdown').toggle();  // Toggle the dropdown visibility
            });

            // Hide the dropdown if clicked outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.notification-icon').length) {
                    $('#notificationDropdown').hide();
                }
            });
        });
    </script>
