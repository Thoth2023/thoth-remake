<?php
/**
 * File: StudyTypeUpdateRequest.php
 * Author: Auri Gabriel
 *
 * Description: This file is used to validate the request to update a study type.
 *
 * Date: 2024-03-09
 *
 * @see StudyType, StudyTypeController
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyTypeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_project' => 'required|string',
            'id_study_type' => 'required|string',
        ];
    }
}

