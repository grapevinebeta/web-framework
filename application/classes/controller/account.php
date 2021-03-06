<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template {
    
    protected $_menuView;
    
    protected $_contentView;

    public function before() {
        parent::before();
        $this->template->scripts[] = 'js/Settings.js';
        $this->template->body = View::factory('account/body');
        $this->_menuView = View::factory('account/menu');

        // If the user is not allowed to see current location's settings, deny:
        if (!$this->_current_user->canManageLocation($this->_location)) {
            die('Permission denied'); // @todo replace it with some fancier message or redirect
        }
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
        $location_id = $this->request->post('loc');
        if (!empty($location_id)) {
            $this->_location = ORM::factory('location', $location_id);
        }
        
        $this->_contentView = View::factory('account/general', array(
            'location' => $this->_location,
            'user' => $this->_current_user,
        ));
    }
    
    public function action_users()
    {
        
        $location_id = $this->request->post('loc');
        if (!empty($location_id)) {
            $this->_location = ORM::factory('location', $location_id);
        }
        $location = $this->_location;

        $this->_contentView = View::factory('account/users', array(
            'users' => $location->getUsers(true), // only manageable users
            'location' => $location,
        ));
    }
    
    public function action_alerts()
    {
        $location_id = $this->_location_id;

        $default_alert_tags = Model_Alert::$default_tags;
        
        // this assumes there is only one alert for specific location, storing
        // big text field content that is then processed by some other mechanism
        $alert = ORM::factory('alert')
                ->where('location_id', '=', (int)$location_id)
                ->find();

        if (empty($alert->id)) {
            $alert = ORM::factory('alert')
                    ->values(array(
                        'location_id' => (int)$location_id,
                        'type' => 'grapevine',
                        'criteria' => (string)implode(', ', $default_alert_tags),
                    ))
                    ->create();
        }
        
        $this->_contentView = View::factory('account/alerts', array(
            'alert' => $alert,
            'default_alert_tags' => $default_alert_tags,
        ));
    }
    
    public function action_reports()
    {
        $location_id = $this->_location_id;

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
        $location_id = $this->_location_id;;

        $this->_contentView = View::factory('account/competitors');
        
        if (!$location_id) {
            // @todo Only debugging, replace it
            die('No location found');
        }
        
        $settings = new Model_Location_Settings($location_id);
        
        $competitors = $settings->getSetting('competitor');
        
        $companies = array();
        
        if(count($competitors)) {
            $companies = DB::select_array(array('id', 'name'))
                    ->from('companies')
                    ->where('id', 'IN', $competitors)
                    ->execute();

            /* @var $companies Database_Result_Cached|Kohana_Database */

            $companies = $companies->as_array('id', 'name');
        
        }
        
        $this->_contentView->competitors = $companies;
        
    }

    public function action_socials()
    {
        $twitter_search_settings = $this->_location->getSettings()->getSetting('twitter_search');
        $twitter_search = Arr::get($twitter_search_settings, 0);
        $this->_contentView = View::factory('account/socials', array(
            'location_id' => (int)$this->_location_id,
            'twitter_search' => $twitter_search,
        ));
    }
    
    public function action_billing()
    {
        $location = $this->_location;
        
        $this->_contentView = View::factory('account/billing', array(
            'billing_type' => $location->billing_type,
        ));
    }
    
    

} // End Welcome