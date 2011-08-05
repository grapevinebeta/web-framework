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
    
    public function before()
    {
        parent::before();

        // salt the cookie (it is required for usage of Cookie::set())
        Cookie::$salt = Kohana::config('cookie.salt');

        /**
         * This is a temporary solution to force login of some user. In the
         * future it should happen on different basis.
         * @todo Replace it with actual authentication process
         */
        $user = ORM::factory('user')->find(); // find the first available user
        Auth::instance()->force_login($user->username); // force login
        $this->_current_user = ORM::factory('user')
                ->where('username', '=', Auth::instance()->get_user())
                ->find(); // cache currently logged in user

        // bind current user to every view
        View::bind_global('_current_user', $this->_current_user);

        $this->_location = $this->_current_user->getLocations()->current();

        $this->_location_id = (int)$this->_location->id;
        
        
        
        $viewingRange = Session::instance()->get('viewingRange');
        
        if (empty($viewingRange)) {
            $viewingRange = array(
                'period' => '1m',
                'date' => date('m/d/Y'),
                );
            Session::instance()->set('viewingRange', $viewingRange);
        }
        
        $this->template->styles = array(
            'styles/common.css',
            'styles/style.css',
            'styles/jqueryui/jquery-ui-1.8.13.custom.css',
            'styles/jquery.selectbox.css',
            'styles/tipTip.css',
            'styles/colorbox/colorbox.css',
            'styles/mask/jquery.loadmask.css',
        );
        $this->template->scripts = array(
            'js/jquery-1.6.min.js',
            'js/highcharts/highcharts.src.js',
            'js/flowplayer/flowplayer-3.2.6.min.js',
            'js/jquery-ui-1.8.13.custom.min.js',
            'js/jquery.tipTip.min.js',
            'js/colorbox/jquery.colorbox-min.js',
            'js/jquery.selectbox.js',
            'js/DataProvider.js',
            'js/highcharts/modules/exporting.js',
            'js/jquery.loadmask.min.js',
            'js/jquery.livequery.js',
            'js/Boxes.js',
            'js/TopMenu.js',
            'js/common.js', // adds some common functions
            'js/Settings.js',
        );
        
        $this->template->body = 'test';
        
        $this->template->set('header', View::factory('layout/header'));
        $this->template->set('footer', View::factory('layout/footer'));
        $this->template->header->menu = View::factory('layout/menu');
    }
}
