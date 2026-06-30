
@include('frontend.include.header')
<style>
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
.modal-header {
    border-bottom: none !important;
}
.wp-dis-own {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-top: 30px;
}

</style>



 <div class="breadcrumb-bar text-center"
 style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover;
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Reusable Listings</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Reusable Listings</li>
						</ol>
					</nav>
				</div>
			</div>

		</div>
	</div>

  <!-- Page Wrapper -->
     <div class="page-wrapper">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 theiaStickySidebar">
						<div class="card mb-4 mb-lg-0">
							<div class="card-body">
							 <form id="filterForm" class="form inputs-underline" >
                                @csrf
									<div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
										<h5><i class="ti ti-filter-check me-2"></i>Filters</h5>

									</div>

									<div class="accordion border-bottom mb-3">
                                        <div class="accordion-item mb-3">
                                            <div class="accordion-header" id="accordion-headingThree">
                                                <div class="accordion-button p-0 mb-3" data-bs-toggle="collapse" data-bs-target="#accordion-collapseThree" aria-expanded="true" aria-controls="accordion-collapseThree" role="button">
                                                    Categories
                                                </div>
                                            </div>
                                            <div id="accordion-collapseThree" class="accordion-collapse collapse show" aria-labelledby="accordion-headingThree">
                                                <div class="content-list mb-3" id="fill-more">

                                                    @foreach($res as $project)
                                                        <div class="form-check mb-2">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input resource-checkbox" type="checkbox" name="resource[]" value="{{ $project->id }}">
                                                                {{ $project->reusable_resource_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a href="javascript:void(0);" id="more" class="more-view text-primary fs-14">View more <i class="ti ti-chevron-down ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>

									<div class="accordion border-bottom mb-3">
										<div class="accordion-header" id="accordion-headingFour">
											<div class="accordion-button p-0 mb-3" data-bs-toggle="collapse" data-bs-target="#accordion-collapseFour" aria-expanded="true" aria-controls="accordion-collapseFour" role="button">
											Show lisitngs that
											</div>
										</div>
										<div id="accordion-collapseFour" class="accordion-collapse collapse show" aria-labelledby="accordion-headingFour">
											<div class="mb-3">
												<select class="select" name="sale_giveaway">
													<option value="">Show lisitngs that </option>
												 <option value="Sell">Sell  </option>
												 <option value="Buy">Buy  </option>
                                            <option value="Giveaway">Giveaway  </option>

                                              <option value="Request for free">Request for free  </option>
												</select>
											</div>
										</div>
									</div>
									<div class="accordion border-bottom mb-3">
										<div class="accordion-header" id="accordion-headingFour">
											<div class="accordion-button p-0 mb-3" data-bs-toggle="collapse" data-bs-target="#accordion-collapseFive" aria-expanded="true" aria-controls="accordion-collapseFive" role="button">
											Quantity
											</div>
										</div>
										<div id="accordion-collapseFive" class="accordion-collapse collapse show" aria-labelledby="accordion-headingFour">
											<div class="mb-3">
												<select class="select selectpicker" name="weight">
                                        <option value="">Select quantity</option>
                                        @foreach($weight as $project)
                                        <option value="{{ $project->id }}"

                                        >{{ $project->min_weight }} {{ $project->min_measure}} {{'to'}} {{ $project->max_weight }}{{ $project->max_measure }}</option>
                                    @endforeach

                                    </select>
											</div>
										</div>
									</div>

										<div class="accordion border-bottom mb-3">
										<div class="accordion-header" id="accordion-headingFour">
											<div class="accordion-button p-0 mb-3" data-bs-toggle="collapse" data-bs-target="#accordion-collapseSeven" aria-expanded="true" aria-controls="accordion-collapseSeven" role="button">
										Show Posts listed by
											</div>
										</div>
										<div id="accordion-collapseSeven" class="accordion-collapse collapse show" aria-labelledby="accordion-headingFour">
											<div class="mb-3">
												<select class="select" name="user_type" id="user_type">
													<option value="">Show Posts listed by  </option>
												 <option value="consumer">Contributor  </option>
                                            <option value="sab">Collection Agent  </option>
                                             <option value="business">Businessess  </option>

												</select>
											</div>
										</div>
									</div>


									<button type="submit" class="btn btn-dark w-100">Search</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-xl-9 col-lg-8">
						<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
							<h4 >  <span class="text-primary"> </span></h4>
							<div class="d-flex align-items-center">
							   
								<span class="text-dark me-2">Sort</span>
							    <div class="dropdown me-2">
                                  <a href="javascript:void(0);" class="dropdown-toggle bg-light-300" data-bs-toggle="dropdown" id="selectedSortOption">Newest First</a>
                                  <div class="dropdown-menu" id="sortOptions">
                                    <a href="javascript:void(0);" class="dropdown-item active" data-sort="1">Newest First</a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-sort="2">Oldest First</a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-sort="3">Smallest Quantity</a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-sort="4">Largest Quantity</a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-sort="5">Highest Ratings</a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-sort="6">Lowest Ratings</a>
                                  </div>
                                </div>


							</div>
						</div>
					<div class="row">
                          <div class="col-md-10">
                            <!-- Service List -->
                            <!-- Container to Display Listings -->
                            <!-- Container to Display Listings -->
                         <div id="listings-container">

                            @foreach ($posts as $post)
                              <div class="service-list">
                                <div class="service-cont">
                                  <div class="service-cont-img">
                                    <a href="{{ url('reusable_listing_details/'.$post->id) }}">

                                      @php
                                        // Check if $listing->resource_img is set and not empty
                                        $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;

                                        // Check if the image exists in the S3 bucket or fallback to default
                                        $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                    ? Storage::disk('s3')->url($imagePath)
                                                    : asset('frontend/assets/img/ecosansar.png');
                                    @endphp

                                    <!-- Display the Image -->
                                    <img src="{{ $imageUrl }}" alt="Listing Image" class="img-fluid serv-img">

                                    </a>

                                  </div>
                                  <div class="service-cont-info">
                                    <span class="badge bg-light fs-14 mb-2">{{ $post->resource->reusable_resource_name }}</span>
                                    <h3 class="title">
                                      <a href="{{ url('reusable_listing_details/'.$post->id) }}">{{ $post->resouece_name }}</a>
                                    </h3>
                                    <p><i class="feather-map-pin"></i>{{ $post->address }}</p>
                                     <p><i class="feather-box"></i>{{ $post->weight->min_weight }} {{ $post->weight->min_measure }} - {{ $post->weight->max_weight }} {{ $post->weight->max_measure }}</p>
                                    <div class="service-pro-img mb-4">
                                      <img src="{{ asset('frontend/assets/img/user.png')  }}" alt="user">

                                     <span>
                                        @php
                                            $rating = round($post->average_rating ?? 0);
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <i class="fas fa-star" style="color: #ffc107;"></i> {{-- Filled gold star --}}
                                            @else
                                                <i class="fas fa-star" style="color: #ddd;"></i> {{-- Outlined gold star --}}
                                            @endif
                                        @endfor
                                    </span>

                                    </div>
                                      {{-- <small >Posted By: {{$post->user->name}} | On {{ date('jS F Y', strtotime($post->created_at)) }}</small> --}}
                                      <small >Posted By: Admin | On {{ date('jS F Y', strtotime($post->created_at)) }}</small>
                                  </div>
                                </div>
                                 <div class="flex-column">
                                <div class="service-action">
                                  <h6>₹{{ $post->resource_price ?? 0  }}</h6>
                                  {{-- <a href="#" data-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#enquiryModal" class="btn btn-light connect-listing mobcon">Connect</a> --}}
                                </div>
                                	<!-- WhatsApp Share Button on the Next Line -->
                                    <div class="  d-flex justify-content-between gap-4">
                                        <div class="social-icon">
                                            @if (session()->has('user_id'))
                                            <span class="wp-dis-own"> Share on:   <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('reusable_listing_details/'.$post->id)) }}" target="_blank" class="me-2">
                                                    <img src="{{asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                                </a></span>
                                            @else
                                                <a href="{{ route('consumer_login', ['redirect_wp' => url('reusable_listing_details/' . $post->id)]) }}" target="_blank">
                                                    <img src="{{asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                       <button class="btn btn-linear-primary btn-lg px-4 w-100 place-enquiry-btn"
												data-id="{{ $post->id }}"
												data-type="{{ $post->resource->reusable_resource_name ?? '' }}"
												data-bs-toggle="modal"
												data-bs-target="#REnquiryModal">
											Place Enquiry
										</button>
                                    </div>
                                </div>
                              </div>
                            @endforeach



</div>


                            <!-- /Service List -->
                          </div>
                        </div>

 <nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($posts->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $posts->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $posts->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($posts->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $posts->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>




					</div>
                </div>
                 <div class="row mt-5 text-center">
                     <div class="col-md-3">

                                                                           <h5> Have something that can be reused? </h5>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                       <a href="{{route('reusable_add_post')}}" class="btn btn-linear-primary btn-lg w-100">
                                                                            Add Your Listing</a>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <a href="{{route('repairmap')}}" class="btn btn-linear-primary btn-lg w-100">  Repair Map</a>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                       <a href="{{route('findcollectionagent')}}" class="btn btn-linear-primary btn-lg w-100">
                                                                            Find your nearest Collection Agent </a>
                                                                    </div>
                                                                </div>
            </div>
        </div>
     </div>
     <!-- /Page Wrapper -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content p-3">

      <!-- Modal Header -->
      <div class="modal-header position-relative">
  <h2 class="modal-title fw-bold text-center w-100" id="enquiryModalLabel">Contact Details</h2>
  <button type="button" class="btn-close position-absolute" style="right: 1rem;" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


      <!-- User Details Section -->
      <div id="user-details" class="">

      </div>

      <!-- Divider with OR -->
      <div class="hr-wrapper text-center my-3">
        <hr class="w-45 d-inline-block"> <span class="fw-bold">OR</span> <hr class="w-45 d-inline-block">
      </div>

      <!-- Send Enquiry Section -->
      <h2 class="modal-title text-center mb-3 fw-bold">Send Enquiry</h2>
      <div class="modal-body p-0">
        <form action="{{ route('reusable_enquiry_save') }}" method="POST">
          @csrf
          <input type="hidden" name="id" id="postid">
          <input type="hidden" name="loginid" value="{{ $user_id }}">

          <!-- Name Field -->
          <div class="mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  >
          </div>

          <!-- Email and Mobile Fields -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter email"  >
            </div>
            <div class="col-md-6 mb-3">
              <input readonly type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile"  >
            </div>
          </div>

          <!-- Message Field -->
          <div class="mb-3">
            <textarea class="form-control" id="message" rows="3" name="message" placeholder="Enter message"></textarea>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-success w-100">Send Message</button>
        </form>
      </div>

    </div>
  </div>
</div>

 <div class="modal fade" id="REnquiryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('reusable.item.enquiry.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Place Enquiry</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                  >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Contact Number</label>

                            <input type="text"
                                   name="mobile"
                                   class="form-control"
                                  >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label id="quantityLabel">Number of Jars</label>

                            <input type="number"
                                   name="quantity"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Colour of Lid</label>

                            <input type="text"
                                   name="lid_colour"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Place of Delivery</label>

                            <input type="text"
                                   name="delivery_place"
                                   class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Required By Date</label>

                            <input type="date"
                                   name="required_by_date"
                                   class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label>Any Other Notes</label>

                            <textarea class="form-control"
                                      rows="4"
                                      name="notes"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-linear-primary">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
@include('frontend.include.footer')
<script>
    const userId = "{{ session('user_id') }}";
</script>
 <script>
    $(document).on('click', '.place-enquiry-btn', function () {

			$('#reusable_item_id').val($(this).data('id'));

			let type = $(this).data('type');

			$('#quantityLabel').text(type ? 'Number of ' + type : 'Quantity');
		});
$(document).ready(function() {
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        console.log($(this).serialize()); // Debugging - Check Data

        $.ajax({
            url: "{{ route('reusable_post_filter') }}",
            method: "GET",
            data: $(this).serialize(),
            success: function(response) {
                console.log(response); // Debugging - Check Response
                $('#listings-container').empty();

                let posts = response.posts; // Directly get the posts from response

                if (!posts || posts.length === 0) {
                    $('#listings-container').append('<p>No listings found.</p>');
                } else {
                    posts.forEach(function(post) {
                        let imageUrl = post.image_url;
                        let resourceName = post.resource ? post.resource.reusable_resource_name : 'N/A';
                           let userName = post.user ? post.user.name : 'N/A';
                        let rating = post.rating || 'N/A';
                        let userImage = "{{ asset('frontend/assets/img/user.png') }}";
                         let weight = post?.weight
                            ? `${post.weight.min_weight} ${post.weight.min_measure} - ${post.weight.max_weight} ${post.weight.max_measure}`
                            : 'N/A';
                       let baseUrl = window.location.origin;

                        // If you want the base folder only (like `/myproject`)
                        let pathParts = window.location.pathname.split('/');
                        let projectFolder = pathParts[1]; // e.g., 'myproject'
                        let basePath = `${baseUrl}/${projectFolder}`;

                        let shareLink;
                        if (userId) {
                            shareLink = `<a href="https://wa.me/?text=${encodeURIComponent('This post from The ZeroWaste Community Tool might interest you, check it out : ' + basePath + '/reusable_listing_details/' + post.id)}" target="_blank">
                                            <img src="{{ asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                         </a>`;
                        } else {
                            shareLink = `<a href="/${projectFolder}/consumer_login?redirect_wp=${basePath}/reusable_listing_details/${post.id}" target="_blank">
                                            <img src="{{ asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                         </a>`;
                        }

                        $('#listings-container').append(`
                            <div class="service-list">
                                <div class="service-cont">
                                    <div class="service-cont-img">
                                        <a href="reusable_listing_details/${post.id}">
                                            <img src="${imageUrl}" alt="Listing Image" class="img-fluid serv-img">
                                        </a>
                                    </div>
                                    <div class="service-cont-info">
                                        <span class="badge bg-light fs-14 mb-2">${resourceName}</span>
                                        <p><i class="feather-map-pin"></i>${post.address}</p>
                                         <p>Weight: ${weight}</p>
                                        <div class="service-pro-img mb-4">
                                            <img src="${userImage}" alt="user">
                                           <span>${generateStars(post.average_rating)}</span>
                                        </div>
                                        <small>Posted By: ${userName} | On ${formatDate(post.created_at)}</small>
                                    </div>
                                </div>
                                <div class="flex-column">
                                <div class="service-action">
                                    <h6>₹${post.resource_price || 0}</h6>
                                    <a href="#" class="btn btn-light">Connect</a>
                                </div>
                                <div class="d-flex justify-content-between gap-4">
            <div class="social-icon">
                <span class="wp-dis-own"> Share on: ${shareLink}</span>
            </div>
        </div>

                                </div>
                            </div>
                        `);
                    });
                }
            },
            error: function(error) {
                console.error('Error:', error);
                $('#listings-container').empty().append('<p>Something went wrong. Please try again later.</p>');
            }
        });
    });
});
function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }
function generateStars(rating) {
    let roundedRating = Math.round(rating ?? 0); // Round to nearest whole number
    let starsHtml = '';

    for (let i = 1; i <= 5; i++) {
        if (i <= roundedRating) {
            starsHtml += `<i class="fas fa-star filled" style="color: gold;"></i>`; // ⭐ Filled Star
        } else {
            starsHtml += `<i class="fas fa-star" style="color: #ddd;"></i>`; // ☆ Empty Star
        }
    }
    return starsHtml;
}

 </script>

