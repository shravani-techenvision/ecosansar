@include('frontend.include.header')
 
	<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<h2 class="breadcrumb-title mb-2">Services</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Services</li>
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
                                use App\Models\admin\Service; // Import the About model
                                
                                $howitwork = Service::get();
                             @endphp
                
                            @foreach($howitwork as $item)
                                {!! $item->content !!}
                            @endforeach
							</div>
						</div>
						<!-- /Terms & Conditions -->
						
					</div>
					<hr>
						<div class="row">
					 
						<div class="col-md-12 d-flex align-items-center justify-content-center">
							<div class="contact-queries flex-fill">
								<h2 class="mb-4">Get In Touch</h2>
								<form action="{{ route('service_enquiry.save') }}" method="post">
								@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												    <label>Enter Name <span class="text-danger">*</span></label>
												 <input required onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="  Name" value={{ old('name') }}>
                                                    @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                 @endif
												</div>
											</div>
									        </div>
									        <div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												    <label>Enter Phone No <span class="text-danger">*</span></label>
													 <input required type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone Number" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                                    @if ($errors->has('mobile'))
                                                         <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                                    @endif
												</div>
											</div>
											</div>
											</div>
											<div class="row">
											<div class="col-md-6">
											<div class="mb-3">
											    <label>Select type of service <span class="text-danger">*</span></label>
												<select required class="select" name="type_of_service" id="type_of_user">
												 <option value="">Select</option>
                                                <option value="Bulk Collection Drive" {{ old('type_of_service') == 'Bulk Collection Drive' ? 'selected' : '' }}>Bulk Collection Drive</option>
                                                <option value="Specific Material Collection" {{ old('type_of_service') == 'Specific Material Collection' ? 'selected' : '' }}>Specific Material Collection</option>
                                                <option value="Other" {{ old('type_of_service') == 'Other' ? 'selected' : '' }}>Other</option>
												</select>
												 @if ($errors->has('type_of_service'))
                                                    <span class="text-danger">{{ $errors->first('type_of_service') }}</span>
                                                 @endif
											</div>
											</div>
											</div>
											<div class="row">
											<div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												     <label>Enter Address <span class="text-danger">*</span></label>
													<textarea required class="form-control" rows="4" cols="50" name="address" id="address" placeholder="Address">{{ old('address') }}</textarea>
                                                    @if ($errors->has('address'))
                                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                                    @endif
												</div>
											</div>
											</div>
											<div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												     <label>Enter Message <span class="text-danger">*</span></label>
												 <textarea required class="form-control" rows="4" cols="50" name="message" id="message" placeholder="Message">{{ old('address') }}</textarea>
                                                @if ($errors->has('message'))
                                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                                @endif
												</div>
											</div>
											</div>
										</div>
										  
										<div class="col-md-12 submit-btn">
											<button class="btn btn-lg btn-linear-primary w-25 align-items-center " type="submit">Send Message<i class="feather-arrow-right-circle ms-2"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

 
<script>
    function isNumeric(event) {
      // Get the key code of the pressed key
      const keyCode = event.which ? event.which : event.keyCode;

      // Allow only numeric characters (0-9)
      if (keyCode >= 48 && keyCode <= 57) {
        return true; // Allow input
      } else {
        event.preventDefault(); // Prevent input if it's not a number
        return false;
      }
    }
</script>
@include('frontend.include.footer')
 