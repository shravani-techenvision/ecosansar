@extends('layouts.master')
@section('title')
    @lang('Ecosansar.About')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Add @endslot
        @slot('title') About @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                                
                                    <form action="{{ $url }}" method="post">
                                    @csrf
                                          <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class=" form-label">Category<span style="color:red;">*</span></label>
                                            <select class="form-select" name="category" id="category">
                                                <option value="">Select</option>
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        @if(isset($faq) && $faq && $cat->id == $faq->category)
                                                            selected
                                                        @endif
                                                    >{{ $cat->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="text-danger">{{ $errors->first('category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Question<span style="color:red;">*</span></label>
                                            <textarea  class="form-control" name="question" id="question" placeholder="Enter your question" >@if(isset($faq->question)){{ $faq->question }}@else{{ old('question')}}@endif</textarea></textarea> 
                                            @if ($errors->has('question'))
                                                <span class="text-danger">{{ $errors->first('question') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                        <textarea id="elm1" name="answer" id="answer">@if(isset($faq->answer)){{$faq->answer}}@else{{old('answer')}}@endif</textarea>
                                        @if ($errors->has('answer'))
                                                <span class="text-danger">{{ $errors->first('answer') }}</span>
                                            @endif
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                 
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>




@endsection
