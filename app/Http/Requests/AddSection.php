<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSection extends FormRequest
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
            'book_id' => '',
            'parent_id' => '',
            'name' => 'required',
            'position' => '',
            'has_hadith' => '',
            'has_section' => ''
        ];
    }
}
