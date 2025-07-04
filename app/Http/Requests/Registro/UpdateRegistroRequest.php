<?php

namespace App\Http\Requests\Registro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistroRequest extends FormRequest
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
            'dni' => 'required|string|digits:8',
            'ape_paterno' => 'required|string',
            'ape_materno' => 'required|string',
            'nombres' => 'required|string',
            'tipo' => 'required|string',
            'fecha' => 'required|date',
            'codigo' => 'required|string|max:10',
            'persona_id' => 'nullable|exists:personas,id',
            'curso_tomado' => 'required|string|max:50',
            'lugar' => 'required|string|max:100',
            'comentario' => 'nullable|string',
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