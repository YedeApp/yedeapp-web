<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UserController extends Controller
{
    /**
     * User avatar max-width set to 362px
     *
     * @var int
     */
    private $avatarMaxWidth = 362;

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
     * @param  App\Models\User  $user
     * @return View
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, $this->avatarMaxWitdh);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()->route('user.show', $user->id)->with('success', '更新成功');
    }
}
