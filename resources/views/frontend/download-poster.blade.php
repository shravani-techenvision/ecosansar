@include('frontend.include.header')

<div class="breadcrumb-bar text-center"
style="background-image:url('{{ asset('frontend/assets/img/bg/default.png') }}');
background-size:cover;background-position:center;">
    <div class="container">
        <h2 class="breadcrumb-title">Download Posters</h2>
    </div>
</div>

<div class="page-wrapper">
    <div class="content py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h2>Awareness Posters</h2>
                <p>Download and print these posters to spread awareness.</p>
            </div>

            <div class="row">

                <!-- Poster 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">

                        <img src="{{ asset('frontend/assets/img/posters/poster1.jpg') }}"
                             class="card-img-top">

                        <div class="card-body text-center">
                            <h5>Glass Disposal</h5>

                            <a href="{{ asset('frontend/assets/posters/poster1.pdf') }}"
                               download
                               class="btn btn-primary mt-3">
                                Download PDF
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Poster 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">

                        <img src="{{ asset('frontend/assets/img/posters/poster2.jpg') }}"
                             class="card-img-top">

                        <div class="card-body text-center">
                            <h5>Wash & Dry Glassware</h5>

                            <a href="{{ asset('frontend/assets/posters/poster2.pdf') }}"
                               download
                               class="btn btn-primary mt-3">
                                Download PDF
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Poster 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">

                        <img src="{{ asset('frontend/assets/img/posters/poster3.jpg') }}"
                             class="card-img-top">

                        <div class="card-body text-center">
                            <h5>Poster 3</h5>

                            <a href="{{ asset('frontend/assets/posters/poster3.pdf') }}"
                               download
                               class="btn btn-primary mt-3">
                                Download PDF
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Poster 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">

                        <img src="{{ asset('frontend/assets/img/posters/poster4.jpg') }}"
                             class="card-img-top">

                        <div class="card-body text-center">
                            <h5>Poster 4</h5>

                            <a href="{{ asset('frontend/assets/posters/poster4.pdf') }}"
                               download
                               class="btn btn-primary mt-3">
                                Download PDF
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('frontend.include.footer')