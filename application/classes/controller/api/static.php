<?php

defined('SYSPATH') or die('No direct script access.');

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
class Controller_Api_Static extends Controller_Api
{

    /**
     * @var
     * */
    protected $apiResponse;
    protected $apiRequest;

    public function before()
    {
        parent::before();
        //        if ($this->request->method() != 'POST') {
        //            throw new HTTP_Exception_405();
        //        }


        $range = $this->request->post('range');
        if (!empty($range)) {
            Session::instance()->set(
                'viewingRange', $range
            );
        }


        list($msecs, $uts) = explode(' ', microtime());
        srand(floor(($uts + $msecs) * 1000));
    }

    public function after()
    {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_index()
    {

        $this->apiResponse = true;

    }

    public function action_videos()
    {


        $this->apiResponse = array(

            'videos'
            => array(

                array(
                    'url' => 'http://www.youtube.com/embed/mkTMj0McIvc?autoplay=1',
                    'thumb_url' => 'http://img.youtube.com/vi/mkTMj0McIvc/0.jpg',
                    'date' => '2/23/2011',
                    'desc' => 'Checkout the new chevy..'
                )
            )

        );

    }

    public function action_photos()
    {


        $this->apiResponse = array(

            'videos'
            => array(

                array(
                    'url' => 'http://farm7.static.flickr.com/6141/5934098842_ae7d7c5466.jpg',
                    'thumb_url' => 'http://farm7.static.flickr.com/6141/5934098842_ae7d7c5466.jpg',
                    'date' => '2/23/2011',
                    'desc' => 'Chevy cruise'
                )
            )

        );

    }

    public function action_scoreboard()
    {

        $rands[] = rand(0, 100);
        $rands[] = rand(0, 100);
        $rands[] = rand(0, 100);

        $this->apiResponse = array(
            $this->request->param('id')
            => array(
                'rating'
                => array( // OGSIDistributionObject,
                    'positive' => $rands[0], //:[int:required] - positive count
                    'neutral' => $rands[1], //:[int:required] - neutral count
                    'negative' => $rands[2], //:[int:required] - negative count
                    'score' => rand(0, 50) / 10.0
                ),
                'ogsi' => number_format(lcg_value() * (abs(100)), 1),
                'reviews' => rand(0, 5000) / 10.0
            )
        );
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

    public function action_tags()
    {
        $tags = array(
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
        $this->apiResponse = array('tags' => $tags);
    }

    /**
     * Reviews inbox endpoint
     */
    public function action_review()
    {

        $postfilters = $this->request->post('filters');
        $filters = array();


        $data = array(
            'status'
            => array(
                'Total', 'Neutral', 'Positive',
                'Negative', 'Alert', 'Flagged', 'Completed'
            ),
            'source' => array('Total', 'Industry Specific', 'General')
        );

        foreach (
            $data as $network
            => $f
        ) {

            $filters[$network] = array();

            $inversed = array();

            if (isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }

            foreach (
                $f as $filter
            ) {

                $filters[$network][$filter] = array(
                    'total' => rand(1, 50),
                    'active' => isset($inversed[strtolower($filter)])
                );
            }
        }

        //        Kohana::$log->instance()->add(Log::DEBUG, $filters);

        $status = array('OPENED', 'CLOSED', 'TODO');
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

        $autor = array(
            'DealerRater', 'Cars.com', 'Edmunds',
            'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
        );

        $competition = array(
            'Google', 'Twitter', 'YouTube', 'Facebook', 'Flickr',
            'Blogger', 'Rss', 'Delicious'
        );

        $reviews = array();

        for (
            $i = 0; $i < 10; $i++
        ) {
            $network = $competition[rand(0, 6)];

            $id = rand(1, 1000000);
            $key = $id % 3;
            $eKey = $id % 7;

            $reviews[] = array(
                'status' => $status[$key],
                'score' => rand(0, 5), // [decimal:optional] - review overall score
                'date' => rand(1300000000, time()),
                'site' => $network,
                'id' => $id,
                'content' => $excerpts[$eKey],
                'category' => 'category',
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$eKey],
                'link' => $autor[$eKey],
                'identity' => $autor[$eKey]
            );
        }


        $this->apiResponse = array(
            'reviews' => $reviews,
            'filters' => $filters,
            'pagination' => array('page' => $this->request->post('page'), 'pages' => 30)
        );
    }

    /**
     * social graph
     */
    public function action_social()
    {
        $id = $this->request->param('id');
        $field = $this->request->param('field');
        $interval = $this->request->post('dateInterval');
        $limit = $this->request->post('limit');
        $limit = $limit ? $limit : 10;
        $networks = array();

        if (!$id) {

            $this->action_socials();
            return;
        }

        if ($field == 'expand') {

            sleep(1);
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

            $autor = array(
                'DealerRater', 'Cars.com', 'Edmunds',
                'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
            );

            $competition = array(
                'Google', 'Twitter', 'YouTube', 'Facebook', 'Flickr',
                'Blogger', 'Rss', 'Stumbleupon', 'Reddit', 'Delicious'
            );

            $key = $id % 10;
            $keyT = $id % 6;
            $network = $competition[$key];

            $social = array(
                'network' => $network,
                'status' => $status[rand(0, 2)],
                'score' => rand(0, 5), // [decimal:optional] - review overall rating
                'date' => rand(1300000000, time()),
                'site' => $network,
                'id' => $id,
                'content' => $excerpts[$keyT],
                'category' => 'category',
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$keyT],
                'link' => $autor[$keyT],
                'identity' => $autor[$keyT]
            );


            $this->apiResponse = array(
                'social' => $social,
            );

            return;
        }


        switch ($id) {

        case 'activity':


            $networks[] = array(
                'network' => 'Facebook', //[string:required] - social network
                'action' => 'Likes', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 4.0, //[decimal:required] - change amount
                'total' => 444, //[int:required] - total amount
            );
            $networks[] = array(
                'network' => 'Tweeter', //[string:required] - social network
                'action' => 'Followers', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 2.0, //[decimal:required] - change amount
                'total' => 123, //[int:required] - total amount
            );
            $networks[] = array(
                'network' => 'Flickr', //[string:required] - social network
                'action' => '', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 2.0, //[decimal:required] - change amount
                'total' => 23, //[int:required] - total amount
            );

            break;
        case 'subscribers':

            $networks[] = array(
                'network' => 'Facebook', //[string:required] - social network
                'action' => 'Likes', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 4.0, //[decimal:required] - change amount
                'total' => 444, //[int:required] - total amount
            );
            $networks[] = array(
                'network' => 'Tweeter', //[string:required] - social network
                'action' => 'Followers', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 2.0, //[decimal:required] - change amount
                'total' => 123, //[int:required] - total amount
            );
            $networks[] = array(
                'network' => 'Flickr', //[string:required] - social network
                'action' => '', //[string:required] - type of activity, ex. tweet,checkin,upload
                'value' => rand(1, 99), //[int:required] - activity value
                'change' => 2.0, //[decimal:required] - change amount
                'total' => 23, //[int:required] - total amount
            );


            break;
        }
        $this->apiResponse = array('networks' => $networks);
    }

    private function action_socials()
    {

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

        $autor = array(
            'DealerRater', 'Cars.com', 'Edmunds',
            'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
        );

        $competition = array(
            'Google', 'Twitter', 'YouTube', 'Facebook', 'Flickr',
            'Blogger', 'Rss', 'Stumbleupon', 'Reddit', 'Delicious'
        );

        $socials = array();

        $limit = $this->request->post('limit');
        $limit = $limit ? $limit : 10;

        for (
            $i = 0; $i < $limit; $i++
        ) {
            $id = rand(1, 1000000);
            $key = $id % 10;
            $keyT = $id % 6;
            $network = $competition[$key];

            $socials[] = array(
                'network' => $network,
                'status' => $status[rand(0, 2)],
                'score' => rand(0, 5), // [decimal:optional] - review overall rating
                'date' => rand(1300000000, time()),
                'site' => $network,
                'id' => $id,
                'content' => $excerpts[$keyT],
                'category' => 'category',
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$keyT],
                'link' => $autor[$keyT],
                'identity' => $autor[$keyT]
            );
        }

        $postfilters = $this->request->post('filters');

        $filters = array();


        $data = array(
            'activity' => array('All', 'Facebook', 'Twitter', 'Check-ins', 'Blogs', 'Other')
        );

        foreach (
            $data as $network
            => $f
        ) {

            $filters[$network] = array();

            $inversed = array();

            if (isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }

            foreach (
                $f as $filter
            ) {

                $filters[$network][$filter] = array(
                    'total' => rand(1, 50),
                    'value' => $filter,
                    'active' => isset($inversed[strtolower($filter)])
                );
            }

            //            Kohana::$log->instance()->add(Log::DEBUG, $filters);
        }


        $this->apiResponse = array(
            'socials' => $socials,
            'filters' => $filters,
            'pagination' => array('page' => $this->request->post('page'), 'pages' => 30)
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
        $this->apiResponse = array('distribution' => $distributions);
    }

    public function action_competition()
    {


        $field = $this->request->param('field');
        $id = $this->request->param('id');

        if (!$id) {

            $this->action_competitions();
            return;

        }

        if ($field == 'expand') {

            sleep(1);
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

            $autor = array(
                'DealerRater', 'Cars.com', 'Edmunds',
                'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
            );

            $competition = array(
                'Google', 'Twitter', 'YouTube', 'Facebook', 'Flickr',
                'Blogger', 'Rss', 'Delicious'
            );


            $key = $id % 10;
            $keyT = $id % 6;
            $network = $competition[$keyT];

            $review = array(
                'network' => $network,
                'status' => $status[rand(0, 2)],
                'score' => rand(0, 5), // [decimal:optional] - review overall rating
                'date' => rand(1300000000, time()),
                'site' => $network,
                'id' => $id,
                'content' => $excerpts[$keyT],
                'category' => "important",
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$keyT],
                'link' => $autor[$keyT],
                'identity' => $autor[$keyT]
            );


            $this->apiResponse = array(
                'competition' => $review,
            );

            return;
        }


        switch ($id) {

        case 'ogsi':

            $ogsi = array();

            $competition = array(
                'Best', 'Classic', 'Bryan', 'Ross downing', 'Brian Harris', 'Mac', 'Batton Rouge'
            );


            foreach (
                $competition as $competitor
            ) {

                $ogsiDistributionObject = array(
                    'positive' => $a = rand(0, 99),
                    'negative' => $b = rand(0, 99),
                    'neutral' => $c = rand(0, 99),
                    'total' => $a + $b + $c,
                    'average' => (lcg_value() * (abs(10)))
                );

                $ogsiScoreObject = array(
                    'value' => (lcg_value() * (abs(100))),
                    'rank'
                    => array(
                        'value' => rand(1, 10),
                        'out' => 10,
                    )
                );

                $ogsiReviewsObject = array(
                    'value' => rand(1, 10),
                    'rank'
                    => array(
                        'value' => rand(1, 10),
                        'out' => 10,
                    )
                );

                $ogsiRatingObject = array(
                    'value' => rand(1, 5),
                    'rank'
                    => array(
                        'value' => rand(1, 10),
                        'out' => 10,
                    )
                );

                $ogsiObject = array(
                    'distribution' => $ogsiDistributionObject,
                    'ogsi' => $ogsiScoreObject,
                    'reviews' => $ogsiReviewsObject,
                    'rating' => $ogsiRatingObject
                );


                $ogsi[$competitor] = $ogsiObject;
            }


            $this->apiResponse = array(
                'ogsi' => $ogsi
            );

            break;
        }

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

        for (
            $i = 0; $i <= $startDays; $i += $interval
        ) {
            foreach (
                $competitors as $competitor
            ) {

                $rand = rand(1, 5);
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
        $interval = (int)$this->request->post('dateInterval');

        $date = $range === false ? time() : strtotime($range['date']);
        /* @var $date DateTime */


        $dayOffset = 3600 * 24;
        $networks = array(
            'Facebook', 'Twitter', 'Foursquare',
            'Flickr', 'Youtube', 'Blogs'
        );


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


        $actions = array('tweet', 'checkin', 'upload');
        $startDays = ($date - $startPoint) / (3600 * 24);

        for (
            $i = 0; $i <= $startDays; $i += $interval
        ) {
            foreach (
                $networks as $network
            ) {
                $rand = rand(1, 200);
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
    private function action_competitions()
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

        $autor = array(
            'DealerRater', 'Cars.com', 'Edmunds',
            'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
        );

        $competition = array('Best', 'Classic', 'Bryan', 'Ross downing', 'Brian Harris', 'Mac', 'Batton Rouge');

        $source = array();

        foreach (
            $competition as $competitor
        ) {

            $source[] = array('source' => $competitor);
        }

        $postfilters = $this->request->post('filters');
        $filters = array();


        $data = array(
            'activity' => array('All', 'Facebook', 'Twitter', 'Check-ins', 'Blogs', 'Other')
        );

        foreach (
            $data as $network
            => $f
        ) {

            $filters[$network] = array();

            $inversed = array();

            if (isset($postfilters[$network])) {
                $keys = array_values($postfilters[$network]);
                $values = array_keys($postfilters[$network]);

                $inversed = array_combine($keys, $values);
            }

            foreach (
                $f as $filter
            ) {

                $filters[$network][] = array(
                    'total' => rand(1, 50),
                    'value' => $filter,
                    'active' => isset($inversed[strtolower($filter)])
                );
            }

        }

        $reviews = array();

        for (
            $i = 0; $i < 10; $i++
        ) {

            $id = rand(1, 1000000);
            $key = $id % 10;
            $keyT = $id % 6;
            $network = $competition[$keyT];

            $reviews[] = array(
                'network' => $network,
                'competition' => $competition[$keyT],
                'status' => $status[rand(0, 2)],
                'score' => rand(0, 5), // [decimal:optional] - review overall rating
                'date' => rand(1300000000, time()),
                'site' => $autor[$keyT],
                'id' => $id,
                'content' => $excerpts[$keyT],
                'category' => 'category',
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$keyT],
                'link' => $autor[$keyT],
                'identity' => $autor[$keyT]
            );
        }


        $this->apiResponse = array(
            'competitions' => $reviews,
            'source' => $source,
            'filters' => $filters,
            'pagination' => array('page' => $this->request->post('page'), 'pages' => 30)
        );
    }

    public function action_random_movie()
    {

        $collection = array();

        $pattern = '/src=["]?((?:.(?!["]?\s+(?:\S+)=|[>"]))+.)["]?/';

        for (
            $i = 0; $i < 5; $i++
        ) {
            $content = file_get_contents(
                "http://flyhour.tv/bots/api/index.php?type=2&countries=US&category=Music&views=75000"
            );
            $results = array();
            preg_match($pattern, $content, $results);

            $collection[] = $results[1];
        }
        $this->apiResponse = array('movies' => $collection);
    }

    public function action_reviews()
    {
        $id = $this->request->param('id');
        $field = $this->request->param('field');

        if ('categories' === $id) {
            $this->apiResponse = array(
                'categories'
                => array(1 => 'shopping', 2 => 'important', 3 => 'it', 4 => 'travel', 5 => 'sport')
            );
        }

        $key = $id % 3;
        $eKey = $id % 7;

        switch ($field) {

        case 'category':
            break;
        case 'notes':
            break;
        case 'tags':
            break;
        case 'expand':

            sleep(1);
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

            $autor = array(
                'DealerRater', 'Cars.com', 'Edmunds',
                'Google', 'CitySearch', 'MyDealerRaport', 'Judys Book'
            );

            $competition = array(
                'Google', 'Twitter', 'YouTube', 'Facebook', 'Flickr',
                'Blogger', 'Rss', 'Delicious'
            );

            $network = $competition[rand(0, 6)];

            $review = array(
                'status' => $status[$key],
                'score' => rand(0, 5), // [decimal:optional] - review overall rating
                'date' => rand(1300000000, time()),
                'site' => $network,
                'id' => $id,
                'content' => $excerpts[$eKey],
                'category' => "important",
                'notes' => 'notes',
                'tags' => array('keyword', 'car'),
                'title' => $excerpts[$eKey],
                'link' => $autor[$eKey],
                'identity' => $autor[$eKey]
            );


            $this->apiResponse = array(
                'review' => $review,
            );

            break;
        }
    }

}