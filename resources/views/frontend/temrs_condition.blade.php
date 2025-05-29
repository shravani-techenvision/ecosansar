@include('frontend.include.header')
 
		<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<h2 class="breadcrumb-title mb-2">Terms & Conditions</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
				</div>
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="container">
					<div class="row">
					
						<!-- Terms & Conditions -->
						<div class="col-md-12">
							<div class="terms-content privacy-cont">
							     <p> Welcome to <a href="https://ecosansar.com/">www.ecosansar.com</a>
                      (the "Website"). The Website is operated by ecoSansar
                       ("we," "our," or "us"). These Terms and Conditions ("Terms") govern your use of the Website
                      and the services provided through it. By accessing or using the Website, you agree to be
                       bound by these Terms. If you do not agree to these Terms, please do not use the Website.</p>
                       
                    <p>1. Definitions <br>
                    1.1 "User" or "You" refers to any individual or entity who accesses or uses the Website.<br>
                    1.2 "Contributor" refers to a User who lists waste materials on the Website.<br>
                    1.3 "Resource Collector" refers to a User who collects waste materials listed on the
                    Website.<br>
                    1.4 "Corporate" refers to a User who is an aggregator or recycler interested in buying or
                    selling waste materials listed on the Website.</p>  
                    
                    
                    <p>2. Eligibility <br>
                      2.1 You must be at least 18 years old to use the Website. <br>
                      2.2 By using the Website, you represent and warrant that you have the legal capacity to
                     enter into these Terms.</p>  
                     
                     <p>3. User Accounts <br>
                        3.1 To access certain features of the Website, you will need to create an account. We call
                        the platform The ZeroWaste Community Tool. <br>
                        3.2 You agree to provide accurate, current, and complete information during the registration
                        process and to update such information to keep it accurate, current, and complete. <br>
                        3.3 You are responsible for maintaining the confidentiality of your account password, otp,
                        emails from ecoSansar and for all activities that occur under your account. <br>
                        3.4 You agree to notify us immediately of any unauthorized use of your account or any other
                        breach of security.</p>  
                        
                    <p>4. Listings and Transactions <br>
                        4.1 All registered users on the Tool may list waste materials for sale, giveaway, or purchase
                        on the Website. <br>
                        4.2 All users may view listings and contact other users. Contact details will be shared with all
                        users when requested. <br>
                        4.3 We do not set prices or manage logistics between Users. All transactions are solely
                        between the Users involved. <br>
                        4.4 We do not guarantee the quality, safety, or legality of the materials listed, the truth or
                        accuracy of listings, or the ability of Users to complete transactions.</p>  
                        
                        
                    <p>5. Content and Conduct <br>
                        5.1 You are responsible for all content that you post, upload, or otherwise make available on
                        the Website. <br>
                        5.2 You agree not to post, upload, or otherwise make available any content that is unlawful,
                        harmful, threatening, abusive, harassing, defamatory, vulgar, obscene, or otherwise
                        objectionable.<br>
                        5.3 You agree not to use the Website for any illegal or unauthorized purpose.<br>
                        5.4 We reserve the right to remove any content that violates these Terms or is otherwise
                        objectionable.<br>
                        5.5 By registering on the platform you consent to receiving promotions, ads, newsletters by ecoSansar <br>
                        5.6 By registering on the platform you consent to sharing your contact details like name, email id, address, 
                        phone number with partners and other registered users to carry out or complete the desired service </p> 
                        
                   <p>6. Intellectual Property <br>
                        6.1 The Website and its original content, features, and functionality are and will remain the
                        exclusive property of ecoSansar and its licensors.<br>
                        6.2 You agree not to reproduce, duplicate, copy, sell, resell, or exploit any portion of the
                        Website without our express written permission.</p>  
                        
                    <p>7. Termination <br>
                     7.1 We may terminate or suspend your account and bar access to the Website immediately,
                       without prior notice or liability, for any reason whatsoever, including, without limitation, if you
                    breach these Terms.<br>
                    7.2 Upon termination, your right to use the Website will immediately cease.</p>  
                    
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
                    Website; and/or (vi) the defamatory, offensive, or illegal conduct of any third party.</p>  
                    
                     <p>9. Governing Law <br>
                        9.1 These Terms shall be governed and construed in accordance with the laws of Karnataka,
                        India, without regard to its conflict of law provisions. <br>
                        9.2 Our failure to enforce any right or provision of these Terms will not be considered a
                        waiver of those rights.</p>  
                        
                    <p>10. Changes to Terms <br>
                        10.1 We reserve the right, at our sole discretion, to modify or replace these Terms at any
                        time. If a revision is material, we will provide at least 30 days' notice prior to any new terms
                        taking effect. What constitutes a material change will be determined at our sole discretion. <br>
                        10.2 By continuing to access or use our Website after those revisions become effective, you
                        agree to be bound by the revised terms.</p> 
                        
                    <p>11. Contact Us <br>
                    11.1 If you have any questions about these Terms, please contact us at
                    <a href="mailto:support@ecosansar.com">support@ecosansar.com</a> </p>  
                    
                   <p> By using the Website, you acknowledge that you have read, understood, and agree to be
                    bound by these Terms and Conditions. </p>
							</div>
						</div>
						<!-- /Terms & Conditions -->
						
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->
 
@include('frontend.include.footer')
 