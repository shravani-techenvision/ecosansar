 @include('frontend.include.header')
 <style>
     .image-wrapper {
    display: inline-block;
    position: relative;
}

.default-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5); /* dark transparent overlay */
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: bold;
    font-size: 16px;
    pointer-events: none; /* allows clicks to pass through */
}
.clients-eight-span h3 {
    color:#8eb66f;
}
.clients-eights-all p {
    text-align:center;
}
.custom-caption {
  height: 60%; /* default for larger screens */
}

@media (max-width: 767.98px) {
  .custom-caption {
    height: 80% !important; /* apply for mobile screens */
  }
  .section-heading {
    margin-bottom: 30px;

}
}
@media (max-width: 425px) {
    .mob-content {
        display: none !important;
    }
    .toggle-card:hover .mob-content {
        display: block;
    }
    .work-box h5{
        font-size: 14px;
    }
    .work-icon span{
        height: 60px;
        width: 60px;;
    }
    .card .card-body {
        padding: 5px;
    }
}

 </style>
 <!-- Hero Section -->
		<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
 <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{asset('frontend/assets/img/banner1.png')}}" class="d-block w-100" alt="..."  >
      <div class="carousel-caption   d-flex justify-content-center align-items-center custom-caption"   >
        <h1   style="color: white !important; height: 93%;" >The ZeroWaste Community Tool - Where waste meets value - and everyone’s included.</h1>

      </div>
    </div>
    <div class="carousel-item">
      <img src="{{asset('frontend/assets/img/banner2.png')}}" class="d-block w-100" alt="..."  >
      <div class="carousel-caption   d-flex justify-content-center align-items-center custom-caption"   >
        <h1   style="color: white !important; height: 93%;" >Work with the Backbone of Circular Economy - the on ground waste collectors</h1>

      </div>
    </div>
    <div class="carousel-item">
      <img src="{{asset('frontend/assets/img/banner3.png')}}" class="d-block w-100" alt="..."  >
      <!--<div class="carousel-caption d-none d-md-block d-flex justify-content-center align-items-center" style="height: 60%;" >-->
       <div class="carousel-caption   d-flex justify-content-center align-items-center custom-caption"   >
        <h1  style="color: white !important; height: 93%;" >Reuse-first approach, right at source for packaging materials</h1>

      </div>
    </div>
    <div class="carousel-item">
      <img src="{{asset('frontend/assets/img/banner4.png')}}" class="d-block w-100" alt="..."  >
      <div class="carousel-caption   d-flex justify-content-center align-items-center custom-caption"  >
        <h1   style="color: white !important; height: 93%;">   Create your own zerowaste community helping onboard your local waste warriors</h1>

      </div>
    </div>
  </div>

