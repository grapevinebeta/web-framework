<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Static extends Controller {
    
    /**
     * @var 
     **/
    protected $apiResponse;
    
    protected $apiRequest;
    
    public function before() {
        
    }
    
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
                'percent' => 60,
                ),
            array(
                'id' => 2,
                'keyword' => 'bad location',
                'used' => 20,
                'rating' => 2,
                'percent' => 40,
                ),
            );
            sleep(1);
        $this->apiResponse = array('keywords' => $keywords);
    }
    
    public function action_reviews()
    {
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
                    'id' => '2', // [int:required] - id for content
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

    public function action_social()
    {
        $id = $this->request->param('id');
        $networks = array();
        switch ($id) {
            case 'activity':
                $networks[] = array(
                    'network' => 'Facebook' , //[string:required] - social network
                    'action' => 'Interactions' , //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5 , //[int:required] - activity value
                    'change' => 4.0 , //[decimal:required] - change amount
                    'total' => 444 , //[int:required] - total amount
                );
                $networks[] = array(
                    'network' => 'Tweeter', //[string:required] - social network
                    'action' => 'Tweets', //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5, //[int:required] - activity value
                    'change' => 2.0, //[decimal:required] - change amount
                    'total' => 123, //[int:required] - total amount
                );
                $networks[] = array(
                    'network' => 'Flickr', //[string:required] - social network
                    'action' => '', //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5, //[int:required] - activity value
                    'change' => 2.0, //[decimal:required] - change amount
                    'total' => 23, //[int:required] - total amount
                );
                break;
            case 'reach':
                $networks[] = array(
                    'network' => 'Facebook' , //[string:required] - social network
                    'action' => 'Likes' , //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5 , //[int:required] - activity value
                    'change' => 4.0 , //[decimal:required] - change amount
                    'total' => 444 , //[int:required] - total amount
                );
                $networks[] = array(
                    'network' => 'Tweeter', //[string:required] - social network
                    'action' => 'Followers', //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5, //[int:required] - activity value
                    'change' => 2.0, //[decimal:required] - change amount
                    'total' => 123, //[int:required] - total amount
                );
                $networks[] = array(
                    'network' => 'Flickr', //[string:required] - social network
                    'action' => '', //[string:required] - type of activity, ex. tweet,checkin,upload
                    'value' => 5, //[int:required] - activity value
                    'change' => 2.0, //[decimal:required] - change amount
                    'total' => 23, //[int:required] - total amount
                );
                
                break;
        }
        $this->apiResponse = array('networks' => $networks);
    }

    public function action_socials() {
        $this->apiResponse = array(
            'socials' => array(
                array(
                    'status' => 'OPEN', //refs: Content.Status[OPEN|CLOSED|TODO] - current status of review
                    'rating' => 3, // [decimal:optional] - review overall rating
                    'submitted' => 1306016438, // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'facebook.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => '1', // [int:required] - id for content
                    'review' => 'full text', // [text:optional] - full content
                    'category' => 'category', // [string:optional] - internal category
                    'notes' => 'notes', // [text:optional] - notes
                    'keywords' => array('keyword', 'car'), // [array:optional] - keywords as string
                    'title' => 'title of content', // [string:optional]  - title for content
                    'link' => 'http://cars.com', // [string:optional] - link for content
                    'author' => 'Author', // [string:optional] - author of the content
                    'network' => 'Facebook', //[string:required]  name of network from Social.Networks[....]
                    ),
                array(
                    'status' => 'OPEN', //refs: Content.Status[OPEN|CLOSED|TODO] - current status of review
                    'rating' => 3, // [decimal:optional] - review overall rating
                    'submitted' => 1307016438, // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'tweeter.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => '2', // [int:required] - id for content
                    'review' => 'full text', // [text:optional] - full content
                    'category' => 'category', // [string:optional] - internal category
                    'notes' => 'notes', // [text:optional] - notes
                    'keywords' => array('keyword', 'car'), // [array:optional] - keywords as string
                    'title' => 'title of content', // [string:optional]  - title for content
                    'link' => 'http://cars.com', // [string:optional] - link for content
                    'author' => 'Author', // [string:optional] - author of the content
                    'network' => 'Tweeter', //[string:required]  name of network from Social.Networks[....]
                    ),
            ),
            'filters' => array(
                'activity' => array(
                    array(
                        'total' => 50,
                        'value' => 'New',
                    ),
                    array(
                        'total' => 5,
                        'value' => 'FB Posts',
                    ),
                    array(
                        'total' => 5,
                        'value' => 'Tweets',
                    ),
                    array(
                        'total' => 21,
                        'value' => 'Photos',
                    ),
                    array(
                        'value' => 'Alert',
                    ),
                ),
                'network' => array(
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