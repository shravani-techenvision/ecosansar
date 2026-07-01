@include('frontend.include.header')
 <style>
     .page-wrapper .content {
    padding: 30px 0;
}
 </style>
 	<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;" >
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">How It Works</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active" aria-current="page">How It Works</li>
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
			<p class="text-center">We follow a 4 step process in enabling a circular model for glass jars & bottle packaging,</p>

    <div class="row align-items-center justify-content-center">
        <div class="col-md-8">
            <div class="work-wrap work-wrap-acc">
                <span>01</span>
                <h1 class="display-6">Collection Drive - </h1>
                <p>Pitching idea to the audience, getting feedback and collection of clean glass jars/bottles</p>
                {{-- <ul style="list-style-type: disc; margin-left: 20px;">
                    <li>Sell</li>
                    <li>Give Away</li>
                    <li>Buy</li>
                </ul> --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step-1.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="work-wrap-img d-none d-md-block">
            <img src="{{ asset('frontend/assets/img/bg/Arrow.png') }}" alt="img" class="img-fluid">
        </div>
    </div>
    <hr>

    <div class="row align-items-center justify-content-center">
        <div class="col-md-4 order-last order-md-first">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step-2.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="col-md-8 d-flex justify-content-center">
            <div class="work-wrap work-wrap-post">
                <span>02</span>
                <h1 class="display-6">Transportation - </h1>
                <p>The collected glass jars/bottles go to washing unit</p>
                {{-- <p>Logistics and transactions are offline and The ZeroWaste Community Tool is not involved.</p>
                <p>This Tool helps you Find and Connect Only. </p> --}}
            </div>
        </div>
        <div class="work-wrap-img d-none d-md-block">
            <img src="{{ asset('frontend/assets/img/bg/Arrow.png') }}" alt="img" class="img-fluid">
        </div>
    </div>
    <hr>
 <div class="row align-items-center justify-content-center">
        <div class="col-md-8">
            <div class="work-wrap work-wrap-acc">
                <span>03</span>
                <h1 class="display-6">Cleaning & Drying - </h1>
                <p>The collection reaches the washing unit, where it is soaked, cleaned and dried for Repurpose. Rusted non usable caps are replaced</p>
                {{-- <p>The listing will automatically deactivate after 30 days. You will receive 2 reminder messages regarding the same. If you wish to renew it, simply click on Reactivate on the listing from your profile page.</p> --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step-3.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="work-wrap-img d-none d-md-block">
            <img src="{{ asset('frontend/assets/img/bg/Arrow.png') }}" alt="img" class="img-fluid">
        </div>
    </div>
  
    <hr>
	<div class="row align-items-center justify-content-center">
        <div class="col-md-4 order-last order-md-first">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step4.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="col-md-8 d-flex justify-content-center">
            <div class="work-wrap work-wrap-post">
                <span>04</span>
                <h1 class="display-6">Sale - </h1>
                <p>Once washed and cleaned, all glass jars/bottles are ready for sale. They are catalogued to share with customers</p>
            </div>
        </div>
		<div class="col-md-4">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step3.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="work-wrap-img d-none d-md-block">
            <img src="{{ asset('frontend/assets/img/bg/Arrow.png') }}" alt="img" class="img-fluid">
        </div>
    </div>

	<hr>
	<div class="row align-items-center justify-content-center">
        <div class="col-md-4 order-last order-md-first">
            <div class="work-img d-none d-md-block">
                <img src="{{ asset('frontend/assets/img/bg/step-5.png') }}" class="img-fluid" alt="image">
            </div>
        </div>
        <div class="col-md-8 d-flex justify-content-center">
            <div class="work-wrap work-wrap-post">
                <span>05</span>
                <h1 class="display-6">Storage - </h1>
                <p>Catalogue is stored in a safe and clean space to ensure similar jars/bottles can then be bundled together for sales</p>
            </div>
        </div>
    </div>
</div>

	<!-- Feature Section -->
		<section class="feature-section" style="background-color:#F4F5F5 !important;">
		 
			<div class="container">
				<div class="section-heading">
					<div class="row align-items-center">
						 
							<h2 class="text-center">What can you list</h2>
						 
						 
						
					</div>
				</div>
				{{-- <h4 class="mb-3 text-center">Recyclables</h4>
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-2">
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
					<div class="col-md-6 col-lg-2">
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
					<div class="col-md-6 col-lg-2">
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
					<div class="col-md-6 col-lg-2">
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
					<div class="col-md-6 col-lg-2">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/flower.png') }}" alt="img">
								</span>
							</div>
							<h5>Flower Waste</h5>
							<div class="feature-overlay">
								 
							</div>
						</div>
					</div>
					 
					 
				</div> --}}
					<h4 class="mb-3 mt-4 text-center"> Packaging Reusables (CLEAN ONLY)   </h4>
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-2">
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
					<div class="col-md-6 col-lg-2">
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
					<!--<div class="col-md-6 col-lg-2">-->
					<!--	<div class="feature-box aos" data-aos="fade-up">-->
					<!--		<div class="feature-icon">-->
					<!--			<span>-->
					<!--				<img src="{{ asset('frontend/assets/img/icons/glass.png') }}" alt="img">-->
					<!--			</span>-->
					<!--		</div>-->
					<!--		<h5></h5>-->
					<!--		<div class="feature-overlay">-->
							 
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<div class="col-md-6 col-lg-2">
						<div class="feature-box aos" data-aos="fade-up">
							<div class="feature-icon">
								<span>
									<img src="{{ asset('frontend/assets/img/icons/jar.png') }}" alt="img">
								</span>
							</div>
							<h5>Glass Jars</h5>
							<div class="feature-overlay">
								 
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-2">
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
					 
					 
				</div>
			</div>
		</section>
		<!-- /Feature Section -->
        	<div class="container mt-4">
            <p class="text=center"><i>Helpful note : Some resources can be paid for and some (e.g : construction debris) can be charged for pickup. 
            Please confirm with your Connect before proceeding</i></p>
        </div>
		</div>
		</div>
		<!-- /Page Wrapper -->        
         
    

 
@include('frontend.include.footer')
 