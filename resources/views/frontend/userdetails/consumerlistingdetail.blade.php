
@include('frontend.include.header')
@include('sweetalert::alert')
<style>
       dl {
        display: flex;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
    }

    dt {
        width: 35%; /* Adjust the width as needed */
        font-weight: bold;
        margin-bottom: 5px; /* Add some spacing between the dt and dd */
        padding-right: 10px; /* Add some spacing between the dt and dd */
    }

    dd {
        width: 65%; /* Adjust the width to complement dt */
        margin: 0;
        margin-bottom: 5px; /* Add some spacing between entries */
    }

    /* Optional: Make sure each <dt> and <dd> pair stays together */
    dt, dd {
        display: flex;
        align-items: left; /* Align text vertically */
    }
    @media (max-width:375px){
     dl {
        display: flex;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
    }

    dt {
        width: 45%; /* Adjust the width as needed */
        font-weight: bold;
        margin-bottom: 5px; /* Add some spacing between the dt and dd */
        padding-right: 10px; /* Add some spacing between the dt and dd */
    }

    dd {
        width: 55%; /* Adjust the width to complement dt */
        margin: 0;
        margin-bottom: 5px; /* Add some spacing between entries */
    }

    /* Optional: Make sure each <dt> and <dd> pair stays together */
    dt, dd {
        display: flex;
        align-items: start; /* Align text vertically */
    }
    }
    /*@media (max-width:768px){*/
    /*   .container::before{*/
    /*       display: unset !important;*/
    /*   } */
    /*}*/

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<div id="page-content">
    <div class="container">
        <ol class="breadcrumb">
            {{--  <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Contact</li>  --}}
        </ol>
        <section class="page-title pull-left">
            <h1>{{ $consumerposts->name }}</h1>

        </section>
        <!--end page-title-->
        {{--  <a href="#write-a-review" class="btn btn-primary btn-framed btn-rounded btn-light-frame icon scroll pull-right"><i class="fa fa-star"></i>Write a review</a>  --}}
    </div>
    <!--end container-->
    <section>
        <div class="gallery detail">
            <div class="owl-carousel" data-owl-items="3" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="0" data-owl-margin="2" data-owl-nav-container="#gallery-nav">
                @foreach($consumerpostsres as $consumerpost)
                <div class="image">
                    <div class="  bg-transfer">
                        @php
                            // Check if $listing->resource_img is set and not empty
                            $imagePath = !empty($consumerpost->resource_img) ? 'Consumerposts/' . $consumerpost->resource_img : null;

                            // Check if the image exists in the S3 bucket or fallback to default
                            $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                        ? Storage::disk('s3')->url($imagePath)
                                        : asset('frontend/assets/img/ecosansar.png');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="abc">
                    </div>
                </div>
            @endforeach
            </div>
            <!--end owl-carousel-->
        </div>
        <!--end gallery-->
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div id="gallery-nav"></div>
                <section>
                    <h2>About this listing</h2>
                    <dl>
                        <dt>Resources: </dt>
<dd>
    {{ implode(', ', $conresources) }}
</dd>
                        <dt>Sale/Giveaway: </dt>
                        <dd>{{ $consumerposts->sale_giveaway }}</dd>
                        <dt>Quantity: </dt>
                        <dd>{{ $consumerposts->min_weight }} {{ $consumerposts->min_measure }} {{ 'to' }} {{ $consumerposts->max_weight }} {{ $consumerposts->max_measure }}</dd>
                        <dt>Clean/Unclean: </dt>
                        <dd>{{ $consumerposts->clean_unclean }}</dd>
                        <dt>Packaged: </dt>
                        <dd>{{ $consumerposts->packaged }}</dd>
                         <dt>Pincode: </dt>
                        <dd>  {{ $consumerposts->pincode }}</dd>
                        <dt>Address: </dt>
                        <dd>  {{ $consumerposts->address }}</dd>
                    </dl>

                    <br><br><br>

                    <span><strong>Posted On: </strong>{{ \Carbon\Carbon::parse($consumerposts->post_date)->format('F j, Y \a\t g:i A') }}</span>


                </section>

                <!--<section>-->
                <!--    <h2>Reviews</h2>-->
                <!--    <div class="review">-->

                <!--        @foreach($conreviews as $review)-->
                <!--        <div class="description">-->
                <!--            <figure>-->
                <!--                <div class="rating-passive" data-rating="{{ $review->rating }}">-->
                <!--                    <span class=" ">{{ $review->title }}</span>-->
                <!--                    <span class="stars"></span>-->
                <!--                    <span class="reviews">{{ $review->rating }}</span>-->
                <!--                </div>-->
                <!--            </figure>-->
                <!--            <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->-->
                <!--        </div>-->
                <!--        @endforeach-->

                <!--    </div>-->
                    <!--end review-->


                <!--</section>-->
                {{--  <section id="write-a-review">
                    <h2>Write a Review</h2>
                    <form class="clearfix form inputs-underline">
                        <div class="box">
                            <div class="comment">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="comment-title">
                                            <h4>Review your experience</h4>
                                        </div>
                                        <!--end title-->
                                        <div class="form-group">
                                            <label for="name">Title of your review<em>*</em></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Beautiful place!" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Your Message<em>*</em></label>
                                            <textarea class="form-control" id="message" rows="8" name="message" required="" placeholder="Describe your experience"></textarea>
                                        </div>
                                        <!--end form-group-->
                                    </div>
                                    <!--end col-md-8-->
                                    <div class="col-md-4">
                                        <div class="comment-title">
                                            <h4>Rating</h4>
                                        </div>
                                        <!--end title-->
                                        <dl class="visitor-rating">
                                            <dt>Comfort</dt>
                                            <dd class="star-rating active" data-name="comfort"></dd>
                                            <dt>Location</dt>
                                            <dd class="star-rating active" data-name="location"></dd>
                                            <dt>Facilities</dt>
                                            <dd class="star-rating active" data-name="facilities"></dd>
                                            <dt>Staff</dt>
                                            <dd class="star-rating active" data-name="staff"></dd>
                                            <dt>Value for money</dt>
                                            <dd class="star-rating active" data-name="value"></dd>
                                        </dl>
                                    </div>
                                    <!--end col-md-4-->
                                </div>
                                <!--end row-->
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-rounded">Send Review</button>
                                </div>
                                <!--end form-group-->
                            </div>
                            <!--end comment-->
                        </div>
                        <!--end review-->
                    </form>
                    <!--end form-->
                </section>  --}}
            </div>
            <!--end col-md-7-->
             <div class="col-md-5 col-sm-5">
                 <strong><h2>Location</h2> </strong>
                  <div id="map" style="height: 400px; width: 100%;"></div>
            </div>

            <!--end col-md-5-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>

<!--start map -->
      @include('frontend.include.footer')
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
    <script>
        function initMap() {
            // Replace these with the latitude and longitude you want to display
            const latitude = {{ $consumerposts->latitude }};
            const longitude = {{ $consumerposts->longitude }};

            // The location to center the map
            const location = { lat: latitude, lng: longitude };

            // Create a new map instance
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: location
            });

            // Place a marker at the specified location
            const marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // Add a click event listener to the map
            map.addListener('click', function(event) {
                const clickedLatLng = event.latLng;
                const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
                window.open(googleMapsUrl, '_blank');
            });

        }

        // Initialize the map when the window loads
        window.onload = initMap;
    </script>

    <!--end map -->

