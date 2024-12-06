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
                        <i class="uil-store"></i>
                        <span>Pages</span>
                    </a>
                    @php
                        use App\Models\admin\About;
                        // Fetch the first record from the About table
                        $about = About::first();
                        // Get the ID of the About record, or null if no record exists
                        $aboutId = $about ? $about->id : null;
                    @endphp
                    @php
                    use App\Models\admin\Contact;
                    // Fetch the first record from the About table
                    $about = Contact::first();
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
                        <i class="uil-store"></i>
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
                         <li><a href="{{ route('blog.blog_list') }}">Post</a></li>
                        <li><a href="{{ route('blog.blog_category_list') }}">Category</a></li>
                       <li><a href="{{ route('blog.blog_tag_list') }}">Tag</a></li>
                        <li><a href="{{ route('blog.comment_list') }}">Comment</a></li>
                         <li><a href="{{ route('blog.comment_reply_list') }}">Comment Reply</a></li>
                    </ul>
                </li>
                @php
                use App\Models\admin\Service;
                // Fetch the first record from the About table
                $service = Service::first();
                // Get the ID of the About record, or null if no record exists
                $serviceId = $service ? $service->id : null;
            @endphp
            @php
            use App\Models\admin\PrivacyPolicy;
            // Fetch the first record from the About table
            $policy = PrivacyPolicy::first();
            // Get the ID of the About record, or null if no record exists
            $policyId = $policy ? $policy->id : null;
        @endphp
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Settings</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('resource.list') }}">Resource</a></li>
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
                    </ul>
                </li>
                {{--  <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user.businesslist') }}">Corporate</a></li>
                       <li><a href="{{ route('user.sablist') }}">Resource Collector</a></li>
                       <li><a href="{{ route('user.consumerlist') }}">Contributor</a></li>

                    </ul>
                </li>  --}}

                <li class="menu-title">Users</li>
                <li>
                    <a href="{{route('volunteer.list')}}">
                        <i class="fas fa-envelope"></i>
                        <span>Volunteers</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Corporate</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user.businesslist') }}">Corporate list</a></li>
                       <li><a href="{{ route('user.businessposts') }}">Corporate post</a></li>
                    </ul>
                </li>
                {{--  <li>
                    <a href="{{ route('user.businesslist') }}" class="waves-effect">
                        <i class="uil-calender"></i>
                        <span>Corporate</span>
                    </a>
                </li>  --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Resource</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user.sablist') }}">Resource list</a></li>
                       <li><a href="{{ route('user.sabposts') }}">Resource post</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Contributor</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user.consumerlist') }}">Contributor list</a></li>
                       <li><a href="{{ route('user.consumerposts') }}">Contributor post</a></li>
                    </ul>
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
                    <a href="{{route('user.sabreviews')}}">
                        <i class="uil-home-alt"></i>
                        <span>Resource</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.consumerreviews')}}">
                        <i class="uil-home-alt"></i>
                        <span>Contributor</span>
                    </a>
                </li>

                <li class="menu-title">Reports</li>

                <li>
                    <a href="{{ route('user.businesspostreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Corporate Post Report</span>
                    </a
                </li>

                <li>
                    <a href="{{ route('user.sabpostreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Resource Post Report</span>
                    </a
                </li>

                <li>
                    <a href="{{ route('user.consumerpostreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Contributor Post Report</span>
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
                    <a href="{{ route('user.Consumerconnectreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Contributor Connect </span>
                    </a
                </li>

                <li>
                    <a href="{{ route('user.sabconnectreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Resource Connect </span>
                    </a
                </li>

                <li>
                    <a href="{{ route('user.Businessconnectreportlist') }}">
                        <i class="uil-home-alt"></i>
                        <span>Corporate Connect </span>
                    </a
                </li>

                <!--<li>-->
                <!--    <a href="{{route('user.sabposts')}}">-->
                <!--        <i class="uil-home-alt"></i>-->
                <!--        <span>Resource</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{route('user.consumerposts')}}">-->
                <!--        <i class="uil-home-alt"></i>-->
                <!--        <span>Contributor</span>-->
                <!--    </a>-->
                <!--</li>-->

                {{--

                <li class="menu-title">@lang('translation.Apps')</li>

                <li>
                    <a href="calendar" class="waves-effect">
                        <i class="uil-calender"></i>
                        <span>@lang('translation.Calendar')</span>
                    </a>
                </li>

                  <li>
                    <a href="chat" class=" waves-effect">
                        <i class="uil-comments-alt"></i>
                        <span>@lang('translation.Chat')</span>
                    </a>
                </li>

                <li>
                    <a href="file-manager" class=" waves-effect">
                        <i class="uil-comments-alt"></i>
                        <span>@lang('translation.File_Manager')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>@lang('translation.Ecommerce')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="ecommerce-products">@lang('translation.Products')</a></li>
                        <li><a href="ecommerce-product-detail">@lang('translation.Product_Detail')</a></li>
                        <li><a href="ecommerce-orders">@lang('translation.Orders')</a></li>
                        <li><a href="ecommerce-customers">@lang('translation.Customers')</a></li>
                        <li><a href="ecommerce-cart">@lang('translation.Cart')</a></li>
                        <li><a href="ecommerce-checkout">@lang('translation.Checkout')</a></li>
                        <li><a href="ecommerce-shops">@lang('translation.Shops')</a></li>
                        <li><a href="ecommerce-add-product">@lang('translation.Add_Product')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-envelope"></i>
                        <span>@lang('translation.Email')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="email-inbox">@lang('translation.Inbox')</a></li>
                        <li><a href="email-read">@lang('translation.Read_Email')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-invoice"></i>
                        <span>@lang('translation.Invoices')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="invoices-list">@lang('translation.Invoice_List')</a></li>
                        <li><a href="invoices-detail">@lang('translation.Invoice_Detail')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>@lang('translation.Contacts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="contacts-grid">@lang('translation.User_Grid')</a></li>
                        <li><a href="contacts-list">@lang('translation.User_List')</a></li>
                        <li><a href="contacts-profile">@lang('translation.Profile')</a></li>
                    </ul>
                </li>

                <li class="menu-title">@lang('translation.Pages')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-user-circle"></i>
                        <span>@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login">@lang('translation.Login')</a></li>
                        <li><a href="auth-register">@lang('translation.Register')</a></li>
                        <li><a href="auth-recoverpw">@lang('translation.Recover_Password')</a></li>
                        <li><a href="auth-lock-screen">@lang('translation.Lock_Screen')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-file-alt"></i>
                        <span>@lang('translation.Utility')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter">@lang('translation.Starter_Page')</a></li>
                        <li><a href="pages-maintenance">@lang('translation.Maintenance')</a></li>
                        <li><a href="pages-comingsoon">@lang('translation.Coming_Soon')</a></li>
                        <li><a href="pages-timeline">@lang('translation.Timeline')</a></li>
                        <li><a href="pages-faqs">@lang('translation.FAQs')</a></li>
                        <li><a href="pages-pricing">@lang('translation.Pricing')</a></li>
                        <li><a href="pages-404">@lang('translation.Error_404')</a></li>
                        <li><a href="pages-500">@lang('translation.Error_500')</a></li>
                    </ul>
                </li>

                <li class="menu-title">@lang('translation.Components')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-flask"></i>
                        <span>@lang('translation.UI_Elements')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="ui-alerts">@lang('translation.Alerts')</a></li>
                        <li><a href="ui-buttons">@lang('translation.Buttons')</a></li>
                        <li><a href="ui-cards">@lang('translation.Cards')</a></li>
                        <li><a href="ui-carousel">@lang('translation.Carousel')</a></li>
                        <li><a href="ui-dropdowns">@lang('translation.Dropdowns')</a></li>
                        <li><a href="ui-grid">@lang('translation.Grid')</a></li>
                        <li><a href="ui-images">@lang('translation.Images')</a></li>
                        <li><a href="ui-lightbox">@lang('translation.Lightbox')</a></li>
                        <li><a href="ui-modals">@lang('translation.Modals')</a></li>
                        <li><a href="ui-offcanvas">@lang('translation.Offcanvas')</a></li>
                        <li><a href="ui-rangeslider">@lang('translation.Range_Slider')</a></li>
                        <li><a href="ui-session-timeout">@lang('translation.Session_Timeout')</a></li>
                        <li><a href="ui-progressbars">@lang('translation.Progress_Bars')</a></li>
                        <li><a href="ui-placeholders">@lang('translation.Placeholders')</a></li>
                        <li><a href="ui-sweet-alert">@lang('translation.Sweet_Alert')</a></li>
                        <li><a href="ui-tabs-accordions">@lang('translation.Tabs_Accordions')</a></li>
                        <li><a href="ui-typography">@lang('translation.Typography')</a></li>
                        <li><a href="ui-utilities.html">@lang('translation.Utilities')<span class="badge rounded-pill bg-success float-end">@lang('translation.New')</span></a></li>
                        <li><a href="ui-toasts">@lang('translation.Toasts')</a></li>
                        <li><a href="ui-video">@lang('translation.Video')</a></li>
                        <li><a href="ui-general">@lang('translation.General')</a></li>
                        <li><a href="ui-colors">@lang('translation.Colors')</a></li>
                        <li><a href="ui-rating">@lang('translation.Rating')</a></li>
                        <li><a href="ui-notifications">@lang('translation.Notifications')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="uil-shutter-alt"></i>
                        <span class="badge rounded-pill bg-info float-end">9</span>
                        <span>@lang('translation.Forms')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="form-elements">@lang('translation.Basic_Elements')</a></li>
                        <li><a href="form-validation">@lang('translation.Validation')</a></li>
                        <li><a href="form-advanced">@lang('translation.Advanced_Plugins')</a></li>
                        <li><a href="form-editors">@lang('translation.Editors')</a></li>
                        <li><a href="form-uploads">@lang('translation.File_Upload')</a></li>
                        <li><a href="form-xeditable">@lang('translation.Xeditable')</a></li>
                        <li><a href="form-repeater">@lang('translation.Repeater')</a></li>
                        <li><a href="form-wizard">@lang('translation.Wizard')</a></li>
                        <li><a href="form-mask">@lang('translation.Mask')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-list-ul"></i>
                        <span>@lang('translation.Tables')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tables-basic">@lang('translation.Bootstrap_Basic')</a></li>
                        <li><a href="tables-datatable">@lang('translation.Datatables')</a></li>
                        <li><a href="tables-responsive">@lang('translation.Responsive')</a></li>
                        <li><a href="tables-editable">@lang('translation.Editable')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-chart"></i>
                        <span>@lang('translation.Charts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="charts-apex">@lang('translation.Apex')</a></li>
                        <li><a href="charts-chartjs">@lang('translation.Chartjs')</a></li>
                        <li><a href="charts-flot">@lang('translation.Flot')</a></li>
                        <li><a href="charts-knob">@lang('translation.Jquery_Knob')</a></li>
                        <li><a href="charts-sparkline">@lang('translation.Sparkline')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-streering"></i>
                        <span>@lang('translation.Icons')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="icons-unicons">@lang('translation.Unicons')</a></li>
                        <li><a href="icons-boxicons">@lang('translation.Boxicons')</a></li>
                        <li><a href="icons-materialdesign">@lang('translation.Material_Design')</a></li>
                        <li><a href="icons-dripicons">@lang('translation.Dripicons')</a></li>
                        <li><a href="icons-fontawesome">@lang('translation.Font_Awesome')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-location-point"></i>
                        <span>@lang('translation.Maps')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="maps-google">@lang('translation.Google')</a></li>
                        <li><a href="maps-vector">@lang('translation.Vector')</a></li>
                        <li><a href="maps-leaflet">@lang('translation.Leaflet')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-share-alt"></i>
                        <span>@lang('translation.Multi_Level')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">@lang('translation.Level_1.1')</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">@lang('translation.Level_1.2')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">@lang('translation.Level_2.1')</a></li>
                                <li><a href="javascript: void(0);">@lang('translation.Level_2.2')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
