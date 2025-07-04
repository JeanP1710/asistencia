<?php

namespace App\Http\Requests\Docente;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocenteRequest extends FormRequest
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
            'codigo'            => 'required|numeric|max_digits:15|unique:docentes,codigo',
            'numero_dni'        => 'required|numeric|max_digits:8|unique:docentes,numero_dni',
            'apellido_paterno'  => 'required|max:35|string',
            'apellido_materno'  => 'required|max:35|string',
            'nombres'           => 'required|max:35|string',
            'profesion_id'      => 'required|numeric',
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