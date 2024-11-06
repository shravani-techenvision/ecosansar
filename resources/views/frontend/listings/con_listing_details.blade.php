
@include('frontend.include.header')
@include('sweetalert::alert')
<style>
    /* Style for star ratings */
    .star-rating1 {
        unicode-bidi: bidi-override;
        direction: ltr; /* Set to left-to-right */
        text-align: center;
    }

    .star-rating1 span {
        display: inline-block;
        position: relative;
        width: 1.1em;
        font-size: 31px;
        cursor: pointer;
        color:transparent;
    }

    .star-rating1 span:before {
       content: "\2606";
        position: absolute;
        color: #FFD700;
    }

    .star-rating1 span.highlight {

        color: #FFD700; /* Yellow */
    }
    .logoimg{
        width : auto ;
height:36px;
    }
    input{
        font-family: sans-serif !important;
    }
    textarea {
width: -webkit-fill-available !important;
padding-left:8px;
}
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
        align-items: start; /* Align text vertically */
    }
    .hr-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.hr-wrapper hr {
    flex: 1;
    border: none;
    border-top: 1px solid #ccc;
    margin: 0 10px; /* Adjust margin as needed */
}

.hr-wrapper h2 {
    margin: 0;
    padding: 0 10px;
    white-space: nowrap;
}
     .custom-card {
    border: 1px solid #8eb66f;
    border-radius: 4px;
    background-color: #fafafa;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow */
    padding: 15px; /* Padding for content */
    margin-bottom: 20px; /* Margin for spacing */
}

