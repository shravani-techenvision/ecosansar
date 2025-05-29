<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{route('admin_dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-lg.png') }}" alt="" height="50">
            </span>
        </a>

        <a href="{{route('admin_dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button> 

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
           
          
           
            
              <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>
              <li>
                    <a href="{{route('admin_dashboard')}}">
                        <i class="uil-home-alt"></i>
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <img src="{{ URL::asset('/frontend/assets/img/pages.png') }}" alt="" height="16">
                        <span>Pages</span>
                    </a>
                    @php
                       
                        // Fetch the first record from the About table
                        $about = App\Models\admin\About::first();
                        // Get the ID of the About record, or null if no record exists
                        $aboutId = $about ? $about->id : null;
                    @endphp
                    @php
                    
                    // Fetch the first record from the About table
                    $about = App\Models\admin\Contact::first();
                    // Get the ID of the About record, or null if no record exists
                    $conatctId = $about ? $about->id : null;
                @endphp
                    <ul class="sub-menu" aria-expanded="false">
                        @if ($aboutId)
                            <li><a href="{{ url('about/edit/' . $aboutId) }}"> How it Works</a></li>
                        @else
                            <li><a href="{{ route('about.add') }}"> How it Works</a></li>
                        @endif
                        {{--  <li><a href="{{ route('faq.list') }}">FAQs</a></li>  --}}
                        @if ($conatctId)
                        <li><a href="{{ url('contact/edit/' . $conatctId) }}"> Contact Us</a></li>
                        @else
                            <li><a href="{{ route('contact.add') }}"> Contact Us</a></li>
                        @endif


                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <img src="{{ URL::asset('/frontend/assets/img/question.png') }}" alt="" height="16">
                        <span>FAQs</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('category.list') }}">Category</a></li>
                       <li><a href="{{ route('faq.list') }}">FAQs</a></li>


                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <img src="{{ URL::asset('/frontend/assets/img/blog.png') }}" alt="" height="16">
                        <span>Blogs</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('admin_blog_list') }}">Post</a></li>
                        <li><a href="{{ route('blog.blog_category_list') }}">Category</a></li>
                       <li><a href="{{ route('blog.blog_tag_list') }}">Tag</a></li>
                        <li><a href="{{ route('blog.comment_list') }}">Comment</a></li>
                         <li><a href="{{ route('blog.comment_reply_list') }}">Comment Reply</a></li>
                    </ul>
                </li>
                 @php
                        
                        // Fetch the first record from the About table
                        $service = App\Models\admin\Service::first();
                        // Get the ID of the About record, or null if no record exists
                        $serviceId = $service ? $service->id : null;
                    @endphp
                     @php
                        
                        // Fetch the first record from the About table
                        $policy = App\Models\admin\PrivacyPolicy::first();
                        // Get the ID of the About record, or null if no record exists
                        $policyId = $policy ? $policy->id : null;
                    @endphp
                    @php
                        
                        // Fetch the first record from the About table
                        $breadcrum = App\Models\admin\BreadcrumImage::first();
                        // Get the ID of the About record, or null if no record exists
                        $breadcrumId = $breadcrum ? $breadcrum->id : null;
                    @endphp
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <img src="{{ URL::asset('/frontend/assets/img/setting.png') }}" alt="" height="16">
                        <span>Settings</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        
                        <li><a href="{{ route('weight.list') }}">Weight</a></li>
                        <li><a href="{{ route('googleadsense.list') }}">Google Adsense</a></li>
                        @if ($serviceId)
                            <li><a href="{{ url('service/edit/' . $serviceId) }}">Service</a></li>
                        @else
                            <li><a href="{{ route('service.add') }}">Service</a></li>
                        @endif
                        <li><a href="{{ route('service_enquiry.list') }}">Service Enquiry List</a></li>
                         @if ($policyId)
                            <li><a href="{{ url('privacypolicy/edit/' . $policyId) }}">Privacy Policy</a></li>
                        @else
                            <li><a href="{{ route('privacypolicy.add') }}">Privacy Policy</a></li>
                        @endif
                        @if ($breadcrumId)
                            <li><a href="{{ url('breadcrumimage/edit/' . $breadcrumId) }}">Breadcrumb Image</a></li>
                        @else
                            <li><a href="{{ route('breadcrumimage.add') }}">Breadcrumb Image</a></li>
                        @endif
                    </ul>
                </li>
                 <li class="menu-title">Resources</li>
                  <li>
                    <a href="{{route('resource.list')}}">
                        
                        <span>Recyclable</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('reusable_resource.list')}}">
                        
                        <span>Reusable</span>
                    </a>
                </li>
                
                 <li class="menu-title">Users</li>
                 
                <li>
                    <a href="{{route('volunteer.list')}}">
                         
                        <span>Volunteers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.businesslist') }}">
                        
                        <span>Corporate list</span>
                    </a>
                </li>
                  <li>
                    <a href="{{ route('user.sablist') }}">
                        
                        <span>Collection Agent list</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('user.consumerlist') }}">
                        
                        <span>Contributor list</span>
                    </a>
                </li>
                  <li class="menu-title">Posts</li>
                 <li>
                    <a href="{{route('user.recyclableposts')}}">
                        <i class="fas fa-envelope"></i>
                        <span>Recyclable posts</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.reusableposts')}}">
                        <i class="fas fa-envelope"></i>
                        <span>Reusable posts</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.requestfulfilledlist')}}">
                        <i class="fas fa-envelope"></i>
                        <span>Request Fulfilled</span>
                    </a>
                </li>
                <li class="menu-title">Contact Us</li>
                <li>
                    <a href="{{route('user.usercontact')}}">
                        <i class="fas fa-envelope"></i>
                        <span>Contact Us list</span>
                    </a>
                </li>
                 <li class="menu-title">Pincode</li>
                  <li>
                    <a href="{{ route('pincode.list') }}">
                       <img src="{{ URL::asset('/frontend/assets/img/pincode available.png') }}" alt="" height="16">
                        <span>Available Pincode</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('pincode.unavaillist')}}">
                       <img src="{{ URL::asset('/frontend/assets/img/pincode not available.png') }}" alt="" height="16">
                        <span>Unavailable Pincode</span>
                    </a>
                </li>
                <li class="menu-title">Reviews</li>

                <li>
                    <a href="{{route('user.recyclablereviews')}}">
                       <img src="{{ URL::asset('/frontend/assets/img/resource.png') }}" alt="" height="16">
                        <span>Resource</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.reusablerreviews')}}">
                       <img src="{{ URL::asset('/frontend/assets/img/contributor.png') }}" alt="" height="16">
                        <span>Contributor</span>
                    </a>
                </li>
                
                <li class="menu-title">Reports</li>
                
                <li>
                    <a href="{{ route('user.recyclablepostreportlist') }}">
                       <img src="{{ URL::asset('/frontend/assets/img/corporate.png') }}" alt="" height="16">
                        <span>Recyclable Post Report</span>
                    </a
                </li>
                
                <li>
                    <a href="{{ route('user.reusablepostreportlist') }}">
                       <img src="{{ URL::asset('/frontend/assets/img/resource.png') }}" alt="" height="16">
                        <span>Reusable Post Report</span>
                    </a
                </li>
                
                <li>
                    <a href="{{ route('user.activityreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>User Activity Report</span>
                    </a
                </li>
                
                 <li class="menu-title">Reports</li>
                 <li>
                    <a href="{{ route('user.recyclableconnectreportlist') }}">
                       <img src="{{ URL::asset('/frontend/assets/img/contributor.png') }}" alt="" height="16">
                        <span>Recyclable Connect </span>
                    </a
                </li>
                <li>
                    <a href="{{ route('user.reusableconnectreportlist') }}">
                       <img src="{{ URL::asset('/frontend/assets/img/contributor.png') }}" alt="" height="16">
                        <span>Reusable Connect </span>
                    </a
                </li>
                
                
                
                       
                

            </ul>
               
            
             
             


        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
