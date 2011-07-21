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
        $this->request->redirect('account/general');
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
        // @todo This is only for development, replace this with actual location ID
        $location_id = 1;

        $location = ORM::factory('location')
                ->where('location_id','=',(int)$location_id)
                ->find();

        $this->_contentView = View::factory('account/users');

        $users = $location->getUsers();
        
        $this->_contentView->users = $users;
    }
    
    public function action_alerts()
    {
        $this->_contentView = View::factory('account/alerts');
    }
    
    public function action_reports()
    {
        // @todo replace it with something actually meaningful
        $location_id = Session::instance()->get('location_id');

        $this->_contentView = View::factory('account/reports');

        // get currently assigned emails
        $emailsData = array();
        $emails = ORM::factory('email')
            ->where('location_id','=',(int)$location_id)
            ->find_all();
        foreach ($emails as $email){
            $emailsData[] = $email->email;
        }

        // assign emails to the view
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