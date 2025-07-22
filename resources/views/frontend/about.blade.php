@include('frontend.include.header')
<style>

.timeline-content p small {
    float:inline-end;
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
  color:#000;
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

/*timeline css*/
/* The actual timeline (the vertical ruler) */
.main-timeline-2 {
  position: relative;
}

/* The actual timeline (the vertical ruler) */
.main-timeline-2::after {
  content: "";
  position: absolute;
  width: 3px;
  background-color: #8eb66f;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
}

/* Container around content */
.timeline-2 {
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.timeline-2::after {
  content: "";
  position: absolute;
  width: 25px;
  height: 25px;
  right: -11px;
  background-color: #8eb66f;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left-2 {
  padding: 0px 40px 20px 0px;
  left: 0;
}

/* Place the container to the right */
.right-2 {
  padding: 0px 0px 20px 40px;
  left: 50%;
}

/* Add arrows to the left container (pointing right) */
.left-2::before {
  content: " ";
  position: absolute;
  top: 18px;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right-2::before {
  content: " ";
  position: absolute;
  top: 18px;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right-2::after {
  left: -14px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .main-timeline-2::after {
    left: 31px;
  }

  /* Full-width containers */
  .timeline-2 {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }

  /* Make sure that all arrows are pointing leftwards */
  .timeline-2::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left-2::after,
  .right-2::after {
    left: 18px;
  }

  .left-2::before {
    right: auto;
  }

  /* Make all right containers behave like the left ones */
  .right-2 {
    left: 0%;
  }
}

</style>


	<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
    style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover;
            background-position: center; "
             >
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-12">
				<h2 class="breadcrumb-title mb-2">About Us</h2>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb justify-content-center mb-0">
						<li class="breadcrumb-item">Home</li>
						<li class="breadcrumb-item active" aria-current="page">About Us</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>

		<!-- /Breadcrumb -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
		<div class="content p-0">

			<!-- About -->
			<div class="about-sec">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-6">
							<div class="about-img d-none d-md-block">
								<div class="about-exp">
									<span> Zero Waste Community Tool</span>
								</div>
								<div class="abt-img">
									<img src="{{ asset('frontend/assets/img/aboutbann.png') }}" class="img-fluid" alt="img">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="about-content">

								<h2>Our Story</h2>
								<p>As a social enterprise, we have always focused on REDUCING waste in the urban context through a zero waste store for groceries and cleaners. The rapid increase in household waste due to shifting consumer lifestyles made it clear that this issue requires more than just a service, it demands an inclusive system intervention.</p>
								<p>The ZeroWaste Community Tool aims to be just that, a ground zero intervention that connects the consumer with the system via the local workforce to create a resilient, scalable, inclusive, and a strong backbone for the Circular Economy.</p>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /About -->

		</div>
		</div>
		<!-- /Page Wrapper -->


   <!-- Timeline 6 - Bootstrap Brain Component -->
 <div >
        <h1 class="text-center mb-3" >Our Journey</h1>
    </div>
   <section style="background-color: #F0F2F5;">
  <div class="container py-5">

    <div class="main-timeline-2">
      <div class="timeline-2 left-2">
        <div class="card">
          <img src="{{ asset('frontend/assets/img/1.png') }}" class="card-img-top" style="height:250px;"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Zero-Waste Grocery Store Front</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> December 2017</p>
            <p class="mb-0">A pioneering venture for buying organic groceries without unnecessary packaging. This was made possible by having returnable containers, refundable deposits, encouraging consumers to bring their own packaging, welcoming donations of containers and upcycling packaging from scrap material. <br>

               Our innovative approach quickly gained traction among a dedicated community of environmentally conscious consumers, who eagerly embraced our ethos. Beyond mere transactions, our store front became a hub for engaging conversations and shared learning experiences. We take pride in inspiring many individuals at that time, fostering enduring loyalty among our patrons at ecoSansar.</p>
          </div>
        </div>
      </div>
      <div class="timeline-2 right-2">
        <div class="card">
          <img src="{{ asset('frontend/assets/img/2.png') }}" class="card-img-top" style="height:250px;"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Online Marketplace - Deposit Refund System</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> March 2019</p>
            <p class="mb-0">As the trend towards online shopping gained momentum, we responded by launching our own marketplace, complete with a first of its kind, integrated deposit refund system for containers. We now had new learnings about logistical challenges, product and logistics based packaging requirements, managing irregular returns and tracking deposits. Every challenge and every interaction were now new learnings.<br><br>

Despite challenges, our system persevered through the pandemic. However, the landscape quickly evolved with the emergence of fast commerce, offering 10 minute deliveries - a level of convenience beyond our capacity as a small business. Consequently, we made the difficult decision to discontinue our grocery arm, recognizing the impossibility of matching such rapid service.</p>
          </div>
        </div>
      </div>
      <div class="timeline-2 left-2">
        <div class="card">
          <img src="{{ asset('frontend/assets/img/3.png') }}" class="card-img-top" style="height:250px;"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Community Collection Drives</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> June 2023</p>
            <p class="mb-0">One of the primary hurdles in implementing a Circular Economy is prompting behavioural shifts in consumers. Through our diverse donation drives, we’ve gained insights into individual consumer responses and motivations across different segments.<br>
              Contrary to common assumptions, modern consumers are enthusiastic about adopting sustainable options when presented effectively. Our voluntary collection drives consistently yielded positive results, showcasing consumer’s willingness to participate in sustainable practices.</p>
          </div>
        </div>
      </div>
      <div class="timeline-2 right-2">
        <div class="card">
          <img src="{{ asset('frontend/assets/img/4.png') }}" class="card-img-top" style="height:250px;"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4"> DWCC Collaborations</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> November 2023</p>
            <p class="mb-0">Understanding the operations, mindset, challenges and requirements of DWCCs (Dry Waste Collection Centers) is crucial for designing an inclusive and
              effective reuse chain. We’ve engaged in open dialogues with them and were pleasantly surprised by their readiness to offer unconditional support and cooperation
              for the advancement of the reuse chain. This speaks volumes about the significance of effective recycling of household waste for them. Food for thought indeed!</p>
          </div>
        </div>
      </div>
      <div class="timeline-2 left-2">
        <div class="card">
          <img src="{{ asset('frontend/assets/img/5.png') }}" class="card-img-top" style="height:250px;"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Second-Hand Marketplace</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> November 2023</p>
            <p class="mb-0">In our efforts to optimize existing resources, we are creating a marketplace for second hand packaging and packaging materials.
              This exercise is intended to be a quick fix while gaining perspectives.</p>
          </div>
        </div>
      </div>
    </div>
    <p class="mt-2">We remain steadfast in our commitment to establishing a system for reusing packaging after consumption, as that has always been our primary core value.</p>
    <p>We've developed specific models tailored to diverse business types, drawing from our experience of implementing DRS (Deposit Refund System) in the grocery marketplace. This expertise enables us to design a comprehensive value chain encompassing logistics, reuse/refill/repurpose strategies and operational requirements. We're currently seeking funded packaging reuse pilot opportunities from producers to implement the value chain for your unique needs.</p>
  </div>
</section>

<div class="row">
              

              <div class="responsive-container-block outer-container">
  <div class="responsive-container-block inner-container">
      <h4>
Who We Are</h4>
   <h1>
     Meet the Team
   </h1>

    <div class="responsive-container-block">
      <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
            <img src="{{ asset('frontend/assets/img/ourteam/gayatrijoshi.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">
           Gayatri Joshi
          </p>
          <p class="text-blk position">
           Founder
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/gayatrijoshi/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>

          </div>
        </div>
      </div>
      {{--  <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
               <img src="{{ asset('frontend/assets/img/ourteam/AmodKabade.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">

Amod Kabade
          </p>
          <p class="text-blk position">
            Business and Tech Strategy Consultant
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/akabade/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>

          </div>
        </div>
      </div>  --}}
       <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
           <img src="{{ asset('frontend/assets/img/ourteam/Sarita.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">
          Saritha Devpunje

          </p>
          <p class="text-blk position">
           CTO (Consultant)
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/saritha-devpunje-50315824/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>

          </div>
        </div>
      </div>
    </div>



      {{--  <div class="responsive-container-block">
          <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
            <img src="{{ asset('frontend/assets/img/ourteam/Renuka.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">
           Renuka
          </p>
          <p class="text-blk position">
          Consultant (Operations and Volunteer Management)
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/renuka-pooja-k-g/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>
          </div>
        </div>
      </div>   --}}
      <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
            <img src="{{ asset('frontend/assets/img/ourteam/Tapas.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">
             Capt Tapas Majumdar
          </p>
          <p class="text-blk position">
          Sustainability Practitioner / Advisor / ESG consultant
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/capttapasmajumdar/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>
          </div>
        </div>
      </div>
      <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
               <img src="{{ asset('frontend/assets/img/ourteam/RanjithRao.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name" >
            Ranjith Rao
          </p>
          <p class="text-blk position">
            Business Coach
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/ranjithraor/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>
          </div>
        </div>
      </div>

    </div>


  </div>
</div>
                <!--end col-md-9-->
            </div>



<script>

    $(document).ready(function(){
	var my_posts = $("[rel=tooltip]");

	var size = $(window).width();
	for(i=0;i<my_posts.length;i++){
		the_post = $(my_posts[i]);

		if(the_post.hasClass('invert') && size >=767 ){
			the_post.tooltip({ placement: 'left'});
			the_post.css("cursor","pointer");
		}else{
			the_post.tooltip({ placement: 'rigth'});
			the_post.css("cursor","pointer");
		}
	}
});
</script>

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
 