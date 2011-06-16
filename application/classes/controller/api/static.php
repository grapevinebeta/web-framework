<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Static extends Controller {
    
    /**
     * @var 
     **/
    protected $apiResponse;
    
    protected $apiRequest;
    
    public function before() {
        parent::before();
//        if ($this->request->method() != 'POST') {
//            throw new HTTP_Exception_405();
//        }
        $range = $this->request->post('range');
        if (!empty($range)) {
            Session::instance()->set(
                'viewingRange',
                $range
            ); 
        }
    }
    
    public function after()
    {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index()
    {
        
    }
    
    public function action_ogsi() {
        $this->apiResponse = array('ogsi'=> array(
            'distribution' => array(  // OGSIDistributionObject,
                'positive' => 5, //:[int:required] - positive count
                'negative' => 2, //:[int:required] - negative count
                'neutral' => 3, //:[int:required] - neutral count
                'total' => 10, //:[int:required] - total count
                'average' => 4, //:[decimal:required] - average count
            ),
            'ogsi' => array( // OGSIScoreObject,
                'value' => 55.0, //:[decimal:required] - the ogsi percent
                'change' => 5.0, //:[decimal:required] - the change in percentage
            ),
            'reviews' => array( // OGSIReviewsObject,
                'value' => 5, //:[number:required] - the number of reviews
                'change' => -2, //:[number:required] - the change in percentage
            ),
            'rating' => array( // OGSIRatingObect
                'value' => 4.5, //:[decimal:required] - the current rating
                'change' => 5.0, //:[decimal:required] - change in rating
            ),
            
        ));
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
        sleep(2);
        $this->apiResponse = array(
            'reviews' => array(
                array(
                    'status' => 'OPEN', //refs: Content.Status[OPEN|CLOSED|TODO] - current status of review
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
                    'rating' => rand(0,5), // [decimal:optional] - review overall rating
                    'submitted' => rand(1300000000,time()), // [int:required] - unixtimestamp - date review was submitted , note indexed
                    'except' => 'except', // [string:required] - excerpt of content
                    'site' => 'cars.com', // [string:required] - site keyvalue, will need to lookup from Content.Sites.getKey(site) to get the human text value
                    'id' => rand(1,1000000), // [int:required] - id for content
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
        $interval = $this->request->post('dateInterval');
        $networks = array();
        switch ($id) {
            case 'activity':
                
                if($interval)
                    $networks = $this->getSocialActivityTimeSeries();
                else 
                {
                    $networks[] = array(
                        'network' => 'Facebook', //[string:required] - social network
                        'action' => 'Likes', //[string:required] - type of activity, ex. tweet,checkin,upload
                        'value' => 5, //[int:required] - activity value
                        'change' => 4.0, //[decimal:required] - change amount
                        'total' => 444, //[int:required] - total amount
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
                }
                
                break;
            case 'reach':
                
                
                if($interval)
                    $networks = $this->getSocialActivityTimeSeries();
                else {
                
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
                
                }
                
                break;
        }
        $this->apiResponse = array('networks' => $networks);
    }

    public function action_socials() {
        
        $status = array('OPEN', 'CLOSE', 'TODO');
        $excerpts = array(
          'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
          'Duis euismod sollicitudin lectus sit amet aliquam. Sed non',
          'massa sapien. Integer lacinia feugiat tellus, at imperdiet metus',
          'tincidunt nec. Donec sollicitudin faucibus arcu, nec pellentesque',
          'nisi sollicitudin at. Aenean vel nunc eu neque egestas dapibus.',
          'Maecenas eget lectus leo. Vestibulum fringilla faucibus lacus, ',
          'vehicula pulvinar est ullamcorper vel. Nullam ac nulla arcu, sed suscipit sem.',
          'In hac habitasse platea dictumst. Integer venenatis ultricies massa quis interdum.'  
        );
        
        $autor = array('DealerRater', 'Cars.com', 'Edmunds', 
            'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book');

        $competition = array('Google','Twitter', 'YouTube', 'Facebook', 'Flickr', 
            'Blogger', 'Rss', 'Delicious');
        
        $socials = array();
        
        for($i=0; $i < 8; $i++)
        {
            $network = $competition[rand(0,6)];
            
            $socials[] = array(
                'network' => $network,
                'status' => $status[rand(0,2)],
                'rating' => rand(0, 5), // [decimal:optional] - review overall rating
                'submitted' => rand(1300000000, time()),
                'excerpt' => $excerpts[rand(0,6)],
                'site' => $network,
                'id' => rand(1, 1000000),
                'review' => $excerpts[rand(0,6)],
                'category' => 'category',
                'notes' => 'notes',
                'keywords' => array('keyword', 'car'),
                'title' => $excerpts[rand(0,6)],
                'link' => $autor[rand(0, 6)],
                'autor' => $autor[rand(0, 6)]

            );
            
        }
        
        
        $this->apiResponse = array(

            'socials' => $socials, 
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
                        'value' => 'Twitter',
                    ),
                    array(
                        'value' => 'Facebook',
                    ),
                    array(
                        'value' => 'Google',
                    ),
                ),
            ),
        );
        
    }
    
    public function action_distribution() 
    {
        $distributions = array(
            array(
                'id' => 1,
                'dealership' => 'Best',
                'positive' => 30,
                'negative' => 2,
                'neutral' => 8,
                'total' => 40,
                'average' => 4.2
            ),
            array(
                'id' => 2,
                'dealership' => 'Classic',
                'positive' => 20,
                'negative' => 2,
                'neutral' => 8,
                'total' => 30,
                'average' => 3.2
            ),
        );
        //sleep(2);
        $this->apiResponse = array('dists' => $distributions);
    }
    
    /**
     * This methods is a mockup of data comes from competition comparision box
     * from competition section
     * 
     * /api/dataPrivider/competition/comparision
     * comparision:An object hashed by the unixtimestamp generated from <dateInterval> 
     * keys will be an ArrayCollection of OGSICompetitionRatingObject
	
     */
    public function action_comparision()
    {
        $comparision = array();
        $range = $this->request->post('range');
        $interval = $this->request->post('dateInterval');
        $date = $range === false ? time() : strtotime($range['date']);
        $dayOffset = 3600 * 24;

        switch ($range['period']) {

            case '1m':
                $startPoint = strtotime('-1 month', $date);
                break;
            case '3m':
                $startPoint = strtotime('-3 month', $date);
                break;
            case '6m':
                $startPoint = strtotime('-6 month', $date);
                break;
            case '1y':
                $startPoint = strtotime('-12 month', $date);
                break;
            default:
                $startPoint = strtotime('-1 month', $date);
                break;
        }


        $competitors = array('Best', 'Classic', 'Bryan', 'Mac', 'Baton Rogue');
        $startDays = ($date - $startPoint) / (3600 * 24);

        for ($i = 0; $i <= $startDays; $i += $interval) {
            foreach ($competitors as $competitor) {

                $rand = rand(1,5);
                $index = $date + ($i * $dayOffset);
                $prev = $rand;
                $change = $rand - $prev;
                
                $comparision[$index][] = array(
                    'competition' => $competitor,
                    'value' => $rand,
                    'change' => $change,
                );
            }
        }

        
        $this->apiResponse = array('comparision' => $comparision);
        
    }
    
    /**
     * Method for creating timeseries with social tab data for linear graphs
     * @return type 
     */
    private function getSocialActivityTimeSeries()
    {
        $timeSeries = array();
        $range = $this->request->post('range');
        $interval = (int) $this->request->post('dateInterval');
        
        $date = $range === false ? time() : strtotime($range['date']);
        /* @var $date DateTime */
        
        
        $dayOffset = 3600 * 24;
        $networks = array('Facebook', 'Twitter', 'Foursquare', 
            'Flickr', 'Youtube', 'Blogs');
        
        
        switch($range['period'])
        {
            
            case '1m':
                $startPoint = strtotime('-1 month', $date);
                break;
            case '3m':
                $startPoint = strtotime('-3 month', $date);
                break;
            case '6m':
                $startPoint = strtotime('-6 month', $date);
                break;
            case '1y':
                $startPoint = strtotime('-12 month', $date);
                break;
            default:
                $startPoint = strtotime('-1 month', $date);
                break;
            
        }
        
        
        $actions = array('tweet','checkin','upload');
        $startDays = ($date - $startPoint) / (3600 * 24);
        
        for($i=0; $i <= $startDays; $i += $interval)
        {
            foreach($networks as $network) {
                $rand = rand(1,200);
                $index = $date + $i * $dayOffset;
                
                $prev = $rand;
                $change = $rand - $prev;
                
                $timeSeries[$index][] = array(
                    'network' => $network,
                    'action' => $actions[rand(0, 2)],
                    'value' => $rand,
                    'change' => $change,
                    'total' => $change,
                );
            }
        }

        return $timeSeries;
        
    }
    
    /**
     * Competition leger action form competition tab
     * it is returning collection of json objects:
     * CompetitionReviewObject extends ContentObject implements IOGISBaseCompetitionObject
     * @see api-dataProvider.txt
     */
    public function action_competition_ledger() 
    {
        
        $status = array('OPEN', 'CLOSE', 'TODO');
        $excerpts = array(
          'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
          'Duis euismod sollicitudin lectus sit amet aliquam. Sed non',
          'massa sapien. Integer lacinia feugiat tellus, at imperdiet metus',
          'tincidunt nec. Donec sollicitudin faucibus arcu, nec pellentesque',
          'nisi sollicitudin at. Aenean vel nunc eu neque egestas dapibus.',
          'Maecenas eget lectus leo. Vestibulum fringilla faucibus lacus, ',
          'vehicula pulvinar est ullamcorper vel. Nullam ac nulla arcu, sed suscipit sem.',
          'In hac habitasse platea dictumst. Integer venenatis ultricies massa quis interdum.'  
        );
        
        $autor = array('DealerRater', 'Cars.com', 'Edmunds', 
            'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book');

        $competition = array('Best','Classic', 'Bryan', 'Ross downing', 'Brian Harris', 'Mac', 'Batton Rouge');
        
        $source = array();
        
        foreach($competition as $competitor)
        {
            
            $source[] = array('source' => $competitor);
            
        }
        
        $reviews = array();
        
        for($i=0; $i < 5; $i++)
        {
            
            $reviews[] = array(
                'competition' => $competition[rand(0,6)],
                'status' => $status[rand(0,2)],
                'rating' => rand(0, 5), // [decimal:optional] - review overall rating
                'submitted' => rand(1300000000, time()),
                'excerpt' => $excerpts[rand(0,6)],
                'site' => $autor[rand(0, 6)],
                'id' => rand(1, 1000000),
                'review' => $excerpts[rand(0,6)],
                'category' => 'category',
                'notes' => 'notes',
                'keywords' => array('keyword', 'car'),
                'title' => $autor[rand(0, 6)],
                'link' => $autor[rand(0, 6)],
                'autor' => $autor[rand(0, 6)]

            );
            
        }
        
        
        $this->apiResponse = array(

            'reviews' => $reviews, 
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
                'source' => $source
            ),
        );
    }
    
}