</div>
		<!-- /Hero Section -->

 	<!-- Work Section -->
		<section class="work-section pt-0 mb-0" >

			<div class="container">
				 <div class="row">
					<div class="col-md-12 text-center">
						<div class="section-heading aos" data-aos="fade-up">
						    <h2 class="text-center">Start managing waste responsibly using any of the 4 options below: </h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 col-6  d-flex ">
						<div class="work-box card flex-fill aos toggle-card" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon ">
									<span>
										<img src="{{asset('frontend/assets/img/icons/recycle-symbol.png')}}" alt="img">
									</span>
								</div>
								<h5>Recyclables </h5>
								<p class="mob-content">Want to Give or Get Recyclables? Let’s Begin! <br> We’ll do a quick pincode check for a nearby Collection Agent.</p>
							 	<a href="{{ route('recyclable-choose_one') }}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                    <span class="d-none d-md-inline">List or Browse Recyclables</span>
                                    <span class="d-inline d-md-none">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-6 d-flex">
						<div class="work-box flex-fill card aos toggle-card" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/material-recycling.png')}}" alt="img">
									</span>
								</div>
								<h5>Packaging Reusables</h5>
								<p class="mob-content">Got clean containers / packaging fit for reuse? Don’t toss them—list them for someone else to reuse! Need some? Just browse. </p>
							 	<a href="{{route('reusable-choose_one')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                    <span class="d-none d-md-inline">List or Browse Reusables</span>
                                    <span class="d-inline d-md-none">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
							</div>
						</div>
					</div>
					</div>
						<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 col-6 d-flex">
						<div class="work-box card flex-fill aos toggle-card" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/repairing-service.png')}}" alt="img">
									</span>
								</div>
								<h5>Find a Repair Service near you</h5>
								<p class="mob-content">Before you throw it, see if you can fix it. Locate nearby informal sector repair heroes who can bring things back to life.</p>
								@if (session()->has('user_id'))
							 	<a href="{{route('repairmap')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                     <span class="d-none d-md-inline">View Repair Map</span>
                                    <span class="d-inline d-md-none">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
							 	@else
							 	<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                    <span class="d-none d-md-inline">View Repair Map</span>
                                    <span class="d-inline d-md-none">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
							 	@endif
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-6 d-flex">
						<div class="work-box card flex-fill aos toggle-card" data-aos="fade-up">
							<div class="card-body">
								<div class="work-icon">
									<span>
										<img src="{{asset('frontend/assets/img/icons/location.png')}}" alt="img">
									</span>
								</div>
								<h5>Locate a Collection Agent near you</h5>
								<p class="mob-content">Find & support your neighborhood waste warriors directly </p>
								@if (session()->has('user_id'))
							 	<a href="{{route('findcollectionagent')}}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                    <span class="d-none d-md-inline">Find Collection Agents</span>
                                    <span class="d-inline d-md-none">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
							 	@else
							 		<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="btn btn-lg btn-linear-primary w-100 mt-2">
                                         <span class="d-none d-md-inline">Find Collection Agents</span>
                                        <span class="d-inline d-md-none">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </a>
							 	@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /Work Section -->
	 		<!-- Work Section -->
		<section class="work-section-two" style="background-color:#F4F5F5 !important; margin: 0">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="section-heading sec-header aos" data-aos="fade-up">
							<h2>How It Works</h2>

						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6">
						<div class="work-wrap-box work-first aos" data-aos="fade-up">
							<div class="work-icon flow">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/registartion.gif') }}" alt="img">
								</span>
							</div>
							<h5>Register on the Platform</h5>

						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="work-wrap-box work-last aos" data-aos="fade-up">
							<div class="work-icon flow">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/resources.gif') }}" alt="img">
								</span>
							</div>
							<h5>List your resources to <br> Buy / Sell</h5>

						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="work-wrap-box aos" data-aos="fade-up">
							<div class="work-flex">
								<div class="work-icon flow">
									<span>
										<img src="{{ asset('frontend/assets/img/icons/output-onlinegiftools.gif') }}" alt="img">
									</span>
								</div>
								<h5>Connect with interested parties to directly trade waste-to-value resources</h5>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /Work Section -->


		<!-- Feature Section -->
		<section class="feature-section" >

			<div class="container">
				<div class="section-heading">
					<div class="row align-items-center">

							<h2 class="text-center">What can you list</h2>
					</div>
				</div>
				<h3 class="mb-3 text-center">RECYCLABLES</h3>
				<div class="row justify-content-center">
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/paper.png') }}" alt="img">
								</span>
							</div>
							<h5>Paper</h5>
							<div class="feature-overlay" >

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div  class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/plastic.png') }}" alt="img">
								</span>
							</div>
							<h5>Plastic</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/soft-drink_7297368.png') }}" alt="img">
								</span>
							</div>
							<h5>Glass</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/Textile.png') }}" alt="img">
								</span>
							</div>
							<h5>Textile</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
                    <div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/ewaste.png') }}" alt="img">
								</span>
							</div>
							<h5>Ewaste</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>



				</div>
					<h3 class="mb-3 mt-4 text-center"> PACKAGING REUSABLES (CLEAN ONLY)   </h3>
				<div class="row justify-content-center">

					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/drum.png') }}" alt="img">
								</span>
							</div>
							<h5>Drums</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/carton.png') }}" alt="img">
								</span>
							</div>
							<h5>Cartons</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>

						<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/Delivery bags.png') }}" alt="img">
								</span>
							</div>
							<h5>Delivery Bags</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/jar.png') }}" alt="img">
								</span>
							</div>
							<h5 style="font-size: 19px;"> Glass jars and Bottles</h5>
							<div class="feature-overlay">
							</div>
						</div>
					</div>
                    			<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/bag.png') }}" alt="img">
								</span>
							</div>
							<h5 style="font-size: 19px;">Sacks</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-2 mb-3 px-1">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/blanket.png') }}" alt="img">
								</span>
							</div>
							<h5 style="font-size: 19px;">Product covers(plastic)</h5>
							<div class="feature-overlay">

							</div>
						</div>
					</div>


				</div>
			</div>
		</section>
		<!-- /Feature Section -->

		<section class="about-our-company"  >
			<!--<div class="our-company-img">-->
			<!--	<img src="{{ asset('frontend/assets/img/bg/wave.png') }}" alt="image" class="img-fluid">-->
			<!--</div>-->
			<div class="container">
				<div class="section-heading section-heading-six">
					<div class="row">
						<div class="col-md-9 col-12 aos" data-aos="fade-up">

							<h2>Grow Your Own ZeroWaste Community</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="our-company-six mt-4" >
						    <h5>Empower a Scrap Dealer or Waste Collector!</h5>
							<p>
								Help them register, add a shortcut to their home screen, and improve conversion of waste to value. Let us know once they're onboarded—we’ll support them in maximizing their benefits!
							</p>
						</div>
							<div class="our-company-six mt-4">
						    <h5>Boost Community Participation!
