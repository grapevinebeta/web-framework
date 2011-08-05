<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Alerts extends Controller_Template {
    
    public function before() {
        parent::before();
        
        $this->template->topOptions = null;
        $this->template->rightPanel = null;
    }
    
    public function after() {
        parent::after();
    }
    
    public function action_index() {
        
        $name = filter_var($this->request->param('name'), FILTER_SANITIZE_STRING);
        
        $response = Request::factory('api/dataProvider/reviews/alerts')
                ->method(HTTP_Request::POST)
                ->post('status', $name)
                ->execute();
        
        var_dump($response); exit;
        
    }
    
}
