@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container" style="font-family:'Tajawal';">
                <div class="row">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                        <div class="card">
                            <div class="text-center pt-4">
                                <h1 class="h4 fw-600" style="font-family:'Tajawal';">
                                    {{ translate('Create an account.')}}
                                </h1>
                            </div>
                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="form-group ">
                                            <input type="text" id="a_name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                            <span class="a_name"></span>
                                        </div>
                                        @php $registrationMethod = old('registration_method', 'phone'); @endphp
                                        <div class="form-group">
                                            <label for="registration-method">{{ translate('Register using') }}</label>
                                            <select class="form-control" id="registration-method" name="registration_method">
                                                <option value="phone" {{ $registrationMethod === 'phone' ? 'selected' : '' }}>{{ translate('Phone number') }}</option>
                                                <option value="email" {{ $registrationMethod === 'email' ? 'selected' : '' }}>{{ translate('Email') }}</option>
                                            </select>
                                            @if ($errors->has('registration_method'))
                                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $errors->first('registration_method') }}</strong></span>
                                            @endif
                                        </div>
                                        <div id="registration-phone-group" class="form-group phone-form-group mb-3" style="{{ $registrationMethod === 'phone' ? '' : 'display:none;' }}">
                                            <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="05XXXXXXXX" name="phone" autocomplete="tel-national" inputmode="numeric" maxlength="10" pattern="(?:05[0-9]{8}|5[0-9]{8})" {{ $registrationMethod === 'phone' ? 'required' : 'disabled' }}>
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                                            @endif
                                        </div>
                                        <input type="hidden" id="registration-country-code" name="country_code" value="966" {{ $registrationMethod === 'phone' ? '' : 'disabled' }}>
                                        <div id="registration-email-group" class="form-group mb-3" style="{{ $registrationMethod === 'email' ? '' : 'display:none;' }}">
                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email" autocomplete="email" {{ $registrationMethod === 'email' ? 'required' : 'disabled' }}>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                        </div>

                                        @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
                                            <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="checkbox_example_1" required>
                                                <span class=opacity-100>{{ translate('By signing up you agree to')}}</span> <a href="{{ route('terms') }}">{{ translate('Terms & conditions') }}</a>


                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>

                                        <div class="mb-5">
                                            <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Create Account') }}</button>
                                        </div>
                                    </form>
                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                        <div class="separator mb-3">
                                            <span class="bg-white px-3 opacity-100">{{ translate('Or Join With')}}</span>
                                        </div>
                                        <ul class="list-inline social colored text-center mb-5">
                                            @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                                        <i class="lab la-facebook-f"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                                        <i class="lab la-google"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                                        <i class="lab la-twitter"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <p class="text-muted mb-0">{{ translate('Already have an account?')}}</p>
                                    <a href="{{ route('user.login') }}">{{ translate('Log In')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection


@section('script')
    @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script type="text/javascript">

        @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function(){
            // alert('helloman');
            $("#reg-form").on("submit", function(evt)
            {
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                //reCaptcha not verified
                    alert("please verify you are humann!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                evt.currentTarget.submit();
            });
        });
        @endif

        var input = document.querySelector("#phone-code");
        var registrationMethod = document.querySelector("#registration-method");
        var phoneGroup = document.querySelector("#registration-phone-group");
        var emailGroup = document.querySelector("#registration-email-group");
        var countryCode = document.querySelector("#registration-country-code");

        function updateRegistrationMethod() {
            var usePhone = registrationMethod.value === 'phone';
            phoneGroup.style.display = usePhone ? '' : 'none';
            emailGroup.style.display = usePhone ? 'none' : '';
            input.disabled = !usePhone;
            input.required = usePhone;
            countryCode.disabled = !usePhone;
            var emailInput = emailGroup.querySelector('input[name="email"]');
            emailInput.disabled = usePhone;
            emailInput.required = !usePhone;
        }

        if (registrationMethod) {
            registrationMethod.addEventListener('change', updateRegistrationMethod);
            updateRegistrationMethod();
        }

        if (input) {
            var iti = intlTelInput(input, {
                separateDialCode: true,
                initialCountry: 'sa',
                onlyCountries: ['sa'],
                utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580"
            });

            $('input[name=country_code]').val('966');
            input.addEventListener("countrychange", function() {
                $('input[name=country_code]').val('966');
            });
        }
    </script>
    <script>
        $(document).ready(function () {
         $('#a_name').keyup(function() {
           var wordCount = $('#a_name').val().trim().split(/\s+/).length;
           if( wordCount < 3 ) {
            $(".a_name").html("<span style='color:red'>{{ translate('The triple name must be entered') }}</span>");
           }else{
             $(".a_name").html("<span style='color:green'>{{ translate('Your triple name is complete') }}</span>");
           }
         });
      });
    </script>
@endsection
