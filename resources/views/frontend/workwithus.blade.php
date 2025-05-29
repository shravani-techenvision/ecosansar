@include('frontend.include.header')
 <style>
     .working-four-main h3 {
         color:white!important;
     }
     .working-four-main p {
         font-size:16px!important;
     }

 </style>
 	<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Work with us</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active" aria-current="page">Work with us</li>
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
		 
  
<!-- Working Section -->
	<section class="Working-four-section">
		<div class="container">
			 
			<div class="row justify-content-center row-gap-3">
				 <div class="col-lg-4 col-md-6 d-flex">
					<div class="working-four-main flex-fill">
					 
						<h3 class="mb-2 text-truncate">🙌 Volunteer with Us</h3>
						<p>Be the change in your community! As a volunteer, you’ll help drive awareness and action—encouraging neighbors to not only segregate recyclables but also list packaging reusables for trade or exchange on our platform. A small nudge from you, supported by us, can lead to big impact. Use the WhatsApp icon now to connect and know how!  </p>
					</div>
				</div>
			 <div class="col-lg-4 col-md-6 d-flex">
					<div class="working-four-main flex-fill">
					 
						<h3 class="mb-2 text-truncate">🤝 Join as a Co-Founder / <br> Core Team Member</h3>
						<p>Are you driven by sustainability and eager to reimagine how waste is collected and reused? We're looking for a committed, full-time founding member to help lead this mission. This role blends ground-level insight with strategic thinking—you’ll be just as comfortable on the field as you are in the boardroom. If you believe system design is key to making reusable packaging mainstream, and you're ready to build that change from the ground up, let’s connect. </p>
					</div>
				</div>
			 
			 <div class="col-lg-4 col-md-6 d-flex">
					<div class="working-four-main flex-fill">
						 
						<h3 class="mb-2 text-truncate">💡 Support the Movement</h3>
						<p>If you’re an impact fund looking to back scalable solutions for climate action, livelihoods, and circular economy—this is your moment. We're building a tech tool that empowers the informal sector, enables packaging reuse, and creates a visible, inclusive collection system.
 </p> <br>
 <p>Your support can accelerate systemic change on the ground. We’d love to walk you through our vision and impact potential.
👉 Connect with us directly using the WhatsApp icon on the website to get the conversation rolling! </p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ Working Section -->
    
 
    
 
	 
        </div>
		</div>
	 
		<!-- /Page Wrapper -->        
         
    

 
@include('frontend.include.footer')
 