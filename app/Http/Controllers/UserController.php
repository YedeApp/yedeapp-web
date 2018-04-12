<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UserController extends Controller
{
    /**
     * User avatar max-width set to 200px
     *
     * @var int
     */
    protected $avatarMaxWidth = 200;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Auth all the methods except show.
        $this->middleware('auth');
    }

    /**
     * User profile edit page.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @return Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        // Laravel's base class 'Controller' has a trait called 'AuthorizesRequests',
        // and this trait has a method called 'authorize' which could use the UserPolicy
        // methods to auth UsersContoller methods.
        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * Update user profile.
     *
     * @param  Illuminate\Foundation\Http\FormRequest\UserRequest  $request
     * @param  App\Handlers\ImageUploadHandler  $uploader
     * @param  Illuminate\Foundation\Auth\User  $user
     * @return Redirect
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        $user->update($data);

        return redirect()->route('user.edit', $user->id)->with('success', '更新成功');
    }

    /**
     * Upload user avatar.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Handlers\ImageUploadHandler  $uploader
     * @param  Illuminate\Foundation\Auth\User  $user
     * @return void
     */
    public function upload(Request $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        if ($request->avatar) {
            $folder = 'avatars';
            $file_prefix = $user->id;

            $result = $uploader->save($request->avatar, $folder, $file_prefix, $this->avatarMaxWidth);

            if ($result) {
                $data['avatar'] = $result['path'];
                $user->update($data);
            }
        }
    }
}
