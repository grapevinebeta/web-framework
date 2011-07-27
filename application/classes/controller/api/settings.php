<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Settings extends Controller_Api {

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
     * @todo Make it consistent with the way location is passed elsewhere
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
        $user_id = (int)Arr::path($data = $this->request->post(), 'params.user_id');
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
                    'id' => $user->id,
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
        $data = $this->request->post();

        // location has been assigned at earlier stage, at higher level
        $location = $this->_location;

        if (empty($location->id)) {
            /**
             * @todo Maybe create location here, if not found?
             */

            // Location not found
            $this->apiResponse['error'] = array(
                'message' => __('Location not found'),
            );
        } else {
            $this->apiResponse['result'] = array();
            $properties = array(
                'id',
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
        $location_id = $this->_location_id;

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
        $location_id = $this->_location_id;

        $post = array(
            'location_id' => $location_id,
        );
        $post = $post + $this->request->post();

        try {
            $email = ORM::factory('email')
                    ->values($post)
                    ->create();
            
            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('Email has been successfully added to the list'),
                'reports_emails_html'
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Email is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Email is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Delete email from the list of emails assigned to specific location
     */
    public function action_deleteemail() {

        /**
         * @todo Change it into something more flexible
         */
        $location_id = $this->_location_id;

        $email_address = Arr::path($this->request->post(), 'email');

        try {
            $email = ORM::factory('email')
                    ->where_open()
                        ->where('location_id','=',(int)$location_id)
                        ->and_where('email', '=', $email_address)
                    ->where_close()
                    ->find(); // assuming email addresses for single location are unique (do not appear more than once)

            $email->delete();

            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('Email has been successfully deleted'),
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Email has not been deleted'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Email has not been deleted'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
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
         * Location is determined on a different level now.
         * @todo Make it consistent with the other places where location is retrieved
         */
        $general_settings = $this->_location;

        // list of fields accepted for setting and for viewing in general settings
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

        try {
            if (!empty($general_settings->id)) {
                $general_settings
                    ->values($data)
                    ->update();
                //$this->apiResponse['result']['general_settings'] = array_intersect_key($general_settings->as_array(), array_flip($editable));
                $this->apiResponse['result']['general_settings'] = $general_settings->as_array();
            } else {
                $this->apiResponse['error']['message'] = __('Location has not been found');
            }

        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }
    
    /**
     * Action to add competitor into location settings
     */
    public function action_addcompetitor() {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;

        $competitor_name = Arr::path($this->request->post(), 'params.competitor');

        try {
            $competitor = ORM::factory('location_setting')
                    ->values(array(
                        'type' => 'competitor',
                        'value' => $competitor_name,
                        'location_id' => (int)$location_id,
                    ))
                    ->create();
            
            // get new list of competitors
            $settings = new Model_Location_Settings($location_id);
            $competitors = $settings->getSetting('competitor');
            
            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('New competitor has been successfully added to the list'),
                'competitors_list_html' => View::factory('account/competitors/list', array(
                    'competitors' => $competitors,
                ))->render(),
            );
        } catch (ORM_Validation_Exception $e) {
            $errors = array(
                'competitor' => Arr::get($e->errors('validation'),'value'),
            );
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $errors,
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }
    
    /**
     * Delete competitor from location settings
     */
    public function action_deletecompetitor() {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;

        $competitor_name = Arr::path($this->request->post(), 'params.competitor');

        try {
            $competitor = ORM::factory('location_setting')
                    ->where_open()
                        ->where('type','=','competitor')
                        ->and_where('location_id','=',(int)$location_id)
                        ->and_where('value','=',$competitor_name)
                    ->where_close()
                    ->find();
            
            if (!empty($competitor->id)) {
                // competitor exists
                $competitor->delete();
                
                // get new list of competitors
                $settings = new Model_Location_Settings($location_id);
                $competitors = $settings->getSetting('competitor');

                $this->apiResponse['result'] = array(
                    'success' => true,
                    'message' => __('New competitor has been successfully added to the list'),
                    'competitors_list_html' => View::factory('account/competitors/list', array(
                        'competitors' => $competitors,
                    ))->render(),
                );
            } else {
                // competitor does not exist
                
                // get new list of competitors
                $settings = new Model_Location_Settings($location_id);
                $competitors = $settings->getSetting('competitor');
                
                $this->apiResponse['result'] = array(
                    'success' => false,
                    'message' => __('Competitor has not been deleted'),
                    'competitors_list_html' => View::factory('account/competitors/list', array(
                        'competitors' => $competitors,
                    ))->render(),
                );
            }
            
            
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }
    
    /**
     * Update alert record for the specific location
     */
    public function action_updatealert() {

        $location_id = $this->_location_id;

        // list of fields editable by user
        $editable = array(
            'type',
            'criteria',
            'use_default',
        );
        $post = Arr::get($this->request->post(), 'params', array());

        // use only 'params' part of POST request to populate fields
        $data = array_intersect_key($post, array_flip($editable));
        $data['location_id'] = (int)$location_id;

        // assume only one alert record exists for a location
        $alert = ORM::factory('alert')
            ->where('location_id','=',(int)$location_id)
            ->find();

        try {
            if (!empty($alert->location_id)) {
                $alert
                    ->values($data)
                    ->update();
            } else {
                $alert
                    ->values($data)
                    ->create();
            }

            //$this->apiResponse['result']['general_settings'] = array_intersect_key($general_settings->as_array(), array_flip($editable));
            $this->apiResponse['result']['alert'] = $alert->as_array();
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }
    
    /**
     * Get alert data for specific location.
     */
    public function action_getalert() {

        /**
         * @todo Change it into something more flexible
         */
        $location_id = Session::instance()->get('location_id');
        if (!$location_id) {
            die ('Location not found');
        }
        
        // assume only one alert record exists for a location
        $alert = ORM::factory('alert')
            ->where('location_id','=',(int)$location_id)
            ->find();
        
        if (empty($alert->id)) {
            // if alert record does not exist, create one
            $alert->create();
        }
        
        $this->apiResponse['result'] = array(
            'alert' => $alert->as_array(),
        );
        
    }

    /**
     * Create or update user records, assigned to the location
     */
    public function action_updateuser() {

        /**
         * @todo Change it into something more flexible
         */
        $location_id = $this->_location_id;
        
        // find location record
        $location = ORM::factory('location')
                ->where('id', '=', (int)$location_id)
                ->find();

        $user_data = Arr::path($this->request->post(), 'params.user');
        
        // names of the fields editable by user
        $editable = array(
            'username',
            'email',
            'password',
            'firstname',
            'lastname',
            'phone',
            'password',
            'password_confirm',
        );

        try {
            if (!empty ($user_data['id'])) {
                // find user given by parameter
                $user = ORM::factory('user')->findUserForLocation((int)$user_data['id'], (int)$location_id);
            } else {
                // assume new user
                $user = ORM::factory('user');
            }
            
            // filter off the data that is not editable by user
            $user_data = array_intersect_key($user_data, array_flip($editable));
            
            if (!empty($user->id)) {
                // user already exists, update him
                $user
                    ->values($user_data)
                    ->update();
            } else {
                // user does not exist, create him
                $user
                    ->values($user_data)
                    ->create();
                // user has been created, now assign him to the location
                DB::insert('locations_users')
                    ->columns(array(
                        'user_id',
                        'location_id',
                    ))
                    ->values(array(
                        (int)$user->id,
                        (int)$location_id,
                    ))
                    ->execute();
            }

            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('User data has been successfully saved'),
                'user' => $user->as_array(),
                'users_html' => View::factory('account/users/list', array(
                    'users' => $location->getUsers(),
                ))->render(),
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('User data has not been saved'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('User data has not been saved'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }
        
    }
    
    /**
     * Delete user from location
     * @todo Decide what should really happen when the user is to be deleted.
     *      Should the user be deleted from the database, or just the access
     *      to the location settings should be removed? For now both things
     *      happen (user is deleted from the database and his/her association
     *      with the location is also revoked).
     * @todo Check permissions?
     */
    public function action_deleteuser() {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;
        
        // get the actual location object
        $location = ORM::factory('location')
                ->where('id', '=', (int)$location_id)
                ->find();

        $user_id = Arr::path($this->request->post(), 'params.user_id');

        try {
            
            $user = ORM::factory('user')
                    ->where('id', '=', (int)$user_id)
                    ->find();
            
            if (empty($user->id)) {
                // user not found, do not proceed
                $this->apiResponse['error'] = array(
                    'message' => __('User has not been found'),
                );
            } else {
                // user found
                $user->delete();
                
                DB::delete('locations_users')
                        ->where('location_id', '=', (int)$location_id)
                        ->and_where('user_id', '=', (int)$user_id)
                        ->execute();
                
                $this->apiResponse['result'] = array(
                    'message' => __('User has been successfully deleted'),
                    'users_html' => View::factory('account/users/list', array(
                        'users' => $location->getUsers(),
                    ))->render(),
                );
            }
            
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }
    
    
    public function action_facebook() {
        
        
        $location_id = $this->_location_id;
        $keys = array_keys($this->request->post());
        
        // clean previous settings instead of updating
        DB::delete('location_settings')
                ->where('type', 'IN', $keys)
                ->and_where('location_id', '=', $location_id)
                ->execute();
        
        $query = DB::insert('location_settings', array('type', 'value','location_id'));
        
        foreach($keys as $key) {
            
            $query->values(array(
            
                'type' => $key,
                'value' => $this->request->post($key),
                'location_id' => (int) $location_id,
            
            ));
            
        }
        
        try {
            $result = $query->execute();
            
            $this->apiResponse['result'] = true;
            
        } catch (Database_Exception $e) {
            
            $this->apiResponse['error'] = array(
                'message' => __('Error with database write'), // @todo add more details
                'error_data' => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }
        
        
        
    }

}