@include('frontend.include.header')
@include('sweetalert::alert')
<head>
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
         .row{
        margin-right: 0px;
        margin-left: 0px;
    }
     #map11 {
            height: 400px;
            width: 100%;
        }
    </style>

</head>
    <div id="page-content">
        <div class="container">
 <div class="row" >
                <div class=" ">
                    <section class="page-title">
                        <h1>Post Details</h1>
                    </section
                    <!--end page-title-->
                    <section id="business">
                        <form id="locationForm" class="form inputs-underline" action="{{ $url }}" method="post" enctype="multipart/form-data">
                            @csrf
            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Blog Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="blog_name" id="blog_name" placeholder="Blog Name"  value={{ old('blog_name') }}>
                                    @if ($errors->has('blog_name'))
                                        <span class="text-danger">{{ $errors->first('blog_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <label for="address">Blog Category<span style="color:red;">*</span></label><br><br>
                                        <select class="form-select js-example" name="category[]" id="category" multiple="multiple" aria-label="Default select example">
                                            <option value="">Select category</option>
                                             @foreach($category as $wat)
                                                            <option value="{{ $wat->id }}" {{ old('category') == $wat->id ? 'selected' : '' }}
                                                            >{{ $wat->category_name }} </option>
                                                        @endforeach

                                        </select>
                                        	@if ($errors->has('category'))
                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <label for="address">Blog Tag<span style="color:red;">*</span></label><br><br>
                                        <select class="form-select js-example1" name="tag[]" id="tag" multiple="multiple" aria-label="Default select example">
                                            <option value="">Select tag</option>
                                            @foreach($tag as $wat)
                                                            <option value="{{ $wat->id }}" {{ old('tag') == $wat->id ? 'selected' : '' }}
                                                            >{{ $wat->tag_name }} </option>
                                                        @endforeach

                                        </select>
                                        	@if ($errors->has('tag'))
                                    <span class="text-danger">{{ $errors->first('tag') }}</span>
                                @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                             <textarea id="elm1" name="content" id="content">@if(isset($blog->content)){{$blog->content}}@else{{old('content')}}@endif</textarea>
                                        @if ($errors->has('content'))
                                                <span class="text-danger">{{ $errors->first('content') }}</span>
                                            @endif
                            </div>
                             </div>
                              </div>
                               <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Submit</button>
                                <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                                </div>
            </form>
            </section>
            </div>
            </div>
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

   @include('frontend.include.footer')
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
   <script>
    $(document).ready(function() {
        $('.js-example').select2({
            placeholder: "Select Category"
        });
         $('.js-example1').select2({
            placeholder: "Select Tag"
        });
    });
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
</body>

