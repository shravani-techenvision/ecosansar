@include('frontend.include.header')
@include('sweetalert::alert')
<style>
 .row{
        margin-right: 0px;
        margin-left: 0px;
    }
@media (max-width: 767px){
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
                    <div class="col-md-12" style="text-align: center;">
                             <h1 class="reg" ><u style="color: #8eb66f;">Enter OTP</u><span></h1> 
                    </div>
                </section>
                
                <section>
                <form id="contact-form" class="form inputs-underline" action="{{ route('consumer.store') }}" method="POST">
                    @csrf
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
                
                    <div class="form-group">
                        <label for="otp">OTP</label>
                        <input type="password" class="form-control @error('otp') is-invalid @enderror" minlength="6" maxlength="6" name="otp" id="otp" placeholder="Your OTP">
                        <div id="otp-error" class="invalid-feedback text-danger" ></div>
                        @error('otp')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="button" id="resend-otp" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="margin-top:17px; float:inline-end;">Resend OTP</button>
                    </div>
                    <!--end form-group-->
                
                    <!--<button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-contact">Submit</button>-->
                    <button type="button" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" id="submit-otp" >Verify OTP</button>
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
    // document.getElementById('submit-contact').addEventListener('click', function() {
    //   //  var contact = document.getElementById('contact').value;
    //     var contactError = document.getElementById('contact-error');
    //     if (contact) {
    //         // Make an AJAX request to send OTP
    //         fetch("{{ route('send.otp') }}", {
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/json",
    //                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
    //             },
    //             body: JSON.stringify({ contact: contact })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.status === 'success') {
    //                 document.getElementById('contact-group').style.display = 'none';
    //                 document.getElementById('submit-contact').style.display = 'none';
    //                 document.getElementById('otp-group').style.display = 'block';
    //                 document.getElementById('submit-otp').style.display = 'block';
    //             } else {
    //                 contactError.style.display = 'block';
    //                 contactError.textContent = 'Failed to send OTP. Please try again.';
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             contactError.style.display = 'block';
    //             contactError.textContent = 'There was an error processing your request.';
    //         });
    //     }else{
    //         contactError.style.display = 'block';
    //         contactError.textContent = 'Please enter your contact information';
    //     }
    // });

document.getElementById('resend-otp').addEventListener('click', function(){
    var contact = document.getElementById('contact').value;
  // alert(contact);
    var contactError = document.getElementById('contact-error');
    var otpInput = document.getElementById('otp');
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
                otpInput.value = ''; // Clear the OTP input field
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
    var otp = document.getElementById('otp').value;
    var otpError = document.getElementById('otp-error');

    if (otp){
        // Verify OTP
        
        fetch("{{ route('activateverify.otp') }}", {
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
                //otpError.style.display = 'block';
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


 
