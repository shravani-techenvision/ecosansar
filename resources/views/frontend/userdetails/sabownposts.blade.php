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
            {{--  <div class="col-md-3 col-sm-3">
                <aside class="sidebar">
                    <section>
                        <h2>Search Filter</h2>
                        <form class="form inputs-underline">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword" placeholder="Enter keyword">
                            </div>
                            <!--end form-group-->
                            <div class="form-group">
                                <select class="form-control selectpicker" name="location">
                                    <option value="">Location</option>
                                        <option value="1">New York</option>
                                        <option value="2">Washington</option>
                                        <option value="3">London</option>
                                        <option value="4">Paris</option>
                                </select>
                            </div>
                            <!--end form-group-->
                            <div class="form-group">
                                <select class="form-control selectpicker" name="category">
                                    <option value="">Category</option>
                                        <option value="1">Restaurant</option>
                                        <option value="2">Event</option>
                                        <option value="3">Adrenaline</option>
                                        <option value="4">Sport</option>
                                        <option value="5">Wellness</option>
                                </select>
                            </div>
                            <!--end form-group-->
                            <div class="form-group">
                                <input type="text" class="form-control date-picker" name="min-price" placeholder="Event Date">
                            </div>
                            <!--end form-group-->
                            <div class="form-group">
                                <div class="ui-slider" id="price-slider" data-value-min="10" data-value-max="400" data-value-type="price" data-currency="$" data-currency-placement="before">
                                    <div class="values clearfix">
                                        <input class="value-min" name="value-min[]" readonly>
                                        <input class="value-max" name="value-max[]" readonly>
                                    </div>
                                    <div class="element"></div>
                                </div>
                                <!--end price-slider-->
                            </div>
                            <!--end form-group-->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">Search Now<i class="fa fa-search"></i></button>
                            </div>
                            <!--end form-group-->
                        </form>
                    </section>
                    <section>
                        <h2>Recent Items</h2>
                        <div class="item" data-id="1">
                            <a href="detail.html">
                                <div class="description">
                                    <figure>Average Price: $8 - $30</figure>
                                    <div class="label label-default">Restaurant</div>
                                    <h3>Marky’s Restaurant</h3>
                                    <h4>63 Birch Street</h4>
                                </div>
                                <!--end description-->
                                <div class="image bg-transfer">
                                    <img src="assets/img/items/1.jpg" alt="">
                                </div>
                                <!--end image-->
                            </a>
                            <div class="controls-more">
                                <ul>
                                    <li><a href="#">Add to favorites</a></li>
                                    <li><a href="#">Add to watchlist</a></li>
                                    <li><a href="#" class="quick-detail">Quick detail</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--end item-->
                        <div class="item" data-id="2">
                            <a href="detail.html">
                                <div class="description">
                                    <div class="label label-default">Restaurant</div>
                                    <h3>Ironapple</h3>
                                    <h4>4209 Glenview Drive</h4>
                                </div>
                                <!--end description-->
                                <div class="image bg-transfer">
                                    <img src="assets/img/items/2.jpg" alt="">
                                </div>
                                <!--end image-->
                            </a>
                            <div class="controls-more">
                                <ul>
                                    <li><a href="#">Add to favorites</a></li>
                                    <li><a href="#">Add to watchlist</a></li>
                                    <li><a href="#" class="quick-detail">Quick detail</a></li>
                                </ul>
                            </div>
                            <!--end controls-more-->
                        </div>
                        <!--end item-->
                        <div class="item" data-id="15">
                            <figure class="ribbon">Top</figure>
                            <a href="detail.html">
                                <div class="description">
                                    <figure>Happy hour: 18:00 - 19:00</figure>
                                    <div class="label label-default">Bar & Grill</div>
                                    <h3>Bambi Planet Houseboat Bar& Grill </h3>
                                    <h4>3857 Losh Lane</h4>
                                </div>
                                <!--end description-->
                                <div class="image bg-transfer">
                                    <img src="assets/img/items/3.jpg" alt="">
                                </div>
                                <!--end image-->
                            </a>
                            <div class="controls-more">
                                <ul>
                                    <li><a href="#">Add to favorites</a></li>
                                    <li><a href="#">Add to watchlist</a></li>
                                    <li><a href="#" class="quick-detail">Quick detail</a></li>
                                </ul>
                            </div>
                            <!--end controls-more-->
                        </div>
                        <!--end item-->
                    </section>
                </aside>
                <!--end sidebar-->
            </div>  --}}
            <!--end col-md-3-->

            <div class="col-md-12 col-sm-12">
                

                <section>
                    <div class="search-results-controls clearfix">
                        {{--  <div class="pull-left">
                            <a href="listing-grid-right-sidebar.html" class="circle-icon active"><i class="fa fa-th"></i></a>
                            <a href="listing-row-right-sidebar.html" class="circle-icon"><i class="fa fa-bars"></i></a>
                        </div>  --}}
                        <!--end left-->
                        {{--  <div class="pull-right">
                            <div class="input-group inputs-underline min-width-150px">
                                <select class="form-control selectpicker" name="sort">
                                    <option value="">Sort by</option>
                                    <option value="1">Price</option>
                                    <option value="2">Distance</option>
                                    <option value="3">Title</option>
                                </select>
                            </div>
                        </div>  --}}
                        <!--end right-->
                    </div>
                    <!--end search-results-controls-->
                </section>
 <section>
     <div class="row">
         <div class="col-md-8">
              <h2>Resource Collector Listings</h2>
         </div>
          <div class="col-md-4">
               <a href="{{ route('sab_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="float:right;" ><i class="fa fa-plus"></i><span>Add listing</span></a>
         </div>
         
     </div>
                    
                    <div class="row">
                        @foreach($uniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sab_own_listing_details/'.$listing->id) }}">
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
                                            <img src="{{ asset('frontend/assets/img/SABposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        {{--  <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <span class="stars"></span>
                                            <span class="reviews">{{ $listing->reviews_count }}</span>
                                        </div>  --}}
                                           <a href="#" class="sab-deactivate-post btn btn-primary btn-small btn-rounded icon shadow add-listing" data-post-id="{{ $listing->id }}">Deactivate</a> 
                                                <!--<li><a href="#">Add to watchlist</a></li>-->
                                                <!--<li><a href="#" class="quick-detail">Quick detail</a></li>-->
                                             
                                        <!--end controls-more-->
                                    </div>
                                    <!--end additional-info-->
                                </div>
                                <!--end item-->
                            </div>
                            <!--end col-md-4-->
                        @endforeach
                    </div>

                    <!--end row-->
                </section>
             
                
  
                <section>
                    {{--  <div class="center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="disabled previous">
                                    <a href="#" aria-label="Previous">
                                        <i class="arrow_left"></i>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="active"><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li class="next">
                                    <a href="#" aria-label="Next">
                                        <i class="arrow_right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>  --}}
                </section>
            </div>
            <!--end col-md-9-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>



 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
        $(document).ready(function() {
            $('.sab-deactivate-post').on('click', function(e) {
               // e.preventDefault();

                var postId = $(this).data('post-id');

                if (confirm('Are you sure you want to deactivate this post?')) {
                    $.ajax({
                        url: '{{ route('sab-posts.deactivate') }}',
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
    @include('frontend.include.footer')
