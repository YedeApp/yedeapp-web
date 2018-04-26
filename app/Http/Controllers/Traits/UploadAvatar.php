<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

trait UploadAvatar
{
    /**
     * User avatar max-width set to 200px
     *
     * @var int
     */
    protected $avatarMaxWidth = 200;

    /**
     * Upload the user's avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return void
     */
    public function uploadAvatar(Request $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        if ($request->avatar) {
            $folder = 'avatars';
            $file_prefix = $user->id;

            $result = $this->uploadImage($request->avatar, $folder, $file_prefix, $uploader);

            if ($result) {
                $data['avatar'] = $result['path'];
                $user->update($data);
            }
        }
    }

    /**
     * Upload the image.
     *
     * @param object $image
     * @param string $folder
     * @param string $file_prefix
     * @param \App\Handlers\ImageUploadHandler $uploader
     * @return string
     */
    protected function uploadImage($image, $folder, $file_prefix, $uploader)
    {
        // Return upload image's path
        return $uploader->save($image, $folder, $file_prefix, $this->avatarMaxWidth);
    }
}