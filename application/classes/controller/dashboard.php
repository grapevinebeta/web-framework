<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dashboard extends Controller_Template {
    
    public function before() {
        parent::before();
        
        $this->template->topOptions = View::factory('layout/top-options');
        $this->template->rightPanel = View::factory('layout/right-panel');
    }
    
    public function after() {
        parent::after();
    }
    
    public function action_index() {
        $this->template->body = View::factory('dashboard/index');
    }
    
    public function action_test() {
        var_dump(Session::instance()->get('viewingRange'));
        die();
    }
    
}
