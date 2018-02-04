<?php

namespace App\Http\Requests;

class CommentRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'id' => 'required_without:reply_to|numeric|min:1',
                    'type' => 'required_without:reply_to|string',
                    'body' => 'required|string|min:2',
                    'reply_to' => 'numeric',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'id' => 'required|numeric|exists:comments,id',
                    'body' => 'required|string|min:2'
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
