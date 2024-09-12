

@include('frontend.include.header')
<style>
    .bann {
    background-image: url('frontend/assets/img/bannerindex.jpg');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 250px; /* Ensure this matches your desired height */
}
.adj{
    margin-top:25px;
}
@media (max-width: 768px) {
.space{
    margin-right:-30px !important;
}
}
</style>

  <div id="page-content">
        
        <section>
            <div class="bann height-400px" id="map-contact"></div>
            <!--end map-->
        </section>
        <section class="block">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h3>Contact Information</h3>
                        <div class="box">
                            <address>
                                <strong>Location</strong>
                                <figure>Bengaluru, Karnataka, India</figure>
                                <br>
                                <strong>Phone Number</strong><br>
                                <a style="color:black !imporatnt;" href="tel:+91 8553012812">+91 8553012812</a>
                                <br>
                                <!--<strong>Email</strong>-->
                                <!--<figure><a href="#">hello@example.com</a></figure>-->
                                <br>
                                <!--<strong>Customer Care</strong>-->
                                <!--<figure><a href="#">support@example.com</a></figure>-->
                            </address>
                        </div>
                    </div>
                    <!--end col-md-3-->
                    <div class="col-md-9 col-sm-9">
                        <!--<h3>Form</h3>-->
                        <form class="form form-email inputs-underline" action="{{route('contact_store')}}" id="form-hero" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-sm-4 adj">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value={{ old('name') }}>
                                         @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                    </div>
                                    <!--end form-group-->
                                </div>
                                 <div class="col-md-6 col-sm-4 adj">
                                    <div class="form-group">
                                        <label for="name">Phone Number<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter 10 digit mobile number" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('phone_no') }}>
                                         @if ($errors->has('phone_no'))
                                    <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                @endif
                                    </div>
                                    <!--end form-group-->
                                </div>
                                <!--end col-md-4-->
                                <div class="col-md-6 col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email<span style="color:red;">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value={{ old('email') }}>
                                         @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                                    </div>
                                    <!--end form-group-->
                                </div>
                                <!--end col-md-4-->
                                <div class="col-md-6 col-sm-4">
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" value={{ old('subject') }}>
                                    </div>
                                    <!--end form-group-->
                                </div>
                                <!--end col-md-4-->
                             <div class="col-md-12">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" rows="4" name="message" placeholder="Enter Message"></textarea>
                            </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="label-text">Please type the characters below<span style="color:red;">*</span></label>
                                        <div style="display:flex; margin-top:20px;">
                                            <div class="box space" style="font-size:20px;padding:10px;">{{ $captcha }}</div>&emsp;&emsp;&emsp;&emsp;&emsp; 
                                            <input class="form-control" type="text" id="userInput" name="captcha" placeholder="Enter Captcha" >  
                                             </div>
                                           @error('captcha')
                                            <div class="text-danger" style="margin-left:144px; ">{{ $message }}</div>
                                           @enderror
                                    </div>
                                   </div>
                                   </div>
                            <!--end row-->
                            <!--end form-group-->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow">Send Message<i class="fa fa-caret-right"></i></button>
                            </div>
                            <!--end form-group-->
                        </form>
                    </div>
                    <!--end col-md-9-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
    </div>
@include('frontend.include.footer')

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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