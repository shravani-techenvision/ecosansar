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

            <!--<div class="text-center mb-5">-->
            <!--    <h2>Awareness Posters</h2>-->
            <!--    <p>Download and print these posters to spread awareness.</p>-->
            <!--</div>-->

            <div class="row justify-content-center">

                <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                    <div class="card poster-card shadow-sm">
                        <img src="{{ asset('frontend/assets/posters/poster2.jpg') }}" class="card-img-top">
            
                        <div class="card-body text-center">
                            <h5>Glass Disposal</h5>
            
                            <button type="button"
                                class="btn btn-outline-primary mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#downloadModal">
                                Unlock Download
                            </button>
                        
                            <br>
                        
                            <a href="{{ asset('frontend/assets/posters/sample.pdf') }}"
                               download
                               class="btn btn-linear-primary download-btn disabled"
                               id="downloadBtn"
                               style="pointer-events:none;opacity:.6;">
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                    <div class="card poster-card shadow-sm">
                        <img src="{{ asset('frontend/assets/posters/poster2.jpg') }}" class="card-img-top">
            
                        <div class="card-body text-center">
                            <h5>Wash & Dry Glassware</h5>
            
                            <button type="button"
                                class="btn btn-outline-primary mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#downloadModal">
                                Unlock Download
                            </button>
                        
                            <br>
                        
                            <a href="{{ asset('frontend/assets/posters/sample.pdf') }}"
                               download
                               class="btn btn-linear-primary download-btn disabled"
                               id="downloadBtn"
                               style="pointer-events:none;opacity:.6;">
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            
            </div>
            
            <div class="row justify-content-center">
            
                <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                    <div class="card poster-card shadow-sm">
                        <img src="{{ asset('frontend/assets/posters/poster2.jpg') }}" class="card-img-top">
            
                        <div class="card-body text-center">
                            <h5>Poster 3</h5>
            
                            <button type="button"
                                class="btn btn-outline-primary mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#downloadModal">
                                Unlock Download
                            </button>
                        
                            <br>
                        
                            <a href="{{ asset('frontend/assets/posters/sample.pdf') }}"
                               download
                               class="btn btn-linear-primary download-btn disabled"
                               id="downloadBtn"
                               style="pointer-events:none;opacity:.6;">
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                    <div class="card poster-card shadow-sm">
                        <img src="{{ asset('frontend/assets/posters/poster2.jpg') }}" class="card-img-top">
            
                        <div class="card-body text-center">
                            <h5>Poster 4</h5>
            
                            <button type="button"
                                class="btn btn-outline-primary mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#downloadModal">
                                Unlock Download
                            </button>
                        
                            <br>
                        
                            <a href="{{ asset('frontend/assets/posters/sample.pdf') }}"
                               download
                               class="btn btn-linear-primary download-btn disabled"
                               id="downloadBtn"
                               style="pointer-events:none;opacity:.6;">
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="downloadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Enter Your Details</h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="downloadForm">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control required-field">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control required-field">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control required-field">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Organization <span class="text-danger">*</span></label>
                            <input type="text" class="form-control required-field">
                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button"
                    class="btn btn-linear-primary"
                    id="saveDetails">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<script>
    $(function(){

        $('#saveDetails').click(function(){
    
            let valid = true;
    
            $('.required-field').each(function(){
    
                if($(this).val().trim()==''){
                    valid=false;
                    $(this).addClass('is-invalid');
                }else{
                    $(this).removeClass('is-invalid');
                }
    
            });
    
            if(valid){
    
                $('#downloadBtn')
                    .removeClass('disabled')
                    .css({
                        'pointer-events':'auto',
                        'opacity':'1'
                    });
    
                $('#downloadModal').modal('hide');
            }
    
        });
    
    });
</script>
@include('frontend.include.footer')