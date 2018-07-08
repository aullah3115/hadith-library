<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBioBook extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'bio_author_id' => '',
            'bio_author_neo_id' => '',
            'name' => '',
        ];
    }
}
