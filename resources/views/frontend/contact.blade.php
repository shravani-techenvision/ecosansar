@include('frontend.include.header')
<style>
    .newsection span {
    width: 70px;
    height: 70px;
    flex-shrink: 0;
    background-color: #3fe31812;
    margin-right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
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
					<h2 class="breadcrumb-title mb-2">Contact Us</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
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
			
			<div class="contacts">
				<div class="contacts-overlay-img d-none d-lg-block">
					<img src="{{ asset('frontend/assets/img/bg/image94.png') }}" alt="img" class="img-fluid">
				</div>
				<!--<div class="contacts-overlay-sm d-none d-lg-block">-->
				<!--	<img src="{{ asset('frontend/assets/img/bg/image95.png') }}" alt="img" class="img-fluid">-->
				<!--</div>-->
					<!-- Contact Details -->
					<!--<div class="contact-details">-->
					<!--	<div class="row justify-content-center">-->
					<!--		<div class="col-md-6 col-lg-4 d-flex">-->
					<!--			<div class="card flex-fill">-->
					<!--				<div class="card-body">-->
					<!--					<div class="d-flex align-items-center">-->
					<!--						<span class="rounded-circle"><i class="ti ti-phone text-primary"></i></span>-->
					<!--						<div>-->
					<!--							<h6 class="fs-18 mb-1">Phone Number</h6>-->
					<!--						<a style="color:black !important;" href="tel:+91 {{$contact->mobile}}">+91 {{$contact->mobile}}</a>-->
											 
					<!--						</div>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		<div class="col-md-6 col-lg-4 d-flex">-->
					<!--			<div class="card flex-fill">-->
					<!--				<div class="card-body">-->
					<!--					<div class="d-flex align-items-center">-->
					<!--						<span class="rounded-circle"><i class="ti ti-mail text-primary"></i></span>-->
					<!--						<div>-->
					<!--							<h6 class="fs-18 mb-1">Email Address</h6>-->
					<!--							<p class="fs-14"><a href="mailto:support@ecosansar.com">	<img src="{{ asset('frontend/assets/img/emailimg.png') }}" alt="img" class="img-fluid"></p></a>-->
											 
					<!--						</div>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		<div class="col-md-6 col-lg-4 d-flex">-->
					<!--			<div class="card flex-fill">-->
					<!--				<div class="card-body">-->
					<!--					<div class="d-flex align-items-center">-->
					<!--						<span class="rounded-circle"><i class="ti ti-map-pin text-primary"></i></span>-->
					<!--						<div>-->
					<!--							<h6 class="fs-18 mb-1">Address</h6>-->
					<!--							<p class="fs-14">{{$contact->address}}</p>-->
					<!--						</div>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!-- /Contact Details -->
					
					<!-- Get In Touch -->
					<div class="row ">
						 <div class="col-12 col-md-6 d-flex align-items-center newsection">
        <div class="w-100">
            <!-- Contact Cards -->
            <div class="card mb-4 mx-auto" style="max-width: 400px;">
                <div class="card-body d-flex align-items-center">
                    <span class="rounded-circle me-3"><i class="ti ti-phone text-primary fs-4"></i></span>
                    <div>
                        <h6 class="mb-1">Phone Number</h6>
                        <a href="tel:+91{{$contact->mobile}}" class="text-dark">+91 {{$contact->mobile}}</a>
                    </div>
                </div>
            </div>

            <div class="card mb-4 mx-auto" style="max-width: 400px;">
                <div class="card-body d-flex align-items-center">
                    <span class="rounded-circle me-3"><i class="ti ti-mail text-primary fs-4"></i></span>
                    <div>
                        <h6 class="mb-1">Email Address</h6>
                        <a href="mailto:support@ecosansar.com" class="text-dark">
                            <img src="{{ asset('frontend/assets/img/emailimg.png') }}" alt="Email" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-body d-flex align-items-center">
                    <span class="rounded-circle me-3"><i class="ti ti-map-pin text-primary fs-4"></i></span>
                    <div>
                        <h6 class="mb-1">Address</h6>
                        <p class="mb-0">{{$contact->address}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
						<div class="col-md-6 d-flex align-items-center justify-content-center">
							<div class="contact-queries flex-fill">
								<h2 class="mb-0">Get In Touch with us</h2>
								<p  >Any question or remarks? Just write us a message!</p>
								<form action="{{route('contact_store')}}" method="post">
								@csrf
									<div class="row">
										<div class="col-md-12">
											<div class="mb-3">
												<div class="form-group">
													<input required onkeydown="return /[a-z ]/i.test(event.key)" name="name" id="name" class="form-control" type="text" placeholder="Enter Name *" value={{ old('name') }}>
												     @if ($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<div class="form-group">
													<input required class="form-control" type="email" name="email" id="email" placeholder="Enter Email *" value={{ old('email') }}>
											         @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<div class="form-group">
													<input required class="form-control" type="text" name="phone_no" id="phone_no" placeholder="Enter 10 digit mobile number *" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('phone_no') }}>
											         @if ($errors->has('phone_no'))
                                                        <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                                    @endif
												</div>
											</div>
											 
											<div class="mb-3">
												<div class="form-group">
													<textarea onkeydown="return /[a-z ]/i.test(event.key)" class="form-control" placeholder="Enter Message" name="subject" id="subject" value={{ old('subject') }}></textarea>
												</div>
											</div>
										</div>
										 <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="label-text">Please type the characters below<span style="color:red;">*</span></label>
                                        <div style="display:flex; margin-top:20px;">
                                            <div class="box space" style="font-size:20px;padding:10px;">{{ $captcha }}</div>&emsp;&emsp;&emsp;&emsp;&emsp; 
                                            <input required class="form-control" type="text" id="userInput" name="captcha" placeholder="Enter Captcha" >  
                                             </div>
                                           @error('captcha')
                                            <div class="text-danger" style="margin-left:169px; ">{{ $message }}</div>
                                           @enderror
                                    </div>
                                   </div>
										<div class="col-md-12 submit-btn">
											<button class="btn btn-lg btn-linear-primary btn-responsive" type="submit">Send Message<i class="feather-arrow-right-circle ms-2"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /Get In Touch -->
			</div>
				
			</div>
		</div>

		<!-- Map -->
		<div class="map-grid">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.1015749108324!2d77.6624724748424!3d13.029203187291435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae111e83ef88b1%3A0x6ea223bbc67fad30!2sPrestige%20Gulmohar!5e0!3m2!1sen!2sin!4v1743053110484!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="contact-map"></iframe>
		</div>	
		
		<!-- /Map -->
		</div>
		<!-- /Page Wrapper -->
 
@include('frontend.include.footer')

 
<script>
    function isNumeric(event) {
      // Get the key code of the pressed key
      const keyCode = event.which ? event.which : event.keyCode;

      // Check if the key code corresponds to a numeric character or a special key
      if (keyCode >= 48 && keyCode <= 57 || keyCode === 8 || keyCode === 9 || keyCode === 37 || keyCode === 39 || keyCode === 46) {
        return true; // Allow input
      } else {
        return false; // Prevent input
      }
    }
</script>