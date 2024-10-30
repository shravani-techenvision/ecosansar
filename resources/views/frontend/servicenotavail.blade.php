@include('frontend.include.header')
<style>
     .bann {
    background-image: url('{{ asset('frontend/assets/img/bannerindex.jpg') }}');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 250px; /* Default height for larger screens */
    position: relative;
}

.banner-text {
    position: absolute;
    right: 20px; /* Distance from the right edge */
    top: 170px; /* Distance from the top edge */
    font-size: 24px; /* Default font size for larger screens */
    color: white;
    font-weight: bold;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    padding: 10px 20px;
    border-radius: 5px;
}

.banner-text a {
    color: white;
}
.terms-link {
    color: #8eb66f; /* Change this to your desired color */
    text-decoration: none;
}
.terms-link:hover {
    text-decoration: underline;
    color:#8eb66f; /* Optional: Change color on hover */
}
/* Media query for devices with a screen width of 768px or less (tablets and smaller) */
@media (max-width: 768px) {
    .bann {
        height: 200px; /* Reduce height for tablets */
    }
    .banner-text {
        font-size: 16px; /* Reduce font size for tablets */
        top: 88px; /* Adjust positioning */
    }
}
.row {
    margin-right: 0px !important;
    margin-left: 0px !important;
}
</style>

<div id="page-content">
    <section>
            <div class="bann height-400px" id="map-contact">
                <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a>

        </div>
            </div>
            <!--end map-->
        </section>
         <section class="block">
            <div class="container">
                <div class="row">

<p><b>Want us to reach YOU sooner?</b>
Share your contact details, and we’ll notify you as soon as we’re available in your area. Plus, your interest will help us prioritize expansion to your community!</p>
<b>Thank you for your support in building a cleaner, greener world with us! </b>🌿

                     </p>
                     </div>
                     </div>
                     </section>
                      <section >
                        <div class="container">
                        <header><h2 class="no-border">Share Your Contact Details</h2></header>

                        <form class="form form-email inputs-underline" action="{{route('check-pincode-save')}}" id="form-hero" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 col-sm-4 adj">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input required onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value={{ old('name') }}>
                                         @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                    </div>
                                    <!--end form-group-->
                                </div>
                                 <div class="col-md-6 col-sm-4 adj">
                                    <div class="form-group">
                                        <label for="name">Phone Number<span style="color:red;">*</span></label>
                                        <input required type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter 10 digit mobile number" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('phone_no') }}>
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
                                        <label for="subject">Pincode<span style="color:red;">*</span></label>
                                        <input required type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode" onkeypress="return isNumeric(event)" minlength="6" maxlength="6" value={{ old('pincode') }}>
                                         @if ($errors->has('pincode'))
                                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                @endif
                                    </div>
                                    <!--end form-group-->
                                </div>
                                <!--end col-md-4-->
                             <div class="col-md-6">
                            <div class="form-group">
                                <label for="message">Address<span style="color:red;">*</span></label>
                                <textarea required class="form-control" id="address" rows="4" name="address" placeholder="Enter Address"></textarea>
                                 @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" rows="4" name="message" placeholder="Enter Message"></textarea>

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

                     </section>
                     <section>
                         <div class="container">
                     <p>
                         Need more info? Learn <a target="_blank" href="{{route('howitsworks')}}" class="terms-link">How It Works</a> or contact us at 8553012812.
                     </p>
                     </div>
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
