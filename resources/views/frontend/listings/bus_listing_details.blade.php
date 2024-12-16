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
<div id="page-content">
    <div class="container">
        <ol class="breadcrumb">
            {{--  <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Contact</li>  --}}
        </ol>
        <section class="page-title pull-left">
            <a href="{{route('listings')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Browse Listings</a>

                  </section>
        <section class="page-title pull-right">


        </section>
        <!--end page-title-->
        <!--<a href="#write-a-review" class="btn btn-primary btn-framed btn-rounded btn-light-frame icon scroll pull-right"><i class="fa fa-star"></i>Write a review</a>-->
    </div>
    <!--end container-->
    <section>
        <div class="gallery detail">
            <div class="owl-carousel" data-owl-items="3" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="0" data-owl-margin="2" data-owl-nav-container="#gallery-nav">
                @foreach($buspostsres as $consumerpost)
                <div class="image">
                    <div class=" bg-transfer">
                        @php
                            // Check if $listing->resource_img is set and not empty
                            $imagePath = !empty($listing->resource_img) ? 'Businessposts/' . $listing->resource_img : null;

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
                    <strong><h2>About this listing</h2></strong>
                    <dl>
                        <dt>Resources: </dt>
                        <dd>
    {{ implode(', ', $busresources) }}
</dd>

                        <dt>Sale/Giveaway: </dt>
                        <dd>{{ $busposts->sale_giveaway }}</dd>
                        <dt>Quantity: </dt>
                        <dd>{{ $busposts->min_weight }} {{ $busposts->min_measure }} {{ 'to' }} {{ $busposts->max_weight }} {{ $busposts->max_measure }}</dd>
                        <dt>Clean/Unclean: </dt>
                        <dd>{{ $busposts->clean_unclean }}</dd>
                        <dt>Packaged:</dt>
                        <dd>{{ $busposts->packaged }}</dd>
                        <dt>Pincode: </dt>
                        <dd>  {{ $busposts->pincode }}</dd>
                        <dt>Address: </dt>
                        <dd>  {{ $busposts->address }}</dd>
                    </dl>
                    <br>
                    <!-- Update your WhatsApp link generation -->
                     @if (session()->has('user_id'))
                        <a href="https://wa.me/?text={{ urlencode('This post from The ZeroWaste Community Tool might interest you, check it out : ' . url('bus_listing_details/'.$busposts->id)) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                           <i class="fa fa-whatsapp"></i> Share on WhatsApp
                        </a>
                    @else
                        <a href="{{ route('consumer_login', ['redirect_wp' => url('bus_listing_details/' . $busposts->id)]) }}" target="_blank" class="btn btn-success btn-small btn-rounded icon shadow" style="margin-bottom:10px;">
                            <i class="fa fa-share"></i> Share on WhatsApp
                        </a>
                    @endif
                     <div class="row">
                    <div class="d-flex">
                    <!--<span> <strong> Posted By:</strong></span><a style="float:inline-end;" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " href="{{ url('buspostprofile'). "/".$id }}" > <strong> Add review</strong></a>-->
                      </div>
                      </div>
                      <div class="custom-card">
                    <div class="card-body">
                        <div class="mb-3">
                       <span style="float:inline-start;font-size:18px;"> <strong> Posted By:</strong></span> <br><br>
                       <a href="#" data-id="{{ $busposts->busid }}" data-toggle="modal" data-target="#businessenquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow bus-connect-listing" style="float:right;">
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


            <!--end col-md-5-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>
<div class="modal fade" id="businessenquiryModal" tabindex="-1" role="dialog" aria-labelledby="busenquiryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="modal-title text-center" id="busenquiryModalLabel"><strong>Contact Details</strong></h2>
                 <div id="bus-user-details" class="mb-1" style="line-height:1.75">

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
            <h2 class="modal-title text-center mt-1" id="busenquiryModalLabel"><strong>Send Enquiry</strong></h2>
            <div class="modal-body">

               <form class="form form-email inputs-underline"  action="{{ route('enquiry.business_save') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="buspostid" value="">
                    <input type="hidden" name="loginid" value="{{ $user_id }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="name" id="busname" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="email" class="form-control" name="email" id="busemail" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control" name="mobile" id="busmobile" placeholder="Enter mobile">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <textarea class="form-control" id="busmessage" rows="3" name="message" placeholder="Enter message"></textarea>
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


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function initMap() {
            // Replace these with the latitude and longitude you want to display
            const latitude = {{ $busposts->latitude }};
            const longitude = {{ $busposts->longitude }};

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
        $(document).on('click', '.bus-connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id'); // Get data-id attribute value
            $('#buspostid').val(dataId); // Assuming you're setting some value to #postid element

            // AJAX request to fetch post details
            $.ajax({
                url: "{{ url('/get_business_post_details') }}",
                method: 'GET',
                data: { dataId: dataId },
                success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;

                         // Update modal content with post details
                        $('#busname').val(post.name);
                        $('#busemail').val(post.email);
                        $('#busmobile').val(post.mobile);
                        $('#busmessage').val(post.message);

                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span> ' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#bus-user-details').html(userDetails);
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
