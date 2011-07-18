<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Box extends Controller {

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

}