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


  <div id="page-content">
      <!--<div class="">-->
      <!--     <img src="{{asset('public/assets/images/eco/ewm.png')}}" alt="Image" width="100%"  height="250" style="background: rgba(15, 23, 43, 0.7) !important" >-->
      <!--</div>-->
    <div class="container" style="margin-top: 25px !important;">

         <div class="row">
     <div class="responsive-container-block outer-container">
     <div class="responsive-container-block inner-container">
             <section>
                <!--<h2 style="font-weight:500 !important">How Its Works</h2>-->
                <!--    <p> <b>Step 1: List Your Waste </b><br>-->
                <!--    If you have waste that can be turned into a valuable resource, start by listing it on our-->
                <!--    platform. You can choose to:<br>-->
                <!--   ● Sell-->
                <!--   ● Give Away-->
                <!--   ● Buy-->
                <!--    </p>-->
                <!--       <hr>-->
                <!--        <p><b>Step 2: Connect with the Next in the Collection Chain</b> <br>-->
                <!--         Once your waste is listed, you can search for and connect with the next in the collection-->
                <!--        chain to sell / giveaway / buy as per your requirement. You could also be reached by-->
                <!--        someone looking for a requirement fit.<br>-->
                <!--      </p> <hr>-->

                <!--    <p><b>Step 3:-->
                <!--      Reactivate or Deactivate Your Post</b> <br>-->
                <!--        If you have successfully established a connection and your request has been fulfilled, you-->
                <!--        can deactivate the listing from your profile page. Don’t forget to leave a review for your-->
                <!--        vendor.<br>-->
                <!--        The listing will automatically deactivate after 7 days. You will receive 2 reminder messages-->
                <!--        regarding the same. If you wish to renew it, simply click on Reactivate on the listing from-->
                <!--        your profile page.</p> <hr>-->

                <!--     <p><b>Other Services : <br>-->
                <!--        Collection Campaigns </b> -->
                <!--        If you need a particular type of resource in bulk, we can organize collection campaigns to-->
                <!--        meet your requirements.Please fill in the enquiry form here.-->
                <!--        Utilize Our Supply Chain Optimisation Service-->
                <!--        For quantities exceeding 100kg, take advantage of our Supply Chain Optimisation Service. Here’s how it works:-->
                <!--        1. Place an Enquiry: Submit a request for a specific type of resource.-->
                <!--        2. Resource Collation: We will gather a list of Resource Collectors who have the resource in stock.-->
                <!--        3. Route Planning: We will chart out an optimal route for you to collect the resources.</p> <hr>-->
                              @php
                                use App\Models\admin\About; // Import the About model

                                $howitwork = About::get();
                             @endphp

                            @foreach($howitwork as $item)
                                {!! $item->content !!}
                            @endforeach


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
