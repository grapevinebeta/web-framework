<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller
{

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

        $no_auth = $this->request->post('no_auth');
        if (empty($no_auth)) {
            if (!Auth::instance()->logged_in()) {
                die('Unauthorized access'); // @todo replace it with proper message to the API client
            }


            $this->_current_user = Auth::instance()->get_user(); // cache currently logged in user

            // bind current user to every view
            View::bind_global('_current_user', $this->_current_user);

            // load first available location
            $this->_location = $this->_current_user->getLocations()->current();
        } else {
            $location_id = $this->request->post('loc');
            if (!empty($location_id)) {
                $this->_location = ORM::factory('location', $location_id);
            }
        }

        $this->_location_id = (int)$this->_location->id;
    }

    public function after()
    {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

}