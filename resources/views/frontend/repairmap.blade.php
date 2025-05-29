@include('frontend.include.header')
<style>
 .square-box {
  width: 100%;
  height: 108px; /* Adjust height as needed */
  background-size: cover; /* Ensures the image covers the box */
  background-position: center; /* Centers the background image */
  background-repeat: no-repeat;
  color: white;
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}

/* Optional overlay to make text more visible */
.square-box::before {
  content: "";
  position: absolute;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.3); /* Adjust transparency */
  border-radius: 10px;
}

.square-box span {
  z-index: 1;
  position: relative;
}

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
						<h2 class="breadcrumb-title mb-2">Repair Map</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Repair Map</li>
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
			<div class="page-wrapper">
			<div class="content">
				<div class="container">
					<div class="row">
					   <div class="col-md-8">
                            <iframe src="https://www.google.com/maps/d/embed?mid=1EEYoJi-3uN8u1HHdDz9ag2UVXzjrh1g&ehbc=2E312F" width="100%" height="480"  allowfullscreen="" ></iframe> 
                        </div> 
					</div>
			
					
		 
			<div class="row mt-4">
  <!-- Left side: Form Section -->
  <div class="col-md-6 d-flex align-items-center justify-content-center">
    <div class="contact-queries flex-fill">
      <h4>Contribute to the Map | Do you know a repair service? Use the fields below to provide details. We will pin it on the map. Thank you for your contribution!</h4>
      <form action="{{route('repair_contact_store')}}" method="post">
        @csrf
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="mb-3">
              <input required onkeydown="return /[a-z ]/i.test(event.key)" name="name" id="name" class="form-control" type="text" placeholder="Enter Name *" value="{{ old('name') }}">
              @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>
          <div class="mb-3">
              <input required class="form-control" type="text" name="phone_no" id="phone_no" placeholder="Enter 10 digit mobile number *" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value="{{ old('phone_no') }}">
              @if ($errors->has('phone_no'))
                <span class="text-danger">{{ $errors->first('phone_no') }}</span>
              @endif
            </div>
            <div class="mb-3">
              <input required class="form-control" placeholder="Enter Location" name="location" id="location" value="{{ old('location') }}">
               @if ($errors->has('location'))
                <span class="text-danger">{{ $errors->first('location') }}</span>
              @endif
            </div>
             <div class="mb-3">
              <input required class="form-control" placeholder="Enter Pincode" name="pincode" id="pincode" value="{{ old('pincode') }}" onkeypress="return isNumeric(event)" minlength="6" maxlength="6" >
               @if ($errors->has('pincode'))
                <span class="text-danger">{{ $errors->first('pincode') }}</span>
              @endif
            </div>
            
            <div class="mb-3">
												<select required class="select" name="type_of_service" id="type_of_service">
												 <option value="">Select</option>
                                                <option value="Alteration Tailors" {{ old('type_of_service') == 'Alteration Tailors' ? 'selected' : '' }}>Alteration Tailors</option>
                                                <option value="Cobblers" {{ old('type_of_service') == 'Cobblers' ? 'selected' : '' }}>Cobblers</option>
                                                <option value="Knife Sharpeners" {{ old('type_of_service') == 'Knife Sharpeners' ? 'selected' : '' }}>Knife Sharpeners</option>
                                                 <option value="Umbrella Repairs" {{ old('type_of_service') == 'Umbrella Repairs' ? 'selected' : '' }}>Umbrella Repairs</option>
                                                  <option value="Other" {{ old('type_of_service') == 'Other' ? 'selected' : '' }}>Other</option>
												</select>
												<div id="other-service-box" style="display: none; margin-top: 10px;">
                                                    <input type="text" name="other_service"   class="form-control" placeholder="Enter your service" value="{{ old('other_service') }}">
                                                 @if ($errors->has('other_service'))
                                                    <span class="text-danger">{{ $errors->first('other_service') }}</span>
                                                 @endif
                                                </div>
												 @if ($errors->has('type_of_service'))
                                                    <span class="text-danger">{{ $errors->first('type_of_service') }}</span>
                                                 @endif
											</div>
          </div>
          <div class="row text-center">
          <div class="col-md-6 submit-btn mb-3">
            <button class="btn btn-lg btn-linear-primary btn-responsive " type="submit">Send Message<i class="feather-arrow-right-circle ms-2"></i></button>
          </div>
           <div class="col-md-6  mb-3">
               <a href="url('/')">
               <button class="btn btn-lg btn-linear-primary btn-responsive " type="submit">Homepage<i class="feather-arrow-right-circle ms-2"></i></button>
               </a>
            </div>
            </div>
        </div>
      </form>
    </div>
  </div>

<!--<div class="col-md-6 mt-3 d-flex flex-column justify-content-center">-->
  <!-- First Div with Background Image -->
<!--  <a href="#">-->
<!--    <div class="square-box mb-3 d-flex align-items-center justify-content-center" -->
<!--      style="background-image: url('{{ asset('frontend/assets/img/icons/recycle-symbol.png') }}');">-->
<!--      <span>Looking for a collection agent?</span>-->
<!--      <p>Find one nearest to you</p>-->
<!--    </div>-->
<!--  </a>-->

  <!-- Second Div with Background Image -->
<!--  <a href="{{url('/')}}">-->
<!--    <div class="square-box d-flex align-items-center justify-content-center"-->
<!--      style="background-image: url('{{ asset('frontend/assets/img/icons/recycle-symbol.png') }}');">-->
<!--      <span>Homepage</span>-->
<!--    </div>-->
<!--  </a>-->
<!--</div>-->
 <!--           <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">-->
 <!--             <a href="#"><button class="btn btn-lg btn-linear-primary w-100 w-md-50 " type="submit">Looking for a collection agent?<br>-->
 <!--Find one nearest to you<i class="feather-arrow-right-circle ms-2"></i></button></a>-->
 <!--                <a href="{{url('/')}}"> <button class="btn btn-lg btn-linear-primary w-100 w-md-50 mt-4" type="submit">Homepage<i class="feather-arrow-right-circle ms-2"></i></button></a>-->
 <!--           </div>-->




</div>

		</div>
		</div>
 
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
<script>
    $(document).ready(function () {
        function toggleOtherBox() {
            if ($('#type_of_service').val() === 'Other') {
                 
                $('#other-service-box').show();
            } else {
                $('#other-service-box').hide();
                $('#other_service').val(''); // Optional: clear the field
            }
        }

        // Initial check on page load
        toggleOtherBox();

        // Check on change
        $('#type_of_service').change(function () {
            toggleOtherBox();
        });
    });
</script>
