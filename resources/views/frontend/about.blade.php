@include('frontend.include.header')
<style>



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

<!--timeline css-->
<style>


    .timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative;
}
.timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline > li {
  margin-bottom: 30px;
  position: relative;
  width: 50%;
  float: left;
  clear: left;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  width: 95%;
  float: left;
  border: 1px solid #d4d4d4;
  /*border-radius: 2px;*/
  /*padding: 20px;*/
  position: relative;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}

.timeline > li > .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -15px;
  display: inline-block;
  border-top: 15px solid transparent;
  border-left: 15px solid #ccc;
  border-right: 0 solid #ccc;
  border-bottom: 15px solid transparent;
  content: " ";
}
.timeline > li > .timeline-panel:after {
  position: absolute;
  top: 27px;
  right: -14px;
  display: inline-block;
  border-top: 14px solid transparent;
  border-left: 14px solid #fff;
  border-right: 0 solid #fff;
  border-bottom: 14px solid transparent;
  content: " ";
}
.timeline > li > .timeline-badge {
  color: #fff;
  width: 24px;
  height: 24px;
  line-height: 50px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  top: 16px;
  right: -12px;
  /*background-color: #999999;*/
  z-index: 100;
  /*
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
  */
}
.timeline > li.timeline-inverted > .timeline-panel {
  float: right;
}
.timeline > li.timeline-inverted > .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 15px;
  left: -15px;
  right: auto;
}
.timeline > li.timeline-inverted > .timeline-panel:after {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-badge > a {
  color: #C5C7C5 !important;
}
.timeline-badge a:hover {
  color: #000 !important;
}
.timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline-body > p,
.timeline-body > ul {
    padding:20px;
    margin-bottom: 0;
}
.timeline-body > p + p {
  margin-top: 5px;
}
.timeline-footer{
    padding:20px;
    background-color:#f4f4f4;
}
.timeline-footer > a{
    cursor: pointer;
    text-decoration: none;
}
.tooltip{

    position:absolute;
    z-index:1020;
    display:block;
    visibility:visible;
    padding:5px;
    font-size:11px;
    opacity:0;
    filter:alpha(opacity=0);

}
.tooltip.in{
    /*opacity:0;
    filter:alpha(opacity=80);*/

}
.tooltip.top{
    margin-top:-2px;
}
.tooltip.right{
    margin-left:2px;
}
.tooltip.bottom{
    margin-top:2px;
}
.tooltip.left{
    margin-left:-2px;
}
.tooltip.top .tooltip-arrow{
    bottom:0;
    left:0;
    margin-left:0;
    border-left:0 solid transparent;
    border-right:5px solid transparent;
    border-top:0 solid #000;
}
.tooltip.left .tooltip-arrow{
    bottom:0;
    left:0;
    margin-left:0;
    border-left:0 solid transparent;
    border-right:5px solid transparent;
    border-top:0 solid #000;
}
.tooltip.bottom .tooltip-arrow{
    bottom:0;
    left:0;
    margin-left:0;
    border-left:0 solid transparent;
    border-right:5px solid transparent;
    border-top:0 solid #000;
}
.tooltip.right .tooltip-arrow{
    bottom:0;
    left:0;
    margin-left:0;
    border-left:0 solid transparent;
    border-right:5px solid transparent;
    border-top:0 solid #000;
}
.tooltip-inner{
    width:200px;
    padding:3px 8px;
    color:#fff;
    text-align:center;
    text-decoration:none;
    background-color:#313131;
    -webkit-border-radius:0px;
    -moz-border-radius:0px;
    border-radius:0px;
}
.tooltip-arrow{
    position:absolute;
    width:0;
    height:0;
}
.timeline > li.timeline-inverted{
  float: right;
  clear: right;
  /*margin-top: 30px;*/
  /*margin-bottom: 30px;*/
}
.timeline > li:nth-child(2){
  margin-top: 60px;
}
.timeline > li.timeline-inverted > .timeline-badge{
  left: -12px;
}
.secondtimeline{
    margin-top:180px !important;
}
@media (max-width: 767px) {
    ul.timeline:before {
        left: 40px;
    }

    ul.timeline > li {
      margin-bottom: 30px;
      position: relative;
      width:100%;
      float: left;
      clear: left;
    }
    ul.timeline > li > .timeline-panel {
        width: calc(100% - 90px);
        width: -moz-calc(100% - 90px);
        width: -webkit-calc(100% - 90px);
    }

    ul.timeline > li > .timeline-badge {
        left: 28px;
        margin-left: 0;
        top: 16px;
    }

    ul.timeline > li > .timeline-panel {
        float: right;
    }

        ul.timeline > li > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.timeline > li > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }

.timeline > li.timeline-inverted{
  float: left;
  clear: left;
  /*margin-top: 30px;*/
  /*margin-bottom: 30px;*/
}

.timeline > li.timeline-inverted > .timeline-badge{
  left: 28px;
}
.secondtimeline{
    margin-top:0px !important;
}
.timeline .our{
    margin: 0px !important;
}
}

    .timeline-footer22 {
    padding: 15px;
    padding-bottom: 1px;
    background-color: #f4f4f4;
    text-align: center;
   }

   img.img-responsive {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
    margin-top:20px;
}

