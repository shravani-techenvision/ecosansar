@include('frontend.include.header1')
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

 

@media (max-width: 767px) {
  .otp-input {
    max-width: 35px;
    height: 35px;
    font-size: 16px;
    margin-right: 4px;
    padding: 0;
  }
}


</style>
 <body class="authentication-page">

	<div class="d-flex justify-content-between vh-100 overflow-auto flex-column">
		
	<!-- Header -->
	<div class="authentication-header">
		<div class="container">
			<div class="col-md-12">
				<div class="text-center">
				    <a href="{{url('/')}}">
					<img src="{{ asset('frontend/assets/img/logo-one.png') }}" alt="logo"></a>
				</div>
			</div>
		</div>
	</div>	
	<!-- /Header -->
		<div class="main-wrapper">
		<div class="container">
		 
			<div class="row justify-content-center">
				<div class="col-md-5 mx-auto">
				      <form id="contact-form" class="form inputs-underline" action="{{ route('consumer.store') }}" method="POST">
                    @csrf
                    <div class="d-flex flex-column justify-content-center">
							<div class="card p-sm-4 my-5">
								<div class="card-body">
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    <input type="hidden" name="redirect_list" value="{{ request('redirect_list') }}">
                    <div class="form-group" id="contact-group" style="display: none;">
                        <label for="contact">Phone33</label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" minlength="10" maxlength="10" value={{ $users->mobile }} name="contact" id="contact" placeholder="Your phone">
                        <div id="contact-error" class="invalid-feedback text-danger" style="display: none;"></div>
                        @error('mobile')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!--end form-group  id="otp-group style="display: none;""-->
                
                   <!--<div class="mb-3">-->
                   <!--     <label for="otp">OTP</label>-->
                   <!--     <input type="password" class="form-control @error('otp') is-invalid @enderror" minlength="6" maxlength="6" name="otp" id="otp" placeholder="Your OTP">-->
                   <!--     <div id="otp-error" class="invalid-feedback text-danger" ></div>-->
                   <!--     @error('otp')-->
                   <!--         <span class="invalid-feedback text-danger" role="alert">-->
                   <!--             <strong>{{ $message }}</strong>-->
                   <!--         </span>-->
                   <!--     @enderror-->
                   <!--     <button type="button" id="resend-otp" class="btn btn-lg btn-linear-primary w-40 float-end mt-3" >Resend OTP</button>-->
                   <!-- </div>-->
                   <div class="mb-3">
  <label for="otp">OTP</label>
  <div class="d-flex justify-content-center flex-wrap">
    @for ($i = 0; $i < 6; $i++)
      <input 
        type="text" 
        name="otp[]" 
        class="form-control otp-input text-center" 
        maxlength="1" 
        id="otp-{{ $i }}" 
        oninput="moveToNext(this, {{ $i }})" 
        onkeydown="handleBackspace(event, this, {{ $i }})"
      />
    @endfor
  </div>
  <div id="otp-error" class="invalid-feedback text-danger" ></div>
  
  @error('otp')
    <span class="invalid-feedback text-danger" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror

  <button type="button" id="resend-otp" class="btn btn-lg btn-linear-primary w-40 float-end mt-3">Resend OTP</button>
</div>

                    <!--end form-group-->
                
                    <!--<button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-contact">Submit</button>-->
                    <button type="button" class="btn btn-lg btn-linear-primary w-40 mt-2 mt-md-0" id="submit-otp" >Verify OTP</button>
                    </div>
							</div>						
							
						</div>
                </form>
				</div>
			</div>
		</div>
	</div>
		<!-- Footer -->
	<div class="footer-copyright  bg-transparent">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p> &copy; ecoSansar <?php echo date('Y');?>. All Rights Reserved </p>
				</div>
			</div>
		</div>
	</div>
	<!-- /Footer -->
	
	</div>
 
<!--end page-content-->

<script>

document.getElementById('resend-otp').addEventListener('click', function(){
    var contact = document.getElementById('contact').value;
  // alert(contact);
    var contactError = document.getElementById('contact-error');
     
    if (contact) {
        // Resend OTP
        fetch("{{ route('resend_Otp') }}", {
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
               // alert('OTP resent successfully.');
              for (let i = 0; i < 6; i++) {
          const otpInput = document.getElementById(`otp-${i}`);
          if (otpInput) otpInput.value = '';
        }
        // Move cursor to the first box
        const firstInput = document.getElementById('otp-0');
        if (firstInput) firstInput.focus();
            } else {
              // contactError.style.display = 'block';
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
    var contact = document.getElementById('contact').value;
    
    var otpError = document.getElementById('otp-error');

   // Collecting OTP from multiple input fields
    let otp = '';
    for (let i = 0; i < 6; i++) {
        const otpInput = document.getElementById(`otp-${i}`);
        if (otpInput) {
            otp += otpInput.value;
        }
    }

    if (otp.length === 6) {
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
            if (data.status === 'success'){
                // Submit the final form data
                console.log('User ID:', data.user_id);
               // alert('OTP verify successfully.');
                 window.location.href = "{{ url('profile') }}/" + data.user_id;
                //document.getElementById('contact-form').submit();
            } else {
                otpError.style.display = 'block';
                otpError.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
           // otpError.style.display = 'block';
            otpError.textContent = 'There was an error processing your request.';
        });
    } else {
        //otpError.style.display = 'block';
        otpError.textContent = 'Please enter your OTP';
    }
});
 </script>

<script>
    function moveToNext(input, index) {
  const nextInput = document.getElementById(`otp-${index + 1}`);
  if (input.value && nextInput) {
    nextInput.focus();
  }
}

function handleBackspace(event, input, index) {
  if (event.key === "Backspace" && !input.value) {
    const prevInput = document.getElementById(`otp-${index - 1}`);
    if (prevInput) {
      prevInput.focus();
    }
  }
}

</script>
 


 
