<?php

namespace Modules\Admin\Http\Requests\Admin;

use Modules\Admin\Http\Requests\Request;

class PasswordRequest extends Request
{
    /**
     * The password validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ];
    }

    /**
     * Allows all users to reset passwords.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
