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
            'styles/jqueryui/jquery-ui-1.8.13.custom.css'
        );
        $this->template->scripts = array(
            'js/jquery-1.6.min.js',
            'js/highcharts/highcharts.src.js',
            'js/jquery-ui-1.8.13.custom.min.js',
            'js/jquery.tipTip.min.js',
            'js/DataProvider.js',
            'js/Boxes.js',
        );
        
        $this->template->body = 'test';
        
        $this->template->set('header', View::factory('layout/header'));
        $this->template->set('footer', View::factory('layout/footer'));
        $this->template->header->menu = View::factory('layout/menu');
    }
}