a.pull-right {
    font-weight: bold;
    margin-top: -8px;
}

.timeline-footer22 h3 {
    margin-bottom: 14px;
}

.timeline .our{
    margin: 30px !important;
}

</style>


  <div id="page-content">
      <!--<div class="">-->
      <!--     <img src="{{asset('public/assets/images/eco/ewm.png')}}" alt="Image" width="100%"  height="250" style="background: rgba(15, 23, 43, 0.7) !important" >-->
      <!--</div>-->
    <div class="container" style="margin-top: 25px !important;">
        <div class="row">
            <!-- Image on the left, content on the right -->
            <div class="col-md-6 col-sm-12">
                <img src="{{asset('frontend/assets/img/aboutbann.png')}}" alt="Image" class="img-rounded shadow" style="max-width: 100%; height: auto;">
            </div>
            <div class="col-md-6 col-sm-12 section2">
                <section >
                <h1 >Our Story</h1>
                    <p>As a social enterprise, we have always focused on REDUCING waste in the urban context through a zero waste store for groceries and cleaners. The rapid increase in household waste due to shifting consumer lifestyles made it clear that this issue requires more than just a service, it demands an inclusive system intervention.</p>
                    <p>The ZeroWaste Community Tool aims to be just that, a ground zero intervention that connects the consumer with the system via the local workforce to create a resilient, scalable, inclusive, and a strong backbone for the Circular Economy.</p>
                </section>
            </div>
            </div>
            <div class="row" style="margin-top: 25px !important;">
            <!-- Content on the left, image on the right -->
            <!--<div class="col-md-6 col-sm-12">-->
            <!--    <section>-->
            <!--        <h1 style="font-weight:500 !important">About Us</h1>-->
            <!--        <p>The concept of Circular Economy has evolved over time, gaining widespread acknowledgment and acceptance among stakeholders through the value chain. ecoSansar has been a thought leader in circular and reusable packaging, having 7 years of experience through various trials and experimentation. ecoSansar originally started as a zero waste grocery store transcending to an online grocery marketplace with a mission to provide the convenience of online shopping without its packaging waste. It was essentially a marketplace with zero-waste delivery system. ecoSansar successfully home delivered close to 40,000 products with an inventory of just about 400 containers. The on-ground experience and intensive constant brainstorming with advisors, mentors, and stakeholders during our initial days has resulted in us maturing as specialists for establishing the Reverse Chain for packaging reuse.</p>-->
            <!--    </section>-->
            <!--</div>-->
            <!--<div class="col-md-6 col-sm-12">-->
            <!--    <img src="{{asset('public/assets/images/eco/hands-holding-recyclable-items.jpg')}}" alt="Image"  class="img-rounded shadow"  style="max-width: 100%; height: auto;">-->
            <!--</div>-->
        </div>
        <!--end row-->



    </div>
    <!--end container-->



    <div class="container" style="margin-top:-40px; !important">
    <div class="page-header text-center">
        <h1 id="timeline">Our journey</h1>
    </div>
    <!--<ul class="timeline" style="margin: 30px; !important">-->
     <ul class="timeline">
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
              <div class="timeline-footer22">
                <h3 class="">Zero-Waste Grocery
                Store Front</h3>
            </div>

            <div class="timeline-heading">
              <!--<img class="img-responsive" src="{{ asset('frontend/assets/img/1.png') }}" style=" height: 268px;" class="mx-auto d-block"/>-->
                <img class="img-responsive" src="{{ asset('frontend/assets/img/1.png') }}"   class="mx-auto d-block"/>
            </div>
            <div class="timeline-body">
              <p>A pioneering venture for buying organic groceries without unnecessary packaging. This was made possible by having returnable containers, refundable deposits, encouraging consumers to bring their own packaging, welcoming donations of containers and upcycling packaging from scrap material. <br>

               Our innovative approach quickly gained traction among a dedicated community of environmentally conscious consumers, who eagerly embraced our ethos. Beyond mere transactions, our store front became a hub for engaging conversations and shared learning experiences. We take pride in inspiring many individuals at that time, fostering enduring loyalty among our patrons at ecoSansar.</p>

            </div>

            <div class="timeline-footer">
                <a class="pull-right">December 2017</a>
            </div>
          </div>
        </li>

        <!--<li  class="timeline-inverted" style=" margin-top: 180px;">-->
         <li  class="timeline-inverted secondtimeline" >
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record invert" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
               <div class="timeline-footer22">
                <h3 class="">Online Marketplace - Deposit Refund System</h3>
            </div>

            <div class="timeline-heading">
              <img class="img-responsive" src="{{ asset('frontend/assets/img/2.png') }}" />

            </div>
            <div class="timeline-body">
              <p>As the trend towards online shopping gained momentum, we responded by launching our own marketplace, complete with a first of its kind, integrated deposit refund system for containers. We now had new learnings about logistical challenges, product and logistics based packaging requirements, managing irregular returns and tracking deposits. Every challenge and every interaction were now new learnings.<br><br>

