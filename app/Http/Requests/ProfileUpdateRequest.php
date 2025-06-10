<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'dni' => [
                'required',
                'string',
                'regex:/^[0-9]{7,8}$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'edad' => ['required', 'integer', 'min:18', 'max:100'],
            'telefono' => ['nullable', 'regex:/^[0-9]+$/', 'min:8', 'max:20'],

        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe contener entre 7 y 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.min' => 'Debes ser mayor de 18 años.',
            'edad.max' => 'La edad no puede ser mayor a 100 años.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'telefono.min' => 'El teléfono debe tener al menos 8 dígitos.',

        ];
    }
}
