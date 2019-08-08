<?php

namespace App\Http\Requests;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatus extends FormRequest
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

    public function getStatusId()
    {
        return $this->validated()['status_id'];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status_id'=>'required|exists:statuses,id'
        ];
    }

    public function messages()
    {
        return [
            'status_id.required'=>'Укажите id статуса',
            'status_id.exists'=>'Статус не найден'
        ];
    }
}
