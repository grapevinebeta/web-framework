<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Competition extends Controller_Template {
    
    public function before() {
        parent::before();
        
        $this->template->topOptions = View::factory('layout/top-options');
        $this->template->rightPanel = View::factory('layout/right-panel');

        if ($this->_location->package != 'pro') {
            die('Location package insufficient'); // @todo replace with fancy message
        }
    }
    
    public function after() {
        parent::after();
    }
    
    public function action_index() {
        $this->template->body = View::factory('competition/index');
    }
}
