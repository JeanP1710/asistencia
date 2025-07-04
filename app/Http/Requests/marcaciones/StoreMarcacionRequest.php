<?php

namespace App\Http\Requests\marcaciones;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreMarcacionRequest extends FormRequest
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
            'numero_dni' => 'required|numeric',
            'fecha' => 'required|date',
            'hora'  => 'required'
        ];
    }
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $codigo = $this->input('codigo');

    //         if (strlen($codigo) == 8) {

    //             if (!DB::table('alumnos')->where('codigo', $codigo)->exists()) {
    //                 $validator->errors()->add('codigo', 'El código de 8 caracteres del alumno no existe.');
    //             }
    //         } else {
    //             if (!DB::table('docentes')->where('codigo', $codigo)->exists()) {
    //                 $validator->errors()->add('codigo', 'El código del docente no existe.');
    //             }
    //         }
    //     });
    // }
    public function messages()
    {
        return [
            'codigo.required' => 'Codigo Obligatorio',
            'sede_id.required' => 'Sede Obligatorio',
            'fecha_hora.required' => 'Fecha Hora Obligatorio',            
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'codigo.numeric'  => 'Solo Numeros',
            'unique' => 'El :nombre ya existe',
            'digits'  => 'Maximo :digits digitos',
        ];
    }

}