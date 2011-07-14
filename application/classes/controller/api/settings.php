<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Settings extends Controller {

    /**
     * @var 
     * */
    protected $apiResponse;
    protected $apiRequest;

    public function before() {
        parent::before();

        /**
         * @todo Perform a security check. According to requirements, there are
         *      3 types of users: Account Creator, Admin User and Normal User.
         *      Only Account Creator and Admin User should be able.
         */
    }

    public function after() {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index() {
        $this->apiResponse = array(
            'result' => array(
                'message' => __('this is a response to the API settings request'),
            ),
            'error' => null,
        );
    }

}