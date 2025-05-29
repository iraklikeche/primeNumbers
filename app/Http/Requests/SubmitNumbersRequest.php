<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SubmitNumbersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'numbers' => ['required', 'array', 'max:10000'],
            'numbers.*' => [
                'required',
                Rule::notIn(['']), 
                function ($attribute, $value, $fail) {
                    if (!is_int($value) && !is_float($value)) {
                        $fail("The {$attribute} must be an integer or float, not a string.");
                    }
                },
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}