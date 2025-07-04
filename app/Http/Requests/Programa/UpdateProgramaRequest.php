<?php

namespace App\Http\Requests\Programa;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramaRequest extends FormRequest
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
            'numero_dni'     => 'required|max:25|string|unique:programa,numero_dni,'.$this->id,
            'nombre'     => 'required|max:25|string|unique:menus,nombre,'.$this->id,
            'nombre'     => 'required|max:25|string|unique:menus,nombre,'.$this->id,
            'nombre'     => 'required|max:25|string|unique:menus,nombre,'.$this->id,
            'nombre'     => 'required|max:25|string|unique:menus,nombre,'.$this->id,
            'slug'       => 'required|max:25|string|unique:menus,slug,'.$this->id,
            'icono'      => 'required|max:25'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El valor ya existe'
        ];
    }

}