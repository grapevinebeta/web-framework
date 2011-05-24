<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template {
    
    protected $_menuView;
    
    protected $_contentView;

    public function before() {
        parent::before();
        $this->template->body = View::factory('account/body');
        $this->_menuView = View::factory('account/menu');
    }
    
    public function after() {
        $this->template->body->menu = $this->_menuView;
        $this->template->body->content = $this->_contentView;
        parent::after();
    }

    public function action_index()
    {
        $this->response->body('hello, world!');
    }
    
    public function action_logout() {
        Auth::instance()->logout();
        $this->request->redirect(url::base());
    }
    
    public function action_general()
    {
        $this->_contentView = View::factory('account/general');
    }
    
    public function action_users()
    {
        $this->_contentView = View::factory('account/users');
        
        // temporary
        $usersData = array(
            array('id' => 1, 'name' => 'Jacek Kromski', 'role' => 'admin'),
            array('id' => 2, 'name' => 'Tomasz Jaśkowski', 'role' => 'admin'),
            array('id' => 3, 'name' => 'Richard Ortega', 'role' => 'admin'),
            array('id' => 4, 'name' => 'John Kowalski', 'role' => 'user'),
        );
        $this->_contentView->users = $usersData;
    }
    
    public function action_alerts()
    {
        $this->_contentView = View::factory('account/alerts');
    }
    
    public function action_reports()
    {
        $this->_contentView = View::factory('account/reports');
        $emailsData = array(
            'jacek.kromski@polcode.com',
            'tomasz.jaskowski@polcode.com',
        );
        $this->_contentView->emails = $emailsData;
    }
    
    public function action_competitors()
    {
        $this->_contentView = View::factory('account/competitors');
        $competitorsData = array(
            array('id' => 1, 'name' => 'Jacek Kromski', 'active' => 1),
            array('id' => 2, 'name' => 'Tomasz Jaśkowski', 'active' => 0),
            array('id' => 3, 'name' => 'Richard Ortega', 'active' => 1),
            array('id' => 4, 'name' => 'John Kowalski', 'active' => 0),
        );
        $this->_contentView->competitors = $competitorsData;
        
    }

    public function action_socials()
    {
        $this->_contentView = View::factory('account/socials');
        
        
    }
    
    public function action_billing()
    {
        $this->_contentView = View::factory('account/billing');
    }
    
    

} // End Welcome