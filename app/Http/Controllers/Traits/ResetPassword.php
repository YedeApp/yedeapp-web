<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Auth;

trait ResetPassword
{
    /**
     * Show the user password resets view.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm(User $user)
    {
        $this->authorize('update', $user);

        return view('user.password', compact('user'));
    }

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), $this->rules(), $this->validationErrorMessages());

        $validator->after(function ($validator) use ($request, $user) {
            if (!Hash::check($request->old_password, $user->password)) {
                $validator->errors()->add('old_password', '旧密码不正确');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $this->updatePassword($request, $user);
        }

        return redirect()->route('user.show', $user->id)->with('success', '密码修改成功');
    }

    /**
     * Update the new user's password to db.
     */
    protected function updatePassword(Request $request, User $user)
    {
        $user->update($this->credentials($request));
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            '_token' => $request->_token,
            'password' => bcrypt($request->password),
        ];
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'old_password.required' => '请输入旧密码',
            'old_password.min' => '旧密码至少为 6 个字符',
        ];
    }
}