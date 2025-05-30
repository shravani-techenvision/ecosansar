
@include('frontend.include.header')



	<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center"
	style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover;
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Profile</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item">User</li>
							<li class="breadcrumb-item active" aria-current="page">Profile</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
				<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<!-- Page Wrapper -->
	<div class="page-wrapper">
		<div class="content">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-3 col-lg-4 theiaStickySidebar">
						<div class="card user-sidebar mb-4 mb-lg-0">
                            <div class="card-header user-sidebar-header mb-4">
                                <div class="d-flex justify-content-center align-items-center flex-column">
                                    <span class="user rounded-circle avatar avatar-xxl mb-2">
                                        <img src="{{asset('frontend/assets/img/user.png') }}" class="img-fluid rounded-circle" alt="Img">
                                    </span>
                                    <h6 class="mb-2">{{$users->name}}</h6>

                                </div>
                            </div>
							<div class="card-body user-sidebar-body p-0">
							<ul>
                              <li class="mb-4">
                                <a href="#" class="d-flex align-items-center" onclick="showSection('profile-info')">
                                <i class="fa-regular fa-circle-user me-2"></i>  Profile Info
                                </a>
                              </li>
                              <li class="mb-4">
                                <a href="#" class="d-flex align-items-center" onclick="showSection('active-listings')">
                               <i class="fa fa-list me-2"></i> My Active Listings
                                </a>
                              </li>
                              <li class="mb-4">
                                <a href="#" class="d-flex align-items-center" onclick="showSection('deactivated-listings')">
                                 <i class="fa fa-ban me-2"></i>  Deactivated Listings
                                </a>
                              </li>
                              <li class="mb-4">
                                <a href="#" class="d-flex align-items-center" onclick="showSection('fulfilled-listings')">
                                <i class="fa fa-clipboard-check me-2 "></i> Fulfilled Listings
                                </a>
                              </li>
                              <li class="mb-4">
                                        <a href="#" class="d-flex align-items-center" onclick="showSection('reviews-recieved')">
                                            <i class="fa fa-comment me-2"></i>
                                           Reviews Received
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="#" class="d-flex align-items-center" onclick="showSection('reviews-given')">
                                             <i class="fa fa-comment-dots me-2"></i>
                                           Reviews Given
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="#" class="d-flex align-items-center" onclick="showSection('connections')">
                                           <i class="fa fa-users me-2"></i>
                                             Connections Initiated by Me
                                        </a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="#" class="d-flex align-items-center" onclick="showSection('my-connections')">
                                           <i class="fa fa-users me-2"></i>
                                            Connection Requests Received
                                        </a>
                                    </li>

                                    <li class="mb-0">
                                        <a href="{{ route('user_logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center">
                                            <!--<i class="ti ti-logout me-2"></i>-->
                                            <i class="fa fa-sign-out-alt me-2"></i>
                                            Logout
                                        </a>
                                    </li>
                            </ul>

							</div>
						</div>
					</div>
					<div class="col-xl-9 col-lg-8">



                        <div id="profile-info" class="content-section">
                             <form class="form " action="{{ $url }}" method="post" enctype="multipart/form-data">
                            @csrf
                             <h3>General Information</h3>
							<div class="row mb-4">
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Name</label>
										<input type="text" class="form-control" name="name" id="name" placeholder=" Name" value="@if(isset($users->name)){{ $users->name }}@else{{ old('name')}}@endif">
									       @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
									<label class="form-label">Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($users->email)){{ $users->email }}@else{{ old('email')}}@endif">
									 @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
									<label class="form-label">Mobile Number</label>
									<input readonly type="text" class="form-control" name="mobile" id="mobile" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value="@if(isset($users->mobile)) {{ $users->mobile }}@else{{ old('mobile')}}@endif">
									</div>
								</div>
    							<div class="col-md-6  ">
    								<div class="mb-3">
    									<label class="form-label d-block">Address</label>
    									<textarea class="form-control" rows="5"  name="address"
                                    id="address"
                                    placeholder="Address">{{ old('address', $users->address ?? '') }}</textarea>
                                  @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                  @endif
    								</div>
    							</div>
						</div>

                        <div class="acc-submit d-flex justify-content-end align-items-center">

                       <button type="submit" class="btn btn-lg btn-linear-primary ">Save Changes  </button>
                        </div>
                        </form>
                        </div>

                         <div id="active-listings" class="content-section d-none">

						<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							  <h3>My Active Listings</h3>

						</div>

						<div class="row  ">
						    	@if($uniqueListings->count() > 0)
						@foreach ($uniqueListings as $listing)
            						@php
                // Decide the detail route
                $detailRoute = strtolower($listing->source) === 'reusable'
                    ? 'reusable_listing_details'
                    : 'recyclable_listing_details';

                // Decide the image folder based on source
                $folder = strtolower($listing->source) === 'reusable' ? 'Reusableposts/' : 'Recyclableposts/';

                // Generate the image path
                $imagePath = !empty($listing->resource_img) ? $folder . $listing->resource_img : null;

                // Check if the image exists on S3
                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                            ? Storage::disk('s3')->url($imagePath)
                            : asset('frontend/assets/img/ecosansar.png');
            @endphp

                            <div class="col-xxl-4 col-md-6">
                                <div class="card p-0">
                                    <div class="card-body p-0">
                                        <div class="img-sec-2 w-100" style="aspect-ratio: 14 / 9; overflow: hidden;">
                                            <a href="{{ url($detailRoute.'/'.$listing->id) }}">


                                                <img src=" {{ $imageUrl }}" class="img-fluid w-100 h-100" alt="img" style="object-fit: cover;">
                                            </a>
                                             <div class="image-tag d-flex justify-content-between align-items-center w-100 px-2" style="position: absolute; top: 10px; left: 0; right: 0; z-index: 10;">
    <span class="trend-tag-2">{{ ucfirst($listing->source) }}</span>
    <span class="trend-tag-2">{{ ucfirst($listing->sale_giveaway) }}</span>
