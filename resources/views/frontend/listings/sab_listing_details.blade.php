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
    textarea{
        width: 80%;
        border-radius: 20px;
        padding: 10px;
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
        align-items: left; /* Align text vertically */
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
@media (max-width:767px){
.rt-container {
    padding-left:2px;
    padding-right:2px;
}
.ScriptHeader{
    padding-top: 2px;
}
}
.align-right {
    text-align: right;
    margin-left: auto;
    margin-right: 0;
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.align-left {
    text-align: left;
    margin-right: auto;
    margin-left: 0;
    background-color: #e1e1e1;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.align-right span,
.align-left span {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
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

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<div id="page-content">
    <div class="container">
        <ol class="breadcrumb">
            <!--<li><a href="#">Home</a></li>-->
            <!--<li><a href="#">Pages</a></li>-->
            <!--<li class="active">Contact</li>-->
        </ol>
        <section class="page-title pull-left">
            <a href="{{route('listings')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>

        </section>
        <section class="page-title pull-right">
            <h1>{{ $sabposts->name }}</h1>

        </section>
        <!--end page-title-->
        <!--<a href="#write-a-review" class="btn btn-primary btn-framed btn-rounded btn-light-frame icon scroll pull-right"><i class="fa fa-star"></i>Write a review</a>-->
    </div>
    <!--end container-->
    <section>
        <div class="gallery detail">
            <div class="owl-carousel" data-owl-items="3" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="0" data-owl-margin="2" data-owl-nav-container="#gallery-nav">
                @foreach($sabpostsres as $consumerpost)
                <div class="image">
                    <div class="bg-transfer">
                        <img src="{{ Storage::disk('s3')->url('SABposts/' . $consumerpost->resource_img) }}" alt="abc">

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
                   <strong> <h2>About this listing</h2></strong>
                    <dl>
                         <dt>Resources: </dt>
                       <dd>
    {{ implode(', ', $sabresources) }}
</dd>
                        <dt>Sale/Giveaway: </dt>
                        <dd>{{ $sabposts->sale_giveaway }}</dd>
                        <dt>Quantity: </dt>
                        <dd>{{ $sabposts->min_weight }} {{ $sabposts->min_measure }} {{ 'to' }} {{ $sabposts->max_weight }} {{ $sabposts->max_measure }}</dd>
                        <dt>Clean/Unclean: </dt>
                        <dd>{{ $sabposts->clean_unclean }}</dd>
                        <dt>Packaged: </dt>
                        <dd>{{ $sabposts->packaged }}</dd>
                        <dt>Pincode: </dt>
                        <dd>  {{ $sabposts->pincode }}</dd>
                        <dt>Address: </dt>
                        <dd>  {{ $sabposts->address }}</dd><br>

                    </dl>
                    <br>
                    @if (session()->has('user_id'))
                    <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('sabs_listing_details/'.$sabposts->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                    </a>
                @else
                    <a href="{{ route('consumer_login', ['redirect_wp' => url('sabs_listing_details/' . $sabposts->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                    </a>
                @endif
                     <div class="custom-card">
                    <div class="card-body">
                        <div class="mb-3">
                     <span style="float:inline-start;font-size:18px;"> <strong> Posted By:</strong></span> <br><br>
                    <a href="#" data-id="{{ $sabposts->sabid }}" data-toggle="modal" data-target="#sabenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow sab-connect-listing" style="float:right;">

        <span>Connect</span>
    </a>
                      <strong>Name:</strong>  {{ $users->name }} <br>
                      <strong>Email:</strong>  {{ $users->email }} <br>
                      <strong>Mobile:</strong>  {{ $users->mobile }} <br>
                       </div>
                       </div>
                       </div>



                </section>

            </div>
            <!--end col-md-7-->
             <div class="col-md-5 col-sm-5">
                 <strong><h2>Location</h2> </strong>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>
            @if($sabenquiries->isEmpty())
            <!--<div class="col-md-5 col-sm-5">-->
            <!--    <div class="detail-sidebar">-->
            <!--        <section class="shadow">-->
            <!--            <h2>Submit your enquiry </h2>-->
            <!--            <div class="content">-->
            <!--                <form class="form form-email inputs-underline"  action="{{ route('enquiry.sab_save') }}" method="POST">-->
            <!--                    @csrf-->
            <!--                    <input type="hidden" name="id" value="{{ $id }}">-->
            <!--                    <input type="hidden" name="loginid" value="{{ $user_id }}">-->
            <!--                    <input type="hidden" name="name" value="{{ $loginuser->name }}">-->
            <!--                    <input type="hidden" name="email" value="{{ $loginuser->email }}">-->
            <!--                    <input type="hidden" name="mobile" value="{{ $loginuser->mobile }}">-->
                                <!--<div class="row justify-content-center align-items-center">-->
                                <!--    <div class="col-md-12 col-sm-12">-->
                                <!--        <div class="form-group">-->
                                <!--            <label for="name">Name<span style="color:red;">*</span></label>-->
                                <!--            <input type="text" class="form-control" name="name" id="name">-->
                                <!--            @if ($errors->has('name'))-->
                                <!--            <span class="text-danger">{{ $errors->first('name') }}</span>-->
                                <!--        @endif-->
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
                                <!--            <span class="text-danger">{{ $errors->first('email') }}</span>-->
                                <!--        @endif-->
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
                                <!--            <span class="text-danger">{{ $errors->first('mobile') }}</span>-->
                                <!--        @endif-->
                                <!--        </div>-->
                                        <!--end form-group-->
                                <!--    </div>-->
                                    <!--end col-md-4-->
                                <!--</div>-->
                                <!--end row-->
            <!--                    <div class="form-group">-->
            <!--                        <label for="message">Message<span style="color:red;">*</span></label>-->
            <!--                        <textarea class="form-control" id="message" rows="4" name="message"></textarea>-->
            <!--                        @if ($errors->has('message'))-->
            <!--                        <span class="text-danger">{{ $errors->first('message') }}</span>-->
            <!--                    @endif-->
            <!--                    </div>-->
                                <!--end form-group-->
            <!--                    <div class="form-group">-->
            <!--                        <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Send Message</button>-->
            <!--                    </div>-->
                                <!--end form-group-->
            <!--                </form>-->
            <!--            </div>-->
            <!--        </section>-->

            <!--    </div>-->
                <!--end detail-sidebar-->
            <!--</div>-->
            <!--end col-md-5-->
            @else
            <!--<div class="col-md-5 col-sm-5">-->
            <!--    <div class="detail-sidebar">-->
            <!--        <section class="shadow">-->

            <!--            <h2>Enquiries</h2>-->
            <!--            <div class="content">-->
            <!--                @foreach($sabenquiries as $review)-->
            <!--                <div class="description review-item" data-id="{{ $review->id }}" style="cursor: pointer;">-->
            <!--                    <figure>-->
            <!--                        <div class="rating-passive" data-rating="{{ $review->rating ?? ' ' }}">-->
            <!--                            <span class="reviewer-name">Name: {{ $review->name }}</span>-->
            <!--                        </div>-->
            <!--                    </figure>-->
            <!--                    <p>Message: {{ $review->message }}</p>-->
            <!--                    <div class="additional-details hidden">-->
            <!--                        <p>Email: {{ $review->email }}</p>-->
            <!--                        <p>Mobile: {{ $review->mobile }}</p>-->

            <!--                        {{--  <div class="align-right">-->
            <!--                            <span>Postadmin</span>-->
            <!--                            <p>{{ $review->post_admin_message }}</p>-->
            <!--                        </div>  --}}-->
                                    <!-- Display chat messages -->
            <!--                        @foreach($sabenquirymsg as $message)-->
            <!--                            @if($message->type == 'admin')-->
            <!--                                <div class="align-left">-->
            <!--                                    <span>Admin</span>-->
            <!--                                    <p>{{ $message->adminmessage }}</p>-->
            <!--                                </div>-->
            <!--                            @else-->
            <!--                                <div class="align-right">-->
            <!--                                    <span>You</span>-->
            <!--                                    <p>{{ $message->usermessage }}</p>-->
            <!--                                </div>-->
            <!--                            @endif-->
            <!--                        @endforeach-->

            <!--                        <div class="row justify-content-center align-items-center">-->
            <!--                            <div class="col-lg-12">-->
            <!--                                <div class="card">-->
            <!--                                    <div class="card-body">-->
            <!--                                        {{--  <h4 class="card-title">Form layouts</h4>  --}}-->
            <!--                                        <div class="row ">-->
            <!--                                            <div class="col-lg-12">-->
            <!--                                                <div class="mt-4">-->
            <!--                        <form action="{{ route('loginsab_send_enquiry') }}" method="POST">-->
            <!--                            @csrf-->
            <!--                            <input type="hidden" name="email" value="{{ $review->email }}">-->
            <!--                            <input type="hidden" name="enquiryid" value="{{ $review->id }}">-->
            <!--                            <input type="hidden" name="login_id"  value="{{ $user_id }}">-->
            <!--                            <input type="hidden" name="user_id" value="{{ $u_id }}">-->
            <!--                            <input type="hidden" name="post_id" value="{{ $id }}">-->
            <!--                            <input type="hidden" name="enquiry_id" value="{{ $enquiry_id }}">-->
            <!--                            <div class="row">-->
            <!--                                <div class="col-md-12">-->
            <!--                                    <div class="form-group">-->
            <!--                                        <label class="form-label" for="formrow-password-input">Enter message</label><br>-->
            <!--                                        <textarea   placeholder="Enter your message" class="message-textarea" rows="3" name="message"></textarea>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->


            <!--                            <div class="row">-->
            <!--                                <div class="col-md-6">-->
            <!--                                    <div class="mb-3">-->
            <!--                             <button class="send-button mt-3 btn btn-primary btn-small btn-rounded icon"  >Send</button>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </form>-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                @endforeach-->
            <!--            </div>-->
            <!--        </section>-->
            <!--    </div>-->
                <!--end detail-sidebar-->
            <!--</div>-->
            <!--end col-md-5-->
            @endif






</div>
<!--end row-->
</div>
<!--end container-->
</div>
 <div class="modal fade" id="sabenquiryModal" tabindex="-1" role="dialog" aria-labelledby="sabenquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="sabenquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="sab-user-details" class="mb-1" style="line-height:1.75">

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
            <h2 class="modal-title text-center mt-1" id="sabenquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.sab_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="sabpostid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="sabname" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="sabemail" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="sabmobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="sabmessage" rows="3" name="message" placeholder="Enter message"></textarea>
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

<!--start map -->
@include('frontend.include.footer')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function initMap() {
            // Replace these with the latitude and longitude you want to display
            const latitude = {{ $sabposts->latitude }};
            const longitude = {{ $sabposts->longitude }};

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
        $(document).on('click', '.sab-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#sabpostid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#sabname').val(post.name);
                        $('#sabemail').val(post.email);
                        $('#sabmobile').val(post.mobile);
                        $('#sabmessage').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#sab-user-details').html(userDetails);
                    } else {
                       // alert(response.message); // Alert if status is not success
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
    <!--    var lat = {{ $sabposts->latitude }};-->
    <!--    var lng = {{ $sabposts->longitude }};-->

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

    <!--end map -->








