@include('frontend.include.header')

@include('sweetalert::alert')
    <div id="page-content" style="background-image: url('frontend/assets/img/usertype.jpg');height: 490px;position: relative">
        <div class="container text-center" style="top:40%;left:10%;position: absolute;" >

            <a href="{{ route('business_add') }}" class="btn btn-primary  btn-rounded" style="padding: 10px 100px;font-size: 20px;"><span>BUSINESS</span></a>

            <a href="{{ route('sab_add') }}" class="btn btn-primary btn-rounded" style="padding: 10px 100px;font-size: 20px;"> <span>SAB</span></a>
            <a href="{{ route('consumer_add') }}" class="btn btn-primary  btn-rounded " style="padding: 10px 100px;font-size: 20px;"> <span>CONSUMER</span></a>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

    <footer id="page-footer">
        <div class="footer-wrapper">
            <div class="block">
                <div class="container">
                    <div class="vertical-aligned-elements">
                        <div class="element width-50">
                            <p data-toggle="modal" data-target="#myModal">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque aliquam at neque sit amet vestibulum. <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>
                        </div>
                        <div class="element width-50 text-align-right">
                            <a href="#" class="circle-icon"><i class="social_twitter"></i></a>
                            <a href="#" class="circle-icon"><i class="social_facebook"></i></a>
                            <a href="#" class="circle-icon"><i class="social_youtube"></i></a>
                        </div>
                    </div>
                    <div class="background-wrapper">
                        <div class="bg-transfer opacity-50">
                            <img src="frontend/assets/img/footer-bg.png" alt="">
                        </div>
                    </div>
                    <!--end background-wrapper-->
                </div>
            </div>
            <div class="footer-navigation">
                <div class="container">
                    <div class="vertical-aligned-elements">
                        <div class="element width-50">(C) 2016 Your Company, All right reserved</div>
                        <div class="element width-50 text-align-right">
                            <a href="index.html">Home</a>
                            <a href="listing-grid-right-sidebar.html">Listings</a>
                            <a href="submit.html">Submit Item</a>
                            <a href="contact.html">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--end page-footer-->
</div>
<!--end page-wrapper-->
<a href="#" class="to-top scroll" data-show-after-scroll="600"><i class="arrow_up"></i></a>

<script type="text/javascript" src="frontend/assets/js/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="frontend/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="frontend/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="frontend/assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBEDfNcQRmKQEyulDN8nGWjLYPm8s4YB58&libraries=places"></script>
<script type="text/javascript" src="frontend/assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="frontend/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="frontend/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="frontend/assets/js/custom.js"></script>
<script type="text/javascript" src="frontend/assets/js/maps.js"></script>

<script>
function sab()
{
    let bus=document.getElementById('business');
   let sab=document.getElementById('sab');
   let con=document.getElementById('consumer');

   sab.style.display="block";
   bus.style.display="none";
   con.style.display="none";


}

function business()
{
    let bus=document.getElementById('business');
   let sab=document.getElementById('sab');
   let con=document.getElementById('consumer');

   sab.style.display="none";
   bus.style.display="block";
   con.style.display="none";


}

function consumer()
{
    let bus=document.getElementById('business');
   let sab=document.getElementById('sab');
   let con=document.getElementById('consumer');

   sab.style.display="none";
   bus.style.display="none";
   con.style.display="block";


}
</script>

</body>