</h5>
							<p>
							Share our link and spread the word—more contributors mean better collections and lesser waste in landfills from your community!
							</p>
						</div>


					</div>
					<div class="col-lg-6 col-12">
						<div class="our-company-ryt d-none d-lg-block">

							<div class="our-company-bg  ">
								<img src="{{ asset('frontend/assets/img/bg/homepage.png') }}" alt="image" class="img-fluid  ">
							</div>

							<div class="our-company-two-content">
								<div class="company-two-top-content">
									<img src="{{ asset('frontend/assets/img/icons/trophy-svgrepo-com.svg') }}" alt="image" class="me-2">
									<h4 class="text-dark">7+</h4>

								</div>
								<p>Years Experience</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

 	<!-- Service Section -->
		<section class="service-section-two" style="background-color:#fff !important;">
			<div class="container">
				<div class="row align-items-center">

						<div class="section-heading-two">
							<h2 class="text-center">Recent Listings</h2>

						</div>

					<!--<div class="col-md-6 text-md-end aos" data-aos="fade-up">-->
					<!--	<a href="{{route('listings')}}" class="btn btn-primary btn-view rounded-pill">View All</a>-->
					<!--</div>-->
				</div>
				<h3 class="mb-0 mb-md-3 text-center">Recyclable Listings</h3>
				<!--<div class="row justify-content-center">-->
				<div class="row ">

				@foreach ($posts as $post)
    <div class="col-lg-3 col-md-6">
        <div class="service-widget service-two aos" data-aos="fade-up">
            <div class="service-img">
                @php
                                        // Check if $listing->resource_img is set and not empty
                                        $imagePath = !empty($post->resource_img) ? 'Recyclableposts/265x265/' . $post->resource_img : null;

                                        // Check if the image exists in the S3 bucket or fallback to default
                                        $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                    ? Storage::disk('s3')->url($imagePath)
                                                    : asset('frontend/assets/img/ecosansar.png');
                                    @endphp
                <a href="{{ url('recyclable_listing_details/'.$post->id) }}">
                  <img class="img-fluid serv-img" alt="Service Image" src="{{ $imageUrl }}">
                </a>
                <div class="fav-item">
                    <a href="#"><span class="item-cat">{{ $post->resource->resource_name ?? '' }}</span></a>
                    <!--<a href="javascript:void(0)" class="fav-icon">-->
                    <!--    <i class="feather-heart"></i>-->
                    <!--</a>-->
                </div>
                <!--<div class="item-info">-->
                <!--    <a href="#">-->
                <!--        <span class="item-img">-->
                <!--            <img src="{{ asset('frontend/assets/img/user.png') }}" class="avatar" alt="User">-->
                <!--            {{ $post->user->name ?? 'Unknown User' }}-->
                <!--        </span>-->
                <!--    </a>-->
                <!--</div>-->
            </div>
            <div class="service-content">

                <p>
                    <i class="feather-map-pin me-2" style="color: #FF5733;"></i>{{ Str::limit($post->address ?? '', 10, '...') }}
                     @isset($post->mobile)
                    <span class="rate">
    <i class="feather-phone me-2" style="color: green;"></i>
    ******{{ substr($post->mobile, -4) }}
</span>

                    @else
                    @endif
                </p>
                <div class="serv-info">
                    <div class="rating">
                      <span>
                                        @php
                                            $rating = round($post->average_rating ?? 0); // Rounded rating
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <i class="fas fa-star" style="color: #ffc107;"></i> {{-- Gold filled --}}
                                            @else
                                                <i class="fas fa-star" style="color: #ddd;"></i> {{-- Light gray empty --}}
                                            @endif
                                        @endfor
                                    </span>
                        <!--<span>({{ $post->reviews_count ?? 0 }})</span>-->
                    </div>
                    <h6>₹{{ $post->resource_price ?? '0.00' }}

                    </h6>
                </div>
            </div>
        </div>
    </div>
