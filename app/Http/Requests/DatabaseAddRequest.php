<?php
/**
 * File: DatabaseAddRequest.php
 * Author: Auri Gabriel
 *
 * Description: This is the request file for the project date add request.
 *
 * Date: 2024-03-09
 *
 * @see Project
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DateAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
