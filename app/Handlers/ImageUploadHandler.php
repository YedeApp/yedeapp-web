<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    /**
     * Allow file types.
     *
     * @var array
     */
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    /**
     * Save images to the server.
     *
     * @param  object  $file
     * @param  string  $folder
     * @param  string  $file_prefix
     * @param  string  $max_width
     * @return array
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        /**
         * Set image's upload path.
         * e.g. uploads/images/avatars/2017/09/21/
         *
         * @var string
         */
        $upload_path = "uploads/images/$folder/" . date("Y", time()) . '/' . date("m", time()) . '/' .date("d", time()).'/';

        /**
         * Set image's physical path.
         * e.g. /home/vagrant/Code/yedeapp/web/public/uploads/images/avatars/2017/09/21/
         *
         * @var string
         */
        $physical_path = public_path() . '/' . $upload_path;

        /**
         * Set image default extension.
         *
         * @var string
         */
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        /**
         * Set a new filename. The prefiex could be user's id.
         * e.g. 1_1493521050_7BVc9v9ujP.png
         *
         * @var string
         */
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // Only images can be uploaded.
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // Move file to the server's physical location
        $file->move($physical_path, $filename);

        // Tailor the avatar
        if ($max_width && $extension != 'gif') {
            $this->resize($physical_path . '/' . $filename, $max_width);
        }

        // Return uploaded file's url.
        return [
            'path' => config('app.url') . "/{$upload_path}{$filename}"
        ];
    }

    /**
     * Tailor an image to the custom size.
     *
     * @param  string  $file_path
     * @param  string  $max_width
     * @return void
     */
    public function resize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function($constraint) {

            // Set the constraint for image's height and width
            $constraint->aspectRatio();

            // Tailor into a smaller size
            $constraint->upsize();
        });

        $image->save();
    }
}