@endforeach


				</div>
					<div class="text-center mt-0 mt-md-4">
					@if (session()->has('user_id'))
					    <a href="{{route('listings')}}" class="btn btn-lg btn-linear-primary btn-responsive-width">View All Listings</a>
					@else
						<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="btn btn-lg btn-linear-primary btn-responsive-width">View All Listings</a>
					@endif
				</div>
				<hr>
					<h3 class="mb-0 mb-md-3  mt-4 text-center">Reusable Listings</h3>
				<div class="row ">

				@foreach ($reusableposts as $post)
    <div class="col-lg-3 col-md-6">
        <div class="service-widget service-two aos" data-aos="fade-up">
            <div class="service-img">

                @php
    $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;

    $isDefaultImage = false;
    if ($imagePath && Storage::disk('s3')->exists($imagePath)) {
        $imageUrl = Storage::disk('s3')->url($imagePath);
    } else {
        $imageUrl = asset('frontend/assets/img/ecosansar.png');
        $isDefaultImage = true;
    }
@endphp

<a href="{{ url('reusable_listing_details/'.$post->id) }}" class="image-wrapper position-relative">
    <img class="img-fluid serv-img" alt="Service Image" src="{{ $imageUrl }}">

    @if($isDefaultImage)
        <div class="default-overlay">
            <!--<span>No Image Available</span>-->
        </div>
    @endif
</a>

                <div class="fav-item">
                    <a href="#"><span class="item-cat">{{ $post->resource->reusable_resource_name ?? '' }}</span></a>
                    <!--<a href="javascript:void(0)" class="fav-icon">-->
                    <!--    <i class="feather-heart"></i>-->
                    <!--</a>-->
                </div>

            </div>
            <div class="service-content">

                <p>
                    <i class="feather-map-pin me-2" style="color: #FF5733;"></i>{{ Str::limit($post->address ?? '', 10, '...') }}
                    @isset($post->mobile)
                    <span class="rate">
                        <i class="feather-phone me-2"></i> ******{{ substr($post->mobile, -4) }}
                    </span>
                    @else
                    @endif
                </p>
                <div class="serv-info">
                    <div class="rating">
                      <span>
                                        @php
                                            $rating = round($post->average_rating ?? 0); // Rounded rating
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <i class="fas fa-star" style="color: #ffc107;"></i> {{-- Gold filled --}}
                                            @else
                                                <i class="fas fa-star" style="color: #ddd;"></i> {{-- Light gray empty --}}
                                            @endif
                                        @endfor
                                    </span>
                        <!--<span>({{ $post->reviews_count ?? 0 }})</span>-->
                    </div>
                    <h6>₹{{ $post->resource_price ?? '0.00' }}

                    </h6>
                </div>
            </div>
        </div>
    </div>
