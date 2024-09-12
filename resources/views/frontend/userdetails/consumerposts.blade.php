@include('frontend.include.header')
@include('sweetalert::alert')


<div id="page-content">
    <div class="container">

        <div class="row">
           

            <div class="col-md-12 col-sm-12">
                

                
                <section>
                    <div class="row">
         <div class="col-md-8">
                     <h2>Contributor Listings</h2>
                     </div>
          <div class="col-md-4">
               <a href="{{ route('consumer_details') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing" style="float:right;" ><i class="fa fa-plus"></i><span>Add listing</span></a>
               </div>
         
     </div>
                    <div class="row">
                        @foreach($uniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('consumer_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/Consumerposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <span class="stars"></span>
                                            <span class="reviews">{{ $listing->reviews_count }}</span>
                                        </div>
                                        <div class="controls-more">
                                            <ul>
                                                <li><a href="#">Add to favorites</a></li>
                                                <li><a href="#">Add to watchlist</a></li>
                                                <li><a href="#" class="quick-detail">Quick detail</a></li>
                                            </ul>
                                        </div>
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
                      <h2>Resource Collector Listings</h2>
                    <div class="row">
                        @foreach($sabuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sab_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <!--<h4>{{ $listing->address }}</h4>-->
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/SABposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <span class="stars"></span>
                                            <span class="reviews">{{ $listing->reviews_count }}</span>
                                        </div>
                                        <div class="controls-more">
                                            <ul>
                                                <li><a href="#">Add to favorites</a></li>
                                                <li><a href="#">Add to watchlist</a></li>
                                                <li><a href="#" class="quick-detail">Quick detail</a></li>
                                            </ul>
                                        </div>
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
                        <h2>Corporate Listings</h2>
                    <div class="row">
                        @foreach($busuniqueListings as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('business_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            <ul>
                                                @foreach(explode(', ', $listing->resource_names) as $resourceName)
                                                    <li>{{ $resourceName }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <h4>{{ $listing->address }}</h4>
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/Businessposts/'.$listing->resource_img) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <div class="rating-passive" data-rating="{{ $listing->rating }}">
                                            <span class="stars"></span>
                                            <span class="reviews">{{ $listing->reviews_count }}</span>
                                        </div>
                                        <div class="controls-more">
                                            <ul>
                                                <li><a href="#">Add to favorites</a></li>
                                                <li><a href="#">Add to watchlist</a></li>
                                                <li><a href="#" class="quick-detail">Quick detail</a></li>
                                            </ul>
                                        </div>
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
              

                 
            </div>
            <!--end col-md-9-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>



@include('frontend.include.footer')
