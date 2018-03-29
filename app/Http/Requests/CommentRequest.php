<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content'    => 'required|min:5',
            'topic_id'   => 'required|numeric',
            'course_id'  => 'required|numeric',
        ];
    }

    /**
     * Get the messages while fail to validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'content.require' => '请输入留言内容',
            'content.min' => '请输入至少 5 个字符',
        ];

    }
}