.card-body {
    padding: 10px 15px;
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


@media (max-width:767px){
.rt-container {
    padding-left:2px;
    padding-right:2px;
}
.ScriptHeader{
    padding-top: 2px;
}


}
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />


<div id="page-content">
    <div class="container">
        <ol class="breadcrumb">

        </ol>
        <section class="page-title pull-left">
            <h1>{{ $consumerposts->name }}</h1>

        </section>
        <!--end page-title-->
        <!--<a href="#write-a-review" class="btn btn-primary btn-framed btn-rounded btn-light-frame icon scroll pull-right"><i class="fa fa-star"></i>Write a review</a>-->
    </div>
    <!--end container-->
    <section>
        <div class="gallery detail">
            <div class="owl-carousel" data-owl-items="3" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="0" data-owl-margin="2" data-owl-nav-container="#gallery-nav">
                @foreach($consumerpostsres as $consumerpost)
                <div class="image">
                    <div class="bg-transfer">
                        <img src="{{ Storage::disk('s3')->url('Consumerposts/' . $consumerpost->resource_img) }}" alt="abc">

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
                    <strong><h2>About this listing</h2></strong>
                    <dl>
                        <dt>Resources: </dt>
<dd>
    {{ implode(', ', $conresources) }}
</dd>
                        <dt>Sale/Giveaway:</dt>
                        <dd>  {{ $consumerposts->sale_giveaway }}</dd>
                        <dt>Quantity: </dt>
                        <dd>  {{ $consumerposts->min_weight }} {{ $consumerposts->min_measure }} {{ 'to' }} {{ $consumerposts->max_weight }} {{ $consumerposts->max_measure }}</dd>
                        <dt>Clean/Unclean: </dt>
                        <dd>  {{ $consumerposts->clean_unclean }}</dd>
                        <dt>Packaged: </dt>
                        <dd>  {{ $consumerposts->packaged }}</dd>
                        <dt>Pincode: </dt>
                        <dd>  {{ $consumerposts->pincode }}</dd>
                        <dt>Address: </dt>
                        <dd>  {{ $consumerposts->address }}</dd>

<br>
                        <!--<dd> <span style="float:inline-start;"> <strong> Posted By:</strong></span><a style="float:inline-end;" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " href="{{ url('conpostprofile'). "/".$id }}" > <strong> Add review</strong></a></dd>-->
                    </dl>
                    <br>
                    @if (session()->has('user_id'))
                    <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('con_listing_details/'.$consumerposts->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                        <!--<i class="fa fa-share-alt"></i> Share on WhatsApp-->
                    </a>
                @else
                    <a href="{{ route('consumer_login', ['redirect_wp' => url('con_listing_details/' . $consumerposts->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                    </a>
                @endif
                    <div class="custom-card">
                    <div class="card-body">
                        <div class="mb-3">
                     <span style="float:inline-start;font-size:18px;"> <strong> Posted By:</strong></span> <br><br>
                     <a href="#" data-id="{{ $consumerposts->conid }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow consumer-connect-listing" style="float:right;">

        <span>Connect</span>
    </a>
                      <strong>Name:</strong>  {{ $users->name }} <br>
                      <strong>Email:</strong>  {{ $users->email }} <br>
                      <strong>Mobile:</strong>  {{ $users->mobile }} <br>
                      </div>
                       </div>
                       </div>
                      <!--<div id="map" style="height: 400px;"></div>-->



                </section>
                <!--<section>-->
                <!--    <h2>Reviews</h2>-->
                <!--    <div class="review">-->

                <!--        @foreach($conlistreviews as $review)-->
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
                <!--<section id="write-a-review">-->
                <!--    <h2>Write a Review</h2>-->
                <!--    <form class="clearfix form inputs-underline" action="{{ route('review.consumer_save') }}" method="POST">-->
                <!--        @csrf-->
                <!--        <input type="hidden" name="user_id" value="{{ $u_id }}">-->
                <!--        <input type="hidden" name="post_id" value="{{ $post_id }}">-->
                <!--        <div class="box">-->
                <!--            <div class="comment">-->
                <!--                <div class="row">-->
                <!--                    <div class="col-md-8">-->
                <!--                        <div class="comment-title">-->
                <!--                            <h4>Review your experience</h4>-->
                <!--                        </div>-->
                                        <!--end title-->
                <!--                        <div class="form-group">-->
                <!--                            <label for="name">Title of your review<em>*</em></label>-->
                <!--                            <input type="text" class="form-control" id="title" name="title" >-->
                <!--                            @if ($errors->has('title'))-->
                <!--                                <span class="text-danger">{{ $errors->first('title') }}</span>-->
                <!--                            @endif-->
                <!--                        </div>-->
                <!--                        <div class="form-group">-->
                <!--                            <label for="message">Your Message<em>*</em></label>-->
                <!--                            <textarea class="form-control" id="message" rows="8" name="message"  =""  ></textarea>-->
                <!--                            @if ($errors->has('message'))-->
                <!--                            <span class="text-danger">{{ $errors->first('message') }}</span>-->
                <!--                        @endif-->
                <!--                        </div>-->
                                        <!--end form-group-->
                <!--                    </div>-->
                                    <!--end col-md-8-->
                <!--                    <div class="col-md-4">-->
                <!--                        <div class="comment-title">-->
                <!--                            <label for="name">Rating<em>*</em></label>-->
                <!--                        </div>-->
                                        <!--end title-->
                <!--                        <span class="star-rating1" id="star1">-->
                <!--                            <span data-rating="1">&#9733;</span>-->
                <!--                            <span data-rating="2">&#9733;</span>-->
                <!--                            <span data-rating="3">&#9733;</span>-->
                <!--                            <span data-rating="4">&#9733;</span>-->
                <!--                            <span data-rating="5">&#9733;</span>-->
                <!--                        </span>-->
                <!--                        <input type="hidden" name="rating" id="rating" value="0">-->
                <!--                        @if ($errors->has('rating'))-->
                <!--                            <span class="text-danger">{{ $errors->first('rating') }}</span>-->
                <!--                        @endif-->
                <!--                    </div>-->
                                    <!--end col-md-4-->
                <!--                </div>-->
                                <!--end row-->
                <!--                <br>-->
                <!--                <div class="form-group">-->
                <!--                    <button type="submit" class="btn btn-primary btn-rounded">Send Review</button>-->
                <!--                </div>-->
                                <!--end form-group-->
                <!--            </div>-->
                            <!--end comment-->
                <!--        </div>-->
                        <!--end review-->
                <!--    </form>-->

                    <!--end form-->
                <!--</section>-->
            </div>
            <!--end col-md-7-->
             <div class="col-md-5 col-sm-5">
                 <strong><h2>Location</h2> </strong>
                   <div id="map" style="height: 400px; width: 100%;"></div>
                 </div>
   <!--<div class="col-md-5 col-sm-5">-->
   <!--             <div class="detail-sidebar">-->
   <!--                 <h2>Enquiry form</h2>-->
   <!--                 <section class="shadow">-->

                        <!--end map-->
   <!--                     <div class="content">-->
   <!--                         <form class="form form-email inputs-underline"  action="{{ route('enquiry.consumer_save') }}" method="POST">-->
   <!--                             @csrf-->
   <!--                             <input type="hidden" name="id" value="{{ $id }}">-->
   <!--                              <input type="hidden" name="name" value="{{ $loginuser->name }}">-->
   <!--                             <input type="hidden" name="email" value="{{ $loginuser->email }}">-->
   <!--                             <input type="hidden" name="mobile" value="{{ $loginuser->mobile }}">-->
                                <!--<div class="row justify-content-center align-items-center">-->
                                <!--    <div class="col-md-12 col-sm-12">-->
                                <!--        <div class="form-group">-->
                                <!--            <label for="name">Name<span style="color:red;">*</span></label>-->
                                <!--            <input type="text" class="form-control" name="name" id="name">-->
                                <!--            @if ($errors->has('name'))-->
                                <!--                <span class="text-danger">{{ $errors->first('name') }}</span>-->
                                <!--            @endif-->
                                <!--        </div>-->
                                        <!--end form-group-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="row">-->
                                    <!--end col-md-4-->
                                <!--    <div class="col-md-12 col-sm-12">-->
                                <!--        <div class="form-group">-->
                                <!--            <label for="email">Email<span style="color:red;">*</span></label>-->
                                <!--            <input type="email" class="form-control" name="email" id="email">-->
                                <!--            @if ($errors->has('email'))-->
                                <!--                <span class="text-danger">{{ $errors->first('email') }}</span>-->
                                <!--            @endif-->
                                <!--        </div>-->
                                        <!--end form-group-->
                                <!--    </div>-->
                                <!--</div>-->
                                    <!--end col-md-4-->
                                <!--    <div class="row">-->
                                <!--    <div class="col-md-12 col-sm-12">-->
                                <!--        <div class="form-group">-->
                                <!--            <label for="subject">Phone no<span style="color:red;">*</span></label>-->
                                <!--            <input type="text" class="form-control" name="mobile" id="mobile">-->
                                <!--            @if ($errors->has('mobile'))-->
                                <!--                <span class="text-danger">{{ $errors->first('mobile') }}</span>-->
                                <!--            @endif-->
                                <!--        </div>-->
                                        <!--end form-group-->
                                <!--    </div>-->
                                    <!--end col-md-4-->
                                <!--</div>-->
                                <!--end row-->
   <!--                             <div class="form-group">-->
   <!--                                 <label for="message">Message<span style="color:red;">*</span></label>-->
   <!--                                 <textarea class="form-control" id="message" rows="4" name="message"></textarea>-->
   <!--                                 @if ($errors->has('message'))-->
   <!--                                             <span class="text-danger">{{ $errors->first('message') }}</span>-->
   <!--                                         @endif-->
   <!--                             </div>-->
                                <!--end form-group-->
   <!--                             <div class="form-group">-->
   <!--                                 <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Send Message </button>-->
   <!--                             </div>-->
                                <!--end form-group-->
   <!--                         </form>-->
   <!--                     </div>-->
   <!--                 </section>-->

   <!--                 {{--  <section>-->
   <!--                     <h2>Share This Listing</h2>-->
   <!--                     <div class="social-share"></div>-->
   <!--                 </section>  --}}-->
   <!--             </div>-->
                <!--end detail-sidebar-->
   <!--         </div>-->
            <!--end col-md-5-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>
 <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="enquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="user-details" class="mb-1" style="line-height:1.75">

                    <!-- User details will be appended here -->
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="hr-wrapper">
        <hr>
        <h2 class="modal-title text-center"><strong>OR</strong></h2>
        <hr>
    </div>
            <h2 class="modal-title text-center mt-1" id="enquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.consumer_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="postid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="message" rows="3" name="message" placeholder="Enter message"></textarea>
                        @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const starRatingContainers = document.querySelectorAll('#star1');
      var inputhidden = document.getElementById("rating");

        starRatingContainers.forEach(container => {
            const stars = container.querySelectorAll('span');
            //const hiddenInput = container.nextElementSibling; // Use nextElementSibling

            stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            inputhidden.value=rating;
            //hiddenInput.value = rating; // Update the hidden input field
            console.log('Rating: ' + rating); // Add this line

            // Highlight stars from the first star to the clicked star
            stars.forEach(s => {
                const sRating = s.getAttribute('data-rating');
                s.classList.remove('highlight');
                if (sRating <= rating) {
                    s.classList.add('highlight');
                }
            });
        });
    });
        });
    });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <script>
    $(document).ready(function() {
        // Event delegation for .connect-listing elements
        $(document).on('click', '.consumer-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#postid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_consumer_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#name').val(post.name);
                        $('#email').val(post.email);
                        $('#mobile').val(post.mobile);
                        $('#message').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#user-details').html(userDetails);
                    } else {
                        //alert(response.message); // Alert if status is not success
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.'); // Alert on AJAX error
                }
            });
        });
    });
</script>
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

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ Session::get('info') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(Session::has('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ Session::get('warning') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    });
</script>
    <!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>-->
    <!--<script>-->
         <!--Get latitude and longitude from the Blade file-->
    <!--    var lat = {{ $consumerposts->latitude }};-->
    <!--    var lng = {{ $consumerposts->longitude }};-->

         <!--Initialize the map and set its view to the given coordinates-->
    <!--    var map = L.map('map').setView([lat, lng], 13);-->

         <!--Load and display tile layer on the map-->
    <!--    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {-->
    <!--        attribution: '© OpenStreetMap contributors'-->
    <!--    }).addTo(map);-->

        <!--Add a marker to the map at the given coordinates-->
    <!--    L.marker([lat, lng]).addTo(map)-->
    <!--        .bindPopup('Your Location')-->
    <!--        .openPopup();-->
    <!--</script>-->
