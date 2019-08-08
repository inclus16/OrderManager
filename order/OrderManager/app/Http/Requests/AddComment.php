<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddComment extends FormRequest
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

    public function wantsJson()
    {
        return true;
    }

    public function getCommentContent(): string
    {
        return $this->validated()['content'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Укажите текс комментария',
            'content.string' => 'Текс должен быть строкой'
        ];
    }
}
