@extends('layouts.master')
@section('title')
Plan validity Add
@endsection

@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle')   Add @endslot
@slot('title') Plan validity @endslot
@endcomponent

<div class="row justify-content-center align-items-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {{--  <h4 class="card-title">Form layouts</h4>  --}}
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="mt-4">

                            <form action="" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Plan Validity<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter pincode" minlength="6" maxlength="6" onkeypress="return isNumeric(event)" value="@if(isset($pincode->pincode)){{ $pincode->pincode }}@else{{ old('pincode')}}@endif">
                                            @if ($errors->has('pincode'))
                                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('planvalidity.list')}}" class="btn btn-primary">Cancel</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    <script>
    function isNumeric(event) {
      // Get the key code of the pressed key
      const keyCode = event.which ? event.which : event.keyCode;

      // Check if the key code corresponds to a numeric character or a special key
      if (keyCode >= 48 && keyCode <= 57) {
        return true; // Allow input
      } else {
        return false; // Prevent input
      }
    }

     

</script>
@endsection
