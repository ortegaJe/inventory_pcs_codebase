<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cc' => 'required|unique:users,cc',
            'name' => 'required|unique:users,name',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'second_last_name' => 'nullable',
            //'nick_name' => 'required',
            'birthday' => 'nullable|date',
            'sex' => 'required',
            //'campu' => 'required',
            //'profile' => 'required',
            'phone_number' => 'nullable',
            'email' => 'required|email|unique:users,email',
        ];
    }
}