<script>
    $(document).ready(function () {
  // Sorting functionality
  $('#sortOptions .dropdown-item').on('click', function () {
    const sortBy = $(this).data('sort');
    const sortText = $(this).text();

    // Update the selected option text
    $('#selectedSortOption').text(sortText);

    // Remove active class from all items and add to selected
    $('#sortOptions .dropdown-item').removeClass('active');
    $(this).addClass('active');

    // Perform sorting
    applySort(sortBy);
  });

  // Function to handle sorting
  function applySort(sortBy) {
    console.log('Applying Sort: Sort By:', sortBy);

    $.ajax({
      url: "{{ route('reusable_post_sort') }}", // Separate route for sorting
      method: "GET",
      data: { sort_by: sortBy },
      success: function (response) {
        console.log('Sort Response:', response);
        displayResults(response);
      },
      error: function (error) {
        console.error('Sort Error:', error);
        $('#listings-container').empty().append('<p>Something went wrong. Please try again later.</p>');
      }
    });
  }

  // Function to display results
  function displayResults(posts) {
    $('#listings-container').empty();

    if (!posts || posts.length === 0) {
      $('#listings-container').append('<p>No listings found.</p>');
      return;
    }

    posts.forEach(function (post) {
      let imageUrl = post.image_url;
      let resourceName = post?.resource?.reusable_resource_name || 'N/A';
       let userName = post.user ? post.user.name : 'N/A';
      let rating = post?.rating || 'N/A';
      let userImage = "{{ asset('frontend/assets/img/user.png') }}";
      let address = post?.address || 'Unknown Address';
      let price = post?.resource_price ? `₹${post.resource_price}` : '0';
      let weight = post?.weight
        ? `${post.weight.min_weight} ${post.weight.min_measure} - ${post.weight.max_weight} ${post.weight.max_measure}`
        : 'N/A';
   let baseUrl = window.location.origin;

                        // If you want the base folder only (like `/myproject`)
                        let pathParts = window.location.pathname.split('/');
                        let projectFolder = pathParts[1]; // e.g., 'myproject'
                        let basePath = `${baseUrl}/${projectFolder}`;

                        let shareLink;
                        if (userId) {
                            shareLink = `<a href="https://wa.me/?text=${encodeURIComponent('This post from The ZeroWaste Community Tool might interest you, check it out : ' + basePath + '/reusable_listing_details/' + post.id)}" target="_blank">
                                            <img src="{{ asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                         </a>`;
                        } else {
                            shareLink = `<a href="/${projectFolder}/consumer_login?redirect_wp=${basePath}/reusable_listing_details/${post.id}" target="_blank">
                                            <img src="{{ asset('frontend/assets/img/icons/whatsapp.svg') }}" class="img" alt="WhatsApp">
                                         </a>`;
                        }
      $('#listings-container').append(`
        <div class="service-list">
          <div class="service-cont">
            <div class="service-cont-img">
              <a href="reusable_listing_details/${post.id}">
                <img src="${imageUrl}" alt="Listing Image" class="img-fluid serv-img">
              </a>
            </div>
            <div class="service-cont-info">
              <span class="badge bg-light fs-14 mb-2">${resourceName}</span>
              <p><i class="feather-map-pin"></i> ${address}</p>
              <p>Weight: ${weight}</p>
              <div class="service-pro-img">
                <img src="${userImage}" alt="user">
                <span>${generateStars(post.average_rating)}</span>
              </div>
               <small>Posted By: ${userName} | On ${formatDate(post.created_at)}</small>
            </div>
          </div>
          <div class="flex-column">
                                <div class="service-action">
                                    <h6>₹${post.resource_price || 0}</h6>
                                    <a href="#" class="btn btn-light">Connect</a>
                                </div>
                                <div class="d-flex justify-content-between gap-4">
            <div class="social-icon">
                <span class="wp-dis-own"> Share on: ${shareLink}</span>
            </div>
        </div>

                                </div>
                            </div>
      `);
    });
  }
});
function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }
function generateStars(rating) {
    let roundedRating = Math.round(rating ?? 0); // Round to nearest whole number
    let starsHtml = '';

    for (let i = 1; i <= 5; i++) {
        if (i <= roundedRating) {
            starsHtml += `<i class="fas fa-star filled" style="color: gold;"></i>`; // ⭐ Filled Star
        } else {
            starsHtml += `<i class="fas fa-star" style="color: #ddd;"></i>`; // ☆ Empty Star
        }
    }
    return starsHtml;
}


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

