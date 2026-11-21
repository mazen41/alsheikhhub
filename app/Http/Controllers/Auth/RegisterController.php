<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\OtpConfiguration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Cookie;
use Nexmo;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(?:05[0-9]{8}|5[0-9]{8})$/'],
            'country_code' => 'required|in:966',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $phone = $data['phone'];
        if (strlen($phone) === 10 && substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }

        $otpEnabled = \App\Addon::where('unique_identifier', 'otp_system')->value('activated');
        $user = User::create([
            'name' => $data['name'],
            'phone' => '+966'.$phone,
            'password' => Hash::make($data['password']),
            'verification_code' => $otpEnabled ? rand(100000, 999999) : null,
        ]);

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        if ($otpEnabled) {
            $otpController = new OTPVerificationController;
            $otpController->send_code($user);
        }

        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $user->referred_by = $referred_by_user->id;
                $user->save();
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        $phone = $request->input('phone', '');
        $this->validator($request->all())->validate();

        $normalizedPhone = strlen($phone) === 10 && substr($phone, 0, 1) === '0'
            ? substr($phone, 1)
            : $phone;
        if (User::where('phone', '+966'.$normalizedPhone)->exists()) {
            flash(translate('Phone already exists.'));
            return back()->withInput();
        }

        $user = $this->create($request->all());

        $this->guard()->login($user);

        flash(translate('Registration successfull.'))->success();

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if ($user->email == null && \App\Addon::where('unique_identifier', 'otp_system')->value('activated')) {
            return redirect()->route('verification');
        }
        else {
            return redirect()->route('home');
        }
    }
}
