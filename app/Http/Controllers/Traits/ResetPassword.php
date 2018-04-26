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

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ], [
            'old_password.required' => '请输入旧密码',
            'old_password.min' => '旧密码至少为 6 个字符'
        ]);

        // Check old password
        $validator->after(function ($validator) use ($request, $user) {
            if (!Hash::check($request->old_password, $user->password)) {
                $validator->errors()->add('old_password', '旧密码不正确');
            }
        });

        // Actions after validation
        if ($validator->fails()) {
            // Response to previous page with errors
            return redirect()->back()->withErrors($validator)->withInput();

        } else {
            // Update user password
            $data = ['_token' => $request->_token, 'password' => bcrypt($request->password)];

            $user->update($data);

            return redirect()->route('user.show', $user->id)->with('success', '密码修改成功');
        }
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}