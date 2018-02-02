<?php

namespace App\Http\Requests;

class AnswerRequest extends Request
{
    public function rules()
    {
        return [
            'question_id' => 'required|numeric|exists:questions,id',
            'body' => 'required|string|min:2',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
