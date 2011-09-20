<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template
{
    /**
     * @var View
     */
    public $template = 'layout';

    /**
     * Currently logged in user.
     * @var Model_User
     */
    protected $_current_user = null;

    /**
     * Location that has been accessed
     * @var Model_Location currently accessed location
     */
    protected $_location = null;

    /**
     * ID of the location. You should probably use $this->_location->id instead
     * @var int
     */
    protected $_location_id = null;

    /**
     * List of controller names that can be accessed by anonymous users
     * @var array
     */
    protected $_public_controllers = array(
        'resources',
        'session',
    );
    
    public function before()
    {
        parent::before();

        // salt the cookie (it is required for usage of Cookie::set())
        Cookie::$salt = Kohana::config('cookie.salt');
        
        /**
         * Check permissions to access specific controller while logged out
         * @todo Move it outside and apply also on API controllers for security
         */
        if (!in_array(strtolower($this->request->controller()), $this->_public_controllers) && !Auth::instance()->logged_in()) {
            // user must be logged in - he is accessing non-public controller while not logged in
            $this->request->redirect(Route::url('login'));
        } elseif (Auth::instance()->logged_in()) {
            // user is logged in - you can assign data based on specific user
            $this->_current_user = Auth::instance()->get_user(); // cache currently logged in user

            // bind current user to every view
            View::bind_global('_current_user', $this->_current_user);

            /**
             * @todo It must be replaced with some kind of Route parameter or
             *      maybe GET parameter - for now (before the final shape of the
             *      application and the relation between company account and
             *      the location clarifies) it and Controller_Api use the first
             *      location found in the database and accessible to user
             */
            $this->_location = $this->_current_user->getLocations(false)->current();

            // bind current location to every view
            View::bind_global('_current_location', $this->_location);
            $this->_location_id = (int)$this->_location->id;
            Session::instance()->set('location_id',$this->_location_id);
        } else {
            /**
             * @todo User went through the security checks, but is still logged
             *      out. Check here, whether the user is really allowed to
             *      access the application at this point
             */
        }
        
        
        $loc = $this->request->query('loc');
        
        if($loc)
            $js = 'api/box/location_js?loc=' . $loc;
        
        $viewingRange = Session::instance()->get('viewingRange');
        
        if (empty($viewingRange)) {
            
            $viewingRange = array(
                'period' => '1m',
                'date' => date('m/d/Y', strtotime('-1 month -1 day')),
                );
            
            Session::instance()->set('viewingRange', $viewingRange);
        }
        
        
        $this->template->styles = array(
            'styles/common.css',
            'styles/style.min.css',
            'styles/jqueryui/jquery-ui-1.8.13.custom.css',
            'styles/jquery.selectbox.css',
            'styles/tipTip.css',
//            'styles/colorbox/colorbox.css',
            'styles/datepicker.css',
        );
        // notice that we use minified versions of all scripts, for dev remove .min
        $this->template->scripts = array(
            'js/common.js', // adds some common functions
            'js/DataProvider.js',
            'js/Boxes.js', // minified version of Boxes.js
            'js/TopMenu.min.js',
            'js/highcharts/highcharts.js',
            'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js',
            'js/jquery.tipTip.min.js',
//            'js/colorbox/jquery.colorbox-min.js',
            'js/jquery.selectbox.pack.js',
            'js/highcharts/modules/exporting.js',
            'js/datepicker.min.js',
        );
        
        if($loc)
            array_unshift($this->template->scripts, $js);

        if (Auth::instance()->logged_in()) {
            $this->template->set('header', View::factory('layout/header'));
        } else {
            $this->template->set('header', View::factory('layout/header_public'));
        }
        $this->template->set('footer', View::factory('layout/footer'));
        $this->template->header->menu = View::factory('layout/menu');
    }
}
