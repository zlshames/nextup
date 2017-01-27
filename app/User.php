<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $hidden = [
    'password',
  ];

  public static $validation_rules = [
    'username'  => 'required|unique:users,username|alpha_dash|between:3,32',
		'email' 		=> 'required|unique:users,email|email',
		'password'  => 'required|confirmed|between:6,60'
	];

	public static $validation_update_rules = [
    'username'  => 'unique:users,username|between:3,32',
		'email' 		=> 'unique:users,email|email',
		'password'  => 'confirmed|between:6,60'
	];

  public static $validation_messages = [
    'required'   => 'The :attribute field is required.',
    'unique'     => 'This :attribute already exists.',
    'between'    => 'A(n) :attribute must be between :min - :max.',
		'email'      => 'Invalid :attribute format.',
		'alpha_dash' => 'The :attribute field must only contain letters and hyphens.'
  ];
}
