

@include('frontend.include.header')
<style>
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
  .btn.btn-default.btn-framed{
      color:black !important;
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
.blog-meta {
    margin-top: 20px;
    padding-top: 10px;
    border-top: 1px solid #ddd;
}
.blog-meta p {
    margin: 5px 0;
}
.reply-form {
    margin-top: 10px;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 5px;
}

.reply-name, .reply-email, .reply-text {
    width: 100%; /* Make inputs and text area full width */
    margin-bottom: 5px; /* Add space between elements */
    padding: 8px !important; /* Add some padding */
    border: 1px solid #ccc; /* Border style */
    border-radius: 4px; /* Rounded corners */
}

button {
    padding: 10px 15px; /* Button padding */
    background-color: #007bff; /* Button color */
    color: white; /* Text color */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor */
}

button:hover {
    background-color: #0056b3; /* Darker button color on hover */
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
.comments .comment {
    padding-left: 0px !important;
}

</style>

    <div id="page-content">
        <div class="container">
            <!--<ol class="breadcrumb">-->
            <!--    <li><a href="{{url('/')}}">Home</a></li>-->
            <!--    <li class="active">Blog Detail</li>-->
            <!--</ol>-->
            </div>
             <section>
            <div class="bann height-400px" id="map-contact">
                <div class="banner-text">
            <a href="{{url('/')}}" class="breadcrumb-link">Home</a> /
            <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}" class="breadcrumb-link">Blog detail</a>
        </div>
            </div>
            <!--end map-->
        </section>
             <section class="block">
            <div class="container">
            <div class="row">

                <div class="col-md-9 col-sm-9">
<!--                   <section class="page-title">-->
<!--    <h1>Blog</h1> <!-- Static page title -->
<!--</section>-->
<!--end section-title-->
<section>
<article class="blog-post">
    <header>

            <h1>{{ $blog->blog_name }}</h1> <!-- Display the blog title dynamically -->

    </header>





    <figure class="meta">
        <i class="fa fa-user"></i> {{ $blog->posted_by_name }}&emsp;  <!-- Author (static for now) -->

            <i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }} <!-- Display the blogs publish date -->

       <div class="tags">

        @foreach($categories as $category)
            <a class="tag article" href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}" class="tag article">{{ $category->category_name }}</a>
        @endforeach
    </div>
    </figure>




    <p>{!! $blog->content !!}


</p> <!-- The main blog content -->
<!-- Display category and tag at the end -->
<div class="blog-meta">
    <!--<p><strong>Category:</strong> -->
    <!--    @foreach($categories as $category)-->
    <!--        {{ $category }}@if(!$loop->last), @endif-->
    <!--    @endforeach-->
    <!--</p>-->

    <p><strong>Tag:</strong>
        @foreach($tags as $tag)
            {{ $tag->tag_name }}@if(!$loop->last), @endif
        @endforeach
    </p>
</div>



</article>
 </section>


 <section id="comments">
    <header><h1 class="no-border">Comments</h1></header>
    @if($comments->isEmpty())
        <p>No comments yet.</p>
    @else
        <ul class="comments">
            @foreach($comments as $comment)
                <li class="comment">
                    <!--<figure>-->
                    <!--    <div class="image">-->
                    <!--        <img alt="User Image" src="{{ asset('path/to/default/image.jpg') }}">-->
                    <!--    </div>-->
                    <!--</figure>-->
                    <div class="comment-wrapper">
                        <div class="name pull-left">{{ $comment->name }}</div>
                        <span class="date pull-right">
                            <span class="fa fa-calendar"></span>{{ $comment->created_at->format('d/m/Y') }}
                        </span>
                        <p>{{ $comment->comment }}</p>
                        <a href="javascript:void(0);" class="reply" onclick="toggleReplyForm({{ $comment->id }})">
                            <span class="fa fa-reply"></span>Reply
                        </a>
                        <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
                            <input type="text" class="reply-name" placeholder="Your Name" required>
                            <input type="email" class="reply-email" placeholder="Your Email" required>
                            <textarea class="reply-text" placeholder="Write your reply here..." required></textarea>
                            <button class="btn  btn-primary btn-rounded" onclick="saveReply({{ $comment->id }}, {{ $userid ?? 'null' }}, {{ $blog->id }})">Submit</button>
                        </div>


                    </div>
                    <ul class="replies">
                        @if(isset($comment->replies) && $comment->replies->isEmpty())
                            <li>No replies yet.</li>
                        @elseif(isset($comment->replies))
                            @foreach($comment->replies as $reply)
                                <li>
                                    <strong>{{ $reply->name }}</strong>
                                    <p>{{ $reply->comment }}</p>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                 <hr>
            @endforeach
        </ul>
    @endif
