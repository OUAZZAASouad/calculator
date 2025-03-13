<?php

namespace App\Modules\Calculator\Http\Requests;

use App\Enums\Operation;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalculatorRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the post request.
     * @return array
     */
    public function rules()
    {

        return [
            'firstNb' => 'required|numeric',
            'secondNb' => 'required|numeric',
            'operation' => ['required', 'string', Rule::enum(Operation::class)],
        ];
    }
}
