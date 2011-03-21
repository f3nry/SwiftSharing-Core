<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'alpha'         => ':field must contain only letters',
	'alpha_dash'    => ':field must contain only numbers, letters and dashes',
	'alpha_numeric' => ':field must contain only letters and numbers',
	'color'         => ':field must be a color',
	'credit_card'   => ':field must be a credit card number',
	'date'          => ':field must be a date',
	'decimal'       => ':field must be a decimal with :param2 places',
	'digit'         => ':field must be a digit',
	'email'         => ':field must be a email address',
	'email_domain'  => ':field must contain a valid email domain',
	'equals'        => ':field must equal :param2',
	'exact_length'  => ':field must be exactly :param2 characters long',
	'in_array'      => ':field must be one of the available options',
	'ip'            => ':field must be an ip address',
	'matches'       => ':field must be the same as :param2',
	'min_length'    => ':field must be at least :param2 characters long',
	'max_length'    => ':field must be less than :param2 characters long',
	'not_empty'     => ':field must not be empty',
	'numeric'       => ':field must be numeric',
	'phone'         => ':field must be a phone number',
	'range'         => ':field must be within the range of :param2 to :param3',
	'regex'         => ':field does not match the required format',
	'url'           => ':field must be a url',

    'username' => array(
        'not_empty' => 'Your username cannot be empty.',
        'username_exists' => 'That username is already in use.',
        'min_length' => 'Your usename must be longer than 4 characters.',
        'max_length' => 'Your username must be shorter than 20 characters.'
    ),

    'firstname' => array(
        'not_empty' => 'Your first name cannot be blank.'
    ),

    'lastname' => array(
        'not_empty' => 'Your last name cannot be blank.'
    ),

    'gender' => array(
        'not_empty' => 'You must select a gender.'
    ),

    'email1' => array(
        'email_exists' => 'The email address is already in use.',
        'email_domain' => 'The email address\'s domain is not valid. Please verify the email address.',
        'email' => 'The email address is not valid.',
        'matches' => 'The two email address do not match'
    ),

    'pass1' => array(
        'not_empty' => 'Your password cannot be empty.',
        'min_length' => 'Your password must be longer than 5 characters.',
        'max_length' => 'Your password must be shorter than 16 characters.',
        'matches' => 'The two passwords do not match.'
    ),

    'birth_month' => array(
        'digit' => 'You must select a birth month.',
        'not_empty' => 'You must select a birth month.'
    ),

    'birth_date' => array(
        'digit' => 'You must select a birth date.',
        'not_empty' => 'You must select a birth date.'
    ),
    
    'birth_year' => array(
        'digit' => 'You must select a birth year.',
        'not_empty' => 'You must select a birth year.'
    )
);
