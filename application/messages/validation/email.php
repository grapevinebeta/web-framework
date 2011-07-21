<?php defined('SYSPATH') or die('No direct script access.');

return array(

    'email' => array(
        'min_length' => __('Email address is too short'),

        'is_unique_for_location' => __('This email address has already been assigned to this location.'),
    ),

);