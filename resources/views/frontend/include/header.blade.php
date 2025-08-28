<!DOCTYPE html>
<html lang="en" style="overflow-x:hidden;">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>ecoSansar</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/images/favicon.png')}}">

	<!-- Bootstrap CSS -->
	 <link href="{{ asset('frontend/assets/fonts/font-awesome.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css')}}">

	<!-- Animation CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css')}}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/tabler-icons/tabler-icons.css')}}">

	<!-- Fontawesome Icon CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/all.min.css')}}">

	<!-- select CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/select2/css/select2.min.css')}}">

	<!-- Owlcarousel CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/owlcarousel/owl.carousel.min.css')}}">

	<!-- Mobile CSS-->
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/intltelinput/css/intlTelInput.css')}}">
	<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/intltelinput/css/demo.css')}}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/feather.css')}}">

	<!-- Style CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">
	    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
	    <!--<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-6/assets/css/timeline-6.css">-->
	<style>
	   #google_translate_element div,
#google_translate_element   {
  display: flex;
  align-items: center;
  margin-top: 6px;
    padding: 5px;
}
}


	</style>
</head>
<body>
    <header class="header header-one">
			<div class="container">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="{{url('/')}}" class="navbar-brand logo">
							<img src="{{ asset('frontend/assets/img/logo-one.png') }}" class="img-fluid" alt="Logo"   >
						</a>
						<a href="{{url('/')}}" class="navbar-brand logo-small">
							<img src="{{ asset('frontend/assets/img/logo-one.png') }}" style="max-width: 73%;height: 50px;" alt="Logo">
						</a>
							@php
    $user_id = session()->get('user_id');
    $userdet = null;

    if (isset($user_id) && !empty($user_id)) {
        $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
        $type = $userdet->user_type;
    }
@endphp
							 @php
                  use App\Models\frontend\RecyclableAskReviews;
                   use App\Models\frontend\RecyclablePost;
                   use App\Models\frontend\RecyclableReview;
                    use App\Models\frontend\ReusableAskReview;
        use App\Models\frontend\ReusableReview;

        $userId = session()->get('user_id');
    $notifications = [];
    $notificationCount = 0;
$conreviews = RecyclableReview::where('login_user_id', $userId)->first();



    if ($userId) {


        $notifications = RecyclableAskReviews::where('user_id', $userId)
                        ->where(function($query) {
                            $query->where('flag', 'asked')
                                  ->whereNull('status')
                                  ->orWhere('change_review', 'changereview');
                        })
                        ->get();

        $notificationCount = $notifications->count();
    }
@endphp
<div class="mobile-header">
<div class="header-btn d-md-none d-flex align-items-center">
    @if ($userdet)
    <div class="provider-head-links">
						<a href="javascript:void(0);" class="d-flex align-items-center justify-content-center me-2 notify-link" data-bs-toggle="dropdown"><i class="feather-bell" style="font-size: 28px;"></i></a>
						<div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
							<div class="d-flex dropdown-body align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
								<h6 class="notification-title">Notifications
								 @if($notificationCount > 0)
								<span class="fs-18 text-gray"> {{ $notificationCount }}</span>
								@endif
								</h6>

							</div>

						@if ($notificationCount > 0)
    <div class="noti-content">
        <div class="d-flex flex-column">
            @foreach ($notifications as $notification)
                @php
                    $reviewModel = $notification->source === 'recyclable'
                        ? \App\Models\frontend\RecyclableReview::where('login_user_id', $userId)->first()
                        : \App\Models\frontend\ReusableReview::where('login_user_id', $userId)->first();

                    $url = is_null($notification->status)
                        ? url($notification->source . 'postprofile') . '/' . $notification->login_user_id . '?review_id=' . $notification->id
                        : url('edit-' . $notification->source . '-review/' . $notification->login_user_id . '/' . optional($reviewModel)->id . '?review_id=' . $notification->id);
                @endphp

                <div class="border-bottom mb-3 pb-3">
                    <a href="{{ $url }}">
                        <div class="d-flex">
                            <span class="avatar avatar-lg me-2 flex-shrink-0">
                                <img src="{{ asset('assets/img/profiles/avatar-52.jpg') }}" alt="Profile" class="rounded-circle">
                            </span>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1 w-100">
                                        <span class="text-dark fw-semibold">{{ $notification->name }}</span>
                                        @if (is_null($notification->status))
                                            asked for a review.
                                        @elseif ($notification->change_review == 'changereview')
                                            asked to change review.
                                        @endif
                                    </p>
                                    <span class="d-flex justify-content-end">
                                        <i class="ti ti-point-filled text-primary"></i>
                                    </span>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p class="text-center">No notifications available.</p>
