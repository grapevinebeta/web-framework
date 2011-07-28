<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Box extends Controller_Api {

    /**
     * @var 
     * */
    protected $apiResponse;
    protected $apiRequest;

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
    
    public function action_move() {
        
        $collection = $this->request->post('holders');
        
        $box = Model::factory('box');
        /* @var $box Model_Box */
        
        foreach($collection as $holder_id => $data) {
            
            $deletePrevious = isset($data['delete_previous']) ? $data['delete_previous'] : false;
            if($deletePrevious) {
                unset($data['delete_previous']);
            }
            
            
            $box->updateByBoxHolderId($holder_id, $data, $deletePrevious);
            
        }
        
    }
    
    public function action_positions() {
        
        $id = $this->request->param('id'); // section id
        
        $b = Model::factory('box');
        
        $rs = $b->getPositions($this->_location_id, $id);
        
        if(count($rs))
        {
            $this->apiResponse = $rs->as_array('holder_id');
        }
        else 
        {    

            $holders = $this->request->post('holders');

            try {
                $b->persists($holders);

                $rs = $b->getPositions($this->_location_id, $id);
                $this->apiResponse = $rs->as_array('holder_id');

            }
            catch(Exception $e) {

                throw $e;

            }
        
        }
        
    }
    
    public function action_auth() {
        
        
        // return url for twitter
        Session::instance()->set('return_url', Url::site($this->request->referrer(), true));
        
        $s = new Model_Location_Settings($this->_location_id);
        $page = $s->getSetting('facebook_page_name');
        $screen = $s->getSetting('twitter_account');
        $this->apiResponse = array(
            
            'appId' => (int) Kohana::config('globals.facebook_app_id'),
            'facebook_page_name' => Arr::get($page, '0', false),
            
        );
        
        if ($screen) {
            $this->apiResponse['twitter_account'] = Arr::get($screen, '0', false);
        } else {
            $this->apiResponse['twitter_url'] = $this->getTwitterUrl();
        }
        
    }
    
    
    private function fetchUser($id) {
        
        
        $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => Kohana::config('globals.twitter_consumer_key'),
                    'consumer_secret' => Kohana::config('globals.twitter_consumer_secret'),
                ));
        
        $code = $tmhOAuth->request('GET', $tmhOAuth->url('/1/users/lookup'), array('user_id' => $id));
        
        if($code == 200) {
            
            $user = json_decode($tmhOAuth->response['response']);
            
            return $user[0];
            
        }
        
        return false;
        
    }
    
    public function action_callback() {
        $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => Kohana::config('globals.twitter_consumer_key'),
                    'consumer_secret' => Kohana::config('globals.twitter_consumer_secret'),
                ));

        if ($this->request->query('oauth_verifier') && Session::instance()->get('oauth')) {

            $tmhOAuth->config['user_token'] = Arr::path($_SESSION, 'oauth.oauth_token');
            $tmhOAuth->config['user_secret'] = Arr::path($_SESSION, 'oauth.oauth_secret');

            $code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/access_token', ''), 
                    array(
                        'oauth_verifier' => $this->request->query('oauth_verifier')
                    ));
            
            if($code == 200) {

                $response = $tmhOAuth->extract_params($tmhOAuth->response['response']);
                
                $location_id = $this->_location_id;
                $keys = array('oauth_token', 'oauth_token_secret', 'user_id', 'screen_name');
                
                

                // clean previous settings instead of updating
                DB::delete('location_settings')
                        ->where('type', 'IN', $keys)
                        ->and_where('location_id', '=', $location_id)
                        ->execute();

                $query = DB::insert('location_settings', array('type', 'value', 'location_id'));

                $mappings = array(
                    
                    'screen_name' => 'twitter_account',
                    'oauth_token' => 'twitter_oauth_token',
                    'oauth_token_secret' => 'twitter_oauth_token_secret',
                    'user_id' => 'twitter_user_id',
                    
                );
                
                
                foreach ($keys as $key) {

                    $query->values(array(
                        'type' => isset($mappings[$key]) ? $mappings[$key] : $key,
                        'value' => $response[$key],
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
                
                Session::instance()->delete('oauth');
                $this->request->redirect(Session::instance()->get('return_url'));
                
            }
        }
    }
    
    private function getTwitterUrl() {
        
        $tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => Kohana::config('globals.twitter_consumer_key'),
            'consumer_secret' => Kohana::config('globals.twitter_consumer_secret'),
        ));
        
        $params = array();
        $params['x_auth_access_type'] = 'write';
        $params['oauth_callback'] = Kohana::config('globals.oauth_callback');

        $code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', ''), $params);
        
        if($code == 200) {
            
            Session::instance()->set('oauth', $tmhOAuth->extract_params($tmhOAuth->response['response']));
            $method = isset($_REQUEST['authenticate']) ? 'authenticate' : 'authorize';
            $force = isset($_REQUEST['force']) ? '&force_login=1' : '';
            $token = Arr::path($_SESSION, 'oauth.oauth_token');
            $authurl = $tmhOAuth->url("oauth/{$method}", '') . "?oauth_token={$token}{$force}";
            return $authurl;
            
        }
        
        return false;
        
    }
    
    private function sendTwitter($message, $config) {
        
        $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => Kohana::config('globals.twitter_consumer_key'),
                    'consumer_secret' => Kohana::config('globals.twitter_consumer_secret'),
                    'user_token' => $config['twitter_token'],
                    'user_secret' => $config['twitter_secret'],
                ));

        $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
                    'status' => $message['message']
                ));

        return json_decode($tmhOAuth->response['response']);
        
        
    }
    
    private function sendFacebook($message, $config) {

        $fb = new Facebook($config);
        $fb->setAccessToken($config['facebook_token']);
        
        
        try {
            return $fb->api($page[0] . '/feed', 'POST', $message);
        } catch (FacebookApiException $e) {
            return $e;
        }
    }
    

    public function action_update() {

        $settings = false;
        $post = array();
        
        $s = new Model_Location_Settings($this->_location_id);
        $fbtoken = $s->getSetting('facebook_oauth_token');
        $page = $s->getSetting('facebook_page_id');
        
        $twitterToken = $s->getSetting('twitter_oauth_token');
        $twitterSecret = $s->getSetting('twitter_oauth_token_secret');
        
        $config = array(
            'appId' => Kohana::config('globals.facebook_app_id'),
            'secret' => Kohana::config('globals.facebook_secret'),
        );
        
        $callbacks = array('facebook' => 'sendFacebook', 'twitter' => 'sendTwitter');
        $callbacks = array_intersect_key($callbacks, $this->request->post());
        
        if(isset($fbtoken[0])) {
            
            $config['facebook_token'] = $fbtoken[0];
            
        }
        else {
            unset($callbacks['facebook']);
        }
        
        if(isset($twitterToken[0]) && isset($twitterSecret[0])) {
            
            $config['twitter_token'] = $twitterToken[0];
            $config['twitter_secret'] = $twitterSecret[0];
            
        }
        else {
            unset($callback['twitter']);
        }

        $post['message'] = strip_tags($this->request->post('message'));
        $post['name'] = 'Grapevine update';

        
        foreach($callbacks as $key => $call) {
            $this->apiResponse[$key] 
                    = call_user_func_array(array($this, $call), array($post, $config));
        }


    }
    
    public function action_export() {



        $markup = View::factory('_partials/export_template', array(
                    'html' => $this->request->post('html'),
                ));

        $apiKey = Kohana::config('globals.api_key');
        $url = sprintf(Kohana::config('globals.docraptor_url'), $apiKey);

        $ch = curl_init();

        $name = substr(md5(time()), 0, 7) . '.pdf';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'doc[document_content]' => $markup,
            'doc[document_type]' => 'pdf',
            'doc[name]' => $name,
            'doc[test]' => Kohana::config('globals.test_mode'),
            'doc[strict]' => 'none',
        ));


        $result = curl_exec($ch);
        curl_close($ch);

        header('Content-type: application/pdf');
        header('Content-disposition: attachment; filename="' . $name . '"');


        die($result);
    }

}