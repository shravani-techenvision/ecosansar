@include('frontend.include.header')
<head>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style>
.pagination-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 6px 12px;
    height: 32px;
    font-size: 14px;
    font-weight: 500;
    border: none;
    background-color: transparent;
    color: #000;
    vertical-align: middle;
    line-height: 1;
}

.pagination-btn .arrow,
.pagination-btn .text {
    display: inline-block;
    line-height: 1;
    vertical-align: middle;
}

.pagination-btn.active-page {
    background-color: #9ccc65;
    color: #fff;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.pagination-btn:hover:not(:disabled) {
    background-color: #e0e0e0;
    border-radius: 5px;
}

.pagination-btn:disabled {
    color: #000;
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
						<h2 class="breadcrumb-title mb-2">Find Collection Agent</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Find Collection Agent</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
					<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
				</div>
			</div>
		</div>
		<!-- /Breadcrumb -->

	<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="container">
				     <div class="row  ">
                        <div class="col-md-2">
                            <h5>  Type your pincode</h5>
                        </div>
                        <div class="col-md-2">
							<div class="mb-3">
								<div class="form-group">
									<input onkeypress="return isNumeric(event)" minlength="6" maxlength="6" name="pincode" id="pincode" class="form-control" type="text" placeholder="Enter Pincode *" value={{ old('pincode') }}>
									@if ($errors->has('pincode'))
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    @endif
								</div>
							</div>
						</div>

                        <div class="col-md-2">
                            <button class="btn btn-lg btn-linear-primary w-50  " onclick="searchNearby()">Search</button>
                        </div>
                        <div class="col-md-1">
                            <h5>  Search within</h5>
                        </div>
                        <div class="col-md-4">
    <button class="btn btn-lg btn-linear-primary" onclick="applyFilter(2)">2 KM</button>
    <button class="btn btn-lg btn-linear-primary" onclick="applyFilter(5)">5 KM</button>
    <button class="btn btn-lg btn-linear-primary" onclick="applyFilter(10)">10 KM</button>
    <button class="btn btn-lg btn-linear-primary" onclick="applyFilter(20)">20 KM</button>
    <button class="btn btn-lg btn-linear-primary" onclick="applyFilter(40)">40 KM</button>
</div>
                    </div>

					 <!-- Map Div -->
<div id="map" style="height: 500px; width: 100%; margin-top: 20px;z-index: 1;"></div>
                        <hr>
							<div class="row mt-4">
  <!-- Left side: Form Section -->
  <div class="col-md-6 d-flex align-items-center justify-content-center">
    <div class="contact-queries flex-fill">
      <h4>Know a Collection Agent who is not onboarded already? Help him onboard here by walking him through the registration process</h4>
    <h6>You can also share their details, using the whatsapp icon, with us and we will explain how he can benefit</h6>
    </div>
  </div>


            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">


                 <a href="{{url('/')}}"> <button class="btn btn-lg btn-linear-primary w-100 w-md-50 mt-4" type="submit">Homepage<i class="feather-arrow-right-circle ms-2"></i></button></a>
            </div>




</div>
				</div>
			</div>
		</div>

@include('frontend.include.footer')
<!-- Leaflet JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map;
let markers = [];
window.allUsers = [];

function initMap() {
    map = L.map('map').setView([12.9716, 77.5946], 10); // Default to Bangalore
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
}

function clearMarkers() {
    markers.forEach(marker => marker.remove());
    markers = [];
}

function searchNearby() {
    const pincode = $('#pincode').val();
    if (pincode === '') {
        Swal.fire({ icon: 'warning', title: 'Pincode Required. Please enter a pincode.' });
        return;
    }

    $.ajax({
        url: '{{ url("nearby-pincodes") }}/' + pincode,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (!response.data || response.data.length === 0) {
                Swal.fire({ icon: 'info', title: 'No nearby users found.' });
                return;
            }

            window.allUsers = response.data;
            pinUsersOnMap(window.allUsers);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({ icon: 'error', title: 'No user found with entered pincode' });
        }
    });
}

function pinUsersOnMap(users) {
    clearMarkers();

    users.forEach(function(user) {
        const lat = parseFloat(user.latitude);
        const lng = parseFloat(user.longitude);

        const marker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <b>${user.name}</b><br>
                Address: ${user.address}<br>
                Mobile: ${user.mobile}<br>
                Pincode: ${user.pincode}<br>
                Rating: ${user.avg_rating !== null ? user.avg_rating : 0}<br>
                Distance: ${user.distance.toFixed(2)} km
            `);

        markers.push(marker);
    });

    if (markers.length > 0) {
        const bounds = L.latLngBounds(markers.map(marker => marker.getLatLng()));
        map.fitBounds(bounds);
    }
}

function applyFilter(radius) {
    if (!window.allUsers || window.allUsers.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Please search a pincode first.' });
        return;
    }

    const filteredUsers = window.allUsers.filter(user => user.distance <= radius);
    pinUsersOnMap(filteredUsers);
}



$(document).ready(function () {
    initMap();
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