</div>
                                        </div>
                                        <div class="img-content p-3">
                                            <h6 class="fs-16 mb-3 text-truncate">
                                                <a href="{{ url($detailRoute.'/'.$listing->id) }}">{{ $listing->resource_name }}</a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-md me-2">
                                                        <img src="{{asset('frontend/assets/img/user.png') }}" class="img-fluid rounded-circle" alt="user">
                                                    </span>
                                                    <div class="user-id">
                                                        <h6 class="fs-14 ">{{ $listing->name }}</h6>
                                                        <span class="fs-12"><i class="ti ti-map-pin me-1"></i>{{ Str::limit($listing->address, 15, '...') }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column align-items-center">
                                                    <!--<a href="{{ url('recyclable_listing_details/'.$listing->id) }}" class="btn btn-light btn-sm"> View Details</a>-->
                                                     <a href="#" class="btn btn-dark btn-sm bus-deactivate-post mb-2"
                                                     data-post-id="{{ $listing->id }}"
                                                     data-post-type="{{ strtolower($listing->source) }}"> Deactivate</a>
                                                      <a href="#" style="background-color:white;" class="btn btn-light btn-sm bus-reactivate-post mb-2"
                                                      data-post-id="{{ $listing->id }}"
                                                       data-post-type="{{ strtolower($listing->source) }}">Reactivate</a>
                                                      <a href="#"
                                                       style="background-color:#8eb66f;"
                                                       class="btn btn-light btn-sm mark-fulfilled"
                                                       data-post-id="{{ $listing->id }}"
                                                       data-post-type="{{ strtolower($listing->source) }}">Is Fulfilled</a>

                                                </div>

                                            </div>

                                                <!-- <div class="d-flex justify-content-center align-items-center gap-3 mt-3">-->
                                                <!--    <a href="#" class="btn btn-dark btn-sm bus-deactivate-post" data-post-id="{{ $listing->id }}"> Deactivate</a>-->
                                                <!--      <a href="#" style="background-color:white;" class="btn btn-light btn-sm bus-reactivate-post" data-post-id="{{ $listing->id }}">Reactivate</a>-->
                                                <!--</div>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
    <p>No listings found.</p>
@endif

						</div>
					@if($uniqueListings->count() > 10)
			<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($uniqueListings->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $uniqueListings->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($uniqueListings->getUrlRange(1, $uniqueListings->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $uniqueListings->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($uniqueListings->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
            @else
            @endif

                        </div>

                        <div id="deactivated-listings" class="content-section d-none">
                         	<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							  <h3>Deactivated Listings</h3>

						</div>
						<div class="row  ">
						    	@if($deactiveuniqueListings->count() > 0)
						@foreach ($deactiveuniqueListings as $listing)
							@php
                // Decide the detail route
                $detailRoute = strtolower($listing->source) === 'reusable'
                    ? 'reusable_listing_details'
                    : 'recyclable_listing_details';

                // Decide the image folder based on source
                $folder = strtolower($listing->source) === 'reusable' ? 'Reusableposts/' : 'Recyclableposts/';

                // Generate the image path
                $imagePath = !empty($listing->resource_img) ? $folder . $listing->resource_img : null;

                // Check if the image exists on S3
                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                            ? Storage::disk('s3')->url($imagePath)
                            : asset('frontend/assets/img/ecosansar.png');
            @endphp
                            <div class="col-xxl-4 col-md-6">
                                <div class="card p-0">
                                    <div class="card-body p-0">
                                        <div class="img-sec-2 w-100" style="aspect-ratio: 14 / 9; overflow: hidden;">
                                            <a href="{{ url($detailRoute.'/'.$listing->id) }}">


                                                <img src=" {{ $imageUrl }}" class="img-fluid w-100 h-100" alt="img" style="object-fit: cover;">
                                            </a>
                                           <div class="image-tag d-flex justify-content-between align-items-center w-100 px-2" style="position: absolute; top: 10px; left: 0; right: 0; z-index: 10;">
    <span class="trend-tag-2">{{ ucfirst($listing->source) }}</span>
    <span class="trend-tag-2">{{ ucfirst($listing->sale_giveaway) }}</span>
</div>


                                        </div>
                                        <div class="img-content p-3">
                                            <h6 class="fs-16 mb-3 text-truncate">
                                                <a href="{{url($detailRoute.'/'.$listing->id)}}">{{ $listing->resource_name }}</a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-md me-2">
                                                        <img src="{{asset('frontend/assets/img/user.png') }}" class="img-fluid rounded-circle" alt="user">
                                                    </span>
                                                    <div class="user-id">
                                                        <h6 class="fs-14 ">{{ $listing->name }}</h6>
                                                        <span class="fs-12"><i class="ti ti-map-pin me-1"></i>{{ Str::limit($listing->address, 15, '...') }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <!--<a href="{{ url('recyclable_listing_details/'.$listing->id) }}" class="btn btn-light btn-sm"> View Details</a>-->
                                                     <a href="#" class="btn btn-light btn-sm bus-reactivate-post" data-post-id="{{ $listing->id }}"
                                                     data-post-type="{{ strtolower($listing->source) }}">Reactivate</a>
                                                </div>
                                            </div>
                                             <!--<div class="d-flex justify-content-between align-items-center">-->

                                             <!--         <a href="#" class="btn btn-light btn-sm bus-reactivate-post" data-post-id="{{ $listing->id }}">Reactivate</a>-->
                                             <!--   </div>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
@else
    <p>No listings found.</p>
@endif

						</div>
							@if($deactiveuniqueListings->count() > 10)
				            	<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($deactiveuniqueListings->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $deactiveuniqueListings->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($deactiveuniqueListings->getUrlRange(1, $deactiveuniqueListings->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $deactiveuniqueListings->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($deactiveuniqueListings->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
                            @else
                            @endif
                        </div>


                        <!--fulfilled listings start-->
                         <div id="fulfilled-listings" class="content-section d-none">
                         	<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							  <h3>Fulfilled Listings</h3>

						</div>
						<div class="row  ">
						    	@if($fulfilledListings->count() > 0)
						@foreach ($fulfilledListings as $listing)
							@php
                // Decide the detail route
                $detailRoute = strtolower($listing->source) === 'reusable'
                    ? 'reusable_listing_details'
                    : 'recyclable_listing_details';

                // Decide the image folder based on source
                $folder = strtolower($listing->source) === 'reusable' ? 'Reusableposts/' : 'Recyclableposts/';

                // Generate the image path
                $imagePath = !empty($listing->resource_img) ? $folder . $listing->resource_img : null;

                // Check if the image exists on S3
                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                            ? Storage::disk('s3')->url($imagePath)
                            : asset('frontend/assets/img/ecosansar.png');
            @endphp
                            <div class="col-xxl-4 col-md-6">
                                <div class="card p-0">
                                    <div class="card-body p-0">
                                        <div class="img-sec-2 w-100" style="aspect-ratio: 14 / 9; overflow: hidden;">
                                            <a href="{{ url($detailRoute.'/'.$listing->id) }}">


                                                <img src=" {{ $imageUrl }}" class="img-fluid w-100 h-100" alt="img" style="object-fit: cover;">
                                            </a>
                                           <div class="image-tag d-flex justify-content-between align-items-center w-100 px-2" style="position: absolute; top: 10px; left: 0; right: 0; z-index: 10;">
    <span class="trend-tag-2">{{ ucfirst($listing->source) }}</span>
    <span class="trend-tag-2">{{ ucfirst($listing->sale_giveaway) }}</span>
</div>


                                        </div>
                                        <div class="img-content p-3">
                                            <h6 class="fs-16 mb-3 text-truncate">
                                                <a href="{{url($detailRoute.'/'.$listing->id)}}">{{ $listing->resource_name }}</a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-md me-2">
                                                        <img src="{{asset('frontend/assets/img/user.png') }}" class="img-fluid rounded-circle" alt="user">
                                                    </span>
                                                    <div class="user-id">
                                                        <h6 class="fs-14 ">{{ $listing->name }}</h6>
                                                        <span class="fs-12"><i class="ti ti-map-pin me-1"></i>{{ Str::limit($listing->address, 15, '...') }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                             <!--<div class="d-flex justify-content-between align-items-center">-->

                                             <!--         <a href="#" class="btn btn-light btn-sm bus-reactivate-post" data-post-id="{{ $listing->id }}">Reactivate</a>-->
                                             <!--   </div>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
@else
    <p>No listings found.</p>
@endif

						</div>
							@if($fulfilledListings->count() > 10)
				            	<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($fulfilledListings->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $fulfilledListings->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($fulfilledListings->getUrlRange(1, $fulfilledListings->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $fulfilledListings->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($fulfilledListings->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
                            @else
                            @endif
                        </div>
                        <!--fulfilled listings end-->






                        <div id="reviews-recieved" class="content-section d-none">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							<h4 class="mb-3">Reviews</h4>
						</div>
						<div class="row ">
						@if($reviewsrecieved->count() > 0)
    @foreach($reviewsrecieved as $review)
        <div class="col-xxl-12 col-lg-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="d-md-flex align-items-center review" data-id="{{ $review->id }}" data-source="{{ $review->source }}">
                        <div class="review-widget d-sm-flex flex-fill">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex">
                                    <span class="review-img me-2">
                                        <img src="{{ asset('frontend/assets/img/user.png') }}" class="rounded img-fluid" alt="User Image">
                                    </span>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fs-14 me-2">{{ $review->service_name ?? ' ' }}</h6>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span>
                                                        <i class="ti ti-star{{ $i <= $review->rating ? '-filled text-warning' : '' }}"></i>
                                                    </span>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                             @php
                                                $user = \App\Models\frontend\EcosansarUsers::find($review->login_user_id);
                                            @endphp
                                            <h6 class="fs-13 me-2">{{ $user->name ?? 'Anonymous' }},</h6>
                                            <span class="fs-12">{{ date('F j, Y h:i A', strtotime($review->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-icon d-inline-flex">
                            <a href="javascript:void(0);"    class="me-2 change-review" title="Change Review"><i class="ti ti-edit"></i></a>
                        </div>
                    </div>

                    <div>
                        <p class="fs-14">
                            {{ $review->message ?? 'No review available.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@else
    <p>No reviews found.</p>
@endif


						</div>
						@if($reviewsrecieved->count() > 10)
						<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($reviewsrecieved->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $reviewsrecieved->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($reviewsrecieved->getUrlRange(1, $reviewsrecieved->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $reviewsrecieved->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($enquiries->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
						@else
						@endif


                        </div>

                        <div id="reviews-given" class="content-section d-none">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							<h4>Reviews Given</h4>

						</div>
						<div class="row">
						    @if($reviewsgiven->count() > 0)
							<div class="col-12 ">
								<div class="table-responsive border">
									<table class="table mb-0">
										<thead class="thead-light">
											<tr>
												<th>Sr. No</th>
												<th>Title</th>
												<th>Ratings</th>
												<th>Review message  </th>
											    <th>Action</th>
											</tr>
										</thead>
										<tbody>
										  @foreach($reviewsgiven as $key => $review)
            <tr id="row_{{ $review->id }}">
                <td>{{ $key + 1 }}</td>
                <td id="title_{{ $review->id }}">{{ $review->title }}</td>
            <!--   <td id="rating_{{ $review->id }}" data-rating="{{ $review->rating }}">-->
            <!--    @for ($i = 1; $i <= 5; $i++)-->
            <!--        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>-->
            <!--    @endfor-->
            <!--</td>-->
            <td id="rating_{{ $review->id }}" data-rating="{{ $review->rating }}">
   @php
    $roundedRating = round($review->rating);
@endphp
@for ($i = 1; $i <= 5; $i++)
    <i class="fas fa-star"
       style="color: {{ $i <= $roundedRating ? '#ffc107' : '#ddd' }}"></i>
@endfor

</td>

                <td id="message_{{ $review->id }}">{{ $review->message }}</td>
                <td>
                    <!-- Edit Icon -->
                    <a href="javascript:void(0);" onclick="enableEdit({{ $review->id }})" id="editBtn_{{ $review->id }}">
                        <i class="fas fa-edit text-primary"></i>
                    </a>
                    <!-- Save & Cancel Buttons (Hidden Initially) -->
                    <button class="btn btn-dark d-none" id="saveBtn_{{ $review->id }}" onclick="saveChanges({{ $review->id }})">Save</button>
                    <button class="btn btn-light d-none" id="cancelBtn_{{ $review->id }}" onclick="cancelEdit({{ $review->id }})">Cancel</button>
                </td>
            </tr>
           @endforeach
										</tbody>
									</table>
								</div>
							</div>
							@else
							 <p>No reviews given.</p>
							@endif
						</div>
						@if($reviewsgiven->count() > 10)
							<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($reviewsgiven->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $reviewsgiven->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($reviewsgiven->getUrlRange(1, $reviewsgiven->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $reviewsgiven->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($reviewsgiven->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
@else
@endif
                            </div>
                             <div id="connections" class="content-section d-none">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							<h4> Connections</h4>

						</div>
						<div class="row">
						    	@if($ownenquiries->count() > 0)
							<div class="col-12 ">
								<div class="table-resposnive border">
									<table class="table mb-0">
										<thead class="thead-light">
											<tr>
												<th>Sr. No</th>
												<th>Name</th>
												<th>Mobile</th>

											</tr>
										</thead>
										<tbody><span hidden>{{ $i=1; }}</span>

										  @foreach($ownenquiries as $data)
                                        <tr>
                                             <td>{{ $i++ }}</td>
                                            <td>{{ $data->post_user_name }}</td>
                                            <td>{{ $data->post_mobile }}</td>
                                        </tr>
                                     @endforeach
										</tbody>
									</table>
								</div>
							</div>
							@else
							<p>No connections.</p>
							@endif
						</div>
							@if($ownenquiries->count() > 10)
						<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($ownenquiries->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $ownenquiries->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($ownenquiries->getUrlRange(1, $ownenquiries->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $ownenquiries->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($ownenquiries->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
@else
@endif
                        </div>
                         <div id="my-connections" class="content-section d-none">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							<h4>My Connections</h4>

						</div>
						<div class="row">
						    	@if($enquiries->count() > 0)
							<div class="col-12 ">
								<div class="table-resposnive border">
									<table class="table mb-0">
										<thead class="thead-light">
											<tr>
												<th>Sr. No</th>
												<th>Name</th>
												<th>Mobile</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody><span hidden>{{ $i=1; }}</span>

										  @foreach($enquiries as $data)
                                        <tr>
                                             <td>{{ $i++ }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->mobile }}</td>
                                            <td>

                                                <a
                                                    class="btn btn-primary btn-small btn-rounded icon shadow add-listing conreview @if($data->flag == 'asked') disabled @endif"
                                                    data-id="{{ $data->id }}"
                                                     data-source="{{ $data->source }}"
                                                    @if($data->flag == 'asked') data-disabled="true" @endif
                                                >
                                                     @if($data->flag == 'asked')
                                                        <strong>Asked for review
                                                        @if($data->loggedin_user_type === 'sab')
                                                                <i class="fab fa-whatsapp" style="margin-left: 5px;"></i>
                                                            @endif</strong>
                                                    @else
                                                        <strong>
                                                            Ask for review
                                                            @if($data->loggedin_user_type === 'sab')
                                                                <i class="fab fa-whatsapp" style="margin-left: 5px;"></i>
                                                            @endif
                                                        </strong>
                                                    @endif
                                                </a>

                                            </td>

                                        </tr>
                                     @endforeach
										</tbody>
									</table>
								</div>
							</div>
							@else
							<p>No connections.</p>
							@endif
						</div>
							@if($enquiries->count() > 10)
						<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($enquiries->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $enquiries->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($enquiries->getUrlRange(1, $enquiries->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $enquiries->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($enquiries->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ v->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>
@else
@endif
                        </div>
                    </div>
				</div>
					<div class="row mt-4 justify-content-center">
					<div class="col-lg-3 col-md-6 d-flex ">
						<div class="work-box card flex-fill aos" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon ">
									<span>
										<img src="{{asset('frontend/assets/img/icons/recycle-symbol.png')}}" alt="img">
									</span>
								</div>
								<h5>Recyclables  </h5>
								<p>Want to Give or Get Recyclables? Let’s Begin!
<br> We’ll do a quick pincode check for a nearby Collection Agent.</p>
							 	<a href="{{route('recyclable-choose_one')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">List or Browse Recyclables</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="work-box flex-fill card aos" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/material-recycling.png')}}" alt="img">
									</span>
								</div>
								<h5>  Packaging Reusables and its Materials</h5>
								<p>Got clean containers / packaging fit for reuse? Don’t toss them—list them! Need some? Just browse. </p>
							 	<a href="{{route('reusable-choose_one')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">List or Browse Reusables</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="work-box card flex-fill aos" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/repairing-service.png')}}" alt="img">
									</span>
								</div>
								<h5>Find a Repair Service near you </h5>
								<p>Before you throw it, see if you can fix it. Locate nearby informal sector repair heroes who can bring things back to life.</p>
							 	<a href="{{route('repairmap')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">View Repair Map</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 d-flex">
						<div class="work-box card flex-fill aos" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/location.png')}}" alt="img">
									</span>
								</div>
								<h5>Locate a Collection Agent near you</h5>
								<p>Find the nearest scrap dealer to sell or recycle materials. </p>
							 	<a href="{{route('findcollectionagent')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">Find & support your neighborhood waste warriors directly</a>
							</div>
						</div>
					</div>
					</div>
			</div>
		</div>
	</div>
	<!-- /Page Wrapper -->









 @include('frontend.include.footer')
 <script>


 function enableEdit(id) {
    let titleElement = document.getElementById(`title_${id}`);
    let ratingElement = document.getElementById(`rating_${id}`);
    let messageElement = document.getElementById(`message_${id}`);

    // Store original values for cancellation
    titleElement.setAttribute('data-original', titleElement.innerHTML);
    messageElement.setAttribute('data-original', messageElement.innerHTML);
    ratingElement.setAttribute('data-original', ratingElement.innerHTML);

    // Convert title & message to input fields
    titleElement.innerHTML = `<input type="text" class="form-control" id="edit_title_${id}" value="${titleElement.innerText}">`;
    messageElement.innerHTML = `<textarea class="form-control" id="edit_message_${id}">${messageElement.innerText}</textarea>`;

    // Get current rating from existing stars
    let currentRating = ratingElement.getAttribute('data-rating');

    // Convert rating to clickable stars with border
    let starsHtml = `<div class="star-container border p-1 rounded" id="star_container_${id}">`; // Add border container
    for (let i = 1; i <= 5; i++) {
        starsHtml += `<i class="fas fa-star star-edit ${i <= currentRating ? 'text-warning' : 'text-secondary'}"
                      data-value="${i}" data-id="${id}" onclick="selectRating(${id}, ${i})"></i>`;
    }
    starsHtml += `</div>`; // Close border container
    ratingElement.innerHTML = starsHtml;

    // Show Save & Cancel buttons, Hide Edit button
    document.getElementById(`editBtn_${id}`).classList.add('d-none');
    document.getElementById(`saveBtn_${id}`).classList.remove('d-none');
    document.getElementById(`cancelBtn_${id}`).classList.remove('d-none');

    // Store selected rating (default to existing rating)
    selectedRatings[id] = parseInt(currentRating);
}

// Store selected rating
let selectedRatings = {};

function selectRating(id, rating) {
    selectedRatings[id] = rating; // Store new rating value

    // Update stars visually
    let stars = document.querySelectorAll(`#rating_${id} .star-edit`);
    stars.forEach(star => {
        let starValue = star.getAttribute("data-value");
        star.classList.toggle("text-warning", starValue <= rating);
        star.classList.toggle("text-secondary", starValue > rating);
    });
}

function saveChanges(id) {
    let title = document.getElementById(`edit_title_${id}`).value;
    let message = document.getElementById(`edit_message_${id}`).value;
    let rating = selectedRatings[id] || document.querySelector(`#rating_${id} .text-warning`).length;

    $.ajax({
        url: "{{ route('update.review', ':id') }}".replace(':id', id),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            title: title,
            message: message,
            rating: rating
        },
        success: function(response) {
            if (response.success) {
                // Update UI with new values
                document.getElementById(`title_${id}`).innerText = title;
                document.getElementById(`message_${id}`).innerText = message;

                // Update stars display after saving
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    starsHtml += `<i class="fas fa-star ${i <= rating ? 'text-warning' : 'text-secondary'}"></i>`;
                }
                document.getElementById(`rating_${id}`).innerHTML = starsHtml;
                document.getElementById(`rating_${id}`).setAttribute('data-rating', rating);

                // Show success message
                let messageDiv = `<div class="alert alert-success">Record updated successfully!</div>`;
                document.getElementById(`row_${id}`).insertAdjacentHTML('beforeend', messageDiv);

                // Hide Save & Cancel buttons, Show Edit button
                document.getElementById(`editBtn_${id}`).classList.remove('d-none');
                document.getElementById(`saveBtn_${id}`).classList.add('d-none');
                document.getElementById(`cancelBtn_${id}`).classList.add('d-none');

                // Remove success message after 3 seconds
                setTimeout(() => document.querySelector(".alert").remove(), 3000);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to update record.');
        }
    });
}

function cancelEdit(id) {
    let titleElement = document.getElementById(`title_${id}`);
    let messageElement = document.getElementById(`message_${id}`);
    let ratingElement = document.getElementById(`rating_${id}`);

    // Restore original values
    titleElement.innerHTML = titleElement.getAttribute('data-original');
    messageElement.innerHTML = messageElement.getAttribute('data-original');
    ratingElement.innerHTML = ratingElement.getAttribute('data-original');

    // Hide Save & Cancel buttons, Show Edit button
    document.getElementById(`editBtn_${id}`).classList.remove('d-none');
    document.getElementById(`saveBtn_${id}`).classList.add('d-none');
    document.getElementById(`cancelBtn_${id}`).classList.add('d-none');
}



 </script>

 <script>
     function showSection(sectionId) {
  // Hide all sections
  document.querySelectorAll('.content-section').forEach(section => {
    section.classList.add('d-none');
  });

  // Show the selected section
  const sectionToShow = document.getElementById(sectionId);
  if (sectionToShow) {
    sectionToShow.classList.remove('d-none');
  }
}

 </script>

<script>
$(document).ready(function() {
    // Delegate the click event to dynamically bind the "Change Review" button
    $('.review').on('click', '.change-review', function() {
        // Get the review ID from the closest div containing the data-id attribute
        var reviewId = $(this).closest('.review').data('id');
        var source = $(this).closest('.review').data('source');
           // Determine the correct route based on source
        var url = '';
        if (source === 'recyclable') {
            url = '{{ url('change-recyclable-review-request') }}/' + reviewId;
        } else if (source === 'reusable') {
            url = '{{ url('change-reusable-review-request') }}/' + reviewId;
        } else {
            alert('Unknown enquiry source!');
            return;
        }




        // Send AJAX request
        $.ajax({
            url: url,  // URL of the route with reviewId
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

<script>
        $(document).ready(function() {
            $('.bus-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');
                var postType = $(this).data('post-type');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('recyclable-posts.deactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId,
                             post_type: postType
                        },
                        success: function(response) {
                            if (response.success) {

                                 location.reload();
                            } else {

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
                var postType = $(this).data('post-type');

                if (confirm('Are you sure you want to reactivate this post?')) {
                    $.ajax({
                        url: '{{ route('recyclable-posts.reactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId,
                            post_type: postType
                        },
                        success: function(response) {
                            if (response.success) {

                                 location.reload();
                            } else {

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
        $(document).on('click', '.mark-fulfilled', function (e) {
    e.preventDefault();

    const postId = $(this).data('post-id');
    const postType = $(this).data('post-type'); // 'recyclable' or 'reusable'

    $.ajax({
        url: "{{url('/mark-as-fulfilled')}}",
        method: 'POST',
        data: {
            post_id: postId,
            post_type: postType,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {

            // Optionally reload or change the button state
        },
        error: function () {
            alert('Something went wrong.');
        }
    });
});

    </script>

    <!-- ask review start-->
<script>
    $(document).on('click', '.conreview', function(event) {
        var button = $(this);

        if (button.is(':disabled')) {
            event.preventDefault();
            return;
        }

        var id = button.data('id');
        var source = button.data('source');
        var url = '';

        if (source === 'recyclable') {
            url = '{{ url('send-review-request') }}/' + id;
        } else if (source === 'reusable') {
            url = '{{ url('send-reusable-review-request') }}/' + id;
        } else {
            alert('Unknown enquiry source!');
            return;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (response.user_type === 'sab') {
                        let shareText = `Please share your feedback on ${response.post_name}'s service:\n{{ url('/recyclablepostprofile') }}/${response.post_user_id}?review_id=${response.review_id}`;
                        let encodedText = encodeURIComponent(shareText);
                        let whatsappUrl = `https://wa.me/?text=${encodedText}`;

                        // Open WhatsApp directly
                        window.open(whatsappUrl, '_blank');
                    }

                    // Always update button text and disable it
                    button.html('<strong>Asked for review</strong>');
                    button.prop('disabled', true);
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


 <!--  ask review end-->












