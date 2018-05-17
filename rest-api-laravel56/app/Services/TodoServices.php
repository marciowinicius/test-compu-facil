<?php
/**
 * Created by PhpStorm.
 * User: Marcio
 * Date: 16/05/2018
 * Time: 16:41
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TodoServices
{
    public static $TYPE_SHOPPING = 'shopping';
    public static $TYPE_WORK = 'work';

    /**
     * Get all types
     * @return array
     */
    public function getTodoTypes()
    {
        return array(
            self::$TYPE_SHOPPING => 'shopping',
            self::$TYPE_WORK = 'work',
        );
    }

    /**
     * Function to validate input of Todo
     * @param $input
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public function validation($input)
    {
        $array = [
            'type' => [
                'required',
                Rule::in(self::getTodoTypes())
            ],
            'content' => 'required|string|max:250',
            'sort_order' => 'sometimes|required|integer',
            'done' => 'sometimes|required|boolean'
        ];
        return Validator::make($input, $array);
    }
}