<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Settings extends Controller {

    /**
     * @var array API response in the format it will be returned, for distinguishing
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
        $data = $_GET; // @todo for debugging only; replace with POST data
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

    /**
     * Get general location settings.
     */
    public function action_getgeneral() {
        $data = $_GET; // @todo For debugging only; replace with POST data
        // $data = $this->request->post();

        // @todo Change location ID to be assigned as needed
        $location_id = 1;

        $location = ORM::factory('location')
                //->where('location_id', '=', $location_id)
                ->find();
        if (empty($location->location_id)) {
            // Location not found
            $this->apiResponse['error'] = array(
                'message' => __('Location not found'),
            );
        } else {
            $this->apiResponse['result'] = array();
            $properties = array(
                'owner_name',
                'owner_email',
                'owner_phone',
                'owner_ext',
                'location_name',
                'address1',
                'address2',
                'city',
                'state',
                'zip',
                'phone',
                'url',
            );
            foreach ($properties as $property_name) {
                $this->apiResponse['result'][$property_name] = $location->$property_name;
            }
        }
    }

    /**
     * Get emails used for reports
     */
    public function action_getemails() {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = 1;

        $emails = ORM::factory('email')
                ->where('location_id', '=', (int)$location_id)
                ->find_all();

        $this->apiResponse['result'] = array(
            'emails' => array(),
        );

        foreach ($emails as $email) {
            $this->apiResponse['result']['emails'][] = $email->email;
        }

        $this->apiResponse['result']['emails_html'] = View::factory('account/_partials/reports_emails', array(
            'emails' => $this->apiResponse['result']['emails'],
        ))->render();

    }

    /**
     * Action to add email to the list of emails to which the report is being
     * sent.
     */
    public function action_addemail() {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = 1;

        $email_id = time()-1310968430; // @todo implement AUTO_INCREMENT in the database, now it fails PRIMARY KEY check

        $post = array(
            'location_id' => $location_id,
            'email_id' => $email_id,
        );
        $post = $post + $this->request->post();

        try {
            $email = ORM::factory('email')
                    ->values($post)
                    ->create();
            
            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('Email has been successfully added to the list'),
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Email is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Email is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(). '['.time().']',
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Update the general settings
     */
    public function action_updategeneral() {

        /**
         * @todo Change it into something more flexible
         */
        $location_id = 1;

        $editable = array(
            'owner_name',
            'owner_email',
            'owner_phone',
            'owner_ext',
            'location_name',
            'address1',
            'address2',
            'city',
            'state',
            'zip',
            'phone',
            'url',
        );
        $data = array_intersect_key($this->request->post(), array_flip($editable));

        $general_settings = ORM::factory('location')
            ->where('location_id','=',(int)$location_id)
            ->find();

        if (!empty($general_settings->location_id)) {
            $general_settings
                ->values($data)
                ->update();
        } else {
            $general_settings
                ->values($data)
                ->create();
        }

        // get settings again
        $general_settings = ORM::factory('location')
            ->where('location_id','=',(int)$location_id)
            ->find();

        //$this->apiResponse['result']['general_settings'] = array_intersect_key($general_settings->as_array(), array_flip($editable));
        $this->apiResponse['result']['general_settings'] = $general_settings->as_array();

    }

}