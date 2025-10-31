<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAddMemberRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email_member' => 'required|email',
            'level_member' => 'required|integer|between:2,4',
        ];
    }

    public function messages(): array
    {
        return [
            'email_member.required' => __('project/projects.errors.email_required'),
            'email_member.email' => __('project/projects.errors.email_invalid'),

            'level_member.required' => __('project/projects.errors.level_required'),
            'level_member.integer' => __('project/projects.errors.level_integer'),
            'level_member.between' => __('project/projects.errors.level_between'),
        ];
    }
}
