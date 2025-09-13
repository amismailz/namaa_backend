<?php

namespace App\Http\Requests\API;

use App\Enums\GoalEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class HostingPlanRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required|string',
            'hosting_plan' => 'required|string|exists:hosting_plans,slug',
        ];
    }

    /**
     * Custom messages for validation errors (optional).
     */
    public function messages(): array
    {

        return [
            'name.required' =>  __('validation.required', ['attribute' => __('Name')]),
            'name.string' => __('validation.string', ['attribute' => __('Name')]),
            'email.required' => __('validation.required', ['attribute' => __('Email')]),
            'email.email' => __('validation.email', ['attribute' => __('Email')]),
            'phone.required' =>  __('validation.required', ['attribute' => __('Phone')]),
            'message.required' =>  __('validation.required', ['attribute' => __('Message')]),
            'message.string' => __('validation.string', ['attribute' => __('Message')]),
            'hosting_plan.required'      => __('validation.required', ['attribute' => __('Hosting Plan')]),
            'hosting_plan.string'      => __('validation.string', ['attribute' => __('Hosting Plan')]),
            'hosting_plan.exists'      => __('validation.exists', ['attribute' => __('Hosting Plan')]),
        ];
    }
}
