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
    <div id="page-content">
        <div class="container">
            <ul class="nav nav-tabs ultop">
                <!-- <li class=""><a  href="{{ route('consumer_add') }}"class="btn btn-primary btn-small btn-rounded icon shadow add-listing"><span class="ultext">Contributor</span></a></li>-->
                <!-- <li><a  href="{{ route('sab_add') }}"><span class="ultext">Resource Collector </span></a></li>-->
                <!--<li  ><a   href="{{ route('business_add') }}"><span class="ultext">Corporate</span></a></li>-->
           </ul>
            <div class="row" >
                <div class="col-md-5 col-sm-5 col-md-offset-4 col-sm-offset-4">
                    <section class="">
                        <div class="col-md-12">
                             <h1 class="reg" style ="margin-top: -6px;"><a href="{{route('consumer_login')}}">Sign In</a>  <span> |  <u style="color: #8eb66f;">Register</u></span></h1>
                             <p style="font-size: 17px;"><b>Welcome! We're thrilled to have you here.</b></p>

                               <p style="font-size: 17px;"> Choose your role to register :<br><br>
                                <b>Contributor</b> – For Waste / Resource Generators (consumers)<br>
                                <b>Resource Collector</b> – Resource Pickup Agents <br>
                                <b>Corporate</b> – Brands / Waste Management Companies / Recyclers / businesses dealing in bulk quantities</p>

                                <p style="font-size: 17px;" ><b>Join your community by registering here</b></p>
                        </div>
                    </section
                    <!--end page-title-->
                    <section id="consumer" >
                        <!--<form id="submit-contact" class="form inputs-underline" action="{{ route('consumer.save') }}" method="post">-->

                             <form id="registerForm" class="form inputs-underline" method="POST">
                            @csrf
                            <!--<input type="hidden" name="user_type" value="consumer">-->
                        <div class="row">
                            <div class="form-group">
                            <label class=" form-label">Who you are<span style="color:red;">*</span></label>
                                    <select class="form-select" name="type_of_user" id="type_of_user">
                                        <option value="">Select</option>
                                        <option value="consumer" {{ old('type_of_user') == 'consumer' ? 'selected' : '' }}>Contributor</option>
                                        <option value="sab" {{ old('type_of_user') == 'sab' ? 'selected' : '' }}>Resource Collector</option>
                                        <option value="business" {{ old('type_of_user') == 'business' ? 'selected' : '' }}>Corporate</option>
                                    </select>
                                            @if ($errors->has('type_of_user'))
                                <span class="text-danger">{{ $errors->first('type_of_user') }}</span>
                             @endif
                               <span class="error-message text-danger" id="type_of_user-error"></span>

                            </div>
                                    <div class="form-group">
                                        <label for="first_name">Name<span style="color:red;">*</span></label>
                                        <input onkeydown="return /[a-z0-9 ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Name" value={{ old('name') }}>
                                     <!--   @if ($errors->has('name'))-->
                                     <!--   <span class="text-danger">{{ $errors->first('name') }}</span>-->
                                     <!--@endif-->
                                     <span class="error-message text-danger" id="name-error"></span>
                                    </div>

                                    <!--end form-group-->
                                <!--end col-md-6-->
                                  <div class="form-group">
                                    <label for="last_name">Phone number<span style="color:red;">*</span> </label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">+91</span>
                                            <input onkeydown="" type="text" class="form-control" name="mobile" id="contact" placeholder="Please enter 10 digit mobile number" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                     <!--<input type="text" class="form-control" aria-label="Amount (rounded to the nearest dollar)">-->
                                    </div>

                                    <span class="error-message text-danger" id="mobile-error"></span>

                                    <div id="contact-error" class="invalid-feedback text-danger" style="display: none;"></div>
                                     @if ($errors->has('mobile'))
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                            <!--<button type="button" id="resend-otp" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="margin-top:17px; float:inline-end;">Resend OTP</button>-->
                                         @endif
                                  </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label for="last_name">Phone number<span style="color:red;">*</span> </label>-->
                                    <!--    <input onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 8" type="text" class="form-control" name="mobile" id="contact" placeholder="Phone number" minlength="10" maxlength="10" value={{ old('mobile') }}>-->
                                    <!--    @if ($errors->has('mobile'))-->
                                    <!--    <span class="text-danger">{{ $errors->first('mobile') }}</span>-->
                                    <!--    <button type="button" id="resend-otp" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="margin-top:17px; float:inline-end;">Resend OTP</button>-->
                                    <!-- @endif-->
                                    <!--</div>-->
                                    <!--end form-group-->
                                <!--end col-md-6-->
                            <!--enr row-->

                            <div class="form-group">
                                <label for="address">
                                    Address<span style="color:red;">*</span>
                                </label>
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

                            <!--end form-group-->
                            <div class="form-group">
                                <label for="password">Pincode<span style="color:red;">*</span></label>
                                <input onkeydown="" type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" minlength="6" maxlength="6" value={{ old('pincode') }}>
                                @if ($errors->has('pincode'))
                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                             @endif

                             <span class="error-message text-danger" id="pincode-error"></span>
                            </div>
                            <!--end form-group-->
                            <div class="form-group" id="hide-tresi">
                            <label class=" form-label">Type of residences<span style="color:red;"></span></label>
                                    <select class="form-select" name="type_of_residences" id="type_of_residences">
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
                            <div class="form-group" id="hide-em">
                                <label for="confirm_password">Email id<span id="email-star" style="display:none; color:red;">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value={{ old('email') }}>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                             @endif

                             <span class="error-message text-danger" id="email-error"></span>

                            </div>
                            <!--<div class="form-group" id="hide-pass">-->
                            <!--    <label for="confirm_password">Password<span id="password-star" style="display:none; color:red;">*</span></label>-->
                            <!--    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value={{ old('password') }}>-->
                            <!--    @if ($errors->has('password'))-->
                            <!--    <span class="text-danger">{{ $errors->first('password') }}</span>-->
                            <!-- @endif-->
                            <!--</div>-->
                            <div class="form-check">
        					<label>
        						<input type="checkbox" name="terms" id="terms" value="accepted" {{ old('terms') ? 'checked' : '' }}>  <a href="{{ route('terms_conditions') }}">I agree to the Terms and Conditions</a><span style="color:red;">*</span>
        					</label>

        				</div>
        				<span class="error-message text-danger" id="terms-error"></span>
        				 @if ($errors->has('terms'))
                            <span class="text-danger">{{ $errors->first('terms') }}</span>
                        @endif
                          <br>
                        <!--    <div class="form-group">-->
                        <!--    <input type="checkbox" name="terms" id="terms" value="accepted" {{ old('terms') ? 'checked' : '' }}>-->
                        <!--    <label for="terms"> <a href="{{ route('terms_conditions') }}">I agree to the Terms and Conditions</a><span style="color:red;">*</span></label> <br>-->
                        <!--    @if ($errors->has('terms'))-->
                        <!--        <span class="text-danger">{{ $errors->first('terms') }}</span>-->
                        <!--    @endif-->
                        <!--</div>-->
                        </div><br>
                            <!--end form-group-->
                            <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" >Register </button>
                                <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                                </div>
                            <!--end form-group-->
                        </form>

                        <div id="responseMessage"></div>
                        {{--  <hr>  --}}
                   </section>

                </div>
                <!--col-md-4-->
            </div>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->



<!--end page-wrapper-->
<a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




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

    document.getElementById('submit-contact').addEventListener('click', function(){

    var contact = document.getElementById('contact').value;
    var contactError = document.getElementById('contact-error');

     alert(contact);
    // alert(contactError);

    if (contact){
        alert(contact);
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

             //alert('ssss');

            if (data.status === 'success'){

                           //  alert('success');

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

                // alert('falus');
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




@include('frontend.include.footer')

