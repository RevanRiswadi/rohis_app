<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:20', 'unique:registrations,nisn'],
            'class' => ['required', 'string', 'max:50'],
            'major' => ['required', 'string', 'max:100'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'reason' => ['required', 'string'],
            'preferred_division' => ['required', 'string', 'max:100'],
        ];
    }
}
