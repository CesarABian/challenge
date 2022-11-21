<?php

namespace App\Http\Requests\Api\Player;

use App\Http\Requests\Api\ApiFormRequest;

class UpdatePlayerRequest extends ApiFormRequest
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
                'string',
                'max:255',
                'sometimes',
                'required',
                'nullable',
            ],
            'last_name' => [
                'string',
                'max:255',
                'sometimes',
                'required',
                'nullable',
            ],
            'ability' => [
                'int',
                'min:0',
                'max:100',
                'sometimes',
                'required',
                'nullable',
            ],
            'force' => [
                'int',
                'min:0',
                'max:100',
                'sometimes',
                'required',
                'nullable',
            ],
            'velocity' => [
                'int',
                'min:0',
                'max:100',
                'sometimes',
                'required',
                'nullable',
            ],
            'reaction' => [
                'int',
                'min:0',
                'max:100',
                'sometimes',
                'required',
                'nullable',
            ],
            'genre' => [
                'string',
                'min:1',
                'max:1',
                'sometimes',
                'required',
                'nullable',
            ],
        ];
    }
}
