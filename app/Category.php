<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public static $validation_rules = [
    'name' => 'required|alpha_num|unique:categories|between:3,25',
    'test' => 'required'
  ];

  public static $validation_messages = [
    'required'  => 'The category :attribute field is required.',
    'unique'    => 'This category :attribute already exists.',
    'between'   => 'A category :attribute must be between :min - :max.',
    'alpha_num' => 'A category :attribute must only contain letters and numbers.'
  ];
}
