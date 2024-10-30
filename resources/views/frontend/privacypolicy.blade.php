@include('frontend.include.header')
<style>

.row {
    margin-right: 0px !important;
    margin-left: 0px !important;
}


.text-blk {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  margin-left: 0px;
  line-height: 25px;
}

.responsive-cell-block {
  min-height: 75px;
}

.responsive-container-block {
  min-height: 75px;
  height: fit-content;
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  margin-top: 0px;
  margin-right: auto;
  margin-bottom: 0px;
  margin-left: auto;
  justify-content: space-evenly;
}

.outer-container {
  /*padding-top: 10px;*/
  /*padding-right: 50px;*/
  /*padding-bottom: 10px;*/
  /*padding-left: 50px;*/

}

.inner-container {
  max-width: 1320px;
  flex-direction: column;
  align-items: center;
  /*margin-top: 50px;*/
  /*margin-right: auto;*/
  /*margin-bottom: 50px;*/
  /*margin-left: auto;*/
}

.section-head-text {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 5px;
  margin-left: 0px;
  font-size: 35px;
  font-weight: 700;
  line-height: 48px;

  margin: 0 0 10px 0;
}

.section-subhead-text {
  font-size: 25px;
  color: rgb(153, 153, 153);
  line-height: 35px;
  max-width: 470px;
  text-align: center;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 60px;
  margin-left: 0px;
}

.img-wrapper {
  /*width: 100%;*/
}

