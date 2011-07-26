<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Box extends Controller_Api {

    /**
     * @var 
     * */
    protected $apiResponse;
    protected $apiRequest;
    protected $location = 1;

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
        
        $rs = $b->getPositions($this->location, $id);
        
        if(count($rs))
        {
            $this->apiResponse = $rs->as_array('holder_id');
        }
        else 
        {    

            $holders = $this->request->post('holders');

            try {
                $b->persists($holders);

                $rs = $b->getPositions($this->location, $id);
                $this->apiResponse = $rs->as_array('holder_id');

            }
            catch(Exception $e) {

                throw $e;

            }
        
        }
        
    }
    
    public function action_auth() {

        if (Auth::instance()->logged_in()) {

            $settings = new Model_Location_Settings(1);
            $token = $settings->getSetting('facebook_oauth_token');
            $page = $settings->getSetting('facebook_page_id');

            $settings['auth_token'] = $token[0];
            $settings['page_id'] = $page[0];
            $settings['api_key'] = $page[0];
        }
        
        $this->apiResponse = $settings;
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