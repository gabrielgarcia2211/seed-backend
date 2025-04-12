<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'activo' => 'required|boolean',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser menor que 0.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'activo.required' => 'El estado es obligatorio.',
            'activo.boolean' => 'El estado debe ser verdadero o falso.',
            'attachment.image' => 'El archivo adjunto debe ser una imagen.',
            'attachment.mimes' => 'El archivo adjunto debe ser un archivo de tipo: jpeg, png, jpg, gif, svg.',
            'attachment.max' => 'El archivo adjunto no puede superar los 2048 kilobytes.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validación fallida',
            'errors' => $validator->errors()
        ], 422));
    }
}
