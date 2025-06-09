
@include('frontend.include.header')

 	<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center"
	style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover;
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Listing Details</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item">Listing</li>
							<li class="breadcrumb-item active" aria-current="page">Listing Details</li>
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
 <div class="page-wrapper">
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-xl-8">
						<div class="card border-0">
							<div class="card-body">


							<!-- Single Image Display -->

                            <div class="service-wrap mb-4">
                                <div class="service-img text-center">
                                     @php
                                        // Check if $listing->resource_img is set and not empty
                                        $imagePath = !empty($posts->resource_img) ? 'Reusableposts/' . $posts->resource_img : null;

                                        // Check if the image exists in the S3 bucket or fallback to default
                                        $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                    ? Storage::disk('s3')->url($imagePath)
                                                    : asset('frontend/assets/img/ecosansar.png');
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="img-fluid" alt="Service Image">
                                </div>
                            </div>
                            <!-- /Single Image Display -->


								<div class="accordion service-accordion">
									<div class="accordion-item mb-4">
										  <h2 class="accordion-header">
											<button class="accordion-button p-0" type="button" data-bs-toggle="collapse" data-bs-target="#overview" aria-expanded="false">
												Listing Description
											</button>
										  </h2>
										  <div id="overview" class="accordion-collapse collapse show">
											<div class="accordion-body border-0 p-0 pt-3">
												<div class="more-text">
												    {{$posts->description}}
													</div>

												<div class="bg-light-200 p-3 offer-wrap">
													<h4 class="mb-3">Details</h4>
													<div class="offer-item d-md-flex align-items-center justify-content-between bg-white mb-2">
														<div class="d-sm-flex align-items-center mb-2">

															<div class="mb-2">
																<h6 class="fs-16 fw-medium">Resources</h6>

															</div>
														</div>
														<div class="pb-3">
															<h6 class="fs-16 fw-medium text-primary mb-0">{{ $posts->resource->reusable_resource_name }}</h6>

														</div>
													</div>
													<div class="offer-item d-md-flex align-items-center justify-content-between bg-white mb-2">
														<div class="d-sm-flex align-items-center mb-2">

															<div class="mb-2">
																<h6 class="fs-16 fw-medium">Sale/Giveaway</h6>

															</div>
														</div>
														<div class="pb-3">
															<h6 class="fs-16 fw-medium text-primary mb-0"> {{$posts->sale_giveaway}}</h6>

														</div>
													</div>
													<div class="offer-item d-md-flex align-items-center justify-content-between bg-white mb-2">
														<div class="d-sm-flex align-items-center mb-2">

															<div class="mb-2">
																<h6 class="fs-16 fw-medium">Quantity</h6>

															</div>
														</div>
														<div class="pb-3">
															<h6 class="fs-16 fw-medium text-primary mb-0">{{ $posts->weight->min_weight }} {{ $posts->weight->min_measure }} - {{ $posts->weight->max_weight }} {{ $posts->weight->max_measure }}</h6>

														</div>
													</div>

													<div class="offer-item d-md-flex align-items-center justify-content-between bg-white ">
														<div class="d-sm-flex align-items-center mb-2">

															<div class="mb-2">
																<h6 class="fs-16 fw-medium">Address</h6>

															</div>
														</div>
														<div class="pb-3">
															<h6 class="fs-16 fw-medium text-primary mb-0">{{$posts->address}}</h6>

														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="col-xl-4 theiaStickySidebar">
						<div class="card border-0">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between border-bottom mb-3">
									<div class="d-flex align-items-center">
										<div class="mb-3">
											<p class="fs-14 mb-0">Suggested Price</p>
											<h4><span class="display-6 fw-bold">₹{{$posts->resource_price}}</span> </h4>
										</div>
									</div>

								</div>
								<a href="#" data-id="{{ $posts->id }}" data-bs-toggle="modal" data-bs-target="#add-contact" class="btn btn-lg btn-linear-primary w-100 d-flex align-items-center justify-content-center mb-3 consumer-connect-listing"><i class="ti ti-user me-2"></i>Connect</a>

							</div>
						</div>
						<div class="card border-0">
							<div class="card-body">
								<h4 class="mb-3">Posted By</h4>
								<div class="provider-info text-center bg-light-500 p-3 mb-3">

									<h5>{{$users->name}}</h5>
									<p class="fs-14"><i class="ti ti-star-filled text-warning me-2"></i><span class="text-gray-9 fw-semibold">{{ $averageRating }}</span> ({{ $reviewsCount }}
        {{ $reviewsCount == 1 ? 'review' : 'reviews' }})</p>
								</div>

								<div class="d-flex align-items-center justify-content-between mb-3">
									<h6 class="fs-16 fw-medium mb-0"><i class="ti ti-map-pin me-1"></i>Address</h6>
									<p>{{$users->address}}</p>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-3">
									<h6 class="fs-16 fw-medium mb-0"><i class="ti ti-mail me-1"></i>Email</h6>
									<p>{{$users->email}}</p>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-3">
									<h6 class="fs-16 fw-medium mb-0"><i class="ti ti-phone me-1"></i>Phone</h6>
									<p>******{{ substr($users->mobile, -4) }}</p>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-3">
									<h6 class="fs-16 fw-medium mb-0"><i class="ti ti-file-text me-1"></i>No of Listings</h6>
									<p>{{$noofposts}}</p>
								</div>
							 <div class="d-flex align-items-center justify-content-between mb-3">
									<h6 class="fs-16 fw-medium">Social Profiles</h6>
									<div class="d-flex align-items-center">
										<div class="social-icon">
										  @if (session()->has('user_id'))
											<a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('reusable_listing_details/'.$posts->id)) }}" target="_blank" class="me-2"><img src="{{asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="icon"></a>
										 @else
										    	<a href="{{ route('consumer_login', ['redirect_wp' => url('reusable_listing_details/' . $posts->id)]) }}" target="_blank"></a>
										  @endif
										</div>
									</div>
								</div>
								<div class="row border-top pt-3 g-2">
									<div class="col-sm-6">
										<a href="#" data-id="{{ $posts->id }}" data-bs-toggle="modal" data-bs-target="#add-contact" class="btn btn-lg btn-linear-primary w-100 consumer-connect-listing"><i class="ti ti-user me-2"></i>Connect</a>

									</div>
									<div class="col-sm-6">
									 @if (!$hideAddReviewButton)
										    <a href="{{ url('reusablepostprofile'). "/".$u_id }}"    class="btn btn-lg btn-linear-primary w-100  "><i class="fa-regular fa-comment-dots me-2"></i></i>Add Review</a>
									    @endif
									</div>

								</div>
							</div>
						</div>

						<div class="card border-0">
							<div class="card-body">
								<h4 class="mb-3">Location</h4>
								  <div id="map" style="height: 400px; width: 100%;"></div>
							</div>
						</div>
						<!--<a href="#" class="text-danger fs-14"><i class="ti ti-pennant-filled me-2"></i>Report Provider</a>-->
					</div>
				</div>
				<div class="row mt-5 d-flex justify-content-center">
                                                                    <div class="col-md-3 mb-2">
                                                                        <a href="{{route('reusable_listings')}}" class="btn btn-linear-primary btn-lg w-100">  Go back to Listings Page</a>
                                                                    </div>
                                                                    <div class="col-md-3 mt-2 mt-md-0 mb-2">
                                                                       <a href="{{url('/')}}" class="btn btn-linear-primary btn-lg w-100">
                                                                            Home Page</a>
                                                                    </div>


                                                                </div>
			</div>
		</div>
	</div>

<!-- Add Contact -->
	<div class="modal fade" id="add-contact" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header d-flex align-items-center justify-content-between">
					<h5>Contact Provider</h5>
					<a href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-circle-x-filled fs-20"></i></a>
				</div>
				<form action="{{ route('reusable_enquiry_save') }}" method="POST">
				    @csrf
				    <input type="hidden" name="id" id="postid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
					<div class="modal-body">
						<div class="bg-light-500 p-3 mb-3 br-10">
							<div class="d-flex align-items-center">

								<div class="ms-2" id="user-details">

								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Name</label>
							<input type="text" class="form-control" name="name" id="name">
						</div>
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="email" class="form-control" name="email" id="email">
						</div>
						<div class="mb-3">
							<label class="form-label">Phone Number</label>
							<input readonly type="text" class="form-control" name="mobile" id="mobile">
						</div>
						<div class="mb-0">
							<label class="form-label">Write us a Message</label>
							<textarea class="form-control" rows="3" name="message" id="message"></textarea>
						</div>
					</div>
					<div class="modal-footer d-flex align-items-center justify-content-end">
						<a href="javascript:void(0);" class="btn btn-light me-2"  data-bs-dismiss="modal">Cancel</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Add Contact -->


@include('frontend.include.footer')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const starRatingContainers = document.querySelectorAll('#star1');
      var inputhidden = document.getElementById("rating");

        starRatingContainers.forEach(container => {
            const stars = container.querySelectorAll('span');
            //const hiddenInput = container.nextElementSibling; // Use nextElementSibling

            stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            inputhidden.value=rating;
            //hiddenInput.value = rating; // Update the hidden input field
            console.log('Rating: ' + rating); // Add this line

            // Highlight stars from the first star to the clicked star
            stars.forEach(s => {
                const sRating = s.getAttribute('data-rating');
                s.classList.remove('highlight');
                if (sRating <= rating) {
                    s.classList.add('highlight');
                }
            });
        });
    });
        });
    });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function initMap() {
            // Replace these with the latitude and longitude you want to display
            const latitude = {{ $posts->latitude }};
            const longitude = {{ $posts->longitude }};

            // The location to center the map
            const location = { lat: latitude, lng: longitude };

            // Create a new map instance
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: location
            });

            // Place a marker at the specified location
            const marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // Add a click event listener to the map
            map.addListener('click', function(event) {
                const clickedLatLng = event.latLng;
                const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
                window.open(googleMapsUrl, '_blank');
            });

        }

        // Initialize the map when the window loads
        window.onload = initMap;
    </script>

    <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.consumer-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#postid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_reusable_post_details') }}",
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
                       var userDetails = '<span style="font-size: 16px;"><strong>User Type:</strong> ' +
                                                (user.user_type === 'business' ? 'Corporate' :
                                                 user.user_type === 'sab' ? 'Collection Agent' :
                                                 user.user_type === 'consumer' ? 'Contributor' : 'Unknown') + '</span><br>' +
                                                '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                                '<span style="font-size: 16px;"><strong>User Email:</strong> ' + (user.email || 'N/A') + '</span><br>' +
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


