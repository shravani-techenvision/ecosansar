@include('frontend.include.header')
<style>

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






.answer {
    display: none;
    transition: all 0.3s ease-in-out;
     background-color: #f8f8f8;
    padding: 10px;
    border: 1px solid #ddd;
}

.faq-item {
    margin-bottom: 20px;
}

.question {
    cursor: pointer;
    background-color: #f8f8f8;
    padding: 10px;
    border: 1px solid #ddd;
}

.question:hover {
    background-color: #f1f1f1;
}

.question h3 {
    margin: 0;
    font-size: 18px;
}
 .question-header {
       /* display: flex;           Use flexbox layout
        align-items: center;    /* Align items vertically */
    }

    .question-header i {
        margin-right: 10px;     /* Space between icon and question */
        cursor: pointer;        /* Show pointer on hover */
    }
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">


</style>


  <div id="page-content">
        <div class="container">
            <ol class="breadcrumb">
                <!--<li><a href="#">Home</a></li>-->
                <!--<li><a href="#">Pages</a></li>-->
                <!--<li class="active">Faq</li>-->
            </ol>
        </div>
        <section>
            <div class="bann height-400px" id="map-contact">
                 <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a> /
            <a href="{{route('faq')}}" class="breadcrumb-link">FAQ</a>
        </div>
            </div>
            <!--end map-->
        </section>
            <!--<div class="row">-->
            <!--    <div class="col-md-12 col-sm-12">-->

            <!--        <section class="page-title">-->
            <!--            <h1>Frequently Asked Questions</h1>-->
            <!--        </section>-->
                    <!--end section-title-->
            <!--        <section>-->

            <!--        </section>-->
            <!--        <section>-->
            <!--            @foreach ($faqs as $faq)-->

            <!--            <div class="answer">-->
            <!--                <div class="box">-->

            <!--                    <h4>Category : {{ $faq['category_name'] }}</h4>-->
            <!--                    <h3>{{ $faq['question'] }}</h3>-->
            <!--                    <p>{{ $faq['answer'] }}-->
            <!--                    </p>-->
            <!--                </div>-->
                            <!--<figure>Was this answer helpful? <a href="#">Yes<i class="fa fa-thumbs-up"></i></a> <a href="#">No<i class="fa fa-thumbs-down"></i></a></figure>-->
            <!--            </div>-->

            <!--             @endforeach-->
                        <!--end answer-->

                        <!--end answer-->
            <!--        </section>-->

            <!--    </div>-->

            <!--</div>-->
            <!--end row-->


            <section class="block">
                <div class="container">
                <div class="row">

                <div class="col-md-12 col-sm-12">

                        <h1>Frequently Asked Questions</h1>
                <!--end section-title-->
                <section>
                    @foreach ($faqs as $faq)
                    <div class="faq-item">
                        <!--<div class="question" onclick="toggleAnswer(this)">-->
                         <div class="question" onclick="toggleAnswer(this)">
                            <h4>Category : {{ $faq['category_name'] }}</h4>
                            <div class="question-header">
                <!-- Icon in front of the question -->

                <h3><strong>{{ $faq['question'] }}</strong></h3>
                <i style="float:right; margin-top: -35px;" class="fa fa-plus"></i>
            </div>
                        </div>
                        <div class="answer" style="display: none;">
                          <p>{!! $faq['answer'] !!}</p>

                        </div>
                    </div>
                    @endforeach
                </section>
            </div>
            </div>
        </div>
        <!--end row-->
            </section>


        </div>
        <!--end container-->

<script>
    function toggleAnswer(element) {
        // Find the closest .faq-item div
        var faqItem = element.closest('.faq-item');

        // Find the .answer div within the same faq-item
        var answer = faqItem.querySelector('.answer');

        // Find the icon within the clicked element or its parent
        var icon = faqItem.querySelector('.question-header i');

        // Toggle the display of the answer
        if (answer.style.display === 'none') {
            answer.style.display = 'block';
            // Change icon to minus when open
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-minus');
        } else {
            answer.style.display = 'none';
            // Change icon back to plus when closed
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        }
    }
</script>


<!--    <script>-->
<!--    function toggleAnswer(element) {-->
<!--        var answer = element.nextElementSibling;-->
<!--        if (answer.style.display === "none") {-->
<!--            answer.style.display = "block";-->
<!--        } else {-->
<!--            answer.style.display = "none";-->
<!--        }-->
<!--    }-->
<!--</script>-->

 <script>
//     document.addEventListener("DOMContentLoaded", function() {
//     var timelineItems = document.querySelectorAll('.timeline-item');
//     var windowHeight = window.innerHeight;

//     function checkPosition() {
//         for (var i = 0; i < timelineItems.length; i++) {
//             var positionFromTop = timelineItems[i].getBoundingClientRect().top;

//             if (positionFromTop - windowHeight <= 0) {
//                 timelineItems[i].style.opacity = 1;
//                 timelineItems[i].style.transform = 'translateY(0)';
//             }
//         }
//     }

//     window.addEventListener('scroll', checkPosition);
//     window.addEventListener('resize', checkPosition);

//     checkPosition();
// });

</script>
@include('frontend.include.footer')
