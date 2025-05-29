 
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
				@if($conlistreviews->isNotEmpty())
						<div class="row">
        					<div class="col-xl-8">
        						<div class="card border-0">
        							<div class="card-body">
        							     @foreach($conlistreviews as $review)
                            <div class="description">
                                <figure>
                                    <div class="rating-passive" data-rating="{{ $review->rating }}">
                                        <span class=" ">{{ $review->title }}</span>
                                        <span class="stars"></span>
                                        <span class="reviews">{{ $review->rating }}</span>
                                    </div>
                                </figure>
                                <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->
                            </div>
                            @endforeach

        							</div>
        						</div>
        					</div>
        				</div>
        				@else
        				<p>No reviews available</p>
        				@endif
			    
				<div class="row">
					<div class="col-xl-8">
						<div class="card border-0">
							<div class="card-body">
							    <form action="{{ route('review.recyclablereviewsave') }}" method="POST">
							        @csrf
							         <input type="hidden" name="user_id" value="{{ $u_id }}">
                            <input type="hidden" name="post_id" value="{{ $post_id }}">
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Rate your Review</label>
							<div class="rating-select mb-0" id="star1">
								<a href="javascript:void(0);"><i class="fas fa-star"></i></a>
								<a href="javascript:void(0);"><i class="fas fa-star"></i></a>
								<a href="javascript:void(0);"><i class="fas fa-star"></i></a>
								<a href="javascript:void(0);"><i class="fas fa-star"></i></a>
								<a href="javascript:void(0);"><i class="fas fa-star"></i></a>
								 <input type="hidden" name="rating" id="rating" value="0">
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Review Title</label>
						 
                                                <input type="text" class="form-control" id="title" name="title" >
                                                @if ($errors->has('title'))
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                @endif
						</div>
					 
						<div class="mb-0">
							<label class="form-label">Write Your Review</label>
						 <textarea class="form-control" id="message" rows="8" name="message"  =""  ></textarea>
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
   document.querySelectorAll('.rating-select a').forEach((star, index) => {
    star.addEventListener('click', function () {
        const rating = index + 1;
        document.getElementById('rating').value = rating;
        highlightStars(rating);
    });
});

function highlightStars(rating) {
    document.querySelectorAll('.rating-select a').forEach((star, index) => {
        if (index < rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

    </script>
  
