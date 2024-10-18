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
            <a href="{{route('service')}}" class="breadcrumb-link">Service</a>
        </div>
            </div>
            <!--end map-->
        </section>
         <section class="block">
            <div class="container">
         <div class="row">
                              @php
                                use App\Models\admin\Service; // Import the About model
                                
                                $howitwork = Service::get();
                             @endphp
                
                            @foreach($howitwork as $item)
                                {!! $item->content !!}
                            @endforeach
     </div>
     </div>
     </section>
                   <section class="block" id="leave-reply">
                        <div class="container">
                        
                        <header><h2 class="no-border">Enquiry form</h2></header>
                       <form id="registerForm" class="form inputs-underline" method="POST" action="{{ route('service_enquiry.save') }}">
                            @csrf
                            <!--<input type="hidden" name="user_type" value="consumer">-->
                        <div class="row">
                            <div class="form-group col-md-6">
                                        <label for="first_name">Name<span style="color:red;">*</span></label>
                                        <input onkeydown="return /[a-z ]/i.test(event.key)" type="text" class="form-control" name="name" id="name" placeholder="Name" value={{ old('name') }}>
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                     @endif
                                     <span class="error-message text-danger" id="name-error"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="first_name">Mobile<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone Number" onkeypress="return isNumeric(event)" minlength="10" maxlength="10" value={{ old('mobile') }}>
                                        @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                     @endif
                                     <span class="error-message text-danger" id="name-error"></span>
                                    </div>
                                     <div class="form-group col-md-6">
                                <label for="address">
                                    Address<span style="color:red;">*</span>
                                </label>
                                <textarea 
                                    class="form-control" 
                                    rows="4" 
                                    cols="50" 
                                    name="address" 
                                    id="address" 
                                    placeholder="Address"
                                >{{ old('address') }}</textarea>
                                @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                                
                                 <span class="error-message text-danger" id="address-error"></span>
                            </div>
                            <div class="form-group col-md-6">
                            <label class=" form-label">Type of Service Required<span style="color:red;">*</span></label>
                                    <select class="form-select" name="type_of_service" id="type_of_user">
                                        <option value="">Select</option>
                                        <option value="Bulk Collection Drive" {{ old('type_of_service') == 'Bulk Collection Drive' ? 'selected' : '' }}>Bulk Collection Drive</option>
                                        <option value="Specific Material Collection" {{ old('type_of_service') == 'Specific Material Collection' ? 'selected' : '' }}>Specific Material Collection</option>
                                        <option value="Other" {{ old('type_of_service') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                            @if ($errors->has('type_of_service'))
                                <span class="text-danger">{{ $errors->first('type_of_service') }}</span>
                             @endif
                               <span class="error-message text-danger" id="type_of_user-error"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">
                                    Message<span style="color:red;">*</span>
                                </label>
                                <textarea 
                                    class="form-control" 
                                    rows="4" 
                                    cols="50" 
                                    name="message" 
                                    id="message" 
                                    placeholder="Message"
                                >{{ old('address') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                                
                                 <span class="error-message text-danger" id="address-error"></span>
                            </div>
                                    
                             
                        </div><br>
                            <!--end form-group-->
                            <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" >Submit </button>
                                <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                                </div>
                            <!--end form-group-->
                        </form>
                        
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
 