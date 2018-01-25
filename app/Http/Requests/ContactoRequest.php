<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoRequest extends FormRequest
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
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'email' => 'required|email|max:255|unique:contactos,email',
            'movil' => 'required|regex:/^[0-9]+$/|min:6|max:15',
            'edad' => 'required',
            'ciudad' => 'required'
        ];
    }
}
