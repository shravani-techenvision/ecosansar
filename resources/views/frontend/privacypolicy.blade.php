@include('frontend.include.header')
 

<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<h2 class="breadcrumb-title mb-2">Privacy Policy</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
				</div>
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="container">
					<div class="row">
					
						<!-- Terms & Conditions -->
						<div class="col-md-12">
							<div class="terms-content privacy-cont">
							     @php
                                use App\Models\admin\PrivacyPolicy; // Import the About model
                                
                                $howitwork = PrivacyPolicy::get();
                             @endphp
                
                            @foreach($howitwork as $item)
                                {!! $item->content !!}
                            @endforeach
							 </div>
						</div>
						<!-- /Terms & Conditions -->
						
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->
   
    
 
@include('frontend.include.footer')
 