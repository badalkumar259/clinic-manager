<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'clinic_location' => 'nullable|string|max:255',
            'clinician_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:now',
            'status' => 'required',
        ];
    }
}