Despite challenges, our system persevered through the pandemic. However, the landscape quickly evolved with the emergence of fast commerce, offering 10 minute deliveries - a level of convenience beyond our capacity as a small business. Consequently, we made the difficult decision to discontinue our grocery arm, recognizing the impossibility of matching such rapid service.</p>

            </div>

            <div class="timeline-footer">
                <a class="pull-right">March 2019</a>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
               <div class="timeline-footer22">
                <h3 class="">Community Collection Drives</h3>
            </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <img class="img-responsive" src="{{ asset('frontend/assets/img/3.png') }}" />

            </div>
            <div class="timeline-body">
              <p>One of the primary hurdles in implementing a Circular Economy is prompting behavioural shifts in consumers. Through our diverse donation drives, we’ve gained insights into individual consumer responses and motivations across different segments.<br>
              Contrary to common assumptions, modern consumers are enthusiastic about adopting sustainable options when presented effectively. Our voluntary collection drives consistently yielded positive results, showcasing consumer’s willingness to participate in sustainable practices.</p>
            </div>

            <div class="timeline-footer">
                <a class="pull-right">June 2023</a>
            </div>
          </div>
        </li>

        <li  class="timeline-inverted">
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record invert" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
               <div class="timeline-footer22">
                <h3 class="">DWCC Collaborations</h3>
            </div>
          <div class="timeline-panel">
              <div class="timeline-heading">
              <img class="img-responsive" src="{{ asset('frontend/assets/img/4.png') }}" />

            </div>
            <div class="timeline-body">
              <p>Understanding the operations, mindset, challenges and requirements of DWCCs (Dry Waste Collection Centers) is crucial for designing an inclusive and
              effective reuse chain. We’ve engaged in open dialogues with them and were pleasantly surprised by their readiness to offer unconditional support and cooperation
              for the advancement of the reuse chain. This speaks volumes about the significance of effective recycling of household waste for them. Food for thought indeed!</p>

            </div>

            <div class="timeline-footer">
                <a class="pull-right">November 2023</a>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
               <div class="timeline-footer22">
                <h3 class="">Second-Hand Marketplace</h3>
            </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <img class="img-responsive" src="{{ asset('frontend/assets/img/5.png') }}" />

            </div>
            <div class="timeline-body">
              <p>In our efforts to optimize existing resources, we are creating a marketplace for second hand packaging and packaging materials.
              This exercise is intended to be a quick fix while gaining perspectives.</p>
            </div>

            <div class="timeline-footer">
                <a></a>
                <a class="pull-right"> November 2023</a>
            </div>
          </div>
        </li>

        <!--<li  class="timeline-inverted">-->
        <!--  <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record invert" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>-->
        <!--  <div class="timeline-panel">-->
        <!--    <div class="timeline-heading">-->
        <!--      <img class="img-responsive" src="http://lorempixel.com/1600/500/sports/2" />-->

        <!--    </div>-->
        <!--    <div class="timeline-body">-->
        <!--      <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>-->

        <!--    </div>-->

        <!--    <div class="timeline-footer primary">-->
        <!--        <a><i class="glyphicon glyphicon-thumbs-up"></i></a>-->
        <!--        <a><i class="glyphicon glyphicon-share"></i></a>-->
        <!--        <a class="pull-right">Continuar Lendo</a>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</li>-->
        <!--<li>-->
        <!--  <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record invert" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>-->
        <!--  <div class="timeline-panel">-->
        <!--    <div class="timeline-body">-->
        <!--      <p><b>All the credits go to <a href="http://bootsnipp.com/rafamaciel">Rafamaciel</a></b></p>-->
        <!--      <p>I only make it responsive and remove the empty spaces to be more like Facebook timeline!</p>-->
        <!--    </div>-->

        <!--    <div class="timeline-footer primary">-->
        <!--        <a><i class="glyphicon glyphicon-thumbs-up"></i></a>-->
        <!--        <a><i class="glyphicon glyphicon-share"></i></a>-->
        <!--        <a class="pull-right">Continuar Lendo</a>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</li>-->

        <li class="clearfix" style="float: none;"></li>
    </ul>

         <div class="row">
            <div class="col-md-12 col-sm-12 section2">
                <section >
                    <p>We remain steadfast in our commitment to establishing a system for reusing packaging after consumption, as that has always been our primary core value.<br><br>
                     We've developed specific models tailored to diverse business types, drawing from our experience of implementing DRS (Deposit Refund System) in the grocery marketplace. This expertise enables us to design a comprehensive value chain encompassing logistics, reuse/refill/repurpose strategies and operational requirements.
                    We're currently seeking funded packaging reuse pilot opportunities from producers to implement the value chain for your unique needs.</p>
                </section>
            </div>
        </div>
</div>



</div>

<div class="row">


              <div class="responsive-container-block outer-container">
  <div class="responsive-container-block inner-container">
      <h3>
Who We Are</h3>
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
      <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
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
      </div>
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



      <div class="responsive-container-block">
          <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
            <img src="{{ asset('frontend/assets/img/ourteam/Pallavi.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name">
           Pallavi Sharma
          </p>
          <p class="text-blk position">
           Advisor / Leadership Mentor
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/pallavisharmatcc/" target="_blank">
              <img src="{{ asset('frontend/assets/img/linkicon.png') }}" alt="image" style="height: 25px;">
            </a>
          </div>
        </div>
      </div>
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

     <div class="responsive-container-block">

      <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
        <div class="team-card">
          <div class="img-wrapper">
           <img src="{{ asset('frontend/assets/img/ourteam/Rohini.png') }}" alt="SAB Post">
          </div>
          <p class="text-blk name1">
           Rohini Ravee Ramanathan
          </p>
          <p class="text-blk position">
            Media Specialist
          </p>
          <div class="social-media-links">
            <a href="https://www.linkedin.com/in/rohini-ravee-ramanathan/" target="_blank">
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
