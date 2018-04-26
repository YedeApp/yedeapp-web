<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    use Traits\ResetPassword;

    /**
     * User avatar max-width set to 200px
     *
     * @var int
     */
    protected $avatarMaxWidth = 200;

    /**
     * Set common pagesize
     *
     * @var int
     */
    protected $pageSize = 15;

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
     * User profile show page.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user, $tab = 'activities')
    {
        switch ($tab) {
            case 'comments':
                $comments = $user->comments()->with('course', 'topic')->paginate($this->pageSize);

                $compact = compact('tab', 'user', 'comments');

                break;

            default: //activities
                $subscriptions = $user->subscriptions()->with('course')->get();

                $comments = $user->comments()->with('course', 'topic')->take(10)->get();

                $compact = compact('tab', 'user', 'comments', 'subscriptions');

                break;
        }

        return view('user.show', $compact);
    }

    /**
     * User profile edit page.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\View\View
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
     * @param  \Illuminate\Foundation\Http\FormRequest\UserRequest  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        $user->update($data);

        return redirect()->route('user.show', $user->id)->with('success', '个人资料更新成功');
    }

    /**
     * Upload user avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
     * @param  \Illuminate\Foundation\Auth\User  $user
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
