<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Settings extends Controller {

    /**
     * @var API response in the format it will be returned, for distinguishing
     *      between successful responses and errors
     * */
    protected $apiResponse = array(
        'result' => null,
        'error' => null,
    );
    protected $apiRequest;

    public function before() {
        parent::before();

        /**
         * @todo Perform a security check. According to requirements, there are
         *      3 types of users: Account Creator, Admin User and Normal User.
         *      Only Account Creator and Admin User should be able to access
         *      this controller.
         */
    }

    public function after() {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index() {

        // @todo The following is only for testing, replace it
//        $settings = new Model_Location_Settings(1);
//
//        echo '<pre>',var_dump($settings),'</pre>';
//
//        die();

        $this->apiResponse['result'] = array(
            'message' => __('this is a response to the API settings request'),
        );
    }

    /**
     * Returns settings that are associated with specific location and have
     * specific type.
     */
    public function action_get() {

        $request_data = $_REQUEST; // @todo change it into $_POST after debugging

        $params = Arr::get($request_data, 'params');

        // @todo replace it, if it will be stored on server side (eg. in session)
        $location_id = (int)  Arr::get($params, 'location_id');

        $settings = new Model_Location_Settings($location_id);

        $types = Arr::get($params, 'types');
        
        $result = array();
        if (is_array($types)) {
            foreach ($types as $type) {
                $result[$type] = $settings->getSetting($type);
            }
        } else {
            // return just all the settings that were loaded
            $result = $settings->getSetting($types);
        }

        $this->apiResponse['result'] = array(
            'location_settings' => $result,
        );

    }

    /**
     * Get data about the specific user
     * @todo Apply security - for now any user can be retrieved
     */
    public function action_getuser() {
        $data = $_GET;
        //$data = $this->request->post();
        $user_id = (int)Arr::path($data, 'params.user_id');
        $user = ORM::factory('user')
                ->where('id','=',$user_id)
                ->find();
        if (empty($user->id)) {
            $this->apiResponse['error'] = array(
                'message' => __('User not found'),
            );
        } else {
            $this->apiResponse['result'] = array(
                'user' => array(
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'username' => $user->username,
                ),
            );
        }
    }

}