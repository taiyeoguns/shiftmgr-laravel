<?php

namespace App\Http\Requests;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory;

class StoreShift extends FormRequest
{
    public function __construct(Factory $factory)
    {
        $name = "unique_shift_date";
        $test = function ($attributes, $value, $parameters) {
            return !Shift::where("shift_date", "=", Carbon::createFromFormat("d/m/Y", $value)->format("Y-m-d"))->exists();
        };

        $message = "Shift date already exists";

        $factory->extend($name, $test, $message);
    }

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
            "shift_date" => "required|unique_shift_date",
            "manager" => "required|exists:managers,id",
            "members" => "required|exists:members,id|array|min:1"
        ];
    }
}
