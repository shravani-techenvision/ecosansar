@include('frontend.include.header')
<style>
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
    .container {
        width: 1394px;
    }

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

@media (max-width: 768px) {
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
        <div class="container">
             
            <div class="row">
              

              <div class="responsive-container-block outer-container">
  <div class="responsive-container-block inner-container">
      <h3>
WHO WE ARE</h3>
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
          <p class="text-blk name">
           
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
          <p class="text-blk name">
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
            <!--end row-->
        </div>
        <!--end container-->
    </div>


@include('frontend.include.footer')