@endif


							<!--<div class="d-flex p-0 notification-footer-btn">-->
							<!--	<a href="#" class="btn btn-light rounded  me-2">Cancel</a>-->
							<!--	<a href="#" class="btn btn-dark rounded ">View </a>-->
							<!--</div>-->
						</div>
					</div>
        <div class="dropdown">
            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="booking-user d-flex align-items-center">
                    <span class="user-img">
                        <img src="{{ asset('frontend/assets/img/user.png') }}" alt="{{ $userdet->name }}">
                    </span>
                    <span class="user-name ms-2 d-none">{{ $userdet->name }}</span>
                </div>
            </a>
            <ul class="dropdown-menu p-2">
                 <li>
                <a href="{{ url('profile') . '/' . $user_id }}"  >
                     My Profile
                </a>
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
    @else

    @endif
</div>
<!--<ul class="nav header-navbar-rht">-->
<!--            <li class="nav-item">-->
<!--                <a class="btn btn-lg btn-linear-primary" href="{{ route('user_register') }}"><i class="fa fa-user-plus me-2"></i> Register</a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="btn btn-lg btn-linear-primary" href="{{ route('consumer_login') }}">-->
<!--                    <i class="fa-regular fa-circle-user me-2"></i>Login-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
</div>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="{{url('/')}}" class="menu-logo">
								<img src="{{ asset('frontend/assets/img/logo-one.png') }}" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>

						</div>
						<ul class="main-nav">
						 <li class="nav-item">
								<a class="nav-link" href="{{url('/')}}">Home</a>
							</li>
							 <li class="nav-item">
								<a class="nav-link" href="{{route('service')}}">Services</a>
							</li>
							<li class="has-submenu ">
								<a href="javascript:void(0);">About Us <i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li class="active"><a href="{{route('about')}}">About Us</a></li>
										<li><a href="{{route('howitsworks')}}">How it Works</a></li>

											<li><a href="{{route('blog')}}">Blogs</a></li>
											<li><a href="{{route('workwithus')}}">Work with us</a></li>
										<li><a href="{{route('contact')}}">Contact</a></li>
										 <!--	@if (session()->has('user_id'))-->
											<!--<li><a href="{{route('repairmap')}}">The Repair Map</a></li>-->
											<!--	@else-->
											<!--		<li><a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}">The Repair Map</a></li>-->
											<!--			@endif-->
												<li><a href="{{route('faq')}}">FAQs</a></li>



								</ul>
							</li>






								 @if (session()->has('user_id'))
								 @else
									<li class="nav-item d-md-none"><a href="{{route('consumer_login')}}">Login</a></li>
										<li class="nav-item d-md-none"><a href="{{route('user_register')}}">Register</a></li>
										@endif
						  <li class="nav-item">
                        <div id="google_translate_element"></div>
                   </li>
						</ul>

					</div>
@php
    $user_id = session()->get('user_id');
    $userdet = null;

    if (isset($user_id) && !empty($user_id)) {
        $userdet = \App\Models\frontend\EcosansarUsers::where('id', $user_id)->first();
        $type = $userdet->user_type;
    }
