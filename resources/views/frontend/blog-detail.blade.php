

@include('frontend.include.header')
    <!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center" style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Blog Details</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Blog Details</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
				<img src="{{asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
	<div class="page-wrapper">
		<div class="content">
			<div class="container">					
				<div class="row">
					<div class="col-lg-8 col-md-12 blog-details">
						<div class="blog-head">
							
							<h4 class="mb-3">{{ $blog->blog_name }}</h4>	
						</div>
	
						<!-- Blog Post -->
						<div class="card blog-list shadow-none">
							<div class="card-body">
								<div class="blog-image">
									 <img class="img-fluid" src="{{ asset('frontend/assets/img/ecoSansar.png') }}" alt="Post Image"> 
								</div>
								<div class="blog-category mt-3">
								<ul>
									<li><span class="  text-dark">
									    <span><strong>Categories:</strong> </span>
									    @foreach($categories as $category)
            <a class="tag article" href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}" class="tag article">{{ $category->category_name }}</a>
            @if(!$loop->last), @endif
        @endforeach</span></li>
									<li><i class="feather-calendar me-1"></i>{{ $blog->created_at->format('d/m/Y') }}</li>
									<li>
										<div class="post-author">
										 <img src="{{ asset('frontend/assets/img/user.png') }}" alt="Post Author"><span>{{ $blog->posted_by_name }}</span> 
										</div>
									</li>
								</ul>
							</div>	
								<div class="blog-content">
									 <p>{!! $blog->content !!}</p> 
								</div>
							</div>
						</div>
						<!-- /Blog Post -->
						
						<div class="social-widget blog-review">
							<h4>Tags</h4>
							<div class="ad-widget">
							<ul>
                                @foreach($tags as $tag)
                                    <li>
                                        <a href="javascript:void(0);">{{ $tag->tag_name }}</a>
                                    </li>
                                @endforeach
                            </ul>

							</div>
						</div>
						
						<!-- Reviews -->
					<div class="service-wrap blog-review">
    <h4>Comments</h4>
   <ul>
    @foreach($comments as $comment)
        <li id="comment-{{ $comment->id }}">
            <div class="review-box">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-md flex-shrink-0 me-2">
                                    <img src="{{ asset('frontend/assets/img/user.png') }}" 
                                         class="img-fluid rounded-circle" 
                                         alt="User">
                                </span>
                                <div class="review-name">
                                    <h6 class="fs-16 fw-medium mb-1">{{ $comment->name }}</h6>
                                    <p class="fs-14">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                           <a href="javascript:void(0);" onclick="toggleReplyForm({{ $comment->id }})" class="reply-box"><i class="fas fa-reply me-2"></i> Reply</a>
                        </div>

                        <p>{{ $comment->comment }}</p>

                        <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control reply-name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control reply-email" placeholder="Your Email" required>
                            </div>
                            <div class="mb-2">
                                <textarea name="reply" class="form-control reply-text" placeholder="Write your reply here..." rows="3" required></textarea>
                            </div>
                            <button type="button" class="btn btn-primary btn-rounded"
                                onclick="saveReply({{ $comment->id }}, {{ $userid ?? 'null' }}, {{ $blog->id }})">
                                Submit
                            </button>
                    </div>

                    </div>
                </div>
            </div>

            @if($comment->replies->count() > 0)
                <ul class="comments-reply">
                    @foreach($comment->replies as $reply)
                        <li>
                            <div class="review-box mb-4">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
                                            <img src="{{ $reply->user->profile_image ?? asset('assets/img/profiles/default-avatar.jpg') }}" 
                                                 class="img-fluid rounded-circle" 
                                                 alt="User">
                                        </span>
                                        <div class="review-name">
                                            <h6 class="fs-16 fw-medium mb-1">  {{ $reply->user ? $reply->user->name : $reply->name }}</h6>
                                            <p class="fs-14">{{ $reply->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <p>{{ $reply->comment }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
</div>

						<!-- /Reviews -->
						
						<!-- Comments -->
						<div class="new-comment">
							<h4>Write a Comment</h4>
							<form  method="post" action={{ route('comment.save') }}>
							     @csrf
                            <input type="hidden" name="login_id" value="{{$userid}}">
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Name <span style="color:red;">*</span></label>
											<input required type="text" class="form-control" placeholder="Enter Your Name" name="name"   value={{ old('name') }}>
										     @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Email <span style="color:red;">*</span></label>
											<input required type="email" class="form-control" placeholder="Enter Email Address" name="email"   value={{ old('email') }}>
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                             @endif
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label class="form-label">Message <span style="color:red;">*</span></label>
											<textarea required rows="6" class="form-control" placeholder="Enter Your Comment Here...." name="comment">{{ old('comment') }}</textarea>
											 @if ($errors->has('comment'))
                                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                                            @endif
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
										    <label class="label-text">Please type the characters below <span style="color:red;">*</span></label>
										    <div style="display:flex; margin-top:10px;">
                                            <div class="box space" style="font-size:20px;padding:10px;">{{ $captcha }}</div>&emsp;&emsp;&emsp;&emsp;&emsp; 
                                            <input required  class="form-control" type="text" id="userInput" name="captcha" placeholder="Enter Captcha" >  
                                             </div>
                                           @error('captcha')
                                            <div class="text-danger" style="margin-left:175px; ">{{ $message }}</div>
                                           @enderror
										</div>
									</div>
									<div>
										<button class="btn btn-dark" type="submit">Post Comment</button>
									</div>
								</div>
							</form>
						</div>
						<!-- /Comments -->
				
					</div>
					
					<!-- Blog Sidebar -->
					<div class="col-lg-4 col-md-12 blog-sidebar theiaStickySidebar">
	
					 
						
						 
	
						<!-- Categories -->
						<div class="card category-widget">
							<div class="card-body">
								<h4 class="side-title">Categories</h4>
							<ul class="categories">
                                @foreach($categoriesall as $category)
                                    <li class="d-flex align-items-center justify-content-between p-2 bg-white">
                                        <!--<a href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}">{{ $category->category_name }}</a> ({{ $category->blogs_count  }})-->
                                        @if(!empty($category->bc_slug) && $category->blogs_count > 0)
                <a href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}">{{ $category->category_name }}</a>
            @else
                <span class="text-muted">{{ $category->category_name }}</span>
            @endif
            ({{ $category->blogs_count }})
                                    </li>
                                @endforeach
                            </ul>

							</div>
						</div>
						<!-- /Categories -->
	
						<!-- Latest Posts -->
					<!-- Latest Posts -->
<div class="card post-widget">
    <div class="card-body">
        <h4 class="side-title">Latest Blogs</h4>
        <ul class="latest-posts">
            @foreach($latestBlogs as $blog)
                <li>
                    <div class="post-thumb">
                        <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">
                            <img class="img-fluid" src="{{asset('frontend/assets/img/services/service-01.jpg') }}" alt="{{ $blog->title }}">
                        </a>
                    </div>
                    <div class="post-info">
                        <p>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</p>
                        <h4>
                            <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">{{ $blog->blog_name }}</a>
                        </h4>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- /Latest Posts -->

						<!-- /Latest Posts -->
	
						<!-- Tags -->
						<div class="card tags-widget">
							<div class="card-body">
								<h4 class="side-title">Tags</h4>
								<ul class="d-flex align-items-center flex-wrap">
                                    @foreach($tagsall as $tag)
                                        <li class="me-2 mb-2">
                                            <a href="{{ url('blog/tag', ['slug' => $tag->bt_slug]) }}" class="bg-dark p-1 d-block fs-12 rounded">
                                                {{ $tag->tag_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

							</div>
						</div>
						<!-- /Tags -->
						
					</div>
					<!-- /Blog Sidebar -->				
				</div>
			</div>		
		</div>
	</div>
@include('frontend.include.footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                // ✅ Show SweetAlert success popup
            Swal.fire({
                icon: 'success',
                title: 'Reply Saved Successfully!',
                text: ' ',
                confirmButtonColor: '#3085d6',
                timer: 2000
            });

        } else {
            // ❌ SweetAlert for failure
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: 'Failed to add reply. Please try again.',
                confirmButtonColor: '#d33'
            });
        }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('An error occurred. Please try again.');
            }
        });
    }
</script>
 
  