<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Rules\SmsCaptcha;
use Overtrue\EasySms\EasySms;
use Carbon\Carbon;

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
     * Phone number regular expression.
     *
     * @var string
     */
    protected $phoneRegex = '/^1[23456789]\d{9}$/';

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
            'phone' => 'required|regex:' . $this->phoneRegex . '|unique:users',
            'captcha' => ['required', new SmsCaptcha],
            'password' => 'required|string|between:6,25|confirmed',
        ], [
            'phone.required' => '请输入手机号码',
            'phone.regex' => '手机号码格式不正确',
            'phone.unique' => '该手机号码已存在',
            'captcha.required' => '请输入短信验证码',
            'password.required' => '请输入密码',
            'password.between' => '密码长度介于 6 至 25 之间',
            'password.confirmed' => '两次输入的密码不一致',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => 'YedeApp_'.str_random(8),
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Send a sms to user and store the captcha to session for later rules checking.
     *
     * @param  string  $phone
     * @return string
     */
    protected function getSmsCode(Request $request, EasySms $easySms)
    {
        $phone = $request->phone;
        $isValidPhoneNumber = preg_match($this->phoneRegex, $phone);

        // If someone have got a sms, he/her would not recieve another again in one minute.
        $isAllow = true;

        // No more smses sent when someone has attempted the specific times.
        $throttleAttempt = 0;
        $throttleLimit = 10;

        $verification = session()->get('smsVerification');

        if ($verification) {
            // Same phone number make the attemp limits happened.
            if ($phone == $verification['phone']) {
                $throttleAttempt = $verification['attempted'] + 1;
            }
            $isAllow = Carbon::now()->gt($verification['expired']) && ($throttleAttempt < $throttleLimit);
        }

        if ($phone && $isValidPhoneNumber && $isAllow) {
            // Generate a random number which has 5 digitals
            $code = str_pad(random_int(1, 99999), 5, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'template' => config('services.aliyun.template'),
                    'data' => array('code' => $code)
                ]);
            } catch (\GuzzleHttp\Exception\ClientException $exception) {
                return 0;
            }

            $verification = [
                'code' => $code,
                'phone' => $phone,
                'expired' => Carbon::now()->addMinute(),
                'attempted' => $throttleAttempt
            ];

            session()->put('smsVerification', $verification);
            return 1;
        }

        return 0;
    }
}
