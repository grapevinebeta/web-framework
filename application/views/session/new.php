<?php defined('SYSPATH') or die('No direct script access.');

echo Form::open(Route::url('login'));
echo Form::input('username', Arr::get($user, 'username'), array(
    'placeholder' => __('Username'),
));
echo Form::password('password', null, array(
    'placeholder' => __('Password'),
));
echo Form::submit('', __('Login'));
echo Form::close();
