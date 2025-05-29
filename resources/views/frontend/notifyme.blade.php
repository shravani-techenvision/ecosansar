@include('frontend.include.header')
@include('sweetalert::alert')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        section:not(.block) {
    margin-top: 30px;
    margin-bottom: 30px;
}
  .custom-card {
    border: 1px solid #8eb66f;
    border-radius: 4px;
    background-color: #fafafa;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow */
    padding: 15px; /* Padding for content */
    margin-bottom: 20px; /* Margin for spacing */
}
.card-body {
    padding: 10px 15px;
}
    </style>  
        
        
         
    

</head>
    <div id="page-content">
        <div class="container">
            <div class="row" >
                <div class="col-md-6 ">
                    <section class="page-title">
                        <h1>Add Preference</h1>
                    </section
                    <!--end page-title id="location-form" -->
                    <section id="business">
                        <form id="locationForm"  class="form inputs-underline" action="{{ $url }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <label for="address">Pincode<span style="color:red;">*</span></label><br><br>
                                        <select class="form-select js-example" name="pincode[]" id="pincode" multiple="multiple" aria-label="Default select example">
                                            <option value="">Select pincode</option>
                                            <!-- Assuming $resources is an array of resources -->
                                            @foreach($pincodes as $res)
                                          <option value="{{ $res->id }}" 
                                                {{ in_array($res->id, $notifyMe->pincode ?? []) ? 'selected' : '' }}>
                                                {{ $res->pincode }}
                                            </option>
                                            @endforeach
                                        </select>
                                        	@if ($errors->has('resource_type'))
                                    <span class="text-danger">{{ $errors->first('resource_type') }}</span>
                                @endif
                                    </div>
                                   
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <label for="address">Type of Resource<span style="color:red;">*</span></label><br><br>
                                        <select class="form-select js-example" name="resource_type[]" id="resource_type" multiple="multiple" aria-label="Default select example">
                                            <option value="">Select resource</option>
                                            <!-- Assuming $resources is an array of resources -->
                                            @foreach($resources as $res)
                                            <!--<option value="{{ $res->id }}" {{ (collect(old('resource_type'))->contains($res->id)) ? 'selected' : '' }}>{{ $res->resource_name }}</option>-->
                                            <option value="{{ $res->id }}" 
                                                {{ in_array($res->id, $notifyMe->resource ?? []) ? 'selected' : '' }}>
                                                {{ $res->resource_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        	@if ($errors->has('resource_type'))
                                    <span class="text-danger">{{ $errors->first('resource_type') }}</span>
                                @endif
                                    </div>
                                   
                                </div>
                            </div>
                           

                            <!--end form-group-->

                                <div class="text-center ">
                                <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Submit</button>
                                 <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing">Cancel</a>
                                </div>
                            <!--end form-group-->
                        </form>

                       
                    </section>


                </div>
                <div class="col-md-6">
                   <section class="page-title">
                        <h1>Added Preference</h1>
                    </section >
                     <div class="custom-card">
                    <div class="card-body">
                        <div class="row">
                             
                         <div class="mb-3">
                    <span style="float:inline-start;font-size:18px;"><strong>Pincode:</strong></span><br>
                    <div>
                        @if(!empty($notifyMe->pincode))
                            @php
                                // Fetch pincode names as a comma-separated string
                                $pincodeNames = $pincodes->whereIn('id', $notifyMe->pincode)
                                    ->pluck('pincode')
                                    ->filter()
                                    ->join(', ');
                            @endphp
                            {{ $pincodeNames }}
                        @else
                            No Pincodes Added
                        @endif
                    </div>
                </div>
                       <!-- Display Added Resources -->
                <div class="mb-3">
                    <span style="float:inline-start;font-size:18px;"><strong>Resources:</strong></span><br>
                    <p>
                        @if(!empty($notifyMe->resource))
                            @php
                                // Fetch resource names as a comma-separated string
                                $resourceNames = $resources->whereIn('id', $notifyMe->resource)
                                    ->pluck('resource_name')
                                    ->filter()
                                    ->join(', ');
                            @endphp
                            {{ $resourceNames }}
                        @else
                            No Resources Added
                        @endif
                    </p>
                </div>
                       
                        
                      </div>
                      
                      
                         
                       </div>
                       </div>
                </div>
                <!--col-md-4-->
            </div>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

   @include('frontend.include.footer')
   <script>
    

    $(document).ready(function() {
        // Initialize Select2 on both multi-select fields
        $('#pincode').select2();
        $('#resource_type').select2();
    });
</script>
   
   
  
    
    
    
 

   

