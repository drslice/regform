<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'not_empty'    => ':field can not be blank',
	'matches'      => ':field must be the same as :param1',
	'regex'        => ':field does not match the required format',
	'exact_length' => ':field must be exactly :param1 characters long',
	'min_length'   => ':field must be at least :param1 characters long',
	'max_length'   => ':field must be less than :param1 characters long',
	'in_array'     => ':field must be one of the available options',
	'digit'        => ':field must be a digit',
	'decimal'      => ':field must be a decimal with :param1 places',
	'range'        => ':field must be within the range of :param1 to :param2',
	'invalid'		=> ':field is invalid',
	'email'			=> ':field must be a valid email address',
	'username_available' => ':field is unavailable',
	'email_available' => ':field is unavailable',
	'name_available' => ':field is unavailable',
	'level_restricted' => ':field can not be changed due to account restrictions',
   	'Upload::not_empty'	=> ':field must be uploaded',
	'Upload::valid'		=> ':field is invalid',
   	'Upload::type'		=> ':field is an invalid type',
   	'Upload::size'		=> ':field is too large',
);