<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">
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
        /* Enable dropdown on hover */
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


                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li>
                            <div id="google_translate_element"></div>
                       </li>
                        <li> @php
                    $user_id = session('user_id');
                    if(null !== $user_id && $user_id != ''){

                    } else {
                    @endphp
                        <a href="{{ route('consumer_login') }}" class="promoted" >Sign In</a>
                        <a href="{{ route('user_register') }}" class="promoted" >Register</a>
                    @php
                    }
                    @endphp

                   <li class="fordes"> @if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    @if ($userType == 'sab')
        <a href="{{ route('sab_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
    @elseif ($userType == 'consumer')
        <a href="{{ route('consumer_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
    @else
        <a href="{{ route('business_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>

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
    <a href="{{ route('consumer_login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Add Your Post</a>
@endif

 @if (session()->has('user_id'))
    @php
        $userType = session('user_type'); // Assuming you have stored the user type in the session
    @endphp

    @if ($userType == 'sab')
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
    @elseif ($userType == 'consumer')
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
    @else
        <a href="{{ route('listings') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
    @endif
@else
    <a href="{{ route('consumer_login', ['redirect_list' => request()->fullUrl()]) }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>
@endif

                        </li>





                    </ul>
                    <!--end navigation-->
                </div>
                <!--end primary-nav-->
                <!-- <div class="secondary-nav">-->

                <!--</div>-->
                <!--end secondary-nav-->
                @php
                $user_id = session('user_id');
                if(null !== $user_id && $user_id != ''){

                } else {
                @endphp
                   <li> <a href="{{ route('consumer_login') }}" class="promoted" >Sign In</a> </li>
                  <li>  <a href="{{ route('user_register') }}" class="promoted" >Register</a> </li>
                @php
                }
                @endphp

               @php
$user_id = session()->get('user_id');
$userdet = null;

if (isset($user_id) && !empty($user_id)) {
    $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
    $type = $userdet->user_type;
}
@endphp

@if(isset($user_id) && !empty($user_id))
<div class="dropdown" style="display: inline-block;">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <img class="formobile-img"  src="{{ URL::asset('frontend/assets/img/user.png') }}" alt="" > <!-- Profile Icon --> <!-- Use Font Awesome for the icon -->
    </a>
    <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="profileDropdown">
        <li>
            <a class="" href="{{ url('profile'). "/" . $user_id }}">My Profile</a>
        </li>
        <li>
            <a href="{{ route('user.user_deactivate') }}">Deactivate account</a>
        </li>

        <li>
            <a class="" href="{{ route('user_logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('user_logout') }}" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
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
