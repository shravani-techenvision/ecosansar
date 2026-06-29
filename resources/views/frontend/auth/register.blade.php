
 @include('frontend.include.header')
 <style>
     .trust-us-section {
    position: relative;
    padding-top: 40px;
    background-color: #fff;
    z-index: 1;

}
.trust-us-main {
  background: linear-gradient(135deg, #ffffff, #f8f9fa);
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}

.trust-us-main:hover {
  background: linear-gradient(90deg,#000000, #8eb66f); /* Gradient on hover */
  color: #fff; /* Change text color to white */
  transform: translateY(-10px) scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.trust-us-main:hover h3 {
    color:white;
}
   .terms-link {
        color: #8eb66f !important; /* Change this to your desired color */
        text-decoration: none;
    }
    .terms-link:hover {
        text-decoration: underline;
        color:#8eb66f; /* Optional: Change color on hover */
    }
 </style>


	<div class="d-flex justify-content-between     flex-column">



	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="container">
		    <section class="trust-us-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="section-heading section-heading-four category-heading aos" data-aos="fade-up">

						<!--<p>Welcome! We're thrilled to have you here. Choose your role to register:</p>-->
						<p>Welcome! We're thrilled to have you here. Register as a Collection Agent to get started.</p>
					</div>
				</div>
			</div>
			<div class="row justify-content-center row-gap-3">
				<!--<div class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex">-->
				<!--	<div class="trust-us-main flex-fill">-->

				<!--		<h3 class="text-truncate">Contributor</h3>-->
				<!--		<p>For Waste / Resource Generators (consumers)</p>-->
				<!--	</div>-->
				<!--</div>-->
				<div class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex">
					<div class="trust-us-main flex-fill">

						<h3 class="text-truncate">Collection Agent</h3>
						<p>Resource Pickup Agents</p>
					</div>
				</div>
				<!--<div class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex">-->
				<!--	<div class="trust-us-main flex-fill">-->

				<!--		<h3 class="text-truncate">Corporate</h3>-->
				<!--		<p>Brands / Waste Management Companies / Recyclers / businesses dealing in bulk quantities</p>-->
				<!--	</div>-->
				<!--</div>-->

			</div>
		</div>
	</section>
			<div class="row justify-content-center">
				<div class="col-md-5 mx-auto">
					<form id="registerForm" method="POST">
					    @csrf
						<div class="d-flex flex-column justify-content-center">
							<div class="card p-sm-4 my-5">
								<div class="card-body">
									<!--<div class="text-center mb-3">-->
									<!--	<h3 class="mb-2">User Signup</h3>-->
									<!--	<p>Enter your credentials to access your account</p>-->
									<!--</div>-->
									<!--<div class="mb-3">-->
									<!--	<label class="form-label">Who you are<span style="color:red;">*</span></label>-->
									<!--	<select class="select" name="type_of_user" id="type_of_user">-->
									<!--		<option value="">Select</option>-->
         <!--                                   <option value="consumer" {{ old('type_of_user') == 'consumer' ? 'selected' : '' }}>Contributor</option>-->
         <!--                                   <option value="sab" {{ old('type_of_user') == 'sab' ? 'selected' : '' }}>Collection Agent</option>-->
         <!--                                   <option value="business" {{ old('type_of_user') == 'business' ? 'selected' : '' }}>Business</option>-->
									<!--	</select>-->
									<!--	@if ($errors->has('type_of_user'))-->
         <!--                                   <span class="text-danger">{{ $errors->first('type_of_user') }}</span>-->
         <!--                                @endif-->
         <!--                                  <span class="error-message text-danger" id="type_of_user-error"></span>-->
									<!--</div>-->
									<input type="hidden" name="type_of_user" value="sab">
									<div class="mb-3">
										<label class="form-label">Name<span style="color:red;">*</span></label>
										 <input onkeydown="return /[a-z0-9 ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Name" value={{ old('name') }}>
								         <span class="error-message text-danger" id="name-error"></span>
									</div>
									<div class="mb-3">
										<label class="form-label">Phone number<span style="color:red;">*</span></label>
                                       <input onkeydown="" type="text" class="form-control" name="mobile" id="contact" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                       <span class="error-message text-danger" id="mobile-error"></span>

                                    <div id="contact-error" class="invalid-feedback text-danger" style="display: none;"></div>
                                     @if ($errors->has('mobile'))
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                            <!--<button type="button" id="resend-otp" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="margin-top:17px; float:inline-end;">Resend OTP</button>-->
                                         @endif
									</div>
									<div class="mb-3">
										<label class="form-label"> Address<span style="color:red;">*</span></label>
                                       <textarea
                                    class="form-control"
                                    rows="4"
                                    cols="50"
                                    name="address"
                                    id="address"
                                    placeholder="Address"
                                >{{ old('address') }}</textarea>
                                @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif

                                 <span class="error-message text-danger" id="address-error"></span>
									</div>
									<div class="mb-3">
										<label class="form-label">Pincode<span style="color:red;">*</span></label>
										<input onkeydown="" type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" minlength="6" maxlength="6" value={{ old('pincode') }}>
                                @if ($errors->has('pincode'))
                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                             @endif

                             <span class="error-message text-danger" id="pincode-error"></span>
									</div>
									<div class="mb-3" id="hide-tresi">
										<label class="form-label">Type of residences<span style="color:red;"></span> </label>
										<select class="select" name="type_of_residences" id="type_of_residences">
												<option value="">Select</option>
                                        <option value="Gated community apartment" {{ old('type_of_residences') == 'Gated community apartment' ? 'selected' : '' }}>Gated community apartment</option>
                                        <option value="Gated community villa" {{ old('type_of_residences') == 'Gated community villa' ? 'selected' : '' }}>Gated community villa</option>
                                        <option value="Independent house apartment" {{ old('type_of_residences') == 'Independent house apartment' ? 'selected' : '' }}>Independent house apartment</option>
                                        <option value="Independent villa" {{ old('type_of_residences') == 'Independent villa' ? 'selected' : '' }}>Independent villa</option>
												</select>
												 @if ($errors->has('type_of_residences'))
                                <span class="text-danger">{{ $errors->first('type_of_residences') }}</span>
                             @endif
                               <span class="error-message text-danger" id="type_of_residences-error"></span>
									</div>
										<div class="mb-3" id="hide-em">
										<label class="form-label">Email id<span id="email-star" style="display:none; color:red;">*</span></label>
										 <input type="email" class="form-control" name="email" id="email" placeholder="Email" value={{ old('email') }}>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                             @endif

                             <span class="error-message text-danger" id="email-error"></span>
									</div>


									<div class="mb-3"  >
										<label class="form-label"> Please type the characters below<span style="color:red;">*</span></label>
										  <div style="display:flex; ">
                                            <div class="box space" style="font-size:20px;padding:10px;">{{ $captcha }}</div>&emsp;&emsp;&emsp;&emsp;&emsp;
                                            <input class="form-control" type="text" id="userInput" name="captcha" placeholder="Enter Captcha" >
                                             </div>

                              <span class="error-message text-danger" id="captcha-error"></span>
                               @if ($errors->has('captcha'))
                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                        @endif
									</div>




									<div class="mb-3">
										<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
											<div class="form-check">

												<label class="form-check-label" for="remember_me">
												    <input class="form-check-input"  type="checkbox" name="terms" id="terms" value="accepted" {{ old('terms') ? 'checked' : '' }}>
													 I have read and agree to the <a target="_blank" href="{{ route('terms_conditions') }}" class="text-primary terms-link">Terms and condition</a> and <a target="_blank" href="{{ route('privacypolicy') }}" class="text-primary terms-link">Privacy policy </a> of this website
												</label>
											</div>
											<span class="error-message text-danger" id="terms-error"></span>
											 @if ($errors->has('terms'))
                            <span class="text-danger">{{ $errors->first('terms') }}</span>
                        @endif
										</div>
									</div>
									<div class="mb-3">
										<button type="submit" class="btn btn-lg btn-linear-primary w-100">Sign Up</button>
									</div>

									<div class=" d-flex justify-content-center">
										<p>Already have a account? <a href="{{route('consumer_login')}}" class=" " style="color:#406c1e;">Sign In</a></p>
									</div>
								</div>
								<div>
									<img src="{{ asset('frontend/assets/img/bg/authentication-bg.png') }}" class="bg-left-top" alt="Img">
									<img src="{{ asset('frontend/assets/img/bg/authentication-bg.png') }}" class="bg-right-bottom" alt="Img">
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->



	</div>



@include('frontend.include.footer')



<script>
document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

   //alert('hhh');

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(function(element) {
        element.innerHTML = '';
    });

    // Collect form data
    let formData = new FormData(this);

    // Send the form data using AJAX
    fetch('{{ route('consumer.save') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        // Handle the response
       if (data.errors) {
            // Display errors next to the respective form fields
            for (let field in data.errors) {
                document.getElementById(`${field}-error`).innerHTML = data.errors[field][0];
            }
        } else {

           // alert(data.user_id);
            // Display success message
               window.location.href = "{{ url('register_otp') }}/" + data.user_id;
            // document.getElementById('responseMessage').innerHTML = `<p>${data.success}</p>`;
            // // Optionally, clear the form
            // document.getElementById('registerForm').reset();
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>




<script>
      document.getElementById('resend-otp').addEventListener('click', function(){
        var contact = document.getElementById('contact').value;
      // alert(contact);
        var contactError = document.getElementById('contact-error');
        var otpInput = document.getElementById('otp');
        if (contact) {
            // Resend OTP
            fetch("{{ route('resend_Otp') }}",{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ contact: contact })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success'){
                   // alert('OTP resent successfully.');
                      window.location.href = "{{ url('register_otp') }}/" + data.user_id;
                    otpInput.value = ''; // Clear the OTP input field

                } else {
                     //alert('OTP resent successfully22222.');
                  // contactError.style.display = 'block';
                    contactError.textContent = 'Failed to resend OTP. Please try again.';
                }
            })
            .catch(error => {
                 //alert('OTP resent successfully333.');
                console.error('Error:', error);
                contactError.style.display = 'block';
                contactError.textContent = 'There was an error processing your request.';
            });
        } else {
            contactError.style.display = 'block';
            contactError.textContent = 'Please enter your contact information';
        }
    });
</script>

<script>

    $(document).ready(function(){
        function toggleFields() {
            var userType = $('#type_of_user').val();
          // alert(userType);
            if (userType === 'business') {
                $('#email-star').css('display', 'inline');
                $('#password-star').css('display', 'inline');
                $('#hide-tresi').css('display', 'none');
                $('#hide-pass').css('display', 'block');
                $('#hide-em').css('display', 'block');
            } else if (userType === 'consumer') {
                $('#email-star').css('display', 'inline');
                $('#hide-pass').css('display', 'none');
                $('#hide-tresi').css('display', 'inline');
                $('#hide-em').css('display', 'block');
            } else {
                $('#hide-em').css('display', 'none');
                $('#hide-pass').css('display', 'none');
                $('#hide-tresi').css('display', 'none');
            }
        }

        $('#type_of_user').change(toggleFields);
        toggleFields(); // Call it initially to set the correct state on page load
    });
</script>






