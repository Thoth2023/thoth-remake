<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;

class UpdateMemberLevelRequest extends FormRequest
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
    public function rules()
    {
        $idProject = $this->route('idProject');
        $idMember = $this->route('idMember');

        return [
            'level_member' => [
                'required',
                'in:2,3,4',
                function ($attribute, $value, $fail) use ($idProject, $idMember) {
                    $project = Project::findOrFail($idProject);
                    $member = $project->users()->findOrFail($idMember);

                    if ($value == $member->pivot->level) {
                        $errorMessage = 'The member level cannot be the same as the current level.';
                        $fail($errorMessage);
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'level_member.required' => 'The member level is required.',
            'level_member.in' => 'Invalid member level.',
            'level_member.*' => $this->errorMessage,
        ];
    }
}
