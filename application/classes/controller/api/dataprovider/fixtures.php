<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 7:23 AM
 */

    class Controller_Api_DataProvider_Fixtures extends Controller_Api_DataProvider_Base
    {
        function random_gen($length)
        {
            $random = "";
            //srand((double)microtime() * 1000000);
            $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $char_list .= "abcdefghijklmnopqrstuvwxyz";
            $char_list .= "1234567890";
            // Add the special characters to $char_list if needed

            $char_length = strlen($char_list);
            for (
                $i = 0; $i < $length; $i++
            )
            {

                $random .= substr($char_list, mt_rand(0, $char_length), 1);
            }
            return $random;
        }

        public function action_index()
        {
            set_time_limit(0);
            $db = $this->mongo->selectDB('auto');
            $db->drop();
            $this->fixtures_reviews($db);
            $this->fixtures_socials($db);


        }

        public function fixtures_reviews($db)
        {

            $amount = 100;
            $displacement = 5;
            $distance = $amount / $displacement;
            $default_start_date = strtotime('-' . ($distance / 2) . ' days');
            $default_date = new MongoDate($default_start_date);


            $reviews = new MongoCollection($db, 'reviews');
            $reviews->ensureIndex(
                array('date' => 1, 'loc' => 1, 'status' => 1, 'rating' => 1, 'site' => 1), array('background' => TRUE)
            );


            $metrics = new MongoCollection($db, 'metrics');
            $metrics->ensureIndex(array('date' => 1, 'type' => 1, 'period' => 1), array('background' => TRUE));
            $sites = array(

                'dealerrater.com',
                'mydealerreport.com',
                'edmunds.com',
                'citysearch.com',
                'insiderpages.com',
                'judysbook.com',
                'superpages.com',
                'yelp.com'
            );

            $metric_entries = array('scoreboard' => array(), 'reviews' => array());
            $review_entries = array();


            $scoreboard_overall = array(
                'type' => 'scoreboard',
                'date' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)),
                'period' => 'overall',
                'aggregates'
                => array(

                )
            );
            for (
                $location_id = 1; $location_id <= 4; $location_id++
            ) {
                $scoreboard_overall['aggregates'][$location_id] = array(
                    'negative' => 0,
                    'positive' => 0,
                    'neutral' => 0,
                    'points' => 0,
                    'count' => 0
                );
                $start_date = $default_start_date;
                $date = $default_date;
                mt_srand(time());
                for (
                    $i = 1; $i <= $amount; $i++
                ) {
                    if ($i % 5 == 0) {
                        $start_date = strtotime('+1 day', $start_date);

                        $date = new MongoDate($start_date);
                    }
                    foreach (
                        $sites as $site
                    ) {
                        $review_amount = rand(2, 5);
                        for (
                            $j = 0; $j < $review_amount; $j++
                        ) {
                            $content = $this->random_gen(mt_rand(80, 150));
                            $score = mt_rand(1, 5);
                            $doc = array(
                                'score' => $score,
                                'date' => $date,
                                'site' => $site,
                                'tags' => null,
                                'notes' => '',
                                'rating' => '',
                                'content' => $content,
                                'title' => substr($content, 0, 40) . '...',
                                'identity' => 'Guest' . mt_rand(600, 1000),
                                'category' => '',
                                'status' => 'OPENED',
                                'loc' => $location_id

                            );

                            if (!isset($metric_entries['scoreboard'][$date->sec])) {
                                $metric_entries['scoreboard'][$date->sec] = array(
                                    'type' => 'scoreboard',
                                    'date' => $date,
                                    'period' => 'day',
                                    'aggregates' => array()

                                );
                                $metric_entries['reviews'][$date->sec] = array(
                                    'type' => 'reviews',
                                    'date' => $date,
                                    'period' => 'day',
                                    'aggregates' => array()

                                );

                            }

                            $scoreboard = &$metric_entries['scoreboard'][$date->sec];
                            $review = &$metric_entries['reviews'][$date->sec];

                            if (!isset($scoreboard['aggregates'][$location_id])) {
                                $scoreboard_entry = array(
                                    'negative' => 0,
                                    'positive' => 0,
                                    'neutral' => 0,
                                    'points' => 0,
                                    'count' => 0
                                );
                                $scoreboard['aggregates'][$location_id] = $scoreboard_entry;


                                $all_sites = $sites;
                                $review_entry = array();
                                foreach (
                                    $all_sites as $card_site
                                ) {
                                    $review_entry[$card_site] = array(
                                        'negative' => 0,
                                        'positive' => 0,
                                        'neutral' => 0,
                                        'points' => 0,
                                        'count' => 0
                                    );
                                }

                                $review['aggregates'][$location_id] = $review_entry;


                            }
                            $id = time();

                            $s[$id] = &$scoreboard['aggregates'][$location_id];
                            $r[$id] = &$review['aggregates'][$location_id];

                            if ($score >= 4) {
                                $s[$id]['positive'] += 1;
                                $r[$id][$site]['positive'] += 1;
                                $scoreboard_overall['aggregates'][$location_id]['positive']++;
                                $doc['rating'] = 'positive';
                            } else {
                                if ($score >= 3) {
                                    $s[$id]['neutral'] += 1;
                                    $r[$id][$site]['neutral'] += 1;
                                    $scoreboard_overall['aggregates'][$location_id]['neutral']++;
                                    $doc['rating'] = 'neutral';
                                } else {
                                    $s[$id]['negative'] += 1;
                                    $r[$id][$site]['negative'] += 1;
                                    $scoreboard_overall['aggregates'][$location_id]['negative']++;
                                    $doc['rating'] = 'negative';
                                }
                            }
                            $review_entries[] = $doc;
                            $s[$id]['points'] += $score;
                            $s[$id]['count'] += 1;
                            $r[$id][$site]['points'] += $score;
                            $r[$id][$site]['count'] += 1;
                            $scoreboard_overall['aggregates'][$location_id]['points'] += $score;
                            $scoreboard_overall['aggregates'][$location_id]['count'] += 1;


                        }
                    }


                }
            }
            $all_metrics = array();
            foreach (
                $metric_entries as $type
            ) {
                foreach (
                    $type as $date
                    => $records
                ) {
                    $all_metrics[] = $records;
                }
            }
            $all_metrics[] = $scoreboard_overall;

            $this->time();
            $metrics->batchInsert($all_metrics);
            $this->time(false, "reviews.$location_id.metrics (" . count($all_metrics) . ')');
            $this->time();
            $reviews->batchInsert($review_entries);
            $this->time(false, "reviews.$location_id.entries (" . count($review_entries) . ')');

            /* $this->apiResponse = array(
                'reviews' => $review_entries,
                'metrics' => $metric_entries
            );*/
            // $this->apiResponse = array('dump' => print_r($metric_entries));
        }


        function fixtures_socials($db)
        {

            $amount = 100;
            $displacement = 5;
            $distance = $amount / $displacement;
            $default_start_date = strtotime('-' . ($distance / 2) . ' days');
            $default_date = new MongoDate($default_start_date);

            $social_actions = array(

                'twitter.com'
                => array(
                    'site' => 'twitter.com',
                    'activity'
                    => array(
                        'tweet',
                        'mention',
                        'hashtag'
                    ),
                    'subscriber'
                    => array(
                        'follower'
                    )

                ),

                'facebook.com'
                => array(
                    'site' => 'facebook.com',
                    'activity'
                    => array(
                        'wall-post',
                        'comment',
                        'like',
                        'page-visit',
                        'photo-post',
                        'video-post',
                        'check-in'
                    ),
                    'subscriber'
                    => array(
                        'like',
                        'active-users'
                    )

                ),

                'flickr.com'
                => array(
                    'site' => 'flickr.com',
                    'activity'
                    => array(
                        'photo',
                        'tag'
                    ),
                    'subscriber'
                    => array(
                        'people'
                    )

                ),
                'youtube.com'
                => array(
                    'site' => 'youtube.com',
                    'activity'
                    => array(
                        'upload',
                        'view'
                    ),
                    'subscriber'
                    => array(
                        'subscriber'
                    )

                ),
                'foursquare.com'
                => array(
                    'site' => 'foursquare.com',
                    'activity'
                    => array(
                        'check-in',
                        'tip',
                        'photo'
                    ),
                    'subscriber'
                    => array(
                        'people',
                        'mayor'
                    )

                )

            );
            $default_activity = array_map(array($this, 'map_activity'), $social_actions);
            $default_subscriber = array_map(array($this, 'map_reach'), $social_actions);

            $socials = new MongoCollection($db, 'socials');
            $socials->ensureIndex(array('date' => 1, 'loc' => 1), array('background' => TRUE));

            $metrics = new MongoCollection($db, 'metrics');
            $metrics->ensureIndex(array('date' => 1, 'type' => 1, 'period' => 1), array('background' => TRUE));
            $sites = array(

                'twitter.com',
                'facebook.com',
                'flickr.com',
                'youtube.com',
                'foursquare.com'

            );

            $metric_entries = array('social.activity' => array(), 'socials' => array(), 'social.reach' => array());
            $social_entries = array();


            $activity_overall = array(
                'type' => 'social.activity',
                'date' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)),
                'period' => 'overall',
                'aggregates' => array()

            );
            $subscriber_overall = array(
                'type' => 'social.subscribers',
                'date' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)),
                'period' => 'overall',
                'aggregates' => array()

            );
            for (
                $location_id = 1; $location_id <= 4; $location_id++
            ) {
                $activity_overall['aggregates'][$location_id] = $default_activity;

                $subscriber_overall['aggregates'][$location_id] = $default_subscriber;
                $start_date = $default_start_date;
                $date = $default_date;
                mt_srand(time());
                for (
                    $i = 1; $i <= $amount; $i++
                ) {
                    if ($i % 5 == 0) {
                        $start_date = strtotime('+1 day', $start_date);

                        $date = new MongoDate($start_date);
                    }
                    foreach (
                        $sites as $site
                    ) {
                        $metrics_types = array('activity', 'subscribers');
                        foreach (
                            $metrics_types as $metric
                        ) {
                            $review_amount = rand(2, 5);
                            for (
                                $j = 0; $j < $review_amount; $j++
                            ) {
                                $content = $this->random_gen(mt_rand(40, 124));
                                $defaults = $metric == 'activity' ? $default_activity : $default_subscriber;
                                $keys = array_keys($defaults[$site]);

                                $index = mt_rand(0, count($keys) - 1);
                                try {
                                    $action = $keys [$index];
                                } catch (Exception $e) {
                                    echo $e;
                                }
                                $doc = array(

                                    'date' => $date,
                                    'site' => $site,
                                    'metric' => $metric,
                                    'action' => $action,
                                    'network' => ucfirst(substr($site, 0, -4)),
                                    'tags' => array(),
                                    'notes' => '',
                                    'content' => $content,
                                    'title' => substr($content, 0, 40) . '...',
                                    'identity' => 'Guest' . mt_rand(600, 1000),
                                    'category' => '',
                                    'status' => 'OPENED',
                                    'loc' => $location_id,
                                    'link' => "http://" . $site . '/' . $this->random_gen(mt_rand(10, 15))

                                );
                                $social_entries[] = $doc;
                                if (!isset($metric_entries['social.activity'][$date->sec])) {
                                    $metric_entries['social.activity'][$date->sec] = array(
                                        'type' => 'social.activity',
                                        'date' => $date,
                                        'period' => 'day',
                                        'aggregates' => array()

                                    );
                                    $metric_entries['social.subscribers'][$date->sec] = array(
                                        'type' => 'social.subscribers',
                                        'date' => $date,
                                        'period' => 'day',
                                        'aggregates' => array()

                                    );


                                }

                                $activity = &$metric_entries['social.activity'][$date->sec];
                                $subscribers = &$metric_entries['social.subscribers'][$date->sec];


                                if (!isset($activity['aggregates'][$location_id])) {

                                    $activity['aggregates'][$location_id] = $default_activity;

                                    $subscribers ['aggregates'][$location_id] = $default_subscriber;


                                }
                                $id = time();

                                $a[$id] = &$activity['aggregates'][$location_id];
                                $s[$id] = &$subscribers['aggregates'][$location_id];


                                if ($metric == 'activity') {
                                    $a[$id][$site][$action] += 1;
                                    $activity_overall['aggregates'][$location_id][$site][$action] += 1;
                                } else {
                                    $s[$id][$site][$action] += 1;
                                    $subscriber_overall['aggregates'][$location_id][$site][$action] += 1;
                                }


                            }
                        }
                    }


                }
            }

            $all_metrics = array();
            foreach (
                $metric_entries as $type
            ) {
                foreach (
                    $type as $date
                    => $records
                ) {
                    $all_metrics[] = $records;
                }
            }
            $all_metrics[] = $subscriber_overall;
            $this->time();
            $metrics->batchInsert($all_metrics);
            $this->time(false, "socials.$location_id.metrics (" . count($all_metrics) . ')');
            $this->time();
            $socials->batchInsert($social_entries);
            $this->time(false, "socials.$location_id.entries (" . count($social_entries) . ')');


        }

        public
        function map_activity(
            $info
        )
        {
            $data = array();
            foreach (
                $info['activity'] as $type
            ) {
                $data[$type] = 0;
            }
            return $data;

        }

        public
        function map_reach(
            $info
        )
        {
            $data = array();
            foreach (
                $info['subscriber'] as $type
            ) {
                $data[$type] = 0;
            }
            return $data;
        }


    }