</section><!-- /#comments -->




                    <section id="leave-reply">
                        <header><h1 class="no-border">Leave a Reply</h1></header>
                        <form role="form" id="form-blog-reply" method="post"  class="clearfix" action={{ route('comment.save') }}>
                            @csrf
                            <input type="hidden" name="login_id" value="{{$userid}}">
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form-blog-reply-name">Your Name</label>
                                        <input required type="text" class="form-control" id="form-blog-reply-name" name="name"   value={{ old('name') }}>
                                         @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                    </div><!-- /.form-group -->
                                </div><!-- /.col-md-6 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form-blog-reply-email">Your Email</label>
                                        <input required type="email" class="form-control" id="form-blog-reply-email" name="email"   value={{ old('email') }}>
                                         @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    </div><!-- /.form-group -->
                                </div><!-- /.col-md-6 -->
                            </div><!-- /.row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form-blog-reply-message">Your Message</label>
                                        <textarea required class="form-control" id="form-blog-reply-message" rows="5" name="comment">{{ old('comment') }}</textarea>
                                         @if ($errors->has('comment'))
                                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                                    @endif
                                    </div><!-- /.form-group -->
                                </div><!-- /.col-md-12 -->
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="label-text">Please type the characters below<span style="color:red;">*</span></label>
                                        <div style="display:flex; margin-top:20px;">
                                            <div class="box space" style="font-size:20px;padding:10px;">{{ $captcha }}</div>&emsp;&emsp;&emsp;&emsp;&emsp;
                                            <input required class="form-control" type="text" id="userInput" name="captcha" placeholder="Enter Captcha" >
                                             </div>
                                           @error('captcha')
                                            <div class="text-danger" style="margin-left:175px; ">{{ $message }}</div>
                                           @enderror
                                    </div>
                                   </div>
                            </div><!-- /.row -->
                            <div class="form-group clearfix">
                                <button type="submit" class="btn pull-right btn-primary btn-rounded" id="form-blog-reply-submit">Leave a Reply</button>
                            </div><!-- /.form-group -->
                            <div id="form-rating-status"></div>
                        </form><!-- /#form-contact -->
                    </section>

                </div>
                <!--end col-md-9-->

                <div class="col-md-3 col-sm-3">
    <!-- Categories Section -->
    <section class="widget categories-widget">
        <h3>Categories</h3>
        <ul class="list-unstyled">
            @foreach($categoriesall as $category)
                <li>
                    <a href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}">
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
            @foreach($tagsall as $tag)
                <a href="{{ url('blog/tag', ['slug' => $tag->bt_slug]) }}" class="tag">{{ $tag->tag_name }}</a>
            @endforeach
        </div>
    </section>
</div>
                <!--end col-md-4-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
        </section>
    </div>
@include('frontend.include.footer')
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    function saveReply(commentId, loginId, blogId) {
       const replyTextElement = document.querySelector(`#reply-form-${commentId} .reply-text`);
    const replyNameElement = document.querySelector(`#reply-form-${commentId} .reply-name`);
    const replyEmailElement = document.querySelector(`#reply-form-${commentId} .reply-email`);

    console.log('Reply Text Element:', replyTextElement);
    console.log('Reply Name Element:', replyNameElement);
    console.log('Reply Email Element:', replyEmailElement);

    // Check if elements are null
    if (!replyTextElement || !replyNameElement || !replyEmailElement) {
        console.error('One or more input fields are missing');
        return; // Exit the function to avoid further errors
    }

    const replyText = replyTextElement.value.trim();
    const replyName = replyNameElement.value.trim();
    const replyEmail = replyEmailElement.value.trim();

    // Validate the fields

    if (!replyName) {
        alert('Please enter your name.');
        replyNameElement.focus(); // Set focus on the empty field
        return; // Exit the function if validation fails
    }
    if (!replyEmail) {
        alert('Please enter your email.');
        replyEmailElement.focus(); // Set focus on the empty field
        return; // Exit the function if validation fails
    }
    if (!replyText) {
        alert('Please enter your reply text.');
        replyTextElement.focus(); // Set focus on the empty field
        return; // Exit the function if validation fails
    }

    const data = {
        comment_id: commentId,
        name: replyName,
        email: replyEmail,
        reply: replyText,
        login_id: loginId,   // Include login_id
        blog_id: blogId,     // Include blog_id
        _token: '{{ csrf_token() }}' // Include CSRF token
    };

        $.ajax({
            url: "{{ url('/comment/reply') }}", // URL for the AJAX request
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    // Append the new reply to the replies section
                    const repliesList = $(`#comment-${commentId} .replies`);
                   repliesList.append(`
            <li>
                <strong>${replyName}</strong>: <p>${response.reply.reply}</p>
            </li>
        `);
                    // Clear the textarea after submission
                  // Clear the input fields after submission
                replyTextElement.value = '';
                replyNameElement.value = '';
                replyEmailElement.value = '';
                 // Hide the reply form after successful submission
                const form = document.getElementById(`reply-form-${commentId}`);
                form.style.display = 'none';
                } else {
                    alert('Failed to add reply. Please try again.');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('An error occurred. Please try again.');
            }
        });
    }
</script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 5000
            });
        @endif
    });
</script>
