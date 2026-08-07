@include('frontend.include.header')
<style>
    .ecosystem-editor-content h1 {

        background: #ffffff;

        padding: 15px 35px;

        margin: 40px 0 20px;

        border-radius: 25px;

        font-size: 28px;

        color: #5aa647;

        font-weight: 700;

        box-shadow: 0 10px 35px rgba(0, 0, 0, .06);

        border-left: 7px solid #5aa647;

    }



    .ecosystem-editor-content h3 {

        font-size: 22px;

        color: #333;

        margin: 20px 35px 15px;

        font-weight: 700;

    }



    .ecosystem-editor-content p {

        margin: 0 35px 15px;

        color: #666;

        font-size: 16px;

        line-height: 1.8;

    }


    /* Modern Listing Style */

    .ecosystem-editor-content ul {

        background: #ffffff;

        padding: 25px 30px;

        margin: 20px 35px 35px;

        border-radius: 24px;

        border: 1px solid #e5efdf;

        box-shadow: 0 8px 25px rgba(0, 0, 0, .05);

        list-style: none;

    }



    .ecosystem-editor-content ul li {
        position: relative;
        padding: 10px 15px 10px 40px;
        margin-bottom: 2px;
        background: #f6faf4;
        border-radius: 14px;
        color: #555;
        font-size: 15px;
        line-height: 1.5;
        transition: .3s;
    }



    /* Green check icon */

    .ecosystem-editor-content ul li:before {
        content: "✓";
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #5aa647;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
        padding: 10px;
        margin-right: 20px;
    }

    .ecosystem-editor-content ul li span {
        margin-left: 20px;
    }


    .ecosystem-editor-content ul li:hover {

        background: #edf7e8;

        transform: translateX(5px);

    }




    /* Nested list (Material flow / Financial flow) */

    .ecosystem-editor-content ul ul {

        margin: 10px 0 10px 25px;

        padding: 0;

        box-shadow: none;

        border: none;

        background: transparent;

    }



    .ecosystem-editor-content ul ul li {

        background: #ffffff;

        border: 1px dashed #d7e8cf;

        padding-left: 35px;

    }



    .ecosystem-editor-content ul ul li:before {

        content: "•";

        background: #5aa647;

        font-size: 18px;

    }



    /* Highlight How You Can Contribute section */

    .ecosystem-editor-content h1:last-of-type {

        /* background:#5aa647; */

        color: #000000;

        border-left: none;

    }



    @media(max-width:768px) {

        .ecosystem-editor-content h1 {

            font-size: 22px;

            padding: 20px;

        }


        .ecosystem-editor-content h3,
        .ecosystem-editor-content p {

            margin-left: 15px;
            margin-right: 15px;

        }


        .ecosystem-editor-content ul {

            margin-left: 15px;
            margin-right: 15px;

            padding: 20px 30px;

        }

    }
	.partner-cta{

padding:70px 0;
background:#f4f9f1;

}


.partner-cta h2{

font-size:38px;
font-weight:700;

}


.partner-cta .btn{

border:none;
padding:15px 35px;
border-radius:30px;
font-size:18px;

} 

</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center"
    style="background-image: url('{{ $breadcrumbimage ? asset('storage/'  . $breadcrumbimage->breadcrumb_image) : asset('frontend/assets/img/bg/default.png') }}');
            background-size: cover; 
            background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Build With Us</h2>
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
        <div class="container">
            <div class="row">

                <!-- Terms & Conditions -->
                <div class="col-md-12">

                    <div class="terms-content privacy-cont build-ecosystem-content">

                        @php
                            use App\Models\admin\Service;

                            $howitwork = Service::get();
                        @endphp


                        @foreach ($howitwork as $item)
                            <div class="ecosystem-editor-content">

                                {!! $item->content !!}

                            </div>
                        @endforeach


                    </div>

                </div>
                <!-- /Terms & Conditions -->

            </div>

            <section class="partner-cta">


                <div class="container text-center">


                    <h2>
						Let's build it together.
                    </h2>


                    <p>
                        No single organisation can build a reuse economy alone. It requires an ecosystem.
                    </p>


                    <a href="https://api.whatsapp.com/send?phone=8553012812&text=" class="btn btn-linear-primary">

                        Partner with ecoSansar
                        <i class="ti ti-brand-whatsapp ms-2"></i>

                    </a>


                </div>


            </section>


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
