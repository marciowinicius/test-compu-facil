<?php
/**
 * Created by PhpStorm.
 * User: Marcio
 * Date: 16/05/2018
 * Time: 16:41
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class UserServices
{
    public function validation($input)
    {
        return Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
    }
}