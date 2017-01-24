<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  public static $validation_rules = [
    'name'  => 'required|unique:events|between:10,100',
		'start' => 'required|date_format:"Y-m-d H:i:s"',
		'finish' => 'date_format:"Y-m-d H:i:s"',
		'category_id' => 'required|numeric|exists:categories,id'
	];

	public static $validation_update_rules = [
    'name'  => 'unique:events|between:10,100',
		'start' => 'date_format:"Y-m-d H:i:s"',
		'finish' => 'date_format:"Y-m-d H:i:s"',
		'category_id' => 'numeric|exists:categories,id'
	];

  public static $validation_messages = [
    'required'  => 'The event :attribute field is required.',
    'unique'    => 'This event :attribute already exists.',
    'between'   => 'An event :attribute must be between :min - :max.',
    'date_format' => 'An event :attribute date must follow the format "2017-1-1 12:00:00".',
		'numeric'   => 'The Category ID must be a number.',
		'exists'    => 'This category ID does not exist.'
  ];
}
