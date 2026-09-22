@include('frontend.include.header')

<head>

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

        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
        }

        .map-info-window {
            min-width: 250px;
            padding: 5px;
        }

        .map-info-window h5 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .map-info-window p {
            margin-bottom: 5px;
            font-size: 13px;
        }

        .directions-btn {
            display: inline-block;
            margin-top: 8px;
            padding: 7px 12px;
            background: #198754;
            color: #fff !important;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }

        .directions-btn:hover {
            background: #157347;
            color: #fff !important;
        }
    </style>

</head>

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center"
    style="background-image: url('{{ $breadcrumbimage ? asset('storage/' . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
    background-size: cover;
    background-position: center;">

    <div class="container">

        <div class="row">

            <div class="col-md-12 col-12">

                <h2 class="breadcrumb-title mb-2">
                    Locate Drop off points
                </h2>

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb justify-content-center mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="ti ti-home-2"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            Home
                        </li>

                        <li class="breadcrumb-item active"
                            aria-current="page">
                            Locate Drop off points
                        </li>

                    </ol>

                </nav>

            </div>

        </div>

        <div class="breadcrumb-bg">

            <img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}"
                class="breadcrumb-bg-1"
                alt="Img">

            <img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}"
                class="breadcrumb-bg-2"
                alt="Img">

        </div>

    </div>

</div>
<!-- /Breadcrumb -->


<!-- Page Wrapper -->
<div class="page-wrapper">

    <div class="content">

        <div class="container">

            <!-- Search Section -->
            <div class="row align-items-center">

                <div class="col-md-2">
                    <h5>
                        Type your pincode
                    </h5>
                </div>

                <div class="col-md-2">

                    <div class="mb-3">

                        <div class="form-group">

                            <input
                                onkeypress="return isNumeric(event)"
                                minlength="6"
                                maxlength="6"
                                name="pincode"
                                id="pincode"
                                class="form-control"
                                type="text"
                                placeholder="Enter Pincode *"
                                value="{{ old('pincode') }}"
                            >

                            @if ($errors->has('pincode'))
                                <span class="text-danger">
                                    {{ $errors->first('pincode') }}
                                </span>
                            @endif

                        </div>

                    </div>

                </div>


                <div class="col-md-2">

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary w-50"
                        onclick="searchNearby()"
                    >
                        Search
                    </button>

                </div>


                <div class="col-md-1">

                    <h5>
                        Search within
                    </h5>

                </div>


                <div class="col-md-5">

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary"
                        onclick="applyFilter(2)"
                    >
                        2 KM
                    </button>

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary"
                        onclick="applyFilter(5)"
                    >
                        5 KM
                    </button>

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary"
                        onclick="applyFilter(10)"
                    >
                        10 KM
                    </button>

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary"
                        onclick="applyFilter(20)"
                    >
                        20 KM
                    </button>

                    <button
                        type="button"
                        class="btn btn-lg btn-linear-primary"
                        onclick="applyFilter(40)"
                    >
                        40 KM
                    </button>

                </div>

            </div>


            <!-- Google Map -->
            <div id="map"></div>


            <hr>


            <!-- Bottom Section -->
            <div class="row mt-4">

                <div class="col-md-6 d-flex align-items-center justify-content-center">

                    <div class="contact-queries flex-fill">

                        <h4>
                            Know a Collection Agent who is not onboarded already?
                            Help him onboard here by walking him through the
                            registration process
                        </h4>

                        <h6>
                            You can also share their details, using the whatsapp
                            icon, with us and we will explain how he can benefit
                        </h6>

                    </div>

                </div>


                <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <a href="{{ url('/') }}">

                        <button
                            class="btn btn-lg btn-linear-primary w-100 w-md-50 mt-4"
                            type="button"
                        >
                            Homepage
                            <i class="feather-arrow-right-circle ms-2"></i>
                        </button>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