@endphp
<!--notification display-->
@php




    use Illuminate\Support\Collection;

    $userId = session()->get('user_id');
    $notifications = collect();
    $notificationCount = 0;

    if ($userId) {
        $recyclable = RecyclableAskReviews::where('user_id', $userId)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('flag', 'asked')
                      ->whereNull('status');
                })->orWhere(function ($q) {
                    $q->where('flag', 'asked')
                      ->where('change_review', 'changereview');
                });
            })
            ->get()
            ->map(function ($item) {
                $item->source = 'recyclable';
                return $item;
            });

       $reusable = ReusableAskReview::where('user_id', $userId)
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->where('flag', 'asked')
              ->whereNull('status');
        })->orWhere(function ($q) {
            $q->where('flag', 'asked')
              ->where('change_review', 'changereview');
        });
    })
    ->get()
    ->map(function ($item) {
        $item->source = 'reusable';
        return $item;
    });


        $notifications = $recyclable->merge($reusable)->sortByDesc('created_at')->values(); // reset keys

        $notificationCount = $notifications->count();
    }

@endphp
<div class="desktop-header">
<div class="header-btn   d-flex align-items-center">
    @if ($userdet)
    <div class="provider-head-links">
						<a href="javascript:void(0);" class="d-flex align-items-center justify-content-center me-2 notify-link" data-bs-toggle="dropdown"><i class="feather-bell" style="font-size: 28px;"></i></a>
						<div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
							<div class="d-flex dropdown-body align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
								<h6 class="notification-title">Notifications
								 @if($notificationCount > 0)
								<span class="fs-18 text-gray"> {{ $notificationCount }}</span>
								@endif
								</h6>

							</div>

						@if ($notificationCount > 0)
    <div class="noti-content">
        <div class="d-flex flex-column">
            @foreach ($notifications as $notification)
                @php
                    $reviewModel = $notification->source === 'recyclable'
                        ? \App\Models\frontend\RecyclableReview::where('login_user_id', $userId)->first()
                        : \App\Models\frontend\ReusableReview::where('login_user_id', $userId)->first();

                    $url = is_null($notification->status)
                        ? url($notification->source . 'postprofile') . '/' . $notification->login_user_id . '?review_id=' . $notification->id
                        : url('edit-' . $notification->source . '-review/' . $notification->login_user_id . '/' . optional($reviewModel)->id . '?review_id=' . $notification->id);
                @endphp

                <div class="border-bottom mb-3 pb-3">
                    <a href="{{ $url }}">
                        <div class="d-flex">
                            <span class="avatar avatar-lg me-2 flex-shrink-0">
                                <img src="{{ asset('assets/img/profiles/avatar-52.jpg') }}" alt="Profile" class="rounded-circle">
                            </span>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1 w-100">
                                        <span class="text-dark fw-semibold">{{ $notification->name }}</span>
                                        @if (is_null($notification->status))
                                            asked for a review.
                                        @elseif ($notification->change_review == 'changereview')
                                            asked to change review.
                                        @endif
                                    </p>
                                    <span class="d-flex justify-content-end">
                                        <i class="ti ti-point-filled text-primary"></i>
                                    </span>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p class="text-center">No notifications available.</p>
@endif


							<!--<div class="d-flex p-0 notification-footer-btn">-->
							<!--	<a href="#" class="btn btn-light rounded  me-2">Cancel</a>-->
							<!--	<a href="#" class="btn btn-dark rounded ">View </a>-->
							<!--</div>-->
						</div>
					</div>
        <div class="dropdown">
            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="booking-user d-flex align-items-center">
                    <span class="user-img">
                        <img src="{{ asset('frontend/assets/img/user.png') }}" alt="{{ $userdet->name }}">
                    </span>
                    <span class="user-name ms-2 d-none d-md-inline d-none d-md-inline">{{ $userdet->name }}</span>
                </div>
            </a>
            <ul class="dropdown-menu p-2">
                 <li>
                <a href="{{ url('profile') . '/' . $user_id }}"  >
                     My Profile
                </a>
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
    @else
        <ul class="nav header-navbar-rht">
            <li class="nav-item">
                <a class="btn btn-lg btn-linear-primary" href="{{ route('user_register') }}"><i class="fa fa-user-plus me-2"></i> Register</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-lg btn-linear-primary" href="{{ route('consumer_login') }}">
                    <i class="fa-regular fa-circle-user me-2"></i>Login
                </a>
            </li>
        </ul>
    @endif
</div>
</div>


				</nav>
			</div>
		</header>

