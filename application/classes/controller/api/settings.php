<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Settings extends Controller_Api
{

    /**
     * @var array API response in the format it will be returned, for distinguishing
     *      between successful responses and errors
     * */
    protected $apiResponse
    = array(
        'result' => null,
        'error' => null,
    );
    protected $apiRequest;

    public function before()
    {
        parent::before();
        /**
         * @todo Perform a security check. According to requirements, there are
         *      3 types of users: Account Creator, Admin User and Normal User.
         *      Only Account Creator and Admin User should be able to access
         *      this controller.
         */
    }

    public function after()
    {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index()
    {

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
    public function action_get()
    {

        $request_data = $_REQUEST; // @todo change it into $_POST after debugging

        $params = Arr::get($request_data, 'params');

        // @todo replace it, if it will be stored on server side (eg. in session)
        $location_id = (int)Arr::get($params, 'location_id');

        $settings = new Model_Location_Settings($location_id);

        $types = Arr::get($params, 'types');

        $result = array();
        if (is_array($types)) {
            foreach (
                $types as $type
            ) {
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
    public function action_getuser()
    {
        $user_id = (int)Arr::path($data = $this->request->post(), 'params.user_id');
        $user = ORM::factory('user')
                ->where('id', '=', $user_id)
                ->find();
        if (empty($user->id)) {
            $this->apiResponse['error'] = array(
                'message' => __('User not found'),
            );
        } else {
            $this->apiResponse['result'] = array(
                'user'
                => array(
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
     * Get emails used for reports
     */
    public function action_getemails()
    {

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;

        $emails = ORM::factory('email')
                ->where('location_id', '=', (int)$location_id)
                ->find_all();

        $this->apiResponse['result'] = array(
            'emails' => array(),
        );

        foreach (
            $emails as $email
        ) {
            $this->apiResponse['result']['emails'][] = $email->email;
        }

        $this->apiResponse['result']['emails_html'] = View::factory(
            'account/_partials/reports_emails', array(
                'emails' => $this->apiResponse['result']['emails'],
            )
        )->render();

    }

    /**
     * Action to add email to the list of emails to which the report is being
     * sent.
     */
    public function action_addemail()
    {

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
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Email is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Delete email from the list of emails assigned to specific location
     */
    public function action_deleteemail()
    {

        /**
         * @todo Change it into something more flexible
         */
        $location_id = $this->_location_id;

        $email_address = Arr::path($this->request->post(), 'email');

        try {
            $email = ORM::factory('email')
                    ->where_open()
                    ->where('location_id', '=', (int)$location_id)
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
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Email has not been deleted'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Update the general settings
     */
    public function action_updategeneral()
    {

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
            'name',
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
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Action to add competitor into location settings
     * @deprecated This action has been disabled on request. It may be safely deleted.
     */
    public function action_addcompetitor()
    {
        die('Not available'); // @todo Remove if action should be re-enabled

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;

        $competitor_name = Arr::path($this->request->post(), 'params.competitor');

        try {
            $competitor = ORM::factory('location_setting')
                    ->values(
                array(
                    'type' => 'competitor',
                    'value' => $competitor_name,
                    'location_id' => (int)$location_id,
                )
            )
                    ->create();

            // get new list of competitors
            $settings = new Model_Location_Settings($location_id);
            $competitors = $settings->getSetting('competitor');

            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('New competitor has been successfully added to the list'),
                'competitors_list_html'
                => View::factory(
                    'account/competitors/list', array(
                        'competitors' => $competitors,
                    )
                )->render(),
            );
        } catch (ORM_Validation_Exception $e) {
            $errors = array(
                'competitor' => Arr::get($e->errors('validation'), 'value'),
            );
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $errors,
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Delete competitor from location settings
     * @deprecated This action has been disabled on request. It may be safely deleted.
     */
    public function action_deletecompetitor()
    {
        die('Not available'); // @todo Remove if action should be re-enabled

        // @todo dummy replacement, delete it and assign it from eg. session
        $location_id = $this->_location_id;

        $competitor_name = Arr::path($this->request->post(), 'params.competitor');

        try {
            $competitor = ORM::factory('location_setting')
                    ->where_open()
                    ->where('type', '=', 'competitor')
                    ->and_where('location_id', '=', (int)$location_id)
                    ->and_where('value', '=', $competitor_name)
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
                    'competitors_list_html'
                    => View::factory(
                        'account/competitors/list', array(
                            'competitors' => $competitors,
                        )
                    )->render(),
                );
            } else {
                // competitor does not exist

                // get new list of competitors
                $settings = new Model_Location_Settings($location_id);
                $competitors = $settings->getSetting('competitor');

                $this->apiResponse['result'] = array(
                    'success' => false,
                    'message' => __('Competitor has not been deleted'),
                    'competitors_list_html'
                    => View::factory(
                        'account/competitors/list', array(
                            'competitors' => $competitors,
                        )
                    )->render(),
                );
            }


        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Update alert record for the specific location
     */
    public function action_updatealert()
    {

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
                ->where('location_id', '=', (int)$location_id)
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
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Your data is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Get alert data for specific location.
     */
    public function action_getalert()
    {

        // assume only one alert record exists for a location
        $alert = ORM::factory('alert')
                ->where('location_id', '=', (int)$this->_location_id)
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
    public function action_updateuser()
    {
        

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
                $user = ORM::factory('user')->findUserForLocation((int)$user_data['id'], (int)$location_id, true);
            } else {
                // assume new user
                $user = ORM::factory('user');
            }

            if ((!empty($user_data['password'])) || (!empty($user_data['password_confirm']))) {
                // password given, check for password matching
                if (Arr::get($user_data, 'password') !== Arr::get($user_data, 'password_confirm')) {
                    // passwords do not match
                    $this->apiResponse['error'] = array(
                        'message' => __('User data has not been saved'), // @todo add more details
                        'error_data'
                        => array(
                            'code' => '(custom error)',
                            'message' => __('Error validating password'),
                        ),
                        'validation_errors'
                        => array(
                            'password' => __('Password and password confirmation do not match'),
                        ),
                    );
                    return; // do not allow further execution, error occured
                }
            } else {
                // no password given, delete both values from the data
                unset($user_data['password']);
                unset($user_data['password_confirm']);
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
                        ->columns(
                    array(
                        'user_id',
                        'location_id',
                        'level',
                    )
                )
                        ->values(
                    array(
                        (int)$user->id,
                        (int)$location_id,
                        (int)Model_Location::getAccessLevel('readonly'),
                    )
                )
                        ->execute();
                $user->addRole('login');
            }

            $this->apiResponse['result'] = array(
                'success' => true,
                'message' => __('User data has been successfully saved'),
                'user' => $user->as_array(), // @todo remove password showing
                'users_html'
                => View::factory(
                    'account/users/list', array(
                        'location' => $location,
                        'users' => $location->getUsers(true), // only manageable users
                    )
                )->render(),
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('User data has not been saved'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('User data has not been saved'), // @todo add more details
                'error_data'
                => array(
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
    public function action_deleteuser()
    {

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
                    'users_html'
                    => View::factory(
                        'account/users/list', array(
                            'location' => $location,
                            'users' => $location->getUsers(true), // only manageable users
                        )
                    )->render(),
                );
            }

        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }


    public function action_facebook()
    {


        $location_id = $this->_location_id;
        $keys = array_keys($this->request->post());

        // clean previous settings instead of updating
        DB::delete('location_settings')
                ->where('type', 'IN', $keys)
                ->and_where('location_id', '=', $location_id)
                ->execute();

        $query = DB::insert('location_settings', array('type', 'value', 'location_id'));

        $queue_extra = array();
        foreach (
            $keys as $key
        ) {

            $queue_extra[str_replace('facebook_', '', $key)] = $this->request->post($key);
            $query->values(
                array(

                    'type' => $key,
                    'value' => $this->request->post($key),
                    'location_id' => (int)$location_id,

                )
            );

        }

        try {
            $result = $query->execute();

            $queue = new Model_Queue($location_id, $this->_location->industry);
            $url = 'http://facebook.com/pages/' . $queue_extra['facebook_page_id'];
            $queue->add('facebook.com', $url, $queue_extra);
            $queue->save();

            $this->apiResponse['result'] = true;

        } catch (Database_Exception $e) {

            $this->apiResponse['error'] = array(
                'message' => __('Error with database write'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Visit it to be sent to the Twitter for authorization
     */
    public function action_twitterconnect()
    {

        // get ID of the location that should be influenced by callback
        $location_id = $this->request->param('location_id') ? (int)$this->request->param('location_id') : null;

        // get settings and create consumer object
        $config = Kohana::config('oauth.twitter');
        $consumer = OAuth_Consumer::factory($config);

        // create provider object
        $provider = OAuth_Provider::factory('twitter');

        // determine the callback URL and assign it
        $callback = Route::url(
            'oauth_twitter_callback', ($location_id ? array(
                'location_id' => $location_id,
            ) : null), true
        );
        $consumer->callback($callback);

        // determine the token needed
        $token = $provider->request_token($consumer);

        // store the token for further use
        Cookie::set('oauth_token', serialize($token));

        $this->request->redirect($provider->authorize_url($token));

        die(); // you should not reach this point, you should be redirected

    }

    /**
     * The action to be called by Twitter as OAuth callback, after redirected
     * from action_twitterconnect or similar request. Will check for validity
     * of the token and die() will be invoked if request will be invalid.
     * @todo fail gracefully if request was incorrect
     * @todo fail gracefully also if no location ID was given - or support such
     *      case in other way, if needed
     * @todo Move "add-delete settings" logic into Location_Settings model
     */
    public function action_twittercallback()
    {
        // get ID of the location that should be influenced by callback
        $location_id = $this->request->param('location_id') ? (int)$this->request->param('location_id') : null;

        // get request token from cookie; will return object or FALSE if not set
        $token = unserialize(Cookie::get('oauth_token'));
        // get token from callback URL; will return string or NULL if not set
        $request_token = Arr::get($_GET, 'oauth_token');

        // check if the token in cookie matches request token
        if ($token && $token->token !== $request_token) {
            // @todo Replace the following with something in case the request is incorrect
            die('Your request was incorrect.');
        } else {
            $verifier = Arr::get($_GET, 'oauth_verifier');
            $token->verifier($verifier);

            // get settings and create consumer object
            $config = Kohana::config('oauth.twitter');
            $consumer = OAuth_Consumer::factory($config);
            // create provider object
            $provider = OAuth_Provider::factory('twitter');
            /* @var $provider OAuth_Provider_Twitter */

            // get access token on the basis of request token
            $access_token = $provider->access_token($consumer, $token);
            // @todo If we need secret contained above, we can extract it also

            $access_token_secret = $access_token->secret;
            $access_token = $access_token->token;

            /**
             * At this point we should have $access_token containing access
             * token to the account of the specific user.
             */
            if ($location_id) {
                $queue_extras = array();
                // add access token to the given location
                // @todo Or should it replace access token even if there already
                //      exists at least one for given location?
                $location = ORM::factory('location')
                        ->where('id', '=', (int)$location_id)
                        ->find();

                if (empty($location->id)) {
                    // @todo fail gracefully
                    die('Location not found!');
                }

                // add access token to the database (does not replace existing ones)
                $twitter_oauth_token_secret = ORM::factory('location_setting')
                        ->values(
                    array(
                        'type' => 'twitter_oauth_token_secret',
                        'value' => (string)$access_token_secret,
                        'location_id' => (int)$location->id,
                    )
                )
                        ->create();
                // store for insert into queue
                $queue_extras['oauth_token_secret'] = (string)$access_token_secret;

                // find older tokens...
                $old_twitter_oauth_tokens = ORM::factory('location_setting')
                        ->where_open()
                        ->where('id', '!=', $twitter_oauth_token_secret->id)
                        ->and_where('location_id', '=', (int)$location->id)
                        ->and_where('type', '=', 'twitter_oauth_token_secret')
                        ->where_close()
                        ->find_all();

                // ... and delete them one-by-one
                foreach (
                    $old_twitter_oauth_tokens as $token
                ) {
                    $token->delete();
                }

                // add access token to the database (does not replace existing ones)
                $twitter_oauth_token = ORM::factory('location_setting')
                        ->values(
                    array(
                        'type' => 'twitter_oauth_token',
                        'value' => (string)$access_token,
                        'location_id' => (int)$location->id,
                    )
                )
                        ->create();

                // store for insert into queue
                $queue_extras['oauth_token'] = (string)$access_token;

                // find older tokens...
                $old_twitter_oauth_tokens = ORM::factory('location_setting')
                        ->where_open()
                        ->where('id', '!=', $twitter_oauth_token->id)
                        ->and_where('location_id', '=', (int)$location->id)
                        ->and_where('type', '=', 'twitter_oauth_token')
                        ->where_close()
                        ->find_all();

                // ... and delete them one-by-one
                foreach (
                    $old_twitter_oauth_tokens as $token
                ) {
                    $token->delete();
                }

                $twitter_account = new Model_TwitterAccount();
                $twitter_account->setAccessToken($access_token);
                $twitter_screen_name = $twitter_account->getScreenName();

                $twitter_account_name = ORM::factory('location_setting')
                        ->values(
                    array(
                        'type' => 'twitter_account',
                        'value' => (string)$twitter_screen_name,
                        'location_id' => (int)$location->id,
                    )
                )
                        ->create();
                // store for insert into queue
                $queue_extras['account'] = (string)$twitter_screen_name;
                // find old account names...
                $old_twitter_account_names = ORM::factory('location_setting')
                        ->where_open()
                        ->where('id', '!=', $twitter_account_name->id)
                        ->and_where('location_id', '=', (int)$location->id)
                        ->and_where('type', '=', 'twitter_account')
                        ->where_close()
                        ->find_all();

                // ... and delete one-by-one
                foreach (
                    $old_twitter_account_names as $account_name
                ) {
                    $account_name->delete();
                }

                // update queue
                $queue = new Model_Queue($location->id, $location->industry);
                $url = 'http://twitter.com/' . $twitter_screen_name;
                $queue->add('twitter.com', $url, $queue_extras);
                $queue->save();

                // redirect to settings page
                $this->request->redirect(Route::url('account_settings_social'));
            } else {
                die('Location could not have been identified!');
            }
        }

    }

    /**
     * Disconnect from specific social network
     */
    public function action_socialdisconnect()
    {

        try {

            $network = Arr::path($this->request->post(), 'params.network');

            $settings = new Model_Location_Settings((int)$this->_location->id);

            // find and delete settings associated with specific network
            $this->apiResponse['result']['success'] = $settings->disconnectNetwork($network);

        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
                'validation_errors' => $e->errors('validation'),
            );
        } catch (Database_Exception $e) {
            // This should not happen and should be handled by validation!
            $this->apiResponse['error'] = array(
                'message' => __('Competitor name is incorrect'), // @todo add more details
                'error_data'
                => array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ),
            );
        }

    }

    /**
     * Change location's access level
     * @todo Add standard AJAX try-catch blocks
     */
    public function action_changelocationlevel()
    {

        $user_id = Arr::path($this->request->post(), 'params.user_id');
        $level = Arr::path($this->request->post(), 'params.level');

        // find user for given location only if he can be managed
        $user = ORM::factory('user')->findUserForLocation($user_id, $this->_location->id, true);

        $this->apiResponse['result'] = array(
            'success' => $user->setAccessLevelForLocation($this->_location, $level),
            'users_html'
            => View::factory(
                'account/users/list', array(
                    'location' => $this->_location,
                    'users' => $this->_location->getUsers(true), // only manageable users
                )
            )->render(),
        );

    }

    /**
     * AJAX action to update Twitter search setting or create new, if does not
     * exist.
     */
    public function action_updatetwittersearch()
    {

        try {
            $data = $this->request->post();
            $twitter_search = Arr::path($data, 'params.twitter_search');

            $setting = ORM::factory('location_setting')
                    ->where('type', '=', 'twitter_search')
                    ->and_where('location_id', '=', $this->_location->id)
                    ->find();

            if (empty($setting->id)) {
                // creating new setting for current location
                $setting = ORM::factory('location_setting')
                        ->values(
                    array(
                        'location_id' => $this->_location->id,
                        'type' => 'twitter_search',
                        'value' => (string)$twitter_search,
                    )
                )
                        ->create();
            } else {
                // modifying old setting
                $setting->value = (string)$twitter_search;
                $setting->update();
            }

            // return updated setting
            $this->apiResponse['result'] = array(
                'twitter_search' => $setting->as_array(),
            );
        } catch (ORM_Validation_Exception $e) {
            $this->apiResponse['error'] = array(
                'validation_errors' => $e->errors(), // @todo add directory with messages
            );
        }

    }

}