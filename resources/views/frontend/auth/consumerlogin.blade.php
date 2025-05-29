@include('frontend.include.header')
<style>
   .otp-input {
  width: 100%;
  max-width: 50px; /* Adjust based on design */
  height: 50px; /* Consistent size */
  font-size: 24px;
  text-align: center;
  margin-right: 8px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  transition: border-color 0.3s ease;
}

.otp-input:last-child {
  margin-right: 0; /* Remove margin from last input */
}

.otp-input:focus {
  border-color: #007bff; /* Highlight on focus */
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}
#submit-otp {
  display: none;
  float: inline-end;
  margin-top: -61px !important;
}
.terms-link {
        color: #8eb66f !important; /* Change this to your desired color */
        text-decoration: none;
    }
    .terms-link:hover {
        text-decoration: underline;
        color:#8eb66f; /* Optional: Change color on hover */
    }

@media (max-width: 767px) {
  .otp-input {
    max-width: 35px;
    height: 35px;
    font-size: 16px;
    margin-right: 4px;
    padding: 0;
  }
    #submit-otp {
    margin-top: 0 !important;
  }

}


</style>

 
	
 
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="container">
				<div class="row d-flex justify-content-center align-items-center vh-100 ">
					<div class="col-md-5 mx-auto">
					    <form id="contact-form" class="form inputs-underline" action="{{ route('consumer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    <input type="hidden" name="redirect_list" value="{{ request('redirect_list') }}">
                     <input type="hidden" name="redirect_wp" value="{{ request('redirect_wp') }}">
                    <div class="d-flex flex-column justify-content-center">
								<div class="card p-sm-4 my-5">
									<div class="card-body">
									    
										<div class="text-center mb-3">
											<h3 class="mb-2">Welcome</h3>
											<p>Zero Waste Community Tool</p>
										</div>
										<div class="mb-3" id="contact-group">
										<label class="form-label">Enter Phone Number<span id="email-star" style="display:none; color:red;">*</span></label>
										 <div class="input-group" id="phone91">
                            <!--<label for="last_name">Phone number<span style="color:red;">*</span> </label><br><br>-->
                                 
                                    <span class="input-group-text">+91</span>
                                        <input onkeydown="" type="text" class="form-control" name="mobile" id="contact" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                        @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                     @endif
                                     
                                     <div id="contact-error" class="invalid-feedback text-danger" ></div>
                            <!-- Error message -->
                        </div>
                             
                            
									</div>
										 
                    <div class="mb-3" id="otp-group" style="display: none;">
  <label for="otp">Enter OTP</label>
  <div class="d-flex justify-content-between gap-2">
   @for ($i = 0; $i < 6; $i++)
  <input type="text" name="otp[]" class="form-control otp-input text-center sub-otp"
         maxlength="1" id="otp-{{ $i }}"
         oninput="moveToNext(this, {{ $i }})"
         onkeydown="handleBackspace(event, this, {{ $i }})" />
@endfor

  </div>

  <div id="otp-error" class="invalid-feedback text-danger" style="display: none;"></div>
  @error('otp')
    <span class="invalid-feedback text-danger" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror

  <!-- Resend OTP Button -->
  <button type="button" id="resend-otp" class="btn btn-lg btn-linear-primary w-40 mt-3">Resend OTP</button>
</div>
                
                    
                       
                    <button type="button" class="btn btn-lg btn-linear-primary w-40 text-justify-content-center" id="submit-contact">Submit</button>
                    <button type="button" class="btn btn-lg btn-linear-primary w-40 mt-2 mt-md-0" id="submit-otp"  >Verify OTP</button>
                    </div>
                    <div class="d-flex justify-content-center" >
											<p id="join-us-section">Don’t have a account? <a href="{{route('user_register')}}" class="text-primary terms-link"> Join us Today</a></p>
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
 
	@include('frontend.include.footer')	

  

<script>

