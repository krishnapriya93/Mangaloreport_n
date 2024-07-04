@extends('backend.layouts.htmlheader_login')
<section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100 mt-4">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <span class="h1 fw-bold mb-0 mt-4"><img src="{{ asset('/assets/frontend/images/nmptlogonew-14n2-en.png') }}" class="navbar-brand_cus"></span>
                    <img src="{{ asset('/assets/frontend/images/download1.webp') }}" class="img-fluid" alt="Sample image">
                </div>
                    
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mb-0 mt-4 card">

                    <form method="post"  action="{{ route('checklogins') }}">
                        @if($errors->any())
                        <span class="alert alert-danger" role="alert">{{$errors->first()}}  <i class="lni lni-cogs"></i></span>
                        @endif

                    @csrf
                        <div class="d-flex align-items-center mb-3 pb-1">
                           <!--  <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                            <!-- <span class="h1 fw-bold mb-0 mt-4 "><img src="/img/logo.jpg" class="navbar-brand_cus"></span> -->
                        </div>
                        <a class="" id="login" type="submit" href="{{route('main.index')}}" ><i class="lni lni-home"> Home</i></a>  
                        <h5 class="fw-normal text-center" style="letter-spacing: 1px;">Sign into your account</h5>
                        <br>
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form2Example17">
                              Email address
                            </label>
                            <input id="email" type="email" class="form-control-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            
                        </div>
                        <br>
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form2Example27">
                                Password
                            </label>
                            <input id="password" type="password" class="form-control-lg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                        <br>


                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                            <div class="col-md-8">
                                <span class="captcha-image">{!! Captcha::img() !!}</span> &nbsp;&nbsp;
                                <button type="button" class="btn btn-success refresh-captcha" id="refresh-captcha">Refresh</button>
                                <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror mt-2" name="captcha" required>
                                @error('captcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="pt-1 mb-2">
                            <button type="submit" id="formbtn" class="btn btn-dark btn-lg btn-block">Login</button>
                          
                        </div><br>

                        <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                        <!-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!"
                                style="color: #393f81;">Register here</a></p> -->
                    </form>
                </div>
            </div>

        </div>
@extends('backend.layouts.htmlfooter_login')
</section>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.refresh-captcha').click(function() {
            $.ajax({
                type: 'get',
                url: '{{ route('refreshCaptcha') }}',
                success:function(data) {
                    $('.captcha-image').html(data.captcha);
                }
            });
        });
    });
</script>
</body>
</html>

