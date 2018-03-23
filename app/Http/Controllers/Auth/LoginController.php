<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * How many minutes throttle users for failed login.
     *
     * @var string
     */
    protected $decayMinutes = 5;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'account' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码不正确，请重新输入',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $emailCredentials = [
            'email' => $request->account,
            'password' => $request->password
        ];

        $phoneCredentials = [
            'phone' => $request->account,
            'password' => $request->password
        ];

        $remember = $request->filled('remember');

        return $this->guard()->attempt($emailCredentials, $remember) || $this->guard()->attempt($phoneCredentials, $remember);
    }
}
