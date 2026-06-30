@include('frontend.include.header')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center"
    style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url('Breadcrumbimage/' . $breadcrumbimage->breadcrumb_image) : asset('frontend/assets/img/bg/default.png') }}');
            background-size: cover; 
            background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Services</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="ti ti-home-2"></i></a></li>
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="breadcrumb-bg">
            <img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1"
                alt="Img">
            <img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2"
                alt="Img">
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">
        <div class="container py-5">

            <div class="text-center mb-5">
                <h2 class="fw-bold">Organize a Bulk Collection Drive</h2>

                <p class="text-muted w-75 mx-auto">
                    Planning a collection drive at your office, society or institution?
                    ecosansar will organize the complete collection process with awareness,
                    logistics and responsible recycling.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body">

                            <h3 class="text-success mb-4">
                                <i class="fas fa-recycle me-2"></i>
                                Regular Collection Drive
                            </h3>

                            <ul class="list-group list-group-flush">

                                <li class="list-group-item">
                                    Bi-monthly dropoff updates through WhatsApp.
                                </li>

                                <li class="list-group-item">
                                    Posters provided by ecosansar.
                                </li>

                                <li class="list-group-item">
                                    Residents store recyclable material at home.
                                </li>

                                <li class="list-group-item">
                                    Common drop-off point arranged.
                                </li>

                                <li class="list-group-item">
                                    Pickup every alternate Monday.
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body">

                            <h3 class="text-primary mb-4">
                                <i class="fas fa-truck-loading me-2"></i>
                                One-Off Collection Drive
                            </h3>

                            <ul class="list-group list-group-flush">

                                <li class="list-group-item">
                                    Creative awareness campaign.
                                </li>

                                <li class="list-group-item">
                                    Posters & promotion support.
                                </li>

                                <li class="list-group-item">
                                    Collection stalls arranged.
                                </li>

                                <li class="list-group-item">
                                    Cartons and bags provided.
                                </li>

                                <li class="list-group-item">
                                    Two trained representatives.
                                </li>

                                <li class="list-group-item">
                                    Pickup at 5:30 PM.
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-5">

                <div class="card border-0 shadow">

                    <div class="card-body">

                        <h3 class="mb-4">
                            Pricing
                        </h3>

                        <div class="row">

                            <div class="col-md-4 text-center">

                                <h4 class="text-success">
                                    FREE
                                </h4>

                                <p>For RWAs</p>

                            </div>

                            <div class="col-md-4 text-center">

                                <h4 class="text-primary">
                                    ₹5000 / Day
                                </h4>

                                <p>Corporate & Events</p>

                            </div>

                            <div class="col-md-4 text-center">

                                <h4 class="text-warning">
                                    Optional
                                </h4>

                                <p>Customized Awareness Session</p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<!-- /Page Wrapper -->


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
@include('frontend.include.footer')
