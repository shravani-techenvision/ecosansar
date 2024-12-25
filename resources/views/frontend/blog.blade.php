

@include('frontend.include.header')
<style>
  .blog-post .btn{
      /*color:black !important;*/
      font-size:18px;
      text-transform:none;
  }
 .widget {
    /*background-color: #8eb66f;  White background */
    background-color: #fff;
    border: 1px solid #ddd; /* Light gray border */
    border-radius: 5px; /* Rounded corners */
    padding: 15px; /* Spacing inside the widget */
    margin-bottom: 20px; /* Spacing between widgets */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */

}

.widget h3 {
    font-size: 1.5em; /* Font size for headings */
    margin-bottom: 10px; /* Spacing below heading */
    color: #333; /* Dark gray text color */
}

.categories-widget ul {
    list-style-type: none; /* Remove bullet points */
    padding: 0; /* Remove padding */
}

.categories-widget li {
    margin: 5px 0; /* Spacing between list items */
}

.categories-widget a {
    text-decoration: none; /* Remove underline from links */
    color: #000; /* Bootstrap primary color */
    transition: color 0.3s ease; /* Transition effect for hover */
}

.categories-widget a:hover {
    color: #0056b3; /* Darker shade on hover */
}

.tags-widget {
    padding-top: 10px; /* Additional spacing at the top */
}

.tag-cloud {
    display: flex; /* Flexbox for tag alignment */
    flex-wrap: wrap; /* Wrap tags if necessary */
}

.tag {
    display: inline-block; /* Inline block for tags */
    background-color: #f1f1f1; /* Light gray background for tags */
    border-radius: 3px; /* Rounded corners for tags */
    padding: 5px 10px; /* Padding inside tags */
    margin: 5px; /* Spacing around tags */
    text-decoration: none; /* Remove underline from tags */
    color: #333; /* Dark gray text color */
    transition: background-color 0.3s ease; /* Transition effect for hover */
}

.tag:hover {
    background-color: #007bff; /* Change background on hover */
    color: #fff; /* Change text color on hover */
}
.blog-post img{
    height:500px;
}
/*p {*/
/*    font-size: 16px;*/
/*    line-height: 1.5;*/
    /*word-spacing: 0.1em;*/
/*    color: #000 !important;*/
/*    opacity: 1 !important;*/
/*}*/
/*  * {*/
/*  font-family: Nunito, sans-serif;*/
/*}*/
 .bann {
    background-image: url('{{ asset('frontend/assets/img/bannerindex.jpg') }}');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 250px; /* You can adjust the height */
    position: relative; /* Ensure this is set for absolute positioning of text */
}

/* Style for the text that appears on top of the banner */
.banner-text {
    position: absolute;
    right: 20px; /* Distance from the right edge */
    top: 170px; /* Distance from the top edge */
    font-size: 24px; /* Adjust as needed */
    color: white; /* Change color based on your banner's image */
    font-weight: bold;
    background-color: rgba(0, 0, 0, 0.5); /* Optional: Semi-transparent background */
    padding: 10px 20px;
    border-radius: 5px; /* Optional: Rounded corners */
}
.banner-text a {
    color:white;
}
/* Media query for devices with a screen width of 768px or less (tablets and smaller) */
@media (max-width: 768px) {
    .bann {
        height: 200px; /* Reduce height for tablets */
    }
    .banner-text {
        font-size: 16px; /* Reduce font size for tablets */
        top: 88px; /* Adjust positioning */
    }
    .blog-post img{
    height:200px !important;
}
}
</style>

  <div id="page-content">
        <div class="container">
            <!--<ol class="breadcrumb">-->
            <!--    <li><a href="{{url('/')}}">Home</a></li>-->
            <!--    <li class="active">Blog</li>-->
            <!--</ol>-->
            </div>
             <section>
            <div class="bann height-400px" id="map-contact">
                <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a> /
            <a href="{{route('blog')}}" class="breadcrumb-link">Blog</a>
        </div>
            </div>
            <!--end map-->
        </section>
         <section class="block">
            <div class="container">
            <div class="row">

                <div class="col-md-9 col-sm-9">
                    <!--<section class="page-title">-->
                    <!--    <h1>Blog</h1>-->
                    <!--</section>-->
                    <!--end section-title-->
                    <section>
    @foreach($blogs as $blog)
    <article class="blog-post">
        <!-- Display the blog featured image, blog name, date, and categories dynamically -->


        <header>

                <h1>{{ $blog->blog_name }}</h1>

        </header>
        <figure class="meta">
             <i class="fa fa-user"></i> {{ $blog->posted_by_name }} &emsp;
             <i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}
            <div class="tags">
                <!-- Display all categories associated with the blog -->
                @foreach(explode(',', $blog->category) as $categoryId)
                    @php
                        $category = \App\Models\admin\BlogCategory::find($categoryId);
                    @endphp
                    @if($category)
                        <a href="{{ route('blog.category', ['id' => $categoryId]) }}" class="tag article">
                            {{ $category->category_name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </figure>

        <!-- Display a portion of the content as a preview -->
        <p>{!! Str::limit(strip_tags($blog->content), 350) !!}</p>
        <a style="margin-left: -1px;" href="{{ route('blog.detail', ['id' => $blog->id]) }}" class="btn  btn-primary btn-small btn-rounded icon shadow add-listing text-center">Read More</a>
    </article><!-- /.blog-post -->
@endforeach

</section>


                </div>
                <!--end col-md-9-->

               <div class="col-md-3 col-sm-3 ">
                    <div class="form-group clearfix ">
                                 {{--  <a style="margin-left: 75px !important;" href="{{ route('user_blog_add') }}"  class="btn  btn-primary btn-small btn-rounded icon shadow add-listing text-center" id="form-blog-reply-submit">Add Post</a>  --}}
                            </div><!-- /.form-group -->
    <!-- Categories Section -->
    <section class="widget categories-widget">
        <h3>Categories</h3>
        <ul class="list-unstyled">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('blog.category', ['id' => $category->id]) }}">
                        {{ $category->category_name }}
                        <br>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    <!-- Tags Section -->
    <section class="widget tags-widget">
        <h3>Tags</h3>
        <div class="tag-cloud">
            @foreach($tags as $tag)
                <a href="{{ route('blog.tag', ['id' => $tag->id]) }}" class="tag">{{ $tag->tag_name }}</a>
            @endforeach
        </div>
    </section>
</div>


                <!--end col-md-4-->
            </div>
            <!--end row-->
        </div>
        </section>
        <!--end container-->
    </div>
@include('frontend.include.footer')

