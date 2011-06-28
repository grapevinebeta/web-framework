<?php defined('SYSPATH') or die('No direct script access.');


/**
 * Specification of filters:
 * 
 *    Review Inbox filters:
 *      Review Status Filter: Total, Positive, Neutral, Negative, Alert, Flagged, & Completed
 *      Default filter is TOTAL
 *      Source Filter: All, Industry Specific, General
 *      Default filter is ALL
 *    Social Inbox filters:
 *      Activity Filter: Total, Posts & Mentions, Videos & Photos, Blogs & News
 *      Default filter is TOTAL
 *    Social Network Filter: All, Social, Location, Video & Photo, Flickr, Blog & News
 *      Default filter is ALL 
 *    Competition Review Inbox filters:
 *      Activity Filter: Total, Positive, Neutral, Negative
 *      Default filter is TOTAL
 *    Competition filter: All, Competitor 1, Competitor 2, etc
 *      Default filter is ALL competition selected ON 
 * 
 */

class Controller_Api_Static extends Controller {
    
    /**
     * @var 
     **/
    protected $apiResponse;
    
    protected $apiRequest;
    
    public function before() {
        parent::before();
        if ($this->request->method() != 'POST') {
            throw new HTTP_Exception_405();
        }
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
        
        $rands[] = rand(0, 100);
        $rands[] = rand(0, 100);
        $rands[] = rand(0, 100);
        
        $this->apiResponse = array('ogsi'=> array(
            'distribution' => array(  // OGSIDistributionObject,
                'positive' => $rands[0], //:[int:required] - positive count
                'neutral' => $rands[1], //:[int:required] - neutral count
                'negative' => $rands[2], //:[int:required] - negative count
                'total' => array_sum($rands), //:[int:required] - total count
                'average' => 4, //:[decimal:required] - average count
            ),
            'ogsi' => array( // OGSIScoreObject,
                'value' => 55.0, //:[decimal:required] - the ogsi percent
                'change' => 5.0, //:[decimal:required] - the change in percentage
            ),
            'reviews' => array( // OGSIReviewsObject,
                'value' => rand(0,50)/10.0, //:[number:required] - the number of reviews
                'change' => rand(-10, 10), //:[number:required] - the change in percentage
            ),
            'rating' => array( // OGSIRatingObect
                'value' => rand(0,50)/10.0, //:[decimal:required] - the current rating
                'change' => rand(-10,10), //:[decimal:required] - change in rating
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
            // sleep(2);
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
            // sleep(1);
        $this->apiResponse = array('keywords' => $keywords);
    }
    
    /**
     * Reviews inbox endpoint
     */
    public function action_reviews()
    {
        
        $postfilters = $this->request->post('filters');
        $filters = array();


        $data = array(
            'status' => array('Total', 'Neutral', 'Positive', 
                'Negative', 'Alert', 'Flagged', 'Completed'),
            'source' => array('Total', 'Industry Specific', 'General')
        );

        foreach($data as $network => $f) {

            $filters[$network] = array();

            $inversed = array();

            if(isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }

            foreach($f as $filter) {

                $filters[$network][] = array(
                'total' => rand(1, 50),
                'value' => $filter,
                'active' => isset($inversed[strtolower($filter)])

                );
            }

        }

//        Kohana::$log->instance()->add(Log::DEBUG, $filters);
        
        $status = array('OPEN', 'CLOSED', 'TODO');
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
        
        $reviews = array();
        
        for($i=0; $i < 10; $i++)
        {
            $network = $competition[rand(0,6)];
            
            $reviews[] = array(
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
            'reviews' => $reviews,
            'filters' => $filters,
            'pagination' => array('page' => $this->request->post('page'), 'pagesCount' => 30)
        );
    }

    /**
     * social graph
     */
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

    
    /**
     * social inbox
     */
    public function action_socials() {
        
        $status = array('OPEN', 'CLOSED', 'TODO');
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
        
        for($i=0; $i < 10; $i++)
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
        
        $postfilters = $this->request->post('filters');
        $filters = array();
        
        
        $data = array(
            'activity' => array('All', 'Facebook', 'Twitter', 'Check-ins', 'Blogs', 'Other')
        );
        
        foreach($data as $network => $f) {
            
            $filters[$network] = array();
            
            $inversed = array();
            
            if(isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }
            
            foreach($f as $filter) {
                
                $filters[$network][] = array(
                    'total' => rand(1,50), 
                    'value' => $filter, 
                    'active' => isset($inversed[strtolower($filter)])
                    
                    );
                
            }
            
            Kohana::$log->instance()->add(Log::DEBUG, $filters);
            
        }
        

        $this->apiResponse = array(

            'socials' => $socials, 
            'filters' => $filters,
            'pagination' => array('page' => $this->request->post('page'), 'pagesCount' => 30)
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
     * Competition review inbox action form competition tab
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
        
        $postfilters = $this->request->post('filters');
        $filters = array();
        
        
        $data = array(
            'activity' => array('All', 'Facebook', 'Twitter', 'Check-ins', 'Blogs', 'Other')
        );
        
        foreach($data as $network => $f) {
            
            $filters[$network] = array();
            
            $inversed = array();
            
            if(isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }
            
            foreach($f as $filter) {
                
                $filters[$network][] = array(
                    'total' => rand(1,50), 
                    'value' => $filter, 
                    'active' => isset($inversed[strtolower($filter)])
                    
                    );
                
            }
            
            Kohana::$log->instance()->add(Log::DEBUG, $filters);
            
        }
        
        $reviews = array();
        
        for($i=0; $i < 10; $i++)
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
                'title' => $excerpts[rand(0, 7)],
                'link' => $autor[rand(0, 6)],
                'author' => $autor[rand(0, 6)]

            );
            
        }
        
        
        $this->apiResponse = array(

                'reviews' => $reviews, 
                'source' => $source,
                'filters' => $filters,
                'pagination' => array('page' => $this->request->post('page'), 'pagesCount' => 30)
        );
    }
    
    public function action_random_movie()
    {
        
        $collection = array();
        
        $pattern = '/src=["]?((?:.(?!["]?\s+(?:\S+)=|[>"]))+.)["]?/';
        
        for($i=0; $i < 5; $i++) {
            $content = file_get_contents("http://flyhour.tv/bots/api/index.php?type=2&countries=US&category=Music&views=75000");
            $results = array();
            preg_match($pattern, $content, $results);
            
            $collection[] = $results[1];
            
        }
        $this->apiResponse = array('movies' => $collection);
        
        
        
        
    }
    
}