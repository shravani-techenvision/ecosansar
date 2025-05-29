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
 
</style>
	<!-- Footer -->
	<footer>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-xl-3">
						<div class="footer-widget">
							<h5 class="mb-4">Quick Links</h5>
							<ul class="footer-menu">
								<li>
								    @if (session()->has('user_id'))
									<a href="{{route('listings')}}"> Recyclables Listings</a>
									@else
										<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}"> Recyclables Listings</a>
										@endif	
								</li>
								<li>
								     @if (session()->has('user_id'))
									<a href="{{route('reusable_listings')}}">Reusables Listings</a>
										@else
											<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}">Reusables Listings</a>
												@endif	
								</li>
								<li>
								     @if (session()->has('user_id'))
									<a href="{{route('repairmap')}}"> Repair Map</a>
									@else
										<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}"> Repair Map</a>
									@endif
								</li>
								<li>
								     @if (session()->has('user_id'))
									<a href="{{route('findcollectionagent')}}"> Find Your Nearest Collection Agent</a>
										@else
											<a href="{{ route('consumer_login', ['redirect' => url()->current()]) }}"> Find Your Nearest Collection Agent</a>
									@endif
								</li>
							 
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-xl-3">
						<div class="footer-widget">
							<h5 class="mb-4">Quick Links</h5>
							<ul class="footer-menu">
								<li>
									<a href="{{route('faq')}}"> FAQs</a>
								</li>
								<li>
									<a href="{{route('about')}}"> About Us</a>
								</li>
								<li>
									<a href="{{route('workwithus')}}"> Work with us</a>
								</li>
								<li>
									<a href="{{route('blog')}}"> Blogs</a>
								</li>
							 
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-xl-3  ">
						<div class=" follow align-items-center justify-content-between flex-wrap  ">			
							<h5 class="mb-4"> Follow Us On</h5>
							<ul class="social-icon mb-3">
								<li>
								<a href="javascript:void(0);"><img src="{{ asset('frontend/assets/img/icons/fb.svg') }}" class="img" alt="icon" style="max-width:40px!important;" ></a>
								</li>
								<li>
								<a href="javascript:void(0);"><img src="{{ asset('frontend/assets/img/icons/instagram.svg') }}" class="img" alt="icon" style="max-width:40px!important;"></a>
								</li>
								<li>
								<a href="javascript:void(0);"><img src="{{ asset('frontend/assets/img/icons/linkedin.svg') }}" class="img" alt="icon" style="max-width:40px!important;"></a>
								</li>
							 
							</ul>
						</div>
					</div>
				  
					<div class="col-md-12 col-xl-3 ">
					<div class="footer-widget">
								<h2 class="footer-title">Contact</h2>
								<div class="footer-six-main">
									<div class="footer-six-left">
										<span class="footer-seven-icon">
											<img src="{{ asset('frontend/assets/img/icons/call-calling.svg') }}" alt="image">
										</span>
										<div class="footer-six-ryt">
											<span>Phone Number</span>
											<h6><a style="color:white !important;" href="tel:+91 8553012812">+91 85530 12812</a></h6>
										</div>
									</div>
									<div class="footer-six-left">
										<span class="footer-seven-icon">
											<img src="{{ asset('frontend/assets/img/icons/sms.svg') }}" alt="image">
										</span>
										<div class="footer-six-ryt">
											<span>Mail Address</span>
											<h6 class="fs-14"><a href="mailto:support@ecosansar.com">	<img src="{{ asset('frontend/assets/img/footerimg.png') }}" alt="img" style="background:none;padding: 3px;" class="img-fluid"></h6></a>
										</div>
									</div>
									<div class="footer-six-left ">
										<span class="footer-seven-icon">
											<img src="{{ asset('frontend/assets/img/icons/location.svg') }}" alt="image">
										</span>
										<div class="footer-six-ryt">
											<span>Address</span>
											<h6>Bengaluru, Karnataka, India 560043</h6>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			 
			</div>
		</div>
		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="d-flex align-items-center justify-content-between flex-wrap">
							<p class="mb-0 p-1"> &copy; <?php echo date('Y');?> ecoSansar, All Rights Reserved </p>
							<ul class="menu-links mb-0 p-1">
								<li>
									<a href="{{ route('terms_conditions') }}"> Terms and Conditions</a>
								</li>
								<li>
									<a href="{{ route('privacypolicy') }}">Privacy Policy</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Footer Bottom -->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=8553012812&text=" class="float" target="_blank" style="margin-bottom: 40px;">
<i class="fa fa-whatsapp my-float"></i>
</a>
	</footer>
	<!-- /Footer -->





<!-- Jquery JS -->
	<script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js')}}"></script>

	<!-- Bootstrap JS -->
	<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>

	<!-- Wow JS -->
	<script src="{{ asset('frontend/assets/js/wow.min.js')}}"></script>

	<!-- Owlcarousel Js -->
	<script src="{{ asset('frontend/assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>

	<!-- select JS -->
	<script src="{{ asset('frontend/assets/plugins/select2/js/select2.min.js')}}"></script>

	<!-- counterup JS -->
	<script src="{{ asset('frontend/assets/js/cursor.js')}}"></script>

	<!-- Mobile Input -->
	<script src="{{ asset('frontend/assets/plugins/intltelinput/js/intlTelInput.js')}}"></script>
	<script src="{{ asset('frontend/assets/plugins/ityped/index.js')}}"></script>

	<!-- Validation-->
	<script src="{{ asset('frontend/assets/js/validation.js')}}"></script>
<!-- Slick Slider -->
	<script src="{{ asset('frontend/assets/js/slick.js') }}"></script>

 
	<!-- Script JS -->
	<script src="{{ asset('frontend/assets/js/script.js')}}"></script>
 <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'hi,te,ta,kn,mr,or,bn,en', // Language codes for Hindi, Telugu, Tamil, Kannada, Marathi, Oriya, Bengali
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
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
</body>

</html>