<?php

namespace Modules\Admin\Http\Requests\Admin;

use Modules\Admin\Http\Requests\Request;

class AccessRequest extends Request
{
    /**
     * The access validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permission' => 'required',
        ];
    }

    /**
     * Allows all users to check site access.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
