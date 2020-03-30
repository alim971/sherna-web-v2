<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title-1' => ['required', 'min:3', 'max:80'],
            'title-2' => ['required', 'min:3', 'max:80'],
            'description-1' => ['required', 'min:5', 'max:255'],
            'description-2' => ['required', 'min:5', 'max:255'],
            'content-1' => ['required', 'min:50'],
            'content-2' => ['required', 'min:50'],
        ];
    }
}
