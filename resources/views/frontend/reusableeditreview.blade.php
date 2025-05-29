 
    
@include('frontend.include.header')
 
<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Review Details</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item">Review</li>
							<li class="breadcrumb-item active" aria-current="page">Review Details</li>
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
    							    <div class="row">
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Name:</strong>
                                    <span>@isset($users->name){{ $users->name }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Phone number:</strong>
                                    <span>@isset($users->mobile){{ $users->mobile }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Email id:</strong>
                                    <span>@isset($users->email){{ $users->email }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Address:</strong>
                                    <span>@isset($users->address){{ $users->address }}@endisset</span>
                                </div>
                                    <!--end form-group-->

                            </div>

    							</div>
    						</div>
    					</div>
					</div>
						<div class="row">
        					<div class="col-xl-8">
        						<div class="card border-0">
        							<div class="card-body">
        							     

        							</div>
        						</div>
        					</div>
        				</div>
			    
				<div class="row">
					<div class="col-xl-8">
						<div class="card border-0">
							<div class="card-body">
							   <form action="{{ route('review.reusablereviewsave') }}" method="POST">
							        @csrf
							          <input type="hidden" name="user_id" value="{{ $id }}">
                            <input type="hidden" name="post_id" value="{{ $post_id }}">
					<div class="modal-body">
						<div class="mb-3">
            <label class="form-label">Rate your Review</label>
            <div class="rating-select mb-0" id="star1">
                <a href="javascript:void(0);" class="star" data-rating="1"><i class="fas fa-star"></i></a>
                <a href="javascript:void(0);" class="star" data-rating="2"><i class="fas fa-star"></i></a>
                <a href="javascript:void(0);" class="star" data-rating="3"><i class="fas fa-star"></i></a>
                <a href="javascript:void(0);" class="star" data-rating="4"><i class="fas fa-star"></i></a>
                <a href="javascript:void(0);" class="star" data-rating="5"><i class="fas fa-star"></i></a>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating', $review->rating ?? 0) }}">
            </div>
        </div>
						<div class="mb-3">
							<label class="form-label">Review Title</label>
						 
                                                <input type="text" class="form-control" id="title" name="title"  value="{{ $review->title }}">
                                                @if ($errors->has('title'))
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                @endif
						</div>
					 
						<div class="mb-0">
							<label class="form-label">Write Your Review</label>
						 <textarea class="form-control" id="message" rows="8" name="message"  =""  > {{ $review->message }}</textarea>
                                                @if ($errors->has('message'))
                                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                            @endif
						</div>
					</div>
					<div class="modal-footer d-flex align-items-center justify-content-end">
						<a href="javascript:void(0);" class="btn btn-light me-2 mt-4" data-bs-dismiss="modal">Cancel</a>
						<button type="submit" class="btn btn-primary mt-4">Submit</button>
					</div>
				</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
   @include('frontend.include.footer')



 
<script>
    // When the page loads, set the stars according to the existing rating
    document.addEventListener('DOMContentLoaded', function() {
        let rating = document.getElementById('rating').value; // Get the existing rating value

        // Update the stars based on the rating value
        const stars = document.querySelectorAll('#star1 .star');

        stars.forEach(star => {
            if (parseInt(star.getAttribute('data-rating')) <= rating) {
                star.querySelector('i').classList.add('text-warning'); // Set filled stars
            }
        });
    });

    // Handle star click event to update the rating
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            const ratingValue = this.getAttribute('data-rating');
            document.getElementById('rating').value = ratingValue; // Update the hidden rating field

            // Remove previous filled stars
            document.querySelectorAll('#star1 .fas').forEach(i => i.classList.remove('text-warning'));

            // Fill the stars up to the clicked rating
            for (let i = 1; i <= ratingValue; i++) {
                document.querySelector(`#star1 .star[data-rating="${i}"] i`).classList.add('text-warning');
            }
        });
    });
</script>


    
    