@endforeach


				</div>
					<div class="text-center mt-0 mt-md-4">
					 @if (session()->has('user_id'))
					    <a href="{{route('reusable_listings')}}" class="btn btn-lg btn-linear-primary btn-responsive-width">View All Listings</a>
					 @else
					     <a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="btn btn-lg btn-linear-primary btn-responsive-width">View All Listings</a>
					 @endif

				</div>
			</div>
		</section>
		<!-- /Service Section -->
			<section id="counter-section" class="cat-dog-eight-section" style="background-color:#F4F5F5 !important;">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12 col-12" class="counter-section" id="counter-section">
						<div class=" section-heading section-heading-eight passion-eight-heading aos aos-init aos-animate"    data-aos="fade-up">

							<h2 class="text-center">Our Impact</h2>

						</div>
						<div class="row justify-content-center">
							<div class="col-lg-4 col-md-6 col-12">
                              <div class="clients-eights-all">
                                   <h5 class="mb-2">Total Contributors</h5>
                                <div class="clients-eight-span text-center">

                                  <h3 class="counter d-inline" data-target="{{ $Contributorusers }}">0</h3>
                                  <span  >+</span>
                                </div>
                                <p>Individuals onboarded to create sustainable change</p>
                              </div>
                            </div>


							<div class="col-lg-4 col-md-6 col-12">
								<div class="clients-eights-all">
								   <h5 class="mb-2"> Local Collection Agents</h5>
									<div class="clients-eight-span">
										<h3 class="counter" data-target="{{ $collagentusers }}">0</h3>
										<span>+</span>
										</div>
									<p>waste professionals driving the change</p>
								</div>
							</div>
							</div>
							<div class="row justify-content-center">
							<div class="col-lg-4 col-md-6 col-12">
								<div class="clients-eights-all">
								    <h5 class="mb-2">Total number of listings</h5>
									<div class="clients-eight-span">
										<h3 class="counter" data-target="{{ $totnooflistings }}">0</h3>
										<span>+</span>
										</div>
									<p>opportunities created to repurpose waste into value resources</p>
								</div>
							</div>
								<div class="col-lg-4 col-md-6 col-12">
								<div class="clients-eights-all" style="padding:55px 20px;">
								     <h5 class="mb-2">Quantity of waste listed as Resources</h5>
									<div class="clients-eight-span">
										<h3 class="counter" data-target="{{ $totnoresources }}">0</h3>
										<span>kg</span>
										</div>

								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-12">
								<div class="clients-eights-all" style="padding:43px 20px;">
								     <h5 class="mb-2">Total Engagements Enabled</h5>
									<div class="clients-eight-span">
										<h3 class="counter" data-target="{{ $totalconn }}">0</h3>
										<span>+</span>
										</div>
									<p>connections established    </p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>


 	<!-- Blog Section -->
		<section class="blog-section blog-section-two">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center aos" data-aos="fade-up">
						<div class="section-heading sec-header">
							<h2> Recent Blogs</h2>

						</div>
					</div>
				</div>
				<div class="row justify-content-center">
				@foreach ($blogs as $blog)
    <div class="col-lg-4 col-md-6 d-flex">
        <div class="blog blog-new flex-fill aos" data-aos="fade-up">
            <div class="blog-image">
                <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">
                    <img class="img-fluid" src="{{ asset('frontend/assets/img/ecoSansar.png') }}" alt="Post Image">
                </a>
                <div class="date">
                    {{ $blog->created_at->format('d') }}<span>{{ $blog->created_at->format('M') }}</span>
                </div>
                <ul class="blog-item">
                    <li>
                        <div class="post-author">
                            <i class="feather-user"></i><span>{{  $blog->posted_by_name}}</span
                        </div>
                    </li>
                    <li><i class="feather-message-square"></i> Comments ({{ $blog->comments_count ?? 0 }})</li>
                </ul>
            </div>
            <div class="blog-content mb-0">
                <h3 class="blog-title">
                    <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">{{ $blog->blog_name }}</a>
                </h3>
                <p>{!! Str::limit(strip_tags($blog->content), 150) !!}</p>
            </div>
        </div>
    </div>
@endforeach


				</div>
				<div class="text-center mt-4">
					<a href="{{route('blog')}}" class="btn btn-lg btn-linear-primary btn-responsive-width">View All Blogs</a>
				</div>
			</div>
		</section>
		<!-- /Blog Section -->
			<!-- Partners Section -->
	<section class="partners-section" >
  <div class="container">
    <div class="row  ">
         <!-- Technical Partners -->
      <div class="text-center col-md-4">
        <h2 class="  mb-4">Technical Partners</h2>
        <a href="https://magnetontech.com/" target="_blank"><img src="{{ asset('assets/images/magnetontechlogo.png') }}" alt=""></a>
      </div>
      <div class="text-center col-md-4">
        <h2 class="  mb-4"> Supported By</h2>
        <a href="#"><img style="width:80px;" src="{{ asset('assets/images/torrum-logo.png') }}" alt=""></a>
      </div>
      <!-- Communication Partners -->
      <div class="text-center col-md-4">
        <h2 class="  mb-4">Communication Partners</h2>
        <a href="#"><img height="60" src="{{ asset('assets/images/msg91-original_Logo.svg') }}" alt=""></a>
      </div>



    </div>
  </div>
</section>

		<!-- Partners Section -->
<!-- Footer (should come last) -->
@include('frontend.include.footer')
<!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        let counterStarted = false;
        const counterSection = $('#counter-section');

        function animateCounter(target) {
            const targetValue = parseInt(target.attr('data-target'), 10);
            $({ countNum: 0 }).animate(
                { countNum: targetValue },
                {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        target.text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        target.text(this.countNum);
                    }
                }
            );
        }

        function isInViewport(element) {
            const rect = element[0].getBoundingClientRect();
            return rect.top < window.innerHeight && rect.bottom > 0;
        }

        $(window).on('scroll', function () {
            if (!counterStarted && isInViewport(counterSection)) {
                counterStarted = true;
                $('.counter').each(function () {
                    animateCounter($(this));
                });
            }
        });
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.toggle-card');

        cards.forEach(card => {
            card.addEventListener('click', function () {
                // Only run on mobile screens
                if (window.innerWidth < 768) {
                    const details = card.querySelector('.mob-content');
                    if (details) {
                        details.style.display = (details.style.display === 'block') ? 'none' : 'block';
                    }
                }
            });
        });
    });
</script>





