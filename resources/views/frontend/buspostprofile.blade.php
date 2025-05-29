<style>
    /* Style for star ratings */
    .star-rating1 {
        unicode-bidi: bidi-override;
        direction: ltr; /* Set to left-to-right */
        text-align: center;
    }

    .star-rating1 span {
        display: inline-block;
        position: relative;
        width: 1.1em;
        font-size: 31px;
        cursor: pointer;
        color:transparent;
    }

    .star-rating1 span:before {
       content: "\2606";
        position: absolute;
        color: #FFD700;
    }

    .star-rating1 span.highlight {

        color: #FFD700; /* Yellow */
    }
    .logoimg{
        width : auto ;
height:36px;
    }
    input{
        font-family: sans-serif !important;
    }
    textarea {
width: -webkit-fill-available !important;
padding-left:8px;
}


@media (max-width:767px){
.rt-container {
    padding-left:2px;
    padding-right:2px;
}
.ScriptHeader{
    padding-top: 2px;
}


}
</style>
@include('frontend.include.header')
@include('sweetalert::alert')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
    <div id="page-content">
        <div class="container">

            <div class="row" >
                <div class=" ">
                    <section class="page-title">
                        <h1>Post Review for </h1>
                    </section
                    <!--end page-title-->
                    <section >


                            <div class="row">
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Name:</strong>
                                    <span>@isset($users->name){{ $users->name }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Phone number:</strong>
                                    <span>@isset($users->mobile){{ $users->mobile }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Email id:</strong>
                                    <span>@isset($users->email){{ $users->email }}@endisset</span>
                                </div>
                                <div class="col-md-6">
                                    <span class="mb-0"><strong> Address:</strong>
                                    <span>@isset($users->address){{ $users->address }}@endisset</span>
                                </div>
                                    <!--end form-group-->

                            </div>
                            <!--enr row-->
                        {{--  <hr>

                        <p class="center">By clicking on “Register Now” button you are accepting the <a href="terms-conditions.html">Terms & Conditions</a></p>  --}}
                    </section>
                    <section>
                        <h2>Reviews</h2>
                        <div class="review">

                            @foreach($conlistreviews as $review)
                            <div class="description">
                                <figure>
                                    <div class="rating-passive" data-rating="{{ $review->rating }}">
                                        <span class=" ">{{ $review->title }}</span>
                                        <span class="stars"></span>
                                        <span class="reviews">{{ $review->rating }}</span>
                                    </div>
                                </figure>
                                <p>{{ $review->message }}</p> <!-- Assuming content is your review content -->
                            </div>
                            @endforeach

                        </div>
                        <!--end review-->


                    </section>
                    <section id="write-a-review">
                        <h2>Write a Review</h2>
                        <form class="clearfix form inputs-underline" action="{{ route('review.business_save') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $u_id }}">
                            <input type="hidden" name="post_id" value="{{ $post_id }}">
                            <div class="box">
                                <div class="comment">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="comment-title">
                                                <h4>Review your experience</h4>
                                            </div>
                                            <!--end title-->
                                            <div class="form-group">
                                                <label for="name">Title of your review<em>*</em></label>
                                                <input type="text" class="form-control" id="title" name="title" >
                                                @if ($errors->has('title'))
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Your Message<em>*</em></label>
                                                <textarea class="form-control" id="message" rows="8" name="message"  =""  ></textarea>
                                                @if ($errors->has('message'))
                                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                            @endif
                                            </div>
                                            <!--end form-group-->
                                        </div>
                                        <!--end col-md-8-->
                                        <div class="col-md-4">
                                            <div class="comment-title">
                                                <label for="name">Rating<em>*</em></label>
                                            </div>
                                            <!--end title-->
                                            <span class="star-rating1" id="star1">
                                                <span data-rating="1">&#9733;</span>
                                                <span data-rating="2">&#9733;</span>
                                                <span data-rating="3">&#9733;</span>
                                                <span data-rating="4">&#9733;</span>
                                                <span data-rating="5">&#9733;</span>
                                            </span>
                                            <input type="hidden" name="rating" id="rating" value="0">
                                            @if ($errors->has('rating'))
                                                <span class="text-danger">{{ $errors->first('rating') }}</span>
                                            @endif
                                        </div>
                                        <!--end col-md-4-->
                                    </div>
                                    <!--end row-->
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-rounded">Send Review</button>
                                    </div>
                                    <!--end form-group-->
                                </div>
                                <!--end comment-->
                            </div>
                            <!--end review-->
                        </form>

                        <!--end form-->
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




   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const starRatingContainers = document.querySelectorAll('#star1');
      var inputhidden = document.getElementById("rating");

        starRatingContainers.forEach(container => {
            const stars = container.querySelectorAll('span');
            //const hiddenInput = container.nextElementSibling; // Use nextElementSibling

            stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            inputhidden.value=rating;
            //hiddenInput.value = rating; // Update the hidden input field
            console.log('Rating: ' + rating); // Add this line

            // Highlight stars from the first star to the clicked star
            stars.forEach(s => {
                const sRating = s.getAttribute('data-rating');
                s.classList.remove('highlight');
                if (sRating <= rating) {
                    s.classList.add('highlight');
                }
            });
        });
    });
        });
    });
    </script>
     <script>
    document.addEventListener('DOMContentLoaded', function() {
        

        @if(Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

       
    });
</script>

