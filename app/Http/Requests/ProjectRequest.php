<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'client_name' =>'required|min:3|max:100',
            'cover_image' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome del progetto è un campo obbligatorio',
            'name.min' => 'Il nome del progetto deve avere almeno :min caratteri',
            'name.max' => 'Il nome del progetto deve avere al massimo :max caratteri',

            'client_name.required' => 'Il nome del cliente è un campo obbligatorio',
            'client_name.min' => 'Il nome del cliente deve avere almeno :min caratteri',
            'client_name.max' => 'Il nome del ciente deve avere al massimo :max caratteri',

            'cover_image.image' => 'Il file dev\'essere un\'immagine',

        ];
    }
}
