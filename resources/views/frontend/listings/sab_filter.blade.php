@if(isset($sabuniqueListings) && $sabuniqueListings->isNotEmpty())
    @if(!empty($appliedFilters))
        <h4>You have searched for:</h4>
        <ul>
            @if(!empty($appliedFilters['pincode']))
                <li>Pincode: {{ $appliedFilters['pincode'] }}</li>
            @endif
            @if(!empty($appliedFilters['resource']))
                <li>Resource:
                    @foreach($appliedFilters['resource'] as $resourceId)
                        {{ $res->where('id', $resourceId)->pluck('resource_name')->first() }},
                    @endforeach
                </li>
            @endif
            @if(!empty($appliedFilters['sale_giveaway']))
                <li>Sale giveaway: {{ $appliedFilters['sale_giveaway'] }}</li>
            @endif
            @if(!empty($appliedFilters['clean_unclean']))
                <li>Clean unclean: {{ $appliedFilters['clean_unclean'] }}</li>
            @endif
            @if(!empty($appliedFilters['packaged']))
                <li>Packaged: {{ $appliedFilters['packaged'] }}</li>
            @endif
        </ul>
    @endif
    @foreach($sabuniqueListings as $listing)
        <div class="item item-row" data-latitude="40.71447628" data-longitude="-73.8821125">
            <a href="{{ url('sabs_listing_details/'.$listing->id) }}">
                <div class="image">
                    <img src="{{ asset('frontend/assets/img/SABposts/'.$listing->resource_img) }}" alt="abc">
                </div>
                <div class="description">
                    @php
                        $resourceNames = explode(', ', $listing->resource_names);
                    @endphp
                    @if(!empty($resourceNames))
                        {{ implode(', ', $resourceNames) }}
                    @endif
                    <h4>{{ $listing->address }}</h4>
                </div>
            </a>
            <div class="controls-more">
                <a href="#" data-id="{{ $listing->id }}" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">
                    <span>Connect</span>
                </a>
            </div>
        </div>
    @endforeach
@else
    <p>No results found for the applied filters.</p>
@endif
