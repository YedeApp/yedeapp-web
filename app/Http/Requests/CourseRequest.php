<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            // CREATE
            case 'POST':
            {
                return [
                    'name' => 'required|between:1,30|unique:courses',
                    'slug' => 'required|between:1,50|regex:/^[A-Za-z0-9\-]+$/|unique:courses',
                    'price' => 'required|integer',
                    'intro' => 'required|min:10',
                    'introduction' => 'required|min:20',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|between:1,30',
                    'slug' => 'required|between:1,50|regex:/^[A-Za-z0-9\-]+$/',
                    'price' => 'required|integer',
                    'intro' => 'required|min:10',
                    'introduction' => 'required|min:20',
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
     * Get the messages while fail to validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请输入课程名',
            'name.between' => '课程名应介于 1 ~ 30 个字符',
            'name.unique' => '此课程名已存在，请重新填写',
            'slug.required' => '请输入课程英文名',
            'slug.between' => '课程英文名应介于 1 ~ 50 个字符',
            'slug.unique' => '此课程英文名已存在，请重新填写',
            'price.required' => '请输入价格',
            'price.integer' => '价格应为数字',
            'intro.required'  => '请输入课程描述',
            'intro.min'  => '课程描述不能少于 10 个字符',
            'introduction.required'  => '请输入课程介绍',
            'introduction.min'  => '课程介绍不能少于 20 个字符',
        ];
    }
}
