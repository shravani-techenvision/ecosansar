@include('frontend.include.header')
@include('sweetalert::alert')
<style>
 .row{
        margin-right: 0px;
        margin-left: 0px;
    }
     .input-group-addon{
        background-color:white !important;
        border:none !important;
        border-bottom: 2px solid #cccccc6e !important;
    }
@media (max-width: 767px) {
.reg{
   font-size: 28px!important;
   font-weight: 500!important;
}
}
</style>
 <!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->
<div id="page-content">
    <div class="container">
        <ul class="nav nav-tabs ultop" >
       </ul>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                <section class="page-title mt-3">
                    <div class="col-md-12">
                             <h1 class="reg" ><u style="color: #8eb66f;">Sign In</u><span> |  <a href="{{route('user_register')}}">Register</a></span></h1>
                        </div>
                </section>

                <section>
                <form id="contact-form" class="form inputs-underline" action="{{ route('consumer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    <input type="hidden" name="redirect_list" value="{{ request('redirect_list') }}">

                   <div class="form-group" id="contact-group">
                        <label for="contact">Phone</label><br>
                        <div class="input-group" id="phone91">
                            <!--<label for="last_name">Phone number<span style="color:red;">*</span> </label><br><br>-->
                                <div class="input-group" >
                                    <span class="input-group-addon">+91</span>
                                        <input onkeydown="" type="text" class="form-control" name="mobile" id="contact" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                        @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                     @endif
                                    </div>
                                     <div id="contact-error" class="invalid-feedback text-danger" ></div>
                            <!-- Error message -->
                        </div>
                    </div>


                    <div class="form-group" id="otp-group" style="display: none;">
                        <label for="otp">OTP</label>
                        <input type="password" class="form-control @error('otp') is-invalid @enderror" minlength="6" maxlength="6" name="otp" id="otp" placeholder="Your OTP">
                        <div id="otp-error" class="invalid-feedback text-danger" style="display: none;"></div>
                        @error('otp')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="button" id="resend-otp" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="margin-top:17px; ">Resend OTP</button>
                    </div>
                    <!--end form-group-->

                    <button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-contact">Submit</button>
                    <button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-otp" style="display: none;float:inline-end; margin-top:-55px;">Verify OTP</button>
                </form>

                    {{--  <hr>  --}}

                    {{--  <a href="#" data-modal-external-file="modal_reset_password.php" data-target="modal-reset-password">I have forgot my password</a>  --}}
                </section>
            </div>
            <!--col-md-4-->
        </div>
        <!--end ro-->
    </div>
    <!--end container-->
</div>
<!--end page-content-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!--<script>-->
<!--    document.getElementById('contact').addEventListener('input', function() {-->
         <!--Check if the value already starts with +91-->
<!--        if (!this.value.startsWith('+91')) {-->
<!--            this.value = '+91' + this.value.replace(/^\+91/, '');-->
<!--        }-->
<!--    });-->
<!--</script>-->


<script>

document.getElementById('submit-contact').addEventListener('click', function() {
    var contact = document.getElementById('contact').value;
    var contactError = document.getElementById('contact-error');
  // List of fixed numbers that should receive the static OTP
  var fixedNumbers = ['9067700409', '9665679920', '9561039920', '8553012812', '9611944188', '9972825642']; // Add your fixed numbers here
    //alert('hii');

    if (contact) {
        if (fixedNumbers.includes(contact)) {
            // Set static OTP and bypass sending it
            document.getElementById('contact-group').style.display = 'none';
            document.getElementById('submit-contact').style.display = 'none';
            document.getElementById('otp-group').style.display = 'block';
            document.getElementById('submit-otp').style.display = 'block';

            // Optionally, prefill the OTP field with 123456 for the user
            document.getElementById('otp').value = '123456';
            contactError.style.display = 'none'; // Hide error message if it was displayed
        } else {
        // Make an AJAX request to send OTP
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
                document.getElementById('otp-group').style.display = 'block';
                document.getElementById('submit-otp').style.display = 'block';

            }else {
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
 var otpInput = document.getElementById('otp');
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
                otpInput.value = ''; // Clear the OTP input field
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
    var otp = document.getElementById('otp').value;
    var otpError = document.getElementById('otp-error');
  // List of fixed numbers that should receive the static OTP
  var fixedNumbers = ['9067700409', '9665679920', '9561039920', '8553012812', '9611944188', '9972825642']; // Add your fixed numbers here


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


</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 5000
            });
        @endif

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ Session::get('info') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ Session::get('warning') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    });
</script>





@include('frontend.include.footer')



