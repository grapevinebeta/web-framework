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
        $location_id = Session::instance()->get('location_id');
        if (!$location_id) {
            die('Location not found');
        }

        $location = ORM::factory('location')
                ->where('location_id','=',(int)$location_id)
                ->find();

        $this->_contentView = View::factory('account/users');

        $users = $location->getUsers();
        
        $this->_contentView->users = $users;
    }
    
    public function action_alerts()
    {
        // @todo This is only for development, replace this with actual location ID
        $location_id = Session::instance()->get('location_id');
        if (!$location_id) {
            die('Location not found');
        }
        
        // this assumes there is only one alert for specific location, storing
        // big text field content that is then processed by some other mechanism
        $alert = ORM::factory('alert')
                ->where('location_id', '=', (int)$location_id)
                ->find();
        
        $this->_contentView = View::factory('account/alerts', array(
            'alert' => $alert,
        ));
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
        
        $location_id = Session::instance()->get('location_id');
        
        if (!$location_id) {
            // @todo Only debugging, replace it
            die('No location found');
        }
        
        $settings = new Model_Location_Settings($location_id);
        
        $competitors = $settings->getSetting('competitor');
        
        $this->_contentView->competitors = $competitors;
        
    }

    public function action_socials()
    {
        $this->_contentView = View::factory('account/socials');
        
        
    }
    
    public function action_billing()
    {
        // @todo This is only for development. Replace it with actual location ID
        $location_id = Session::instance()->get('location_id');
        if (!$location_id) {
            die('Location not found');
        }
        
        $location = ORM::factory('location')
                ->where('location_id', '=', (int)$location_id)
                ->find();
        
        $this->_contentView = View::factory('account/billing', array(
            'billing_type' => $location->billing_type,
        ));
    }
    
    

} // End Welcome