@include('frontend.include.footer')


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>

    let map = null;

    let markers = [];

    let infoWindow = null;

    let AdvancedMarkerElement = null;

    window.allUsers = [];


    /**
     * Initialize Google Map
     */
    async function initMap() {

        try {

            const { Map, InfoWindow } =
                await google.maps.importLibrary("maps");

            const markerLibrary =
                await google.maps.importLibrary("marker");

            AdvancedMarkerElement =
                markerLibrary.AdvancedMarkerElement;


            // Default map location - Bangalore
            const defaultLocation = {
                lat: 12.9716,
                lng: 77.5946
            };


            // Create map
            map = new Map(
                document.getElementById("map"),
                {
                    center: defaultLocation,
                    zoom: 10,
                    mapId: "DEMO_MAP_ID"
                }
            );


            // Create InfoWindow
            infoWindow = new InfoWindow();


            console.log('Google Map initialized successfully.');

        } catch (error) {

            console.error(
                'Google Maps initialization error:',
                error
            );

        }

    }


    /**
     * Remove all existing markers
     */
    function clearMarkers() {

        markers.forEach(function(marker) {

            marker.map = null;

        });

        markers = [];

    }


    /**
     * Search nearby locations by pincode
     */
    function searchNearby() {

        const pincode =
            $('#pincode').val().trim();


        // Validate pincode
        if (pincode === '') {

            Swal.fire({
                icon: 'warning',
                title: 'Pincode Required',
                text: 'Please enter a pincode.'
            });

            return;

        }


        if (!/^\d{6}$/.test(pincode)) {

            Swal.fire({
                icon: 'warning',
                title: 'Invalid Pincode',
                text: 'Please enter a valid 6 digit pincode.'
            });

            return;

        }


        $.ajax({

            url: '{{ url("nearby-pincodes") }}/' + pincode,

            method: 'GET',

            dataType: 'json',


            success: function(response) {

                console.log('Nearby locations:', response);


                if (
                    !response.data ||
                    response.data.length === 0
                ) {

                    clearMarkers();

                    Swal.fire({
                        icon: 'info',
                        title: 'No nearby users found.'
                    });

                    return;

                }


                window.allUsers =
                    response.data;


                pinUsersOnMap(
                    window.allUsers
                );

            },


            error: function(xhr, status, error) {

                console.error(
                    'Error:',
                    error
                );

                clearMarkers();

                Swal.fire({
                    icon: 'error',
                    title: 'No user found',
                    text: 'No user found with entered pincode.'
                });

            }

        });

    }


    /**
     * Add users to Google Map
     */
    function pinUsersOnMap(users) {

        if (!map) {

            console.error(
                'Google Map is not initialized.'
            );

            return;

        }


        clearMarkers();


        const bounds =
            new google.maps.LatLngBounds();


        let validMarkerCount = 0;


        users.forEach(function(user) {

            const lat =
                parseFloat(user.latitude);

            const lng =
                parseFloat(user.longitude);


            // Skip invalid coordinates
            if (
                isNaN(lat) ||
                isNaN(lng)
            ) {

                console.warn(
                    'Invalid coordinates:',
                    user
                );

                return;

            }


            const position = {
                lat: lat,
                lng: lng
            };


            /**
             * Create Google Maps Advanced Marker
             */
            const marker =
                new AdvancedMarkerElement({
                    map: map,
                    position: position,
                    title: user.name
                });


            /**
             * Google Maps Directions URL
             */
            const directionsUrl =
                'https://www.google.com/maps/dir/?api=1' +
                '&destination=' +
                encodeURIComponent(
                    lat + ',' + lng
                );


            /**
             * Popup content
             */
            const distance =
                parseFloat(user.distance);


            const distanceText =
                !isNaN(distance)
                    ? distance.toFixed(2) + ' km'
                    : 'N/A';


            const content = `

                <div class="map-info-window">

                    <h5>
                        ${escapeHtml(user.name ?? '')}
                    </h5>

                    <p>
                        <strong>Address:</strong>
                        ${escapeHtml(user.address ?? '')}
                    </p>

                    <p>
                        <strong>Mobile:</strong>
                        ${escapeHtml(user.phone ?? '')}
                    </p>

                    <p>
                        <strong>Pincode:</strong>
                        ${escapeHtml(user.pincode ?? '')}
                    </p>

                    <p>
                        <strong>Rating:</strong>
                        ${escapeHtml(user.rating ?? '')}
                    </p>

                    <p>
                        <strong>Distance:</strong>
                        ${distanceText}
                    </p>

                    <a
                        href="${directionsUrl}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="directions-btn"
                    >
                        Get Directions
                    </a>

                </div>

            `;


            /**
             * Marker click
             */
            marker.addListener(
                'click',
                function() {

                    infoWindow.setContent(
                        content
                    );

                    infoWindow.open({
                        map: map,
                        anchor: marker
                    });

                }
            );


            markers.push(marker);


            bounds.extend(position);


            validMarkerCount++;

        });


        /**
         * Fit map to markers
         */
        if (validMarkerCount > 0) {

            map.fitBounds(bounds);


            // Prevent extreme zoom when only one marker exists
            if (validMarkerCount === 1) {

                google.maps.event.addListenerOnce(
                    map,
                    'idle',
                    function() {

                        if (map.getZoom() > 15) {

                            map.setZoom(15);

                        }

                    }
                );

            }

        }

    }


    /**
     * Apply distance filter
     */
    function applyFilter(radius) {

        if (
            !window.allUsers ||
            window.allUsers.length === 0
        ) {

            Swal.fire({
                icon: 'warning',
                title: 'Please search a pincode first.'
            });

            return;

        }


        const filteredUsers =
            window.allUsers.filter(
                function(user) {

                    return (
                        parseFloat(user.distance) <=
                        radius
                    );

                }
            );


        if (filteredUsers.length === 0) {

            clearMarkers();

            Swal.fire({
                icon: 'info',
                title: 'No locations found',
                text:
                    'No locations found within ' +
                    radius +
                    ' KM.'
            });

            return;

        }


        pinUsersOnMap(
            filteredUsers
        );

    }


    /**
     * Escape HTML before inserting API/database
     * values into the InfoWindow.
     */
    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /**
     * Numeric-only pincode input
     */
    function isNumeric(event) {

        const keyCode =
            event.which
            ? event.which
            : event.keyCode;


        if (
            keyCode >= 48 &&
            keyCode <= 57
        ) {

            return true;

        } else {

            event.preventDefault();

            return false;

        }

    }

</script>


<!-- Google Maps JavaScript API -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0&libraries=places&loading=async&callback=initMap"
    async
    defer>
</script>