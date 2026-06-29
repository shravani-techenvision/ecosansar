@include('frontend.include.header')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
         .row{
        margin-right: 0px;
        margin-left: 0px;
    }
     .tooltip-inner {
        background-color: #000; /* Light beige */
        color: #fff; /* Black text */
        border: 1px solid #000; /* Optional: Add a border */
        max-width: 200px; /* Increase width */
        width: 200px; /* Set fixed width if desired */
        padding-left: 5px; /* Reduce padding for height */
        font-size: 14px; /* Adjust font size if necessary */
        line-height: 1; /* Control text line spacing */
        margin-left:200px;
    }
    .tooltip-arrow {
        border-top-color: #f5f5dc !important; /* Match arrow color with the background */
    }
    @media screen and (max-width: 786px) {
    .tooltip-inner {
        background-color: #000; /* Light beige */
        color: #fff; /* Black text */
        border: 1px solid #000; /* Optional: Add a border */
        max-width: 200px; /* Increase width */
        width: 200px; /* Set fixed width if desired */
        padding-left: 3px; /* Reduce padding for height */
        font-size: 14px; /* Adjust font size if necessary */
        line-height: 1.2; /* Control text line spacing */
        margin-left:130px !important;
    }
}
    
        #map11 {
            height: 400px;
            width: 100%;
        }
    </style>
    
