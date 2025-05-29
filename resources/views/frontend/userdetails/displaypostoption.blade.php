@include('frontend.include.header')
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Choose One</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
						 
							<li class="breadcrumb-item active" aria-current="page">Choose One</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="breadcrumb-bg">
				<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
				<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
			</div>
	</div>
	<!-- /Breadcrumb -->
	<!-- Categories Section -->
<section class="categories-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="section-heading section-heading-four category-heading aos" data-aos="fade-up">
						<h2>Recyclables</h2>
					 
					</div>
				</div>
			</div>
			<div class="row justify-content-center gap-5">
				<div class="col-xl-3 col-lg-3 col-md-3 d-flex ">
				     @if (session()->has('user_id'))
					<a href="{{route('recyclable_add_post')}}" class="w-100">
					<div class="categories-main-all flex-fill" style="background-image: url('{{ asset('frontend/assets/img/addlisting.png') }}'); background-size: cover; background-position: center; height: 300px;">

						 
						 
						
					</div>
					</a>
					@else
					<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="w-100">
					<div class="categories-main-all flex-fill"  style="background-image: url('{{ asset('frontend/assets/img/addlisting.png') }}'); background-size: cover; background-position: center; height:300px;">
						 
					</div>
					</a>
                        @endif
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 d-flex ">
				     @if (session()->has('user_id'))
					<a href="{{route('listings')}}" class="w-100">
					<div class="categories-main-all flex-fill" style="background-image: url('{{ asset('frontend/assets/img/listing.png') }}'); background-size: cover; background-position: center; height:300px;">
						 
					</div>
					</a>
					@else
					<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}" class="w-100">
					<div class="categories-main-all flex-fill" style="background-image: url('{{ asset('frontend/assets/img/listing.png') }}'); background-size: cover; background-position: center; height:300px;">
					 
					</div>
					</a>
					@endif
				</div>
			</div>
			<div class="row text-center gap-5">
			 <a href="{{url('/')}}"> <button class="btn btn-lg btn-linear-primary   mt-4" type="submit">Homepage<i class="feather-arrow-right-circle ms-2"></i></button></a>
			</div>
		</div>
	</section>

	<!-- /Categories Section -->
@include('frontend.include.footer')