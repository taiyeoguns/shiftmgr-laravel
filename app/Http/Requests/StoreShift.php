<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShift extends FormRequest
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
            "shift_date" => "required|unique:shifts,shift_date",
            "manager" => "required|exists:managers,id",
            "members" => "required|exists:members,id|array|min:1"
        ];
    }
}
