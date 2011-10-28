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

        if (count($this->request->post()) && !Auth::instance()->logged_in()) {
            // some data has been posted by not logged in user

            // get the user matching posted credentials
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), true);
            
            if ($user) {
                // credentials are ok
                
                // reindex locations - good to check it before first login
                Auth::instance()->get_user()->getLocationsList();
                
                $this->request->redirect(Route::url('frontpage'));
            } else {
                // credentials were incorrect
                $this->template->body = View::factory('session/new', array(
                    'error_message' => __('Username or password incorrect'),
                    'user' => $user,
                ));
            }
            
        } elseif (Auth::instance()->logged_in()) {
            // user is logged in
            // @todo Replace it with anything apropriate for such case
            Auth::instance()->logout();
            $this->request->redirect(Route::url('login')); // redirect to this action again
        } else {
            $user = ORM::factory('user')->values($this->request->post())->as_array();
            $this->template->body = View::factory('session/new', array(
                'user' => $user,
            ));
        }

    }

    /**
     * Logout process
     */
    public function action_destroy() {

        Auth::instance()->logout();
        $this->template->body = __('You have been logged out. <strong>:signin_link again.</strong>', array(
            ':signin_link' => HTML::anchor(Route::url('login'), __('Sign In')),
        ));

    }
    
}
