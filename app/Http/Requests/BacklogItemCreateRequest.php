<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class BacklogItemCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => 'required|string',
            'activity' => 'required|string',
            'story_point' => 'required|integer',
            'project_id' => 'required|integer',
            'sprint_id' => 'integer',
            'type' => 'required|string',
            'status' => 'integer',
            'user_id' => 'integer'
        ];
    }
}
