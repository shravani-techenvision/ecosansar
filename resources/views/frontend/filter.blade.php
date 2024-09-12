@include('frontend.include.header')
<div class="container">
    
    <section>
        <div class="row">
    <h2>Corporate Listings</h2>
    @if($businessPosts->isEmpty())
        <p>No Corporate listings found</p>
    @else




        @foreach($businessPosts as $listing)
        <div class="col-md-4 col-sm-4">
            <div class="item" data-id="{{ $listing->id }}">
                <a href="{{ url('bus_listing_details/'.$listing->id) }}">
                    <div class="description">


                    </div>
                    <!--end description-->
                    <div class="image bg-transfer">
                        <img src="{{ asset('frontend/assets/img/Businesspostimages/'.$listing->post_pic) }}" alt="abc">
                    </div>
                    <!--end image-->
                </a>
                <div class="additional-info">
                    <!--<ul>-->
                    <!--    @foreach(explode(', ', $listing->resource_names) as $index => $resourceName)-->
                    <!--        @if($index < 2)-->
                    <!--            <li>{{ $resourceName }}</li>-->
                    <!--        @else-->
                    <!--            @break-->
                    <!--        @endif-->
                    <!--    @endforeach-->
                    <!--</ul>-->

                    <h4>{{ $listing->name }}</h4>
                        <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                        <h4>{{ $listing->address }}</h4>
                        <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                        <!--<h4>{{ $listing->packaged }}</h4>-->
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
    @endif
</div>
    </section>
<section>
    <div class="row">
    <h2>Resource Collector Listings</h2>
    @if($sabPosts->isEmpty())
        <p>No Resource Collector listings found</p>
    @else



        @foreach($sabPosts as $listing)
                            <div class="col-md-4 col-sm-4">
                                <div class="item" data-id="{{ $listing->id }}">
                                    <a href="{{ url('sabs_listing_details/'.$listing->id) }}">
                                        <div class="description">
                                            
                                        </div>
                                        <!--end description-->
                                        <div class="image bg-transfer">
                                            <img src="{{ asset('frontend/assets/img/SABpostimages/'.$listing->post_pic) }}" alt="abc">
                                        </div>
                                        <!--end image-->
                                    </a>
                                    <div class="additional-info">
                                        <!--<ul>-->
                                        <!--        @foreach(explode(', ', $listing->resource_names) as $resourceName)-->
                                        <!--            <li>{{ $resourceName }}</li>-->
                                        <!--        @endforeach-->
                                        <!--    </ul>-->
                                            <h4>{{ $listing->name }}</h4>
                                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                                            <h4>{{ $listing->address }}</h4>
                                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                                            <!--<h4>{{ $listing->packaged }}</h4>-->
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
    @endif
</div>
</section>
<section>
    <div class="row">
    <h2>Consumer Posts</h2>
    @if($consumerPosts->isEmpty())
        <p>No consumer posts found</p>
    @else




        @foreach($consumerPosts as $listing)
            <div class="col-md-4 col-sm-4">
                <div class="item" data-id="{{ $listing->id }}">
                    <a href="{{ url('con_listing_details/'.$listing->id) }}">
                        <div class="description">
                           
                        </div>
                        <!--end description-->
                        <div class="image bg-transfer">
                            <img src="{{ asset('frontend/assets/img/Consumerpostimages/'.$listing->post_pic) }}" alt="abc">
                        </div>
                        <!--end image-->
                    </a>
                    <div class="additional-info">
                         <!--<ul>-->
                         <!--       @foreach(explode(', ', $listing->resource_names) as $resourceName)-->
                         <!--           <li>{{ $resourceName }}</li>-->
                         <!--       @endforeach-->
                         <!--   </ul>-->
                            <h4>{{ $listing->name }}</h4>
                            <!--<h4>{{ $listing->sale_giveaway }}</h4>-->
                            <h4>{{ $listing->address }}</h4>
                            <!--<h4>{{ $listing->clean_unclean }}</h4>-->
                            <!--<h4>{{ $listing->packaged }}</h4>-->
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
    @endif
</div>
</section>
</div>
@include('frontend.include.footer')
