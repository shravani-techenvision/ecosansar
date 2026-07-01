@include('frontend.include.header')

<!-- Breadcrumb -->
<style>
    .card {
        border-radius: 18px;
    }


    .list-group-item {
        border: none;
        padding: 15px 0;
    }

    .pricing-box {
        background: #f8f9fa;
        border-radius: 15px;
    }

    .section-title {
        font-size: 36px;
        font-weight: 700;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: #28a745;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table thead th {
        background-color: #a7b79b;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        font-size: 18px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: top;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .collection-table {
    width: 100%;
    table-layout: fixed; /* Equal column widths */
}

.collection-table th,
.collection-table td {
    white-space: normal;      /* Allow text to wrap */
    word-wrap: break-word;    /* Break long words if needed */
    overflow-wrap: break-word;
    vertical-align: top;
    padding: 15px;
}

.collection-table thead th {
    background: #a7b79b;
    color: #fff;
    text-align: center;
    font-size: 18px;
}

.collection-table tbody tr:nth-child(even) {
    background: #f8f9fa;
}
</style>
<div class="breadcrumb-bar text-center"
    style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url('Breadcrumbimage/' . $breadcrumbimage->breadcrumb_image) : asset('frontend/assets/img/bg/default.png') }}');
            background-size: cover; 
            background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Organize a Bulk Collection Drive</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="ti ti-home-2"></i></a></li>
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active" aria-current="page">Organize a Bulk Collection Drive</li>
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
        <div class="container">

            <div class="text-center mb-5">

                <p class="w-75 mx-auto">
                    Planning a collection drive at corporates or events or in your community? We will facilitate this
                    for you with a local waste collector incubated at ecoSansar. We oversee the process to ensure the
                    collected materials are directed into it's respective proper waste value chain. All proceeds from
                    recyclable sales go directly in full to the waste picker or scrap dealer. This is your opportunity
                    to contribute to environmental sustainability while supporting the unorganized sector workforce.
                    Choose your option below :
                </p>
            </div>

            <!--<div class="table-responsive mt-4">-->
            <!--    <table class="table table-bordered table-striped align-middle">-->
            <!--        <thead class="table-success text-center">-->
            <!--            <tr>-->
            <!--                <th width="50%">Regular drives (for glass jars and bottles / paper bags)</th>-->
            <!--                <th width="50%">One off drive (for all recyclables - glass/plastic/textile/paper/ewaste)-->
            <!--                </th>-->
            <!--            </tr>-->
            <!--        </thead>-->
            <!--        <tbody>-->
            <!--            <tr>-->
            <!--                <td>How it works : </td>-->
            <!--                <td>How it works : </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td></td>-->
            <!--                <td></td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>Bi - monthly dropoffs are communicated via whatsapp posters. Posters provided by-->
            <!--                    ecoSansar</td>-->
            <!--                <td>Creatives for collection drives and encouraging people to start collecting at home are-->
            <!--                    provided </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>Residents are encouraged to store at home</td>-->
            <!--                <td>Stalls are setup for dropoffs. Cartons and bags are brought on the day of the drive</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>EC provides a common dropoff point</td>-->
            <!--                <td>2 Experienced personnel are appointed at stall to interact with visitors and answer-->
            <!--                    queries and spread awareness</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>Pickups happen every alternate Mondays</td>-->
            <!--                <td>Pickups happen at 5:30pm from venue</td>-->
            <!--            </tr>-->
            <!--        </tbody>-->
            <!--    </table>-->
            <!--</div>-->
            <div class="mt-4">
    <table class="table table-bordered collection-table align-middle">
        <thead>
            <tr>
                <th width="50%">Regular drives (for glass jars and bottles / paper bags)</th>
                <th width="50%">One off drive (for all recyclables - glass/plastic/textile/paper/ewaste)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>How it works :</strong></td>
                <td><strong>How it works :</strong></td>
            </tr>
            <tr>
                <td>Bi - monthly dropoffs are communicated via whatsapp posters. Posters provided by ecoSansar</td>
                <td>Creatives for collection drives and encouraging people to start collecting at home are provided </td>
            </tr>
            <tr>
                <td>Residents are encouraged to store at home</td>
                <td>Stalls are setup for dropoffs. Cartons and bags are brought on the day of the drive</td>
            </tr>
            <tr>
                <td>EC provides a common dropoff point</td>
                <td>2 Experienced personnel are appointed at stall to interact with visitors and answer queries and spread awareness</td>
            </tr>
            <tr>
                <td>Pickups happen every alternate Mondays</td>
                <td>Pickups happen at 5:30pm from venue</td>
            </tr>
        </tbody>
    </table>
</div>
            <div class="text-center my-4">
                <p>
                    Facilitation fee : Zero (for RWAs) , 5000/day for corporates and events
                <br>An awareness session can be arranged at extra cost (customised to your requriement) </p>
            </div>

            <hr class="my-3">

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow border-0">
                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Organize a Collection Drive</h2>
                                <p class="text-muted mb-0">
                                    Fill in the details below and our team will get in touch with you.
                                </p>
                            </div>

                            <form action="{{ route('collection.drive.store') }}" method="POST">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Name <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter your name"
                                            value="{{ old('name', session('user_name')) }}"
                                            onkeydown="return /[a-z ]/i.test(event.key)" required>

                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Contact Number <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="contact_number" class="form-control"
                                            placeholder="Enter contact number" maxlength="10"
                                            value="{{ old('contact_number', session('mobile')) }}"
                                            onkeypress="return isNumeric(event)" required>

                                        @error('contact_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">
                                            Location for Collection Drive
                                            <span class="text-danger">*</span>
                                        </label>

                                        <textarea name="location" rows="3" class="form-control" placeholder="Enter complete location" required>{{ old('location') }}</textarea>

                                        @error('location')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">
                                            Approximate Number of Participants
                                            <small>(No. of Houses / Flats)</small>
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="number" name="participants" min="1" class="form-control"
                                            placeholder="Enter number of participants"
                                            value="{{ old('participants') }}" required>

                                        @error('participants')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-linear-primary px-5">
                                        Submit Enquiry
                                        <i class="feather-arrow-right-circle ms-2"></i>
                                    </button>
                                </div>

                            </form>

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
