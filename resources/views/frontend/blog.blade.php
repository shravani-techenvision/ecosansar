@include('frontend.include.header')
<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover;
            background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Blog  </h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active" aria-current="page">Blog  </li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="breadcrumb-bg">
				<img src="assets/img/bg/breadcrumb-bg-01.png" class="breadcrumb-bg-1" alt="">
				<img src="assets/img/bg/breadcrumb-bg-02.png" class="breadcrumb-bg-2" alt="">
			</div>
		</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
		<div class="content">
           <div class="container">
            <div class="row justify-content-center align-items-center">

                @foreach ($blogs as $blog)
<div class="col-xl-4 col-md-6">
    <div class="card p-0">
        <div class="card-body p-0">
            <div class="img-sec w-100">
                <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">
                    <img src="{{asset ('frontend/assets/img/ecoSansar.png') }}" class="img-fluid rounded-top w-100" alt="{{ $blog->title }}">
                </a>
                <div class="image-tag d-flex justify-content-end align-items-center">
                    <span class="trend-tag">@foreach(explode(',', $blog->category) as $categoryId)
                    @php
                        $category = \App\Models\admin\BlogCategory::find($categoryId);
                    @endphp
                    @if($category)
                        <a href="{{ url('blog/category', ['slug' => $category->bc_slug]) }}" class="tag article">
                            {{ $category->category_name }}
                        </a> @if(!$loop->last), &nbsp;@endif
                    @endif
                @endforeach</span>
                </div>






            </div>
            <div class="p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center border-end pe-2">
                        <span class="avatar avatar-sm me-2">
                            <img src="{{ asset('frontend/assets/img/user.png') }}" class="rounded-circle" alt="{{ $blog->posted_by_name }}">
                        </span>
                        <h6 class="fs-14 text-gray-6">{{ $blog->posted_by_name }}</h6>
                    </div>
                    <div class="d-flex align-items-center ps-2">
                        <span><i class="ti ti-calendar me-2"></i></span>
                        <span class="fs-14">{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
                <div>
                    <h6 class="fs-16 text-truncate mb-1">
                        <a href="{{ url('blog-detail', ['slug' => $blog->slug]) }}">{{ $blog->blog_name }}</a>
                    </h6>
                 <p class="fs-14">{!! Str::limit(strip_tags($blog->content), 50, '...') !!}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


            </div>
            	<nav aria-label="Page navigation">
  <ul class="paginations d-flex justify-content-center align-items-center">
    {{-- Previous Page Link --}}
    @if ($blogs->onFirstPage())
      <li class="page-item me-3 disabled">
        <a class="page-link"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @else
      <li class="page-item me-3">
        <a class="page-link" href="{{ $blogs->previousPageUrl() }}"><i class="ti ti-arrow-left me-2"></i>Prev</a>
      </li>
    @endif

    {{-- Page Number Links --}}
    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
      <li class="page-item me-2">
        <a class="page-link-1 d-flex justify-content-center align-items-center {{ $page == $blogs->currentPage() ? 'active' : '' }}"
           href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

    {{-- Next Page Link --}}
    @if ($blogs->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $blogs->nextPageUrl() }}">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @else
      <li class="page-item disabled">
        <a class="page-link">Next<i class="ti ti-arrow-right ms-2"></i></a>
      </li>
    @endif
  </ul>
</nav>

           </div>
		</div>
		</div>
		<!-- /Page Wrapper -->
@include('frontend.include.footer')

