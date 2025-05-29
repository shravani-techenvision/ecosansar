@include('frontend.include.header')
 <style>
         .row{
        margin-right: 0px;
        margin-left: 0px;
    }
     .tooltip-inner {
        background-color: #000; /* Light beige */
        color: #fff; /* Black text */
        border: 1px solid #000; /* Optional: Add a border */
        max-width: 200px; /* Increase width */
        width: 200px; /* Set fixed width if desired */
        padding-left: 5px; /* Reduce padding for height */
        font-size: 14px; /* Adjust font size if necessary */
        line-height: 1; /* Control text line spacing */
        margin-left:200px;
    }
    .tooltip-arrow {
        border-top-color: #f5f5dc !important; /* Match arrow color with the background */
    }
    @media screen and (max-width: 786px) {
    .tooltip-inner {
        background-color: #000; /* Light beige */
        color: #fff; /* Black text */
        border: 1px solid #000; /* Optional: Add a border */
        max-width: 200px; /* Increase width */
        width: 200px; /* Set fixed width if desired */
        padding-left: 3px; /* Reduce padding for height */
        font-size: 14px; /* Adjust font size if necessary */
        line-height: 1.2; /* Control text line spacing */
        margin-left:130px !important;
    }
}
    
        #map11 {
            height: 400px;
            width: 100%;
        }
    </style>
	<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<h2 class="breadcrumb-title mb-2">Register your interest</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Register your interest</li>
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
							     <div class="row">
                                        <p><b>Want us to reach YOU sooner?</b>
                                        Share your contact details, and we’ll notify you as soon as we’re available in your area. Plus, your interest will help us prioritize expansion to your community!</p>
                                      <p>  <b>Thank you for your support in building a cleaner, greener world with us! </b>🌿
                     </p>
                     </div>
							</div>
						</div>
						<!-- /Terms & Conditions -->
						
					</div>
					<hr>
						<div class="row">
					 
						<div class="col-md-12 d-flex align-items-center justify-content-center">
							<div class="contact-queries flex-fill">
								<h2 class="mb-4">Share Your Contact Details</h2>
								<form action="{{route('check-pincode-save')}}" method="post">
								@csrf
									<div class="row">
									    <div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
									    <label>Collection Agent's Name:</label>
                                        <input required onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="collagent_name" id="collagent_name" placeholder="Enter Collection Agent's Name" value={{ old('collagent_name') }}>
                                         @if ($errors->has('collagent_name'))
                                    <span class="text-danger">{{ $errors->first('collagent_name') }}</span>
                                @endif
												</div>
											</div>
									        </div>
									        <div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
									    <label>Contact Number (WhatsApp preferred):</label>
                                        <input required  onkeypress="return isNumeric(event)" minlength="10" maxlength="10"  type="text" class="form-control" name="collagent_phoneno" id="collagent_phoneno" placeholder="Enter Contact Number (WhatsApp preferred)" value={{ old('collagent_phoneno') }}>
                                         @if ($errors->has('collagent_phoneno'))
                                    <span class="text-danger">{{ $errors->first('collagent_phoneno') }}</span>
                                @endif
												</div>
											</div>
									        </div>
									          
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Enter your address
                                                                            <span class="text-danger">*</span></label>
                                                                        <input required type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                                                    </div>
                                                                    <div class="col-md-2 ">
                                                                          <label class="form-label d-block">&nbsp;
                                                                             </label>
                                                                    <button type="button" class="btn btn-linear-primary" onclick="geocodeAddress()" >Show on Map</button><br><br>
                                                             </div>  
                                                             
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                    <div id="map11"></div> <br><br>
                                                            
                                                                    <input type="hidden" id="latitude" name="latitude">
                                                                    <input type="hidden" id="longitude" name="longitude">
                                                            </div></div> 
									        <div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												    <label>Any Additional Info (optional):</label>
											<textarea class="form-control" id="message" rows="4" name="message" placeholder="Enter Message"></textarea>
												</div>
											</div>
											</div>
										<div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
											 <label>Your Name (Optional):</label>
                                        <input required onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value={{ old('name') }}>
                                         @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
												</div>
											</div>
									        </div>
									        <div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
												    <label>Your Contact (Optional):</label>
													 <input required type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter 10 digit mobile number" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('phone_no') }}>
                                         @if ($errors->has('phone_no'))
                                    <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                @endif
												</div>
											</div>
											</div>
										 
											<div class="row">
											 
											 
											 
											 
												
										</div>
										  
										<div class="col-md-12 submit-btn">
											<button class="btn btn-lg btn-linear-primary btn-responsive-width align-items-center " type="submit">Send Message<i class="feather-arrow-right-circle ms-2"></i></button>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0&libraries=places"></script>
 <script>
    let map11;
    let marker;
     let autocomplete;

    function initMap(lat = 28.6139, lng = 77.2090) { // Coordinates for New Delhi, India
        map11 = new google.maps.Map(document.getElementById('map11'), {
            center: { lat: lat, lng: lng },
            zoom: 14
        });

        marker = new google.maps.Marker({
            map: map11,
            draggable: true,
            position: { lat: lat, lng: lng }
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            document.getElementById('latitude').value = marker.getPosition().lat();
            document.getElementById('longitude').value = marker.getPosition().lng();
        });
         // Initialize Autocomplete
                autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        map11.setCenter(place.geometry.location);
                        marker.setPosition(place.geometry.location);
                        document.getElementById('latitude').value = place.geometry.location.lat();
                        document.getElementById('longitude').value = place.geometry.location.lng();
                    }
                });
    }

    function geocodeAddress() {
        const address = document.getElementById('address').value;
        
       // alert(address);
        
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === 'OK') {
                map11.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                document.getElementById('latitude').value = results[0].geometry.location.lat();
                document.getElementById('longitude').value = results[0].geometry.location.lng();
                
                // Check if latitude and longitude are successfully retrieved
                if (!latitude || !longitude) {
                    alert('Failed to get the latitude and longitude. Please try again.');
                }
                
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    
    

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
    
    
    // Check latitude and longitude on form submit
    document.getElementById('locationForm').addEventListener('submit', function(event) {
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (!latitude || !longitude) {
            event.preventDefault(); // Stop form from submitting
            alert('Please make sure the location is correctly set on the map. Click on Show on Map button');
        }
    });
    
</script>
@include('frontend.include.footer')
 