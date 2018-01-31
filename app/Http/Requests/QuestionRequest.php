<?php

namespace App\Http\Requests;

class QuestionRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'title' => 'required|string|min:10|max:80',
                    'body' => 'required|string|min:3'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|string|min:10|max:80',
                    'body' => 'required|string|min:3'
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

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
