<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller_Template {
    
    public function before() {
        parent::before();

        $this->template->header = View::factory('layout/header_public');
    }

    /**
     * Login form
     */
    public function action_new() {

        $user = ORM::factory('user')->values($this->request->post())->as_array();

        $this->template->body = View::factory('session/new', array(
            'user' => $user,
        ));

    }

    /**
     * Logout process
     */
    public function action_destroy() {

        Auth::instance()->logout();
        $this->template->body = __('You have been logged out. :signin_link again.', array(
            ':signin_link' => HTML::anchor(Route::url('login'), __('Sign In')),
        ));

    }
    
}
