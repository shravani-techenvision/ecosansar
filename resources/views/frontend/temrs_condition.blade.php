@include('frontend.include.header')
<style>
 
p {
    font-size: large;
    line-height: 1.5; /* Adjust this value as needed */
    word-spacing: 0.1em; /* Adjust this value as needed */
    color: #000 !important;
    opacity: 1 !important;
}

    * {
  font-family: Nunito, sans-serif;
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
  padding-top: 10px;
  padding-right: 50px;
  padding-bottom: 10px;
  padding-left: 50px;
  
}

.inner-container {
  max-width: 1320px;
  flex-direction: column;
  align-items: center;
  margin-top: 50px;
  margin-right: auto;
  margin-bottom: 50px;
  margin-left: auto;
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

@media (max-width: 500px) {
  .outer-container {
    padding: 10px 20px 10px 20px;
  }

  .section-head-text {
    text-align: center;
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

.wk-desk-1 {
  width: 8.333333%;
}

.wk-desk-2 {
  width: 16.666667%;
}

.wk-desk-3 {
  width: 25%;
}

.wk-desk-4 {
  width: 33.333333%;
}

.wk-desk-5 {
  width: 41.666667%;
}

.wk-desk-6 {
  width: 50%;
}

.wk-desk-7 {
  width: 58.333333%;
}

.wk-desk-8 {
  width: 66.666667%;
}

.wk-desk-9 {
  width: 75%;
}

.wk-desk-10 {
  width: 83.333333%;
}

.wk-desk-11 {
  width: 91.666667%;
}

.wk-desk-12 {
  width: 100%;
}

@media (max-width: 1024px) {
  .wk-ipadp-1 {
    width: 8.333333%;
  }

  .wk-ipadp-2 {
    width: 16.666667%;
  }

  .wk-ipadp-3 {
    width: 25%;
  }

  .wk-ipadp-4 {
    width: 33.333333%;
  }

  .wk-ipadp-5 {
    width: 41.666667%;
  }

  .wk-ipadp-6 {
    width: 50%;
  }

  .wk-ipadp-7 {
    width: 58.333333%;
  }

  .wk-ipadp-8 {
    width: 66.666667%;
  }

  .wk-ipadp-9 {
    width: 75%;
  }

  .wk-ipadp-10 {
    width: 83.333333%;
  }

  .wk-ipadp-11 {
    width: 91.666667%;
  }

  .wk-ipadp-12 {
    width: 100%;
  }
}
 /*.container {*/
 /*       width: auto !important;*/
 /*   }*/
@media (max-width: 768px) {
    .section2{
        margin-top: 20px;
    }
       
  .wk-tab-1 {
    width: 8.333333%;
  }

  .wk-tab-2 {
    width: 16.666667%;
  }

  .wk-tab-3 {
    width: 25%;
  }

  .wk-tab-4 {
    width: 33.333333%;
  }

  .wk-tab-5 {
    width: 41.666667%;
  }

  .wk-tab-6 {
    width: 50%;
  }

  .wk-tab-7 {
    width: 58.333333%;
  }

  .wk-tab-8 {
    width: 66.666667%;
  }

  .wk-tab-9 {
    width: 75%;
  }

  .wk-tab-10 {
    width: 83.333333%;
  }

  .wk-tab-11 {
    width: 91.666667%;
  }

  .wk-tab-12 {
    width: 100%;
  }
}

@media (max-width: 500px) {
  .wk-mobile-1 {
    width: 8.333333%;
  }

  .wk-mobile-2 {
    width: 16.666667%;
  }

  .wk-mobile-3 {
    width: 25%;
  }

  .wk-mobile-4 {
    width: 33.333333%;
  }

  .wk-mobile-5 {
    width: 41.666667%;
  }

  .wk-mobile-6 {
    width: 50%;
  }

  .wk-mobile-7 {
    width: 58.333333%;
  }

  .wk-mobile-8 {
    width: 66.666667%;
  }

  .wk-mobile-9 {
    width: 75%;
  }

  .wk-mobile-10 {
    width: 83.333333%;
  }
  

  .wk-mobile-11 {
    width: 91.666667%;
  }

  .wk-mobile-12 {
    width: 100%;
  }
}


</style>


  <div id="page-content">
      <!--<div class="">-->
      <!--     <img src="{{asset('public/assets/images/eco/ewm.png')}}" alt="Image" width="100%"  height="250" style="background: rgba(15, 23, 43, 0.7) !important" >-->
      <!--</div>-->
    <div class="container" style="margin-top: 25px !important;">
         
         <div class="row">
     <div class="responsive-container-block outer-container">
     <div class="responsive-container-block inner-container">
             <section>
                <h2 style="font-weight:500 !important">Terms and Conditions</h2>
                    <p> Welcome to <a href="https://ecosansar.com/">www.ecosansar.com</a>
                      (the "Website"). The Website is operated by ecoSansar
                       ("we," "our," or "us"). These Terms and Conditions ("Terms") govern your use of the Website
                      and the services provided through it. By accessing or using the Website, you agree to be
                       bound by these Terms. If you do not agree to these Terms, please do not use the Website.</p>
                       <hr>
                    <p>1. Definitions <br>
                    1.1 "User" or "You" refers to any individual or entity who accesses or uses the Website.<br>
                    1.2 "Contributor" refers to a User who lists waste materials on the Website.<br>
                    1.3 "Resource Collector" refers to a User who collects waste materials listed on the
                    Website.<br>
                    1.4 "Corporate" refers to a User who is an aggregator or recycler interested in buying or
                    selling waste materials listed on the Website.</p> <hr>
                    
                    
                    <p>2. Eligibility <br>
                      2.1 You must be at least 18 years old to use the Website. <br>
                      2.2 By using the Website, you represent and warrant that you have the legal capacity to
                     enter into these Terms.</p> <hr>
                     
                     <p>3. User Accounts <br>
                        3.1 To access certain features of the Website, you will need to create an account. We call
                        the platform The ZeroWaste Community Tool. <br>
                        3.2 You agree to provide accurate, current, and complete information during the registration
                        process and to update such information to keep it accurate, current, and complete. <br>
                        3.3 You are responsible for maintaining the confidentiality of your account password, otp,
                        emails from ecoSansar and for all activities that occur under your account. <br>
                        3.4 You agree to notify us immediately of any unauthorized use of your account or any other
                        breach of security.</p> <hr>
                        
                    <p>4. Listings and Transactions <br>
                        4.1 All registered users on the Tool may list waste materials for sale, giveaway, or purchase
                        on the Website. <br>
                        4.2 All users may view listings and contact other users. Contact details will be shared with all
                        users when requested. <br>
                        4.3 We do not set prices or manage logistics between Users. All transactions are solely
                        between the Users involved. <br>
                        4.4 We do not guarantee the quality, safety, or legality of the materials listed, the truth or
                        accuracy of listings, or the ability of Users to complete transactions.</p> <hr>
                        
                        
                    <p>5. Content and Conduct <br>
                        5.1 You are responsible for all content that you post, upload, or otherwise make available on
                        the Website. <br>
                        5.2 You agree not to post, upload, or otherwise make available any content that is unlawful,
                        harmful, threatening, abusive, harassing, defamatory, vulgar, obscene, or otherwise
                        objectionable.<br>
                        5.3 You agree not to use the Website for any illegal or unauthorized purpose.
                        5.4 We reserve the right to remove any content that violates these Terms or is otherwise
                        objectionable.</p> <hr>
                        
                   <p>6. Intellectual Property <br>
                        6.1 The Website and its original content, features, and functionality are and will remain the
                        exclusive property of ecoSansar and its licensors.<br>
                        6.2 You agree not to reproduce, duplicate, copy, sell, resell, or exploit any portion of the
                        Website without our express written permission.</p> <hr>
                        
                    <p>7. Termination <br>
                     7.1 We may terminate or suspend your account and bar access to the Website immediately,
                       without prior notice or liability, for any reason whatsoever, including, without limitation, if you
                    breach these Terms.<br>
                    7.2 Upon termination, your right to use the Website will immediately cease.</p> <hr>
                    
                     <p>8. Limitation of Liability <br>
                    8.1 To the maximum extent permitted by law, ecoSansar shall not be liable for any indirect,
                    incidental, special, consequential, or punitive damages, or any loss of profits or revenues,
                    whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible
                    losses, resulting from (i) your use or inability to use the Website; (ii) any unauthorized
                    access to or use of our servers and/or any personal information stored therein; (iii) any
                    interruption or cessation of transmission to or from the Website; (iv) any bugs, viruses, trojan
                    horses, or the like that may be transmitted to or through the Website by any third party; (v)
                    any errors or omissions in any content or for any loss or damage incurred as a result of your
                    use of any content posted, emailed, transmitted, or otherwise made available through the
                    Website; and/or (vi) the defamatory, offensive, or illegal conduct of any third party.</p> <hr>
                    
                     <p>9. Governing Law <br>
                        9.1 These Terms shall be governed and construed in accordance with the laws of Karnataka,
                        India, without regard to its conflict of law provisions. <br>
                        9.2 Our failure to enforce any right or provision of these Terms will not be considered a
                        waiver of those rights.</p> <hr>
                        
                    <p>10. Changes to Terms <br>
                        10.1 We reserve the right, at our sole discretion, to modify or replace these Terms at any
                        time. If a revision is material, we will provide at least 30 days' notice prior to any new terms
                        taking effect. What constitutes a material change will be determined at our sole discretion. <br>
                        10.2 By continuing to access or use our Website after those revisions become effective, you
                        agree to be bound by the revised terms.</p> <hr>
                        
                    <p>11. Contact Us <br>
                    11.1 If you have any questions about these Terms, please contact us at
                    <a href="mailto:support@ecosansar.com">support@ecosansar.com</a> </p> <hr>
                    
                   <p> By using the Website, you acknowledge that you have read, understood, and agree to be
                    bound by these Terms and Conditions. </p>
                    
            </section>
     </div>
     </div>
                <!--end col-md-9-->
            </div>
         
         
         
    </div>
    <!--end container-->
    
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
@include('frontend.include.footer')
 