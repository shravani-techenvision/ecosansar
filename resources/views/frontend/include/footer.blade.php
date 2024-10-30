<style>
    .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#25d366;
	color:#FFF;
	border-radius:50px;
	text-align:center;
  font-size:30px;
	box-shadow: 2px 2px 3px #999;
  z-index:100;
}

.my-float{
	margin-top:16px;
}

div#phone91 {
    width: 100%;
}
/* Styles for mobile devices (max-width: 767px) */
@media (max-width: 767px) {
    .formobile {
        display: block !important; /* Show the mobile version */
    }
    .fordesk {
        display: none !important; /* Hide the desktop version */
    }
}

/* Styles for tablets (min-width: 768px and max-width: 1024px) */
@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .formobile {
        display: none !important; /* Hide the mobile version */
    }
    .fordesk {
        display: block !important; /* Show the desktop version */
    }
}

/* Default styles for desktop (min-width: 1025px) */
@media only screen and (min-width: 1025px) {
    .formobile {
        display: none !important; /* Hide the mobile version */
    }
    .fordesk {
        display: block !important; /* Show the desktop version */
    }
}

</style>

<footer id="page-footer">
    <div class="footer-wrapper">
        <!--<div class="block">-->
        <!--    <div class="container">-->

        <!--        <div class="background-wrapper">-->
        <!--            <div class="bg-transfer opacity-50">-->
        <!--                <img src="{{ asset('frontend/assets/img/footer-bg.png" alt="">-->
        <!--            </div>-->
        <!--        </div>-->
                <!--end background-wrapper-->
        <!--    </div>-->
        <!--</div>-->
        <div class="footer-navigation">
            <div class="container fordesk">
                <div class="vertical-aligned-elements">
                    <div class="element width-30">(C) <?php echo date('Y');?> EcoSansar, All right reserved</div>
                    <div class="element width-60 text-align-right">
                        <a href="{{url('/')}}">Home</a>
                        <a href="{{route('about')}}">About Us</a>
                         <!--<a href="{{route('listings')}}">Browse Sellers</a>-->
                         <!--  <a href="{{route('buy_listings')}}">Browse Buyers</a>-->
                        <a href="{{route('howitsworks')}}">How it Works</a>
                        <a href="{{route('contact')}}">Contact Us</a>
                        <a href="{{ route('terms_conditions') }}">Terms and Conditions</a>
                        <a href="{{ route('privacypolicy') }}">Privacy Policy</a>
                    </div>
                    <div class="element width-10 text-align-right">
                        <!--<a href="#" class="circle-icon"><i class="social_twitter"></i></a>-->
                        <!--<a href="#" class="circle-icon"><i class="social_facebook"></i></a>-->
                        <!--<a href="#" class="circle-icon"><i class="social_youtube"></i></a>-->
                    </div>
                </div>
            </div>
             <div class="container formobile">

                <div class="text-center">

                    <div class="element width-100  ">
                        <a href="{{url('/')}}">Home</a>
                        <a href="{{route('about')}}">About Us</a>
                         <!--<a href="{{route('listings')}}">Browse Sellers</a>-->
                         <!--  <a href="{{route('buy_listings')}}">Browse Buyers</a>-->
                        <a href="{{route('howitsworks')}}">How it Works</a>
                        <a href="{{route('contact')}}">Contact Us</a>
                        <a href="{{ route('terms_conditions') }}">Terms and Conditions</a>
                        <a href="{{ route('privacypolicy') }}">Privacy Policy</a>
                    </div>

                </div>
                 <div class="text-center">

                    <div class="element width-100 ">
                        <!--<a href="#" class="circle-icon"><i class="social_twitter"></i></a>-->
                        <!--<a href="#" class="circle-icon"><i class="social_facebook"></i></a>-->
                        <!--<a href="#" class="circle-icon"><i class="social_youtube"></i></a>-->
                    </div>
                </div>
                <div class="text-center">
                    <div class="element width-100 ">(C) <?php echo date('Y');?> EcoSansar, All right reserved</div>

                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=8553012812&text=" class="float" target="_blank" style="margin-bottom: 40px;">
<i class="fa fa-whatsapp my-float"></i>
</a>


</footer>
<!--end page-footer-->
</div>
<!--end page-wrapper-->
<a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>

<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery-2.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBEDfNcQRmKQEyulDN8nGWjLYPm8s4YB58&libraries=places"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/richmarker-compiled.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/markerclusterer_packed.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/infobox.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.fitvids.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.nouislider.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/maps.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'hi,te,ta,kn,mr,or,bn', // Language codes for Hindi, Telugu, Tamil, Kannada, Marathi, Oriya, Bengali
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
