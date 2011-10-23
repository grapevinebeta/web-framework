<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Alerts extends Controller_Min {
    
    
    public function action_index() {
        
        $name = filter_var($this->request->param('name'), FILTER_SANITIZE_STRING);
        
        
         $this->template->body = View::factory('alerts/inbox');
         $this->template->body->alert = $name;
        
    }
    
}
