<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

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

    public function before() {
        parent::before();

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

        // load first available location
        $this->_location = $this->_current_user->getLocations()->current();

        $this->_location_id = (int)$this->_location->id;
    }

    public function after() {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

}