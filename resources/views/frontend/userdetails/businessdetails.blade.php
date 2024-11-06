@include('frontend.include.header')
@include('sweetalert::alert')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
         .row{
        margin-right: 0px;
        margin-left: 0px;
    }
    </style>

    <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />-->


    <style>
        #map11 {
            height: 400px;
            width: 100%;
        }
    </style>

</head>
    <div id="page-content">
        <div class="container">

            <div class="row" >
                <div class=" ">
                    <section class="page-title">
                        <h1>Corporate Details</h1>
                    </section
                    <!--end page-title-->
                    <section id="business">
                        <form id="locationForm" class="form inputs-underline" action="{{ route('business_post_save') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <div class="row">
                            <!-- <div class="col-md-6">-->
                            <!--<div class="form-group">-->
                            <!--  <label for="address">-->
                            <!--    Address<span class="text-danger">*</span>-->
                            <!--  </label>-->
                            <!--  <textarea -->
                            <!--    class="form-control" -->
                            <!--    rows="4" -->
                            <!--    cols="50" -->
                            <!--    name="address" -->
                            <!--    id="address" -->
                            <!--    placeholder="Address">{{ old('address', $users->address ?? '') }}</textarea>-->
                            <!--  @if ($errors->has('address'))-->
                            <!--    <span class="text-danger">{{ $errors->first('address') }}</span>-->
                            <!--  @endif-->
                            <!--</div>-->
                            <!--</div>-->

                      </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Pincode<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode"  onkeypress="return isNumeric(event)" minlength="6" maxlength="6" value={{ old('pincode') }}>
                                    @if ($errors->has('pincode'))
                                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-check-inline">
					<label>

						<input   type="radio" id="sale_giveaway" name="sale_giveaway" value="Giveaway" {{ old('sale_giveaway') == 'Giveaway' ? 'checked' : '' }}><span class="label-text">Giveaway</span>
					</label>
				</div>
				<div class="form-check-inline">
					<label>

						 <input  type="radio" id="sale_giveaway" name="sale_giveaway" value="Sale" {{ old('sale_giveaway') == 'Sale' ? 'checked' : '' }}><span class="label-text">For Sell</span>
					</label>
				</div>
				<div class="form-check-inline">
					<label>
						 <input   type="radio" id="sale_giveaway" name="sale_giveaway" value="Buy" {{ old('sale_giveaway') == 'Buy' ? 'checked' : '' }}><span class="label-text">For Buy</span>
					</label>
				</div>
					@if ($errors->has('sale_giveaway'))
                                <span class="text-danger">{{ $errors->first('sale_giveaway') }}</span>
                            @endif
                                <!--<div class="form-group">-->
                                <!--    <label for="address">For Sale/Giveaway<span style="color:red;">*</span></label><br><br>-->
                                <!--<input class="form-control" type="radio" id="sale_giveaway" name="sale_giveaway" value="Sale" {{ old('sale_giveaway') == 'Sale' ? 'checked' : '' }}>-->
                                <!--<label for="age1">For Sell</label>&emsp;-->
                                <!-- <input class="form-control" type="radio" id="sale_giveaway" name="sale_giveaway" value="Buy" {{ old('sale_giveaway') == 'Buy' ? 'checked' : '' }}>-->
                                <!--<label for="age1">For Buy</label>&emsp;-->
                                <!--<input class="form-control" type="radio" id="sale_giveaway" name="sale_giveaway" value="Giveaway" {{ old('sale_giveaway') == 'Giveaway' ? 'checked' : '' }}>-->
                                <!--<label for="age2">For Giveaway</label><br>-->
                                <!--@if ($errors->has('sale_giveaway'))-->
                                <!--      <span class="text-danger">{{ $errors->first('sale_giveaway') }}</span>-->
                                <!--@endif-->
                                <!--    </div>-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <label  >Quantity - Weight / Number of pieces<span style="color:red;">*</span></label>
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
                                </div>
                            <!--</div>-->
                            <!--<div class="row">-->
                                <div class="col-md-6">
                                    <div class="col-md-6"><br>
                                    <label for="address">Condition  <span style="color:red;">*</span></label>
                                    <div class="form-check">
					<label>

						 <input class="form-control" type="radio" id="clean_unclean" name="clean_unclean" value="Clean" {{ old('clean_unclean') == 'Clean' ? 'checked' : '' }}><span class="label-text">Clean</span>
					</label>
				</div>
				<div class="form-check">
					<label>

						 <input class="form-control" type="radio" id="clean_unclean" name="clean_unclean" value="Unclean" {{ old('clean_unclean') == 'Unclean' ? 'checked' : '' }}><span class="label-text">Unclean</span>
					</label>
				</div>
				 @if ($errors->has('clean_unclean'))
                                    <span class="text-danger">{{ $errors->first('clean_unclean') }}</span>
                                @endif
                                    <!--<div class="form-group">-->
                                    <!--    <label for="address">Condition  <span style="color:red;">*</span></label><br><br>-->
                                    <!--<input class="form-control" type="radio" id="clean_unclean" name="clean_unclean" value="Clean" {{ old('clean_unclean') == 'Clean' ? 'checked' : '' }}>-->
                                    <!--<label for="age1">Clean</label>&emsp;-->
                                    <!--<input class="form-control" type="radio" id="clean_unclean" name="clean_unclean" value="Unclean" {{ old('clean_unclean') == 'Unclean' ? 'checked' : '' }}>-->
                                    <!--<label for="age2">Unclean</label><br>-->
                                    <!--@if ($errors->has('clean_unclean'))-->
                                    <!--                        <span class="text-danger">{{ $errors->first('clean_unclean') }}</span>-->
                                    <!--                @endif-->
                                    <!--    </div>-->
                                </div>
                                <div class="col-md-6"><br>
                                     <label for="address">Packaged<span style="color:red;">*</span></label>
                                    <div class="form-check">

					<label>
						 <input class="form-control" type="radio" id="packaged" name="packaged" value="Yes" {{ old('packaged') == 'Yes' ? 'checked' : '' }}><span class="label-text">Yes</span>
					</label>
				</div>
				<div class="form-check">
					<label>

						 <input class="form-control" type="radio" id="packaged" name="packaged" value="No" {{ old('packaged') == 'No' ? 'checked' : '' }}><span class="label-text">No</span>
					</label>
				</div>
				@if ($errors->has('packaged'))
                                    <span class="text-danger">{{ $errors->first('packaged') }}</span>
                                @endif
                            <!--        <div class="form-group">-->
                            <!--            <label for="address">Packaged<span style="color:red;">*</span></label><br><br>-->
                            <!--        <input class="form-control" type="radio" id="packaged" name="packaged" value="Yes" {{ old('packaged') == 'Yes' ? 'checked' : '' }}>-->
                            <!--        <label for="age1">Yes</label>&emsp;-->
                            <!--        <input class="form-control" type="radio" id="packaged" name="packaged" value="No" {{ old('packaged') == 'No' ? 'checked' : '' }}>-->
                            <!--        <label for="age2">No</label><br>-->
                            <!--        @if ($errors->has('packaged'))-->
                            <!--        <span class="text-danger">{{ $errors->first('packaged') }}</span>-->
                            <!--@endif-->
                            <!--            </div>-->
                                </div>
                            </div>
                            <!--enr row-->
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Free flow text</label>
                                    <textarea id="textarea" class="form-control" name="description" id="description"  rows="3" placeholder="Description"></textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                                </div>
                            </div>
                                <!--<div class="col-md-6">-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="address">Image<span style="color:red;">*</span></label><br><br>-->
                                <!--        <input type="file" class="form-control" name="post_pic" id="post_pic" placeholder="Pincode"  >-->
                                <!--        @if ($errors->has('post_pic'))-->
                                <!--                    <span class="text-danger">{{ $errors->first('post_pic') }}</span>-->
                                <!--                @endif-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <label for="address">Type of Resource<span style="color:red;">*</span></label><br><br>
                                        <select class="form-select js-example" name="resource_type[]" id="resource_type" multiple="multiple" aria-label="Default select example">
                                            <option value="">Select resource</option>
                                            <!-- Assuming $resources is an array of resources -->
                                            @foreach($resources as $res)
                                            <option value="{{ $res->id }}" {{ (collect(old('resource_type'))->contains($res->id)) ? 'selected' : '' }}>{{ $res->resource_name }}</option>
                                            @endforeach
                                        </select>
                                        	@if ($errors->has('resource_type'))
                                    <span class="text-danger">{{ $errors->first('resource_type') }}</span>
                                @endif
                                    </div>
                                    {{--  <label for="address"><span>(*max upload size 10 mb)</span></label><br>  --}}
                                </div>
                            </div>

                            <!--<div class="row">-->
                            <!--    <div id="dynamic-inputs">-->
                            <!--    @foreach(old('resource_type', []) as $index => $resourceId)-->
                            <!--        <div class="col-md-6">-->
                            <!--            <div class="form-group">-->
                            <!--                <label for="resource_{{ $resourceId }}">Upload Image for {{ $resources->find($resourceId)->resource_name }}<span class="image-upload-asterisk" style="color:red;">*</span></label><br><br>-->
                            <!--                <input type="file" class="form-control" name="resource_img[]" id="resource_{{ $resourceId }}">-->
                            <!--                @if ($errors->has('resource_img'))-->
                            <!--                                    <span class="text-danger">{{ $errors->first('resource_img') }}</span>-->
                            <!--                                @endif-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    @endforeach-->
                            <!--</div>-->
                            <!--</div>-->

                            <div class="row">
                                <div id="dynamic-inputs">
                                    @foreach(old('resource_type', []) as $index => $resourceId)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="resource_{{ $resourceId }}">
                                                Upload Image for {{ $resources->find($resourceId)->resource_name }}
                                                <span class="image-upload-asterisk" style="color:red;">* </span><span></span>
                                            </label><br><br>
                                            <input type="file" class="form-control" name="resource_img[]" id="resource_{{ $resourceId }}">

                                            @if ($errors->has('resource_img'))
                                            <div class="text-danger">
                                                {{-- Display general 'resource_img' errors if any --}}
                                                @foreach ($errors->get('resource_img') as $error)
                                                    <p style="color:red;">{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Track if we've displayed the specific size or format error to avoid duplicates --}}
                                        @php
                                            $sizeErrorDisplayed = false;
                                            $formatErrorDisplayed = false;
                                        @endphp

                                        {{-- Loop through each file-specific error --}}
                                        @foreach ($errors->get('resource_img.*') as $fileErrors)
                                            @foreach ($fileErrors as $msg)
                                                {{-- Display the size error message only once --}}
                                                @if (str_contains($msg, 'must not be greater than') && !$sizeErrorDisplayed)
                                                    <div class="text-danger">
                                                        <p style="color:red;">The image must not be greater than 10 MB.</p>
                                                    </div>
                                                    @php
                                                        $sizeErrorDisplayed = true;
                                                    @endphp
                                                @endif

                                                {{-- Display the format error message only once --}}
                                                @if (str_contains($msg, 'must be a file of type') && !$formatErrorDisplayed)
                                                    <div class="text-danger">
                                                        <p style="color:red;">The image must be a valid format (jpg, jpeg, png).</p>
                                                    </div>
                                                    @php
                                                        $formatErrorDisplayed = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach

                                        </div>

                                    </div>

                                    @endforeach

                                </div>

                            </div>

                            {{--  <label for="address">Select your location</label><br><br>  --}}

                            <!--    <div id="map" style="height: 400px;"></div>-->
                            <!--<input type="hidden" id="lat" name="latitude">-->
                            <!--<input type="hidden" id="lng" name="longitude"><br>-->

                             <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                             <label for="address">Enter Address/Nearest Landmark<span style="color:red;">* </span>:</label>
                            <input type="text" id="address" name="address" required value="{{ old('address') }}">
                             </div></div></div>
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                            <button type="button" onclick="geocodeAddress()">Show on Map</button><br><br>
                     </div></div></div>
                     <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                            <div id="map11"></div> <br><br>

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
  </div></div></div>
                            <!--end form-group-->

                                <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Post</button>
                                <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                                </div>
                            <!--end form-group-->
                        </form>

                        {{--  <hr>

                        <p class="center">By clicking on “Register Now” button you are accepting the <a href="terms-conditions.html">Terms & Conditions</a></p>  --}}
                    </section>

                </div>
                <!--col-md-4-->
            </div>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

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

   <!--start map -->






   <!--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>-->
   <!-- <script>-->
        <!--var map = L.map('map').setView([51.505, -0.09], 13);-->
   <!--     var map = L.map('map').setView([19.08639137903828, 72.88027561369839], 6);-->
   <!--     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {-->
   <!--         attribution: '© OpenStreetMap contributors'-->
   <!--     }).addTo(map);-->
   <!--     var marker;-->

   <!--     map.on('click', function(e) {-->
   <!--         var lat = e.latlng.lat;-->
   <!--         var lng = e.latlng.lng;-->

   <!--         if (marker) {-->
   <!--             map.removeLayer(marker);-->
   <!--         }-->
   <!--         marker = L.marker([lat, lng]).addTo(map);-->

   <!--         document.getElementById('lat').value = lat;-->
   <!--         document.getElementById('lng').value = lng;-->
   <!--     });-->
   <!-- </script>-->

       <!--end map -->



   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script>
    $(document).ready(function() {
        $('.js-example').select2({
            placeholder: "Select Resource"
        });
    });
   </script>
   <script>
    $(document).ready(function() {
        function updateAsterisks() {
            var selectedOption = $('input[name="sale_giveaway"]:checked').val();
            if (selectedOption === 'Buy') {
                $('.image-upload-asterisk').css('display', 'none'); // Hide asterisks for "Upload Image" fields
            } else {
                $('.image-upload-asterisk').css('display', 'inline'); // Show asterisks for "Upload Image" fields
            }
        }

        function createInputField(resourceId, resourceName ) {

            return '<div class="col-md-6">' +
                        '<div class="form-group">' +
                            '<label for="resource_' + resourceId + '">Upload Image for ' + resourceName + '<span class="image-upload-asterisk" style="color:red;">*</span></label><br><br>' +
                            '<input type="file" class="form-control" name="resource_img[]" id="resource_' + resourceId + '">' +

                        '</div>' +
                    '</div>';
        }

        $('#resource_type').change(function() {
            $('#dynamic-inputs').empty(); // Clear existing dynamic inputs


            $(this).find('option:selected').each(function() {
                var resourceId = $(this).val();
                var resourceName = $(this).text();

                var inputField = createInputField(resourceId, resourceName);
                $('#dynamic-inputs').append(inputField);
            });
            updateAsterisks();
        });

        // Listen for change in radio buttons for sale/giveaway
        $('input[name="sale_giveaway"]').change(function() {
            updateAsterisks();
        });

        // Initialize the state on page load
        updateAsterisks();
    });
</script>
<script>
    function isNumeric(event) {
      // Get the key code of the pressed key
      const keyCode = event.which ? event.which : event.keyCode;

      // Check if the key code corresponds to a numeric character or a special key
      if (keyCode >= 48 && keyCode <= 57 ) {
        return true; // Allow input
      } else {
        return false; // Prevent input
      }
    }



</script>
</body>

