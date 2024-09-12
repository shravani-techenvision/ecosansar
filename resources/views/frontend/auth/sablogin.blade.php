

@include('frontend.include.header')
@include('sweetalert::alert')
    <div id="page-content">
        <div class="container">
            <ul class="nav nav-tabs ultop">
                 <li ><a  href="{{ route('consumer_login') }}"><span class="ultext">Contributor</span></a></li>
                  <li class=""><a  href="{{ route('sab_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing"><span class="ultext">Resource Collector </span></a></li>
                <li  ><a   href="{{ route('business_login') }}"><span class="ultext">Corporate</span></a></li>
               
               
           </ul>

           <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                <section class="page-title">
                    <h1>Sign In</h1>
                </section>
                <!--end page-title-->
                <section>
                    <form class="form inputs-underline" action="{{ route('sab.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Phone</label>
                            <input type="text" class="  form-control  @error('mobile') is-invalid @enderror" name="mobile" id="mobile" placeholder="Your phone">
                            @error('mobile')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                        </div>
                        <!--end form-group-->
                        <div class="form-group">
                            <label for="password">OTP</label>
                            <input type="text" class="  form-control @error('otp') is-invalid @enderror" name="otp" id="otp" placeholder="Your otp">
                            @error('otp')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                        </div>
                        <div class="text-center ">
                            <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Sign in   </button>
                            <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                            </div>
                        <!--end form-group-->
                    </form>

                    {{--  <hr>  --}}

                    {{--  <a href="#" data-modal-external-file="modal_reset_password.php" data-target="modal-reset-password">I have forgot my password</a>  --}}
                </section>
            </div>
            <!--col-md-4-->
        </div>
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

    @include('frontend.include.footer')

</body>