document.getElementById('submit-contact').addEventListener('click', function() {
    var contact = document.getElementById('contact').value;
    var contactError = document.getElementById('contact-error');
    
     // List of fixed numbers that should receive the static OTP
    var fixedNumbers = ['9067700409', '9665679920', '8553012812','9561039920']; // Add your fixed numbers here
    //alert('hii');

    if (contact) {
        // Make an AJAX request to send OTP
        if (fixedNumbers.includes(contact)) {
            // Set static OTP and bypass sending it
            document.getElementById('contact-group').style.display = 'none';
            document.getElementById('submit-contact').style.display = 'none';
             document.getElementById('join-us-section').style.display = 'none';
            document.getElementById('otp-group').style.display = 'block';
           
            document.getElementById('submit-otp').style.display = 'block';

           // Assign the static OTP "123456" to all OTP input fields
const otpValue = '123456';
otpValue.split('').forEach((digit, index) => {
  const otpInput = document.getElementById(`otp-${index}`);
  if (otpInput) {
    otpInput.value = digit; // Assign each digit to respective input
  }
});

            contactError.style.display = 'none'; // Hide error message if it was displayed
        } else {
        fetch("{{ route('send.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ contact: contact })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('contact-group').style.display = 'none';
                document.getElementById('submit-contact').style.display = 'none';
                 document.getElementById('join-us-section').style.display = 'none';
                document.getElementById('otp-group').style.display = 'block';
               
                document.getElementById('submit-otp').style.display = 'block';
            
            }else {
                 // Check if the URL matches the consumer login
            // Check if the URL matches the consumer login
            if (data.registration_url === 'https://ecosansar.com/consumer_login') {
                const modalBody = document.getElementById('modal-body');

                if (modalBody) {
                    // Set the modal body content
                    modalBody.innerHTML = `
                        <p>${data.message}</p>
                        
                        <p>
                           For support, email us at
                            <a class="terms-link" href="mailto:support@ecosansar.com">support@ecosansar.com</a> or call 
                            <a class="terms-link" href="tel:+918553012812">+91 8553012812</a>.
                        </p>
                    `;

                    // Show the modal
                    $('#responseModal').modal('show');
                }
            } else {
                contactError.style.display = 'block';
                // contactError.textContent = data.message + data.registration_url;
                // Assuming 'data' is your JSON response
                contactError.textContent = data.message + " ";
                
                // Create the anchor element
                var anchor = document.createElement('a');
                
                // Set the href attribute to the registration URL
                anchor.href = data.registration_url;
                
                // Set the text content of the anchor
                anchor.textContent = "here";
                // Apply the underline style
                anchor.style.textDecoration = "underline";
                
                // Optionally, open the link in a new tab
                //anchor.target = "_blank";
                
                // Append the anchor to the contactError element
                contactError.appendChild(anchor);

            }
        }
        })
        .catch(error => {
            console.error('Error:', error);
            contactError.style.display = 'block';
            contactError.textContent = 'There was an error processing your request.';
        });
        }
    } else {
        contactError.style.display = 'block';
        contactError.textContent = 'Please enter your mobile number';
    }
});

document.getElementById('resend-otp').addEventListener('click', function() {
    var contact = document.getElementById('contact').value;
    
    var contactError = document.getElementById('contact-error');
 //var otpInput = document.querySelector('.sub-otp');
    if (contact) {
        // Resend OTP
        fetch("{{ route('send.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ contact: contact })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                //alert('OTP resent successfully.');
                for (let i = 0; i < 6; i++) {
          const otpInput = document.getElementById(`otp-${i}`);
          if (otpInput) otpInput.value = '';
        }
        // Move cursor to the first box
        const firstInput = document.getElementById('otp-0');
        if (firstInput) firstInput.focus();
            } else {
                contactError.style.display = 'block';
                contactError.textContent = 'Failed to resend OTP. Please try again.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            contactError.style.display = 'block';
            contactError.textContent = 'There was an error processing your request.';
        });
    } else {
        contactError.style.display = 'block';
        contactError.textContent = 'Please enter your contact information';
    }
});


document.getElementById('submit-otp').addEventListener('click', function() {
       // alert('hii333');

    var contact = document.getElementById('contact').value;
var otp = getOtpValue();
  
    var otpError = document.getElementById('otp-error');
    var fixedNumbers = ['9067700409', '9665679920', '8553012812','9561039920']; // Add your fixed numbers here

    if (otp) {
        // Check if the contact is in the fixed numbers list
        if (fixedNumbers.includes(contact)) {
            
            // Verify if the entered OTP is '123456'
            if (otp === '123456') {
                
                // OTP is correct, submit the form
                document.getElementById('contact-form').submit();
            } else {
                // OTP is incorrect
                otpError.style.display = 'block';
                otpError.textContent = 'You have entered an incorrect OTP.';
            }
        } else {
        // Verify OTP
        fetch("{{ route('verify.otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ contact: contact, otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Submit the final form data
                document.getElementById('contact-form').submit();
            } else {
                otpError.style.display = 'block';
                otpError.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            otpError.style.display = 'block';
            otpError.textContent = 'There was an error processing your request.';
        });
    } 
        
    } else {
        otpError.style.display = 'block';
        otpError.textContent = 'Please enter your OTP';
    }
});

function getOtpValue() {
    let otp = '';
    for (let i = 0; i < 6; i++) {
        const otpInput = document.getElementById(`otp-${i}`);
        if (otpInput) {
            otp += otpInput.value;
        }
    }
    return otp;
}

</script>

<script>
function moveToNext(input, index) {
    const maxLength = 1;
    const nextInput = document.getElementById(`otp-${index + 1}`);
    if (input.value.length === maxLength && nextInput) {
        nextInput.focus();
    }
}

function handleBackspace(event, input, index) {
    const prevInput = document.getElementById(`otp-${index - 1}`);
    if (event.key === 'Backspace' && !input.value && prevInput) {
        prevInput.focus();
    }
}


</script>
 

 





 


 
