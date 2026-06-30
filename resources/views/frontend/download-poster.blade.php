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

            <div class="row">

                @forelse($posters as $poster)

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card poster-card shadow-sm h-100">

                            <img src="{{ Storage::disk('s3')->url('DownloadPosters/Image/'.$poster->poster_image) }}"
                                 class="card-img-top"
                                 style="height:250px;object-fit:cover;">

                            <div class="card-body text-center d-flex flex-column">

                                <h5>{{ $poster->title }}</h5>

                                <button
                                    type="button"
                                    class="btn btn-linear-primary downloadPosterBtn"
                                    data-id="{{ $poster->id }}"
                                    data-file="{{ Storage::disk('s3')->url('DownloadPosters/PDF/'.$poster->poster_pdf) }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#downloadModal">

                                    Download PDF

                                </button>

                            </div>

                        </div>
                    </div>

                @empty

                    <div class="col-12 text-center">
                        <h5>No posters available.</h5>
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="downloadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <form id="downloadForm" action="{{ route('download.poster.enquiry') }}" method="POST">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Download Poster</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                           name="download_poster_id"
                           id="download_poster_id">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="name"
                                   class="form-control required-field"
                                   value="{{ session()->has('user_id') ? optional(\App\Models\frontend\EcosansarUsers::find(session('user_id')))->name : '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email <span class="text-danger">*</span></label>

                            <input type="email"
                                   name="email"
                                   class="form-control required-field"
                                   value="{{ session()->has('user_id') ? optional(\App\Models\frontend\EcosansarUsers::find(session('user_id')))->email : '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="mobile"
                                   class="form-control required-field"
                                   value="{{ session()->has('user_id') ? optional(\App\Models\frontend\EcosansarUsers::find(session('user_id')))->mobile : '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Organization <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="organization"
                                   class="form-control required-field">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-linear-primary">
                        Download PDF
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {

    let pdfUrl = '';

    // Open modal and set poster details
    $(document).on('click', '.downloadPosterBtn', function () {

        let posterId = $(this).data('id');
        pdfUrl = $(this).data('file');

        console.log("Poster ID:", posterId);

        $('#download_poster_id').val(posterId);

        // Remove previous validation
        $('.required-field').removeClass('is-invalid');
    });

    // Submit form using AJAX
    $(document).on('submit', '#downloadForm', function (e) {

        e.preventDefault();

        let valid = true;

        $('.required-field').each(function () {

            if ($.trim($(this).val()) === '') {

                $(this).addClass('is-invalid');
                valid = false;

            } else {

                $(this).removeClass('is-invalid');

            }

        });

        if (!valid) {
            return false;
        }

        console.log($(this).serialize());

        $.ajax({

            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            beforeSend: function () {

                $('button[type="submit"]').prop('disabled', true);

            },

            success: function (response) {

                $('button[type="submit"]').prop('disabled', false);

                $('#downloadModal').modal('hide');

                $('#downloadForm')[0].reset();

                $('#download_poster_id').val('');

                if (response.success) {

                    window.location.href = response.download;

                }

            },

            error: function (xhr) {

                $('button[type="submit"]').prop('disabled', false);

                $('.required-field').removeClass('is-invalid');

                if (xhr.status == 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key) {

                        $('[name="' + key + '"]').addClass('is-invalid');

                    });

                } else {

                    console.log(xhr.responseText);
                    alert('Something went wrong.');

                }

            }

        });

    });

});
</script>
@include('frontend.include.footer')