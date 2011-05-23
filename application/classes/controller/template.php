<?php

abstract class Controller_Template extends Kohana_Controller_Template
{
    /**
     * @var View
     */
    public $template = 'layout';
    
    public function before()
    {
        parent::before();
        
        $this->template->styles = array(
            'styles/common.css',
            'styles/style.css',
        );
        $this->template->scripts = array(
            
        );
        
        
        $this->template->body = 'test';
        
        $this->template->set('header', View::factory('layout/header'));
        $this->template->set('footer', View::factory('layout/footer'));
        $this->template->header->menu = View::factory('layout/menu');
    }
}
