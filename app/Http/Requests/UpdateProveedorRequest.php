<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProveedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $proveedorId = $this->route('id');

        return [
            'nombre' => 'required|string|max:50|unique:proveedores,nombre,' . $proveedorId . ',idproveedor',
            'contacto' => 'required|string|max:10',
            'direccion' => 'required|string|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del proveedor es requerido.',
            'nombre.unique' => 'Este nombre de proveedor ya existe.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'contacto.required' => 'El contacto es requerido.',
            'contacto.max' => 'El contacto no puede exceder 10 caracteres.',
            'direccion.required' => 'La dirección es requerida.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.',
        ];
    }
}
