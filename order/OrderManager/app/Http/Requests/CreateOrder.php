<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrder extends FormRequest
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

    public function getDescription(): string
    {
        return $this->validated()['description'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Введите описание заявки',
            'description.string' => 'Описание должно быть строкой',
        ];
    }
}
