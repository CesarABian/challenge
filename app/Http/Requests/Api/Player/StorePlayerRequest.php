<?php

namespace App\Http\Requests\Api\Player;

use App\Http\Requests\Api\ApiFormRequest;

class StorePlayerRequest extends ApiFormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'ability' => [
                'required',
                'int',
                'min:0',
                'max:100',
            ],
            'force' => [
                'required',
                'int',
                'min:0',
                'max:100',
            ],
            'velocity' => [
                'required',
                'int',
                'min:0',
                'max:100',
            ],
            'reaction' => [
                'required',
                'int',
                'min:0',
                'max:100',
            ],
            'genre' => [
                'required',
                'string',
                'min:1',
                'max:1',
            ],
        ];
    }
}
