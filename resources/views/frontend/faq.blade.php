@include('frontend.include.header')
 <style>
     p:empty {
  display: none;
}

 </style>
<!-- Breadcrumb -->
		<div class="breadcrumb-bar text-center"
		style="background-image: url('{{ $breadcrumbimage ? Storage::disk('s3')->url("Breadcrumbimage/" . $breadcrumbimage->breadcrumb_image) : asset("frontend/assets/img/bg/default.png") }}');
            background-size: cover; 
            background-position: center;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<h2 class="breadcrumb-title mb-2">Frequently Asked Questions</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb justify-content-center mb-0">
								<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="ti ti-home-2"></i></a></li>
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active" aria-current="page">Frequently Asked Questions</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="breadcrumb-bg">
					<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-01.png') }}" class="breadcrumb-bg-1" alt="Img">
					<img src="{{ asset('frontend/assets/img/bg/breadcrumb-bg-02.png') }}" class="breadcrumb-bg-2" alt="Img">
				</div>
			</div>
		</div>
		<!-- /Breadcrumb -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="container">
				    @php
$groupedFaqs = $faqs->groupBy('category_name');
@endphp

<!--					<div class="row faq-content justify-content-center">-->
  <!-- Faq List -->
<!--  <div class="col-md-10 mx-auto faq">-->
<!--    <div class="accordion" id="accordionPanelsStayOpenExample">-->
<!--      @foreach ($faqs as $index => $faq)-->
<!--      <div class="accordion-item">-->
<!--        <h2 class="accordion-header">-->
<!--          <button class="accordion-button @if($index != 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="panelsStayOpen-collapse{{ $index }}">-->
<!--              {{ $faq['category_name'] }} <br><br> {{ $faq->question }}-->
<!--          </button>-->
<!--        </h2>-->
<!--        <div id="panelsStayOpen-collapse{{ $index }}" class="accordion-collapse collapse @if($index == 0) show @endif">-->
<!--          <div class="accordion-body">-->
<!--         <p>{!! $faq->answer !!}</p>-->

<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      @endforeach-->
<!--    </div>-->
<!--  </div>-->
  <!-- /Faq List -->
<!--</div>-->

<div class="row faq-content justify-content-center">
  <div class="col-md-10 mx-auto faq">
    <div class="accordion" id="accordionPanelsStayOpenExample">
      @foreach ($groupedFaqs as $category => $faqsInCategory)
        <h4 class="mt-4 mb-3 text-center">{{ $category }}</h4> <!-- Display category name once -->

        @foreach ($faqsInCategory as $index => $faq)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button @if($loop->first && $loop->parent->first) '' @else collapsed @endif" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapse-{{ $loop->parent->index }}-{{ $index }}"
                aria-expanded="{{ $loop->first && $loop->parent->first ? 'true' : 'false' }}"
                aria-controls="panelsStayOpen-collapse-{{ $loop->parent->index }}-{{ $index }}">
                {{ $faq->question }}
              </button>
            </h2>
            <div id="panelsStayOpen-collapse-{{ $loop->parent->index }}-{{ $index }}" class="accordion-collapse collapse @if($loop->first && $loop->parent->first) show @endif">
              <div class="accordion-body">
                <p>{!! $faq->answer !!}</p>
              </div>
            </div>
          </div>
        @endforeach

      @endforeach
    </div>
  </div>
</div>

					<div class="row justify-content-center">
						<div class="col-md-5">
							<div class="text-center">
								<h5 class="mb-2">Still have questions?</h5>
								<p class="fs-14">Tap the WhatsApp icon to send your query—we’ll respond soon!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

  
@include('frontend.include.footer')
 