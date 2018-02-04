<?php

namespace App\Http\Requests;

class AnswerRequest extends Request
{
    public function rules()
    {
        switch ($this->method())
        {
            case 'POST':
            {
                return [
                    'question_id' => 'required|numeric|exists:questions,id',
                    'body' => 'required|string|min:2',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'body' => 'required|string|min:2',
                ];
            }
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
