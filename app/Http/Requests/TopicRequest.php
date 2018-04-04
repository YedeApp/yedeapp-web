<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
        switch($this->method())
        {
            case 'POST': // CREATE
            case 'PUT': // UPDATE
            case 'PATCH': // UPDATE
            {
                return [
                    'title' => 'required|min:3',
                    'content' => 'required|min:3',
                    'course_id' => 'required|numeric',
                    'chapter_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    /**
     * Get messages from the validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '请输入标题',
            'content.required' => '请输入内容',
            'title.min' => '标题不少于 3 个字符',
            'content.min'  => '内容不少于 3 个字符',
        ];
    }
}
