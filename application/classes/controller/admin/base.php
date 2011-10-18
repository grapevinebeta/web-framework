<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 10/3/11
 * Time: 4:49 AM
 */

class Admin_Controller_Base extends Kohana_Controller_Template
{
    /**
     * @var View
     */
    public $template = 'layout';

    function before()
    {
        if ($_SERVER['SERVER_NAME'] != 'grapevine.localhost') {
            die(":#@");
        }
        parent::before();
        $this->template->styles = array();
        $this->template->scripts = array();
        $this->template->header = '<style>.ajax-loader{display:none}</style>';
        $this->template->footer = '';
        ini_set('mongo.default_host', '50.57.109.174');
    }
}