</head>
 	<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center" 
	style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Create a Post</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item">Post</li>
							<li class="breadcrumb-item active" aria-current="page">Create a Post</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
 
	<div class="page-wrapper">
        <div class="content content-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9" style="width: 100%;">
                        <div class="service-inform-fieldset">
                            <fieldset id="first-field">
                                <form id="locationForm" action="{{ route('reusable_post_save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <input type="hidden" name="action" id="action" value="post"> 
                                    <div class="d-flex justify-content-center align-items-center vh-90">
                                        <!--<div class="card p-4 shadow" style=" width: 90%;">-->
                                        <!--    <div class="card-body">-->
                                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                                    <div class="accordion-item mb-3">
                                                        <div id="accordion-collapseOne"
                                                            class="accordion-collapse collapse show"
                                                            aria-labelledby="accordion-headingOne">
                                                            <div class="accordion-body p-0 mt-3 pb-1">
                                                                <div class="row g-4">
                                                                    <!--<div class="col-md-6">-->
                                                                    <!--    <label class="form-label">Do you want to <span-->
                                                                    <!--            class="text-danger">*</span></label>-->
                                                                    <!--    <div class="d-flex flex-wrap gap-3">-->
                                                                    <!--        <div class="form-check">-->
                                                                    <!--            <input type="radio" -->
                                                                    <!--                class="form-check-input"-->
                                                                    <!--                id="sale_giveaway" name="sale_giveaway" value="Sell" {{ old('sale_giveaway') == 'Sell' ? 'checked' : '' }}>-->
                                                                    <!--            <label-->
                                                                    <!--                class="form-check-label">Sell</label>-->
                                                                    <!--        </div>-->
                                                                    <!--        <div class="form-check">-->
                                                                    <!--            <input type="radio"-->
                                                                    <!--                class="form-check-input"-->
                                                                    <!--                id="sale_giveaway" name="sale_giveaway" value="Giveaway" {{ old('sale_giveaway') == 'Giveaway' ? 'checked' : '' }}>-->
                                                                    <!--            <label-->
                                                                    <!--                class="form-check-label">Giveaway</label>-->
                                                                    <!--        </div>-->
                                                                    <!--        <div class="form-check">-->
                                                                    <!--            <input type="radio"-->
                                                                    <!--                class="form-check-input"-->
                                                                    <!--                id="sale_giveaway" name="sale_giveaway" value="Buy" {{ old('sale_giveaway') == 'Buy' ? 'checked' : '' }}>-->
                                                                    <!--            <label-->
                                                                    <!--                class="form-check-label">Buy</label>-->
                                                                    <!--        </div>-->
                                                                    <!--        <div class="form-check">-->
                                                                    <!--            <input type="radio"-->
                                                                    <!--                class="form-check-input"-->
                                                                    <!--                id="sale_giveaway" name="sale_giveaway" value="Request for free" {{ old('sale_giveaway') == 'Request for free' ? 'checked' : '' }}>-->
                                                                    <!--            <label class="form-check-label">Request-->
                                                                    <!--                for free</label>-->
                                                                    <!--        </div>-->
                                                                    <!--        	@if ($errors->has('sale_giveaway'))-->
                                                                    <!--                <span class="text-danger">{{ $errors->first('sale_giveaway') }}</span>-->
                                                                    <!--            @endif-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->

                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Type of Resource (you
                                                                            can add another one after this) </label>
                                                                        <select class="form-select" name="resource_type" id="resource_type"  >
                                                                            <option value="">Select</option>
                                                                            @foreach($resources as $res)
                                                                                <option value="{{ $res->id }}" {{ old('resource_type') == $res->id ? 'selected' : '' }}
                                                                                >{{ $res->reusable_resource_name }} </option>
                                                                             @endforeach
                                                                        </select>
                                                                        @if ($errors->has('resource_type'))
                                                                             <span class="text-danger">{{ $errors->first('resource_type') }}</span>
                                                                         @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Upload
                                                                            Image</label>
                                                                        <div
                                                                            class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column mb-2">

                                                                            <span class="upload-img d-block mb-2"><img
                                                                                    src="{{ asset('frontend/assets/img/icons/upload-icon.svg') }}"
                                                                                    alt="Img"
                                                                                    width="30px"></span>
                                                                            <p class="mb-0"
                                                                                style="font-size: 12px;">Drag & Drop or
                                                                                <span class="text-primary">
                                                                                    Browse</span>
                                                                            </p>
                                                                            <input type="file" name="resource_img" id="resource_img" accept="image">
                                                                           
                                                                        </div>
                                                                         @if ($errors->has('resource_img'))
                                                                                <span class="text-danger">{{ $errors->first('resource_img') }}</span>
                                                                            @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Upload Image</label>
                                                                          Image Preview 
                                                                        <div id="imagePreview" class="mt-2" style="display:none;">
                                                                            <img id="previewImg" src="#" alt="Image Preview" style="max-width: 100%; height: 150px;" />
                                                                        </div>
                                                                        <br>
                                                                        <div class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column mb-2">
                                                                            <span class="upload-img d-block mb-2">
                                                                                <img src="{{ asset('frontend/assets/img/icons/upload-icon.svg') }}" alt="Upload Icon" width="30px">
                                                                            </span>
                                                                            <p class="mb-0" style="font-size: 12px;">
                                                                                Drag & Drop or <span class="text-primary">Browse</span>
                                                                            </p>
                                                                            <input type="file" name="resource_img" id="resource_img" accept="image/*" onchange="previewImage(event)">
                                                                        </div>
                                                                    
                                                                       
                                                                    
                                                                        @if ($errors->has('resource_img'))
                                                                            <span class="text-danger">{{ $errors->first('resource_img') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Quantity <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="form-select" name="quantity" id="quantity"  >
                                                                            <option value="">Select</option>
                                                                            @foreach($weights as $wat)
                                                                                <option value="{{ $wat->id }}" {{ old('quantity') == $wat->id ? 'selected' : '' }}
                                                                                >{{ $wat->min_weight }} {{ $wat->min_measure }} {{ 'to' }} {{ $wat->max_weight }} {{ $wat->max_measure }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @if ($errors->has('quantity'))
                                                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Description</label>
                                                                        <textarea id="textarea" class="form-control" name="description" id="description"  rows="3" placeholder="Description">{{ old('description') }}</textarea>
                                                                        @if ($errors->has('description'))
                                                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Suggested
                                                                            Price</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder=" Enter Suggested Price" name="resource_price" id="resource_price">
                                                                    </div>
                                                                    
                                                                </div>
                                                            <!--     <div class="row mt-2 g-4">-->
                                                            <!--        <div class="col-md-4">-->
                                                            <!--            <label class="form-label">Enter your address-->
                                                            <!--                <span class="text-danger">*</span></label>-->
                                                            <!--            <input required type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">-->
                                                            <!--        </div>-->
                                                            <!--        <div class="col-md-2 ">-->
                                                            <!--              <label class="form-label d-none d-block">&nbsp;-->
                                                            <!--                 </label>-->
                                                            <!--        <button type="button" class="btn btn-linear-primary" onclick="geocodeAddress()" >Show on Map</button><br><br>-->
                                                            <!-- </div> </div>-->
                                                            <!-- <div class="row">-->
                                                            <!--        <div class="col-md-12">-->
                                                            <!--            <div class="form-group">-->
                                                            <!--        <div id="map11"></div> <br><br>-->
                                                            
                                                            <!--        <input type="hidden" id="latitude" name="latitude">-->
                                                            <!--        <input type="hidden" id="longitude" name="longitude">-->
                                                            <!--</div></div></div>-->
                                                                  <div class="row mt-2 g-4">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Enter your address
                                                                            <span class="text-danger">*</span></label>
                                                                        <input required type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                                                    </div>
                                                                    <div class="col-md-2 ">
                                                                          <label class="form-label d-none d-md-block">&nbsp;
                                                                             </label>
                                                                    <button type="button" class="btn btn-linear-primary" onclick="geocodeAddress()" >Show on Map</button><br><br>
                                                             </div> </div>
                                                             <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                    <div id="map11"></div> <br><br>
                                                            
                                                                    <input type="hidden" id="latitude" name="latitude">
                                                                    <input type="hidden" id="longitude" name="longitude">
                                                            </div></div></div>

                                                                <!-- Centering Buttons -->
                                                                <div class="row   d-flex justify-content-center text-center">
                                                                    <div class="col-md-3 mb-2">
                                                                        <button type="submit"
                                                                            class="btn btn-linear-primary btn-lg w-100" onclick="document.getElementById('action').value='post_another'">Add
                                                                            Another Listing  </button>
                                                                    </div>
                                                                    <div class="col-md-3 mb-2">
                                                                        <button type="submit"
                                                                            class="btn btn-linear-primary btn-lg w-100">Post</button>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                       <a href="{{url('/')}}" class="btn btn-linear-primary btn-lg w-100">  
                                                                            Homepage </a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   @include('frontend.include.footer')
   
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0&libraries=places"></script>

    <script src="https://ecosansar.com/frontend/assets/js/richmarker-compiled.js"></script>
    
   <script>
    let map11;
    let marker;
     let autocomplete;

    function initMap(lat = 28.6139, lng = 77.2090) { // Coordinates for New Delhi, India
        map11 = new google.maps.Map(document.getElementById('map11'), {
            center: { lat: lat, lng: lng },
            zoom: 14
        });

        marker = new google.maps.Marker({
            map: map11,
            draggable: true,
            position: { lat: lat, lng: lng }
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            document.getElementById('latitude').value = marker.getPosition().lat();
            document.getElementById('longitude').value = marker.getPosition().lng();
        });
         // Initialize Autocomplete
                autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        map11.setCenter(place.geometry.location);
                        marker.setPosition(place.geometry.location);
                        document.getElementById('latitude').value = place.geometry.location.lat();
                        document.getElementById('longitude').value = place.geometry.location.lng();
                    }
                });
    }

    function geocodeAddress() {
        const address = document.getElementById('address').value;
        
       // alert(address);
        
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === 'OK') {
                map11.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                document.getElementById('latitude').value = results[0].geometry.location.lat();
                document.getElementById('longitude').value = results[0].geometry.location.lng();
                
                // Check if latitude and longitude are successfully retrieved
                if (!latitude || !longitude) {
                    alert('Failed to get the latitude and longitude. Please try again.');
                }
                
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    
    

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
    
    
    // Check latitude and longitude on form submit
    document.getElementById('locationForm').addEventListener('submit', function(event) {
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (!latitude || !longitude) {
            event.preventDefault(); // Stop form from submitting
            alert('Please make sure the location is correctly set on the map. Click on Show on Map button');
        }
    });
    
</script>
  <script>
      function validateFileSize(input) {
    const maxSize = 2 * 1024 * 1024; // 2 MB in bytes
    const files = input.files;
    
    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
            alert(`The file ${files[i].name} exceeds the maximum size of 2 MB.`);
            input.value = ''; // Clear the input if the file is too large
            return false;
        }
    }
    
    return true;
}
  </script>
   
<script>
$(document).ready(function () {
    const isTouchDevice = window.matchMedia("(hover: none)").matches;

    if (isTouchDevice) {
        // For touch devices, manage tooltip manually
        $('[data-toggle="tooltip"]').on('click', function (e) {
            e.preventDefault(); // Prevent default scrolling or focus
            e.stopPropagation(); // Stop event propagation

            const $this = $(this);

            if ($this.attr('aria-describedby')) {
                $this.tooltip('hide'); // Hide tooltip if visible
            } else {
                $('[data-toggle="tooltip"]').not($this).tooltip('hide'); // Hide other tooltips
                $this.tooltip('show'); // Show current tooltip
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('[data-toggle="tooltip"]').length) {
                $('[data-toggle="tooltip"]').tooltip('hide'); // Hide tooltips when clicking outside
            }
        });
    } else {
        // For non-touch devices, trigger on hover
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover',
            placement: 'top',
        });
    }
});


</script>
 
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImg');
    const container = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
