 

 
@include('frontend.include.header')
@include('sweetalert::alert')
    <style>
        .hidden {
            display: none;
        }
        .send-button{
            background-color: green !important;
            border-color: green !important;
        }
        textarea{
            width: 80%;
            border-radius: 20px;
            padding: 10px;
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
            <h1>{{ $sabposts->name }}</h1>

        </section>
        <!--end page-title-->
        {{--  <a href="#write-a-review" class="btn btn-primary btn-framed btn-rounded btn-light-frame icon scroll pull-right"><i class="fa fa-star"></i>Write a review</a>  --}}
    </div>
    <!--end container-->
    <section>
        <div class="gallery detail">
            <div class="owl-carousel" data-owl-items="3" data-owl-loop="1" data-owl-auto-width="1" data-owl-nav="1" data-owl-dots="0" data-owl-margin="2" data-owl-nav-container="#gallery-nav">
                @foreach($sabpostsres as $consumerpost)
                <div class="image">
                    <div class="bg-transfer"><img src="{{ asset('frontend/assets/img/SABposts/'.$consumerpost->resource_img) }}" alt=""></div>
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
                        <dt style="margin-bottom: 24px;">Address: </dt>
                        <dd>  {{ $sabposts->address }}</dd>
                    </dl>
                      <br><br><br>
                    
                    <span><strong>Posted On: </strong>{{ \Carbon\Carbon::parse($sabposts->post_date)->format('F j, Y \a\t g:i A') }}</span>
                                        
                     
                </section>
                <!--<section>-->
                <!--    <h2>Reviews</h2>-->
                <!--    <div class="review">-->
                <!--        @foreach($sabreviews as $review)-->
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
            <!--            <h2>Enquiry form</h2>-->
            <!--            <div class="content">-->
            <!--                <form class="form form-email inputs-underline"  action="{{ route('enquiry.sab_save') }}" method="POST">-->
            <!--                    @csrf-->
            <!--                    <input type="hidden" name="id" value="{{ $id }}">-->
            <!--                    <input type="hidden" name="loginid" value="{{ $user_id }}">-->
            <!--                    <div class="row justify-content-center align-items-center">-->
            <!--                        <div class="col-md-12 col-sm-12">-->
            <!--                            <div class="form-group">-->
            <!--                                <label for="name">Name<span style="color:red;">*</span></label>-->
            <!--                                <input type="text" class="form-control" name="name" id="name">-->
            <!--                                @if ($errors->has('name'))-->
            <!--                                <span class="text-danger">{{ $errors->first('name') }}</span>-->
            <!--                            @endif-->
            <!--                            </div>-->
                                        <!--end form-group-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="row">-->
                                    <!--end col-md-4-->
            <!--                        <div class="col-md-12 col-sm-12">-->
            <!--                            <div class="form-group">-->
            <!--                                <label for="email">Email<span style="color:red;">*</span></label>-->
            <!--                                <input type="email" class="form-control" name="email" id="email">-->
            <!--                                @if ($errors->has('email'))-->
            <!--                                <span class="text-danger">{{ $errors->first('email') }}</span>-->
            <!--                            @endif-->
            <!--                            </div>-->
                                        <!--end form-group-->
            <!--                        </div>-->
            <!--                    </div>-->
                                    <!--end col-md-4-->
            <!--                        <div class="row">-->
            <!--                        <div class="col-md-12 col-sm-12">-->
            <!--                            <div class="form-group">-->
            <!--                                <label for="subject">Phone no<span style="color:red;">*</span></label>-->
            <!--                                <input type="text" class="form-control" name="mobile" id="mobile">-->
            <!--                                @if ($errors->has('mobile'))-->
            <!--                                <span class="text-danger">{{ $errors->first('mobile') }}</span>-->
            <!--                            @endif-->
            <!--                            </div>-->
                                        <!--end form-group-->
            <!--                        </div>-->
                                    <!--end col-md-4-->
            <!--                    </div>-->
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
            <!--                        <button type="submit" class="btn btn-primary btn-rounded">Send Message</button>-->
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
            <!--                            <input type="hidden" name="user_id" value="{{ $sabuserid }}">-->
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
            <!--end col-md-5-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>

@include('frontend.include.footer')

<!--start map -->
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0"></script>
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
    
    <!--end map -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reviewItems = document.querySelectorAll('.review-item');
    
            reviewItems.forEach(item => {
                item.addEventListener('click', function () {
                    reviewItems.forEach(i => i.classList.add('hidden'));
                    this.classList.remove('hidden');
    
                    const details = this.querySelector('.additional-details');
                    if (details) {
                        details.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
    
