<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserRequest extends FormRequest
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
     * @link https://laravel.com/docs/master/validation#available-validation-rules
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:255",
            "email" => "required|string|max:255|unique:users,email,{$this->route('user')}",
            "password" => "required|string|max:255",
            
        ];
    }

    /**
    * Get custom attributes for validator errors.
    *
    * @return array
    */
    public function attributes()
    {
        return trans('models/users.fields');
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function withValidator($validator)
    {
        //
    }
}
