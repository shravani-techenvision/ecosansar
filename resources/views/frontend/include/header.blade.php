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
                        <li class=" "><a href="{{route('about')}}">About Us</a>
                        </li>
                        
                        <li class=" "><a href="{{route('faq')}}">FAQ</a>
                        </li>
                        <li class=" "><a href="{{route('howitsworks')}}">How it works </a>
                        </li>
                        <!-- <li class="has-child"><a href="#">know more</a>-->
                        <!--    <div class="wrapper">-->
                        <!--        <div id="nav-homepages" class="nav-wrapper">-->
                        <!--            <ul>-->
                        <!--                <li class=" "><a href="{{route('faq')}}">FAQ</a></li>-->
                        <!--            </ul>-->
                        <!--             <ul>-->
                        <!--                <li class=" "><a href="{{route('howitsworks')}}">How it works</a></li>-->
                        <!--            </ul>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <!--<li class=" "><a href="{{ route('listings') }}"> Browse Sellers  </a>-->
                        <!--</li>-->
                        <!-- <li class=" "><a href="{{ route('buy_listings') }}"> Browse Buyers  </a>-->
                        <!--</li>-->
                        <!--<li class=" "><a href="#">How it works</a>-->
                        <!--</li>-->
                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                        <li> @php
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

    if(isset($user_id) && !empty($user_id)) {
        $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
        
         $type = $userdet->user_type; 
    }
                if(isset($user_id) && !empty($user_id)) {
            @endphp
             <li> <a class="  " href="{{ url('profile'). "/".$user_id }}" >  My Profile </a>
              </li>
              <li>
            <a class="  " href="{{ route('user_logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">  {{ __('Logout') }} </a>
            <form id="logout-form" action="{{ route('user_logout') }}"   class="d-none">
                @csrf
            </form>
            @php
                }
            @endphp</li>
                        
                    </ul>
                    <!--end navigation-->
                </div>
                <!--end primary-nav-->

    <!--            <div class="secondary-nav">-->
    <!--                @php-->
    <!--                $user_id = session('user_id');-->
    <!--                if(null !== $user_id && $user_id != ''){-->
    <!--                    echo "<span style='background-color: #6ab04c;'>".session('user')."</span>";-->
    <!--                } else {-->
    <!--                @endphp-->
    <!--                    <a href="{{ route('consumer_login') }}" class="promoted" >Sign In</a>-->
    <!--                    <a href="{{ route('user_register') }}" class="promoted" >Register</a>-->
    <!--                @php-->
    <!--                }-->
    <!--                @endphp-->

    <!--                @php-->
    <!--              $user_id = session()->get('user_id'); -->
    <!--              $userdet = null;-->

    <!--if(isset($user_id) && !empty($user_id)) {-->
    <!--    $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();-->
        
    <!--     $type = $userdet->user_type; -->
    <!--}-->
    <!--            if(isset($user_id) && !empty($user_id)) {-->
    <!--        @endphp-->
    <!--          <a class="  " href="{{ url('profile'). "/".$user_id }}" >  My Profile </a>-->
    <!--        <a class="  " href="{{ route('user_logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">  {{ __('Logout') }} </a>-->
    <!--        <form id="logout-form" action="{{ route('user_logout') }}"   class="d-none">-->
    <!--            @csrf-->
    <!--        </form>-->
    <!--        @php-->
    <!--            }-->
    <!--        @endphp-->
    <!--            </div>-->
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
