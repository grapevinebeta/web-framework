<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Static extends Controller {
    
    /**
     * @var 
     **/
    protected $apiResponse;
    
    protected $apiRequest;
    
    
    public function after()
    {
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index()
    {
        
    }
    
    public function action_sites()
    {
        $keywords = array(
            array(
                'id' => 1,
                'site' => 'cars.com',
                'positive' => 30,
                'negative' => 2,
                'neutral' => 8,
                'total' => 40,
                'average' => 4.2
                ),
            array(
                'id' => 2,
                'site' => 'carss.com',
                'positive' => 20,
                'negative' => 2,
                'neutral' => 8,
                'total' => 30,
                'average' => 3.2
                ),
            );
            sleep(2);
        $this->apiResponse = array('keywords' => $keywords);
    }
}