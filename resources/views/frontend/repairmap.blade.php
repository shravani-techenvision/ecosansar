@include('frontend.include.header')
<style>
   .bann {
    background-image: url('{{ asset('frontend/assets/img/bannerindex.jpg') }}');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 250px; /* Default height for larger screens */
    position: relative;
}

.banner-text {
    position: absolute;
    right: 20px; /* Distance from the right edge */
    top: 170px; /* Distance from the top edge */
    font-size: 24px; /* Default font size for larger screens */
    color: white;
    font-weight: bold;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    padding: 10px 20px;
    border-radius: 5px;
}

.banner-text a {
    color: white;
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
</style>
  <div id="page-content">

             <section>
            <div class="bann height-400px" id="map-contact">
                <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a> /
            <a href="{{route('repairmap')}}" class="breadcrumb-link">The Repair Map</a>
        </div>
            </div>
            <!--end map-->
        </section>
         <section class="block">
            <div class="container">
 <h1>The Repair Map</h1>
<iframe src="https://www.google.com/maps/d/embed?mid=1EEYoJi-3uN8u1HHdDz9ag2UVXzjrh1g&ehbc=2E312F" width="100%" height="480"></iframe>
<!--<iframe src="https://www.google.com/maps/d/u/0/embed?mid=1vi6XBXzVq1CeWN2ljchFH-U5zy9JD9I&ehbc=2E312F" width="640" height="480"></iframe>-->

  </div>
  </div>
@include('frontend.include.footer')
