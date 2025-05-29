@include('frontend.include.header')
@include('sweetalert::alert')
<style>
 .row{
        margin-right: 0px;
        margin-left: 0px;
    }
@media (max-width: 767px) {
.reg{
   font-size: 28px!important;
   font-weight: 500!important;
}
}  
</style>
<div id="page-content">
    <div class="container">
        <ul class="nav nav-tabs ultop" >
            
           
           
       </ul>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                <section class="page-title mt-3">
                    <div class="col-md-12">
                             <h1 class="reg" >Reset Password</h1> 
                        </div>
                </section>
                
                <section>
                    <form id="contact-form" class="form inputs-underline" action="{{ route('consumer.store') }}" method="POST">
                        @csrf
                  
            

    

    <div class="form-group" id="password-group"  >
        <label for="password">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="password" id="password" placeholder="Your password">
        @error('password')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        
    </div>
    <!--end form-group-->

    <button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-contact">Submit</button>
    <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-otp" style="display: none;">Verify OTP</button>
    <button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-password" style="display: none;">Submit Password</button>



                        <!--end form-group-->
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
<script>
    document.getElementById('submit-contact').addEventListener('click', function() {
        var contact = document.getElementById('contact').value;
        var contactError = document.getElementById('contact-error');

        if (contact) {
            // Make an AJAX request to check if the contact exists
            fetch("{{ route('check.contact') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ contact: contact })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    if (validateEmail(contact)) {
                        // If it's an email, show the password field
                        document.getElementById('contact-group').style.display = 'none';
                        document.getElementById('submit-contact').style.display = 'none';
                        document.getElementById('password-group').style.display = 'block';
                        document.getElementById('submit-password').style.display = 'block';
                    } else if (validatePhone(contact)) {
                        // If it's a phone number, simulate an OTP request
                        setTimeout(function() {
                            document.getElementById('contact-group').style.display = 'none';
                            document.getElementById('submit-contact').style.display = 'none';
                            document.getElementById('otp-group').style.display = 'block';
                            document.getElementById('submit-otp').style.display = 'block';
                        }, 1000);
                    }
                } else {
                    contactError.style.display = 'block';
                    contactError.innerHTML = 'You have not registered. <a href="{{ route('user_register') }}">Please register here</a>.';
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
        var otp = document.getElementById('otp').value;
        var otpError = document.getElementById('otp-error');

        if (otp) {
            window.location.href = "{{ route('consumer.store') }}";
        } else {
            otpError.style.display = 'block';
            otpError.textContent = 'Please enter your OTP';
        }
    });

    document.getElementById('submit-password').addEventListener('click', function() {
        var password = document.getElementById('password').value;
        var passwordError = document.getElementById('password-error');

        if (password) {
            // Handle Password submission here
            // Simulate AJAX request
            setTimeout(function() {
                window.location.href = "{{ route('consumer.store') }}";
                // Set the form action to the desired route and submit
                document.getElementById('contact-form').submit();
            }, 1000);
        } else {
            passwordError.style.display = 'block';
            passwordError.textContent = 'Please enter your password';
        }
    });

    function validateEmail(email) {
        // Simple email validation regex
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        // Simple phone validation regex (10-15 digits)
        var re = /^\d{10,15}$/;
        return re.test(phone);
    }
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


 
