@include('frontend.include.header')
@include('sweetalert::alert')


<div id="page-content">
    <div class="container">
        <ul class="nav nav-tabs ultop">
             <li><a  href="{{ route('consumer_login') }}"><span class="ultext">Contributor</span></a></li>
              <li><a  href="{{ route('sab_login') }}" ><span class="ultext">Resource Collector </span></a></li>
            <li class="" ><a   href="{{ route('business_login') }}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing"><span class="ultext">Corporate</span></a></li>
           
           
       </ul>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                <section class="page-title">
                    <h1>Sign In</h1>
                </section>
                <!--end page-title-->
                <section>
                    <form class="form inputs-underline" action="{{ route('business.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="  form-control  @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email">
                            @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                        </div>
                        <!--end form-group-->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="  form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Your password">
                            @error('password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                        </div>
                        <div class="text-center ">
                            <button type="submit" class="btn btn-primary btn-small btn-rounded icon shadow add-listing ">Sign in  </button>
                            <a href="{{url('/')}}" class="btn btn-primary btn-small btn-rounded icon shadow add-listing " style="padding: 13px;margin-top: -2px;margin-left:40px">Cancel</a>
                            </div>
                        <!--end form-group-->
                    </form>

                    {{--  <hr>

                    <a href="#" data-modal-external-file="modal_reset_password.php" data-target="modal-reset-password">I have forgot my password</a>  --}}
                </section>
            </div>
            <!--col-md-4-->
        </div>
        <!--end ro-->
    </div>
    <!--end container-->
</div>
<!--end page-content-->

@include('frontend.include.footer')


</body>
