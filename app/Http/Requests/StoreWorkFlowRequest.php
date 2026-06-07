<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkFlowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // no auth check
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'definition'        => ['required', 'array'],
            'definition.nodes'  => ['required', 'array'],
            'definition.edges'  => ['required', 'array'],

            'definition.nodes.*.id'             => ['required', 'integer'],
            'definition.nodes.*.type'           => ['required', 'string'],
            'definition.nodes.*.config'         => ['required', 'array'],
            'definition.nodes.*.config.message' => ['required', 'string'],
        ];
    }
}