.team-card {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.social-media-links {
  width: 125px;
  display: flex;
  justify-content: center;
}

.name {
  font-size: 24px;
  font-weight: 700;

  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 5px;
  margin-left: 0px;
}
.name1 {
  font-size: 24px;
  font-weight: 700;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 5px;
  margin-left: 0px;
  text-align: center;
}

.position {
  font-size: 16px;
  font-weight: 500;

  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 8px;
  margin-left: 0px;
  text-align: center;
}

.team-img {
  width: 100%;
  height: 100%;
}

.team-card-container {
  width: 280px;
  margin: 0 0 40px 0;
}
    /*.container {*/
    /*    width: 1394px;*/
    /*}*/
.col-md-6, .col-md-12{
    padding-left:0px;
}
@media (max-width: 500px) {
  .outer-container {
    padding: 10px 20px 10px 20px;
  }

  .section-head-text {
    text-align: center;
  }
}
.bann {
    background-image: url('frontend/assets/img/bannerindex.jpg');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 250px; /* You can adjust the height */
    position: relative; /* Ensure this is set for absolute positioning of text */
}

/* Style for the text that appears on top of the banner */
.banner-text {
    position: absolute;
    right: 20px; /* Distance from the right edge */
    top: 170px; /* Distance from the top edge */
    font-size: 24px; /* Adjust as needed */
    color: white; /* Change color based on your banner's image */
    font-weight: bold;
    background-color: rgba(0, 0, 0, 0.5); /* Optional: Semi-transparent background */
    padding: 10px 20px;
    border-radius: 5px; /* Optional: Rounded corners */
}
.banner-text a {
    color:white;
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
/*Responsive CSS*/

@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800&amp;display=swap');

*,
*:before,
*:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  margin: 0;
}


</style>


  <div id="page-content">
      <!--<div class="">-->
      <!--     <img src="{{asset('public/assets/images/eco/ewm.png')}}" alt="Image" width="100%"  height="250" style="background: rgba(15, 23, 43, 0.7) !important" >-->
      <!--</div>-->
    <div class="container">
        <!--<ol class="breadcrumb">-->
        <!--        <li><a href="{{url('/')}}">Home</a></li>-->
        <!--        <li class="active">How it works</li>-->
        <!--    </ol>-->
      </div>
      <section>
            <div class="bann height-400px" id="map-contact">
                 <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a> /
            <a href="{{route('privacypolicy')}}" class="breadcrumb-link">Privacy Policy</a>
        </div>
            </div>
            <!--end map-->
        </section>
         <section class="block">
            <div class="container">
         <div class="row">
            <p>At ecoSansar, accessible from www.ecosansar.com, we prioritize the privacy of our users. This Privacy Policy document outlines the types of information that we collect and record, how we use it, and the measures we take to safeguard your data.</p>

            1. Information We Collect<br>
            <p>We may collect and process the following types of information:</p>

            <p>Personal Information: When you sign up or use our services, we collect data such as your name, email address, phone number, and address. This information is necessary to create your account and provide our services and is retained.<br>
            Geographic Information: We collect your pincode to check if our services are available in your area.<br>
            Transaction Data: This includes records of the materials you list, the inquiries you make, and any transactions facilitated through our platform.<br>
            Usage Data: We collect and retain information about how you use our website, such as pages visited, features used, and time spent on the site. This helps us improve our services and user experience.<br>
            Communication Data: If you contact us through email, chat, or phone, we may retain details of that communication for quality and training purposes.</p>
            <p>
                2. How We Use Your Information<br>
                We use the information collected in various ways, including:
            </p>
            <p>To provide, operate, and maintain our platform and services.<br>
            To process your inquiries, listings, and transactions related to listed materials.<br>
            To improve our website, products, and services.<br>
            To communicate with you, including customer support and providing updates related to your use of our platform.<br>
            To analyze user behavior and trends to enhance user experience and expand our services to new areas.<br>
            To notify you of changes to our services, policies, or terms of use.<br></p>
            <p>3. Data Sharing and Disclosure<br>
            ecoSansar is committed to keeping your information safe and will not sell or share your personal data with third parties, except in the following circumstances:<br>
            With Service Providers: We may share information with third-party service providers who assist us in delivering our services (e.g., hosting providers, all registered users on www.ecosansar.com).<br>
            For Legal Compliance: We may disclose information if required by law, such as in response to a court order or government request.<br>
            With Your Consent: We will share your data with third parties if you give us explicit consent to do so.<br>
            For advertising services : To ensure appropriate and relevant ads are displayed to you by third party service providers like Google AdSense </p>
            <p>4. Data Security<br>
            We implement appropriate technical and organizational measures to protect your data from unauthorized access, alteration, disclosure, or destruction. However, please note that no method of transmission over the internet or method of electronic storage is 100% secure, and we cannot guarantee absolute security.<br>
            Built-in protections against common vulnerabilities like SQL injection and XSS.<br>
            Application supports SSL certificates or HTTPS, which encrypts communication between the client and server. Application uses the Form Classes Token Method (CSRF token), which is enabled by default. <br>
            Application offers CSRF protection and session management.</p>
            <p>
                5. Your Data Rights<br>
                Depending on your location, you may have the following rights regarding your personal data:
            </p>
            <p>
                Access: You have the right to access the personal data we hold about you.<br>
                Correction: You can request the correction of inaccurate or incomplete data.<br>
                Deletion: You can request the deletion of your personal data under certain circumstances.<br>
                Objection: You can object to the processing of your personal data.<br>
                To exercise these rights, please contact us at ecosansar@yahoo.com
            </p>
            <p>6. Cookies and Tracking Technologies<br>
            ecoSansar uses cookies and similar tracking technologies to analyze trends, administer the website, track user movements, and gather demographic information about our user base. You can choose to disable cookies through your browser settings, but this may affect the functionality of our website.</p>
            <p>
                7. Third-Party Links<br>
                Our website may contain links to other websites or services that are not operated by ecoSansar. We are not responsible for the privacy practices or the content of these third-party sites. We recommend that you review their privacy policies before providing them with your personal information.
            </p>
            <p>
                8. Changes to This Privacy Policy<br>
                We may update our Privacy Policy from time to time to reflect changes in our practices or legal requirements. Any changes will be posted on this page, and we encourage you to review it periodically. If the changes are significant, we will notify you via email or through a prominent notice on our website.
            </p>
            <p>
                9. Contact Us<br>
                If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:
            </p>
            <p>ecoSansar<br>
            Email: ecosansar@yahoo.com<br>
            Phone: +91 8553012812<br>
            Address: Bengaluru, India</p>
     </div>
     </div>
     </section>

            </div>





<script>
    document.addEventListener("DOMContentLoaded", function() {
    var timelineItems = document.querySelectorAll('.timeline-item');
    var windowHeight = window.innerHeight;

    function checkPosition() {
        for (var i = 0; i < timelineItems.length; i++) {
            var positionFromTop = timelineItems[i].getBoundingClientRect().top;

            if (positionFromTop - windowHeight <= 0) {
                timelineItems[i].style.opacity = 1;
                timelineItems[i].style.transform = 'translateY(0)';
            }
        }
    }

    window.addEventListener('scroll', checkPosition);
    window.addEventListener('resize', checkPosition);

    checkPosition();
});

</script>
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

      // Allow only numeric characters (0-9)
      if (keyCode >= 48 && keyCode <= 57) {
        return true; // Allow input
      } else {
        event.preventDefault(); // Prevent input if it's not a number
        return false;
      }
    }
</script>
@include('frontend.include.footer')
