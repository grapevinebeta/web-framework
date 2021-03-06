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
    
    public function action_location_js() {
        
        
       /* @var $locations Database_Result */
       $locations = Auth::instance()->get_user()->getLocationsList();
        
       $this->response->headers('Content-Type', 'application/json');
       echo json_encode(
                array(
                    'locations' => $locations['locations'],
                    'hashes' => $locations['hashes']
                ));
       exit;
       
        
    }
    
    public function action_email() {
        
        $name = filter_var($this->request->param('id'), FILTER_SANITIZE_STRING);
        $view = View::factory('emails/' . $name);
        
        $from = $this->request->post('from');
        $recipients = $this->request->post('to');
        $data = $this->request->post('data');
        
        $post = Validation::factory($_POST);
        
        $post
        ->rule('from', 'not_empty')
        ->rule('to', 'not_empty')
        ->rule('data', 'not_empty');

        
        if($post->check()) {

            $view->bind('from', $from);
            $view->bind('data', $data);

            $count = 0;
            foreach ($recipients as $recipient) {
                
                $count += Model_Mailer::getInstance()
                        ->send($recipient, 'Information Through the Grapevine ', 
                                $view->render(), null, $from);
            }

            return $this->apiResponse['success'] = $count;
            
            
        }
        else {
            
            $this->apiResponse['error'] = $post->errors();
            
        }

        
    }
    
    public function action_social() {

        $config = array(
            'appId' => Kohana::config('globals.facebook_app_id'),
            'secret' => Kohana::config('globals.facebook_secret'),
        );

        $s = new Model_Location_Settings($this->_location_id);
        $fbtoken = $s->getSetting('facebook_oauth_token');
        $page = $s->getSetting('facebook_page_id');
        
        $twitterToken = $s->getSetting('twitter_oauth_token');
        $twitterSecret = $s->getSetting('twitter_oauth_token_secret');
        $twitterAccount = $s->getSetting('twitter_account');
        

        $facebook = false;
        if(isset($fbtoken[0])) {
            
            $config['facebook_token'] = $fbtoken[0];
            $config['facebook_page_id'] = $page[0];
            $facebook = true;
            
        }
        
        
        $twitter = false;
        if(isset($twitterToken[0]) && isset($twitterSecret[0])) {
            
            $config['twitter_user_token'] = $twitterToken[0];
            $config['twitter_user_secret'] = $twitterSecret[0];
            $config['twitter_account'] = $twitterAccount[0];
            $twitter = true;
            
        }
       
        if(!$twitter && !$facebook) {
            $this->apiResponse = 0;
            return;
        }
        
        try {
    
            if($facebook) {
                
            
                $fb = new Facebook($config);
                $fb->setAccessToken($config['facebook_token']);

                $response = $fb->api($config['facebook_page_id'] . '/feed', 'GET', array(
                    'limit' => 3
                ));
                
                
                $messages = array();
                foreach($response['data'] as $message) {

                    if(!isset($message['message']))
                        continue;
                    
                    $messages[strtotime($message['created_time'])] = array(
                        'id' => $message['id'],
                        'from' => $message['from']['name'],
                        'message' => isset($message['message']) ? $message['message'] : '',
                        'type' => $message['type'],
                        'network' => 'facebook',
                        'link' => $message['actions'][0]['link']
                    );

                }
            
            }
            
            if ($twitter) 
            {

                $tmhOAuth = new tmhOAuth(array(
                            'consumer_key' => Kohana::config('globals.twitter_consumer_key'),
                            'consumer_secret' => Kohana::config('globals.twitter_consumer_secret'),
                            'user_token' => $config['twitter_user_token'],
                            'user_secret' => $config['twitter_user_secret']
                        ));

                $code = $tmhOAuth->request('GET', $tmhOAuth->url('1/statuses/user_timeline'), array(
                    'include_entities' => '1',
                    'include_rts' => '1',
                    'screen_name' => $config['twitter_account'],
                    'count' => 3,
                        ));

                if ($code == 200) {

                    $results = json_decode($tmhOAuth->response['response'], true);

                    
                    foreach ($results as $message) {
                        
                        $link = sprintf('http://twitter.com/%s/status/%d', 
                                $message['user']['screen_name'], $message['id_str']);
                        
                        $timestamp = strtotime($message['created_at']);

                        $tweet = array(
                            'id' => $message['id_str'],
                            'from' => $message['source'],
                            'message' => $message['text'],
                            'type' => 0,
                            'network' => 'twitter',
                            'link' => $link
                        );

                        if (isset($messages[$timestamp])) {

                            $messages[$timestamp] = array(
                                $messages[$timestamp],
                                $tweet
                            );
                        }
                        else
                            $messages[$timestamp] = $tweet;
                    }
                }
            }
            
            $this->apiResponse['messages'] = $messages;
            
        } catch (FacebookApiException $e) {
            $this->apiRequest['errors']['facebook'] = $e;
        }
        catch (Exception $e) {
            $this->apiRequest['errors'] = $e;
        }
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
        $location_id = $this->request->post('location_id'); // section id
        
        $b = Model::factory('box');
        
        $rs = $b->getPositions($location_id, $id);
        
        if(count($rs))
        {
            $this->apiResponse = $rs->as_array('holder_id');
        }
        else 
        {    

            $holders = $this->request->post('holders');
            
            if(!$holders)
                return;

            try {
                $b->persists($holders);

                $rs = $b->getPositions($location_id, $id);
                $this->apiResponse = $rs->as_array('holder_id');

            }
            catch(Exception $e) {

                $this->apiRequest['errors'] = $e;

            }
        
        }
        
    }
    
    
    /**
     * this action gives information about twitter and facebook linking status
     */
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
    
    /**
     * return callback for Twitter to verify data and populate location settings
     */
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
            return $fb->api($config['facebook_page_id'] . '/feed', 'POST', $message);
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
            $config['facebook_page_id'] = $page[0];
            
        }
        
        if(isset($twitterToken[0]) && isset($twitterSecret[0])) {
            
            $config['twitter_token'] = $twitterToken[0];
            $config['twitter_secret'] = $twitterSecret[0];
            
        }

        $post['message'] = strip_tags($this->request->post('message'));
        $post['name'] = 'Grapevine update';

        
        foreach($callbacks as $key => $call) {
            $this->apiResponse[$key] 
                    = call_user_func_array(array($this, $call), array($post, $config));
        }


    }
    
    private function initCurl() {
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        
        return $ch;
        
    }
    
    private function range_detect($range) {
        
        
        $period = $range['period'];
        switch ($period) {
            case '1m':
                $period = "+1 month";
                break;
            case '3m':
                $period = "+3 months";
                break;
            case '6m':
                $period = "+6 months";
                break;
            case '1y':
                $period = "+1 year";
            case 'ytd':
                $period = "-1 day";
            case 'all':
                $period = "-1 day";
                break;
            default:
                $period = false;
                break;
        }


        /**
         *  i change the code and assumed that $range['date'] always return start date
         * and $range['offset'] return positive offset that need to be add to start date.
         * 
         * 
         */
        $start = strtotime($range['date']);

        if ($period) {
            if (in_array($range['period'], array('all', 'ytd'))) {
                $end = strtotime($period);
            }
            else
                $end = strtotime($period, $start);
        }
        else
            $end = strtotime($range['period']); // this is the case when period has date value
        
        
        return array(date('m-d-Y', $start), date('m-d-Y', $end));
    }
    
    /**
     * this action handle both export to file and export to email actions
     * if request contains email value it will send email to recipients
     * if not it will return the output to browser
     * 
     */
    public function action_export() {
        
        
        preg_match('@^(?:http://)?([^/]+)\/(\w*)@i',
        $this->request->referrer(), $matches);
        
        $page = $matches[2];
        
        $page = $page ? $page : 'dashboard';
        $range = $this->request->post('range');
        
        $range = implode('to', $this->range_detect(Session::instance()->get('viewingRange')));
        
        $emails = $this->request->post('email');

        $recipients = $emails['to'];
        $from = $emails['from'];
        
        $markup = View::factory('_partials/export_template', array(
            'html' => $this->request->post('html'),
            'range' => $this->range_detect(Session::instance()->get('viewingRange'))
        ));
        
        
        // we get credentials for doc raptor
        $apiKey = Kohana::config('globals.api_key');
        $url = sprintf(Kohana::config('globals.docraptor_url'), $apiKey);

        /**
         * we made initial request to get document if export button is clicked
         * or fetch it asynchronous when email button is clicked
         */
        $ch = $this->initCurl();
        
        $postArray = array(
            'doc[document_content]' => $markup,
            'doc[document_type]' => 'pdf',
            'doc[test]' => Kohana::config('globals.test_mode'),
            'doc[strict]' => 'none',
        );
              
        
        curl_setopt($ch, CURLOPT_URL, $url);
        $postArray['doc[name]'] = $name = sprintf('GrapevineDashboard-%s-%s.pdf ', $page, $range);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);
        $result = curl_exec($ch);
        curl_close($ch);
        
        
        // if we not define recipients using email parameter we send normal headers
        if(!$recipients) {
            
            
            header('Content-type: application/pdf');
            header('Content-disposition: attachment; filename="' . $name . '"');
            die($result);

            
        }
        else {
            $body = View::factory('emails/standard')->render();
            $count = 0;
            foreach ($recipients as $recipient) {
                
                $count += Model_Mailer::getInstance()->send($recipient, 'Grapevine Export Notification', $body, array($name => $result), $from);
            }
            
            return $this->apiResponse['success'] = $count;
            
        }

        
        
        
        return $this->apiResponse['error'] = 1;
        

        
    }

}