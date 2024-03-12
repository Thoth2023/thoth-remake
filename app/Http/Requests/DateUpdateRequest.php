<?php
/**
 * File: DateUpdateRequest.php
 * Author: Auri Gabriel
 *
 * Description: This file is used to validate the request for updating the date of a project.
 *
 * Date: 2024-03-09
 *
 * @see Project
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DateUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }
}
