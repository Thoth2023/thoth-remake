<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255|regex:/^[a-zA-Z0-9]+$/',
            'description' => 'required|string',
            'objectives' => 'required|string',

            'copy_planning' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value !== 'none' && !(Project::where('id_project', $value)->exists())) {
                    $fail('The selected :attribute is invalid.');
                }
            }],
            'feature_review' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field must not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            'objectives.required' => 'The objectives field is required.',
            'objectives.string' => 'The objectives field must be a string.',
            'feature_review.required' => 'feature review is required field',
            'feature_review.string' => 'feature review is must string,'
        ];
    }
}
