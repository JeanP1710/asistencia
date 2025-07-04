<?php

namespace App\Http\Requests\Reporte;

use Illuminate\Foundation\Http\FormRequest;

class BuscarReportRequest extends FormRequest
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

            'programa_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo es obligatorio.',
            'FECHA.date' => 'El campo FECHA debe ser una fecha válida.',
            'codigo.max' => 'El campo CODIGO no debe exceder los :max caracteres.',
            'persona_id.exists' => 'El valor seleccionado para el campo persona_id no es válido.',
            'CURSO_TOMADO.required' => 'El campo CURSO_TOMADO es obligatorio.',
            'CURSO_TOMADO.string' => 'El campo CURSO_TOMADO debe ser una cadena de caracteres.',
            'CURSO_TOMADO.max' => 'El campo CURSO_TOMADO no debe exceder los :max caracteres.',
            'LUGAR.required' => 'El campo LUGAR es obligatorio.',
            'LUGAR.string' => 'El campo LUGAR debe ser una cadena de caracteres.',
            'LUGAR.max' => 'El campo LUGAR no debe exceder los :max caracteres.',
            'string' => 'El campo debe ser una cadena de caracteres.',
            
        ];
    }

}