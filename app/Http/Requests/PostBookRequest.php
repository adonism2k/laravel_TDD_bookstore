<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        return [
            "isbn"            => ["required", "string", "size:13", "unique:books", "regex:/^[0-9]{13}$/"],
            "title"           => ["required", "string", "max:255"],
            "description"     => ["required", "string", "max:255"],
            "published_year"  => ["required", "numeric", "between:1900,2020"],
            "authors"         => ["required", "array", "min:1"],
            "authors.*"       => ["required", "numeric", "exists:authors,id", "distinct", "min:1"],
        ];
    }
}
