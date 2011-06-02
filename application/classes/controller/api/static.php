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
        $sites = array(
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
        $this->apiResponse = array('sites' => $sites);
    }

    public function action_keywords()
    {
        $keywords = array(
            array(
                'id' => 1,
                'keyword' => 'great location',
                'used' => 30,
                'rating' => 2,
                'percent' => 8,
                ),
            array(
                'id' => 2,
                'keyword' => 'bad location',
                'used' => 20,
                'rating' => 2,
                'percent' => 8,
                ),
            );
            sleep(1);
        $this->apiResponse = array('keywords' => $keywords);
    }
    
    public function action_reviews()
    {
        sleep(3);
        $this->apiResponse = array(
            'reviews' => array(
                array(
                    'status' => 'OPEN', //refs: Content.Status[OPEN|CLOSED|TODO] - current status of review
                    'rating' => 3, // [decimal:optional] - review overall rating
                    'submitted' => 1306016438, // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => '1', // [int:required] - id for content
                    'review' => 'full text', // [text:optional] - full content
                    'category' => 'category', // [string:optional] - internal category
                    'notes' => 'notes', // [text:optional] - notes
                    'keywords' => array('keyword', 'car'), // [array:optional] - keywords as string
                    'title' => 'title of content', // [string:optional]  - title for content
                    'link' => 'http://cars.com', // [string:optional] - link for content
                    'author' => 'Author', // [string:optional] - author of the content
                    ),
                array(
                    'status' => 'OPEN', //refs: Content.Status[OPEN|CLOSED|TODO] - current status of review
                    'rating' => 3, // [decimal:optional] - review overall rating
                    'submitted' => 1307016438, // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => '1', // [int:required] - id for content
                    'review' => 'full text', // [text:optional] - full content
                    'category' => 'category', // [string:optional] - internal category
                    'notes' => 'notes', // [text:optional] - notes
                    'keywords' => array('keyword', 'car'), // [array:optional] - keywords as string
                    'title' => 'title of content', // [string:optional]  - title for content
                    'link' => 'http://cars.com', // [string:optional] - link for content
                    'author' => 'Author', // [string:optional] - author of the content
                    ),
            ),
            'filters' => array(
                'status' => array(
                    array(
                        'total' => 67,
                        'value' => 'Total',
                    ),
                    array(
                        'total' => 4,
                        'value' => 'New',
                    ),
                    array(
                        'total' => 5,
                        'value' => 'Neutral',
                    ),
                    array(
                        'total' => 7,
                        'value' => 'Positive',
                    ),
                    array(
                        'total' => 1,
                        'value' => 'Negative',
                    ),
                    array(
                        'value' => 'Alert',
                    ),
                    array(
                        'value' => 'Flagged',
                    ),
                    array(
                        'value' => 'Completed',
                    ),
                ),
                'source' => array(
                    array(
                        'value' => 'DealerRater',
                    ),
                    array(
                        'value' => 'Cars.com',
                    ),
                    array(
                        'value' => 'Google',
                    ),
                ),
            ),
        );
    }
}