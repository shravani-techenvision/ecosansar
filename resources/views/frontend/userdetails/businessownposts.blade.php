<style>
    .btn.btn-small{
        padding: 7px 10px !important;

    }
</style>
@include('frontend.include.header')
@include('sweetalert::alert')


<div id="page-content">
    <div class="container">

        <div class="row">

            <div class="col-md-12 col-sm-12">

                <section>
                    <div class="row">
         <div class="col-md-8">
              <h2>Corporate Listings</h2>
         </div>
          <div class="col-md-4">
              <a href="{{ route('business_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="float:right;" ><i class="fa fa-plus"></i><span>Add listing</span></a>
               </div>
                </div>
                    <div class="row">
                        @foreach($uniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('business_own_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->sale_giveaway }}</h4>
                                            <h4>{{ $listing->address }}</h4>
                                            <h4>{{ $listing->clean_unclean }}</h4>
                                            <h4>{{ $listing->packaged }}</h4>
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            @php
                                                // Check if $listing->resource_img is set and not empty
                                                $imagePath = !empty($listing->resource_img) ? 'Businessposts/' . $listing->resource_img : null;

                                                // Check if the image exists in the S3 bucket or fallback to default
                                                $imageUrl = $imagePath && Storage::disk('s3')->exists($imagePath)
                                                            ? Storage::disk('s3')->url($imagePath)
                                                            : asset('frontend/assets/img/ecosansar.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        {{--  <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <span class="stars"></span>
                                            <span class="reviews">{{ $listing->reviews_count }}</span>
                                        </div>  --}}
                                           <a href="#" class="bus-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a>
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->

                                        </div>
                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->

                        @endforeach
                    </div>

                    <!--end row-->
                </section>
            </div>
            <!--end col-md-9-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>



@include('frontend.include.footer')
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
        $(document).ready(function() {
            $('.bus-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('bus-posts.deactivate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                 location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>
