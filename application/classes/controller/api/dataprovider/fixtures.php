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
            srand((double)microtime() * 1000000);
            $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $char_list .= "abcdefghijklmnopqrstuvwxyz";
            $char_list .= "1234567890";
            // Add the special characters to $char_list if needed

            $char_length = strlen($char_list);
            for (
                $i = 0; $i < $length; $i++
            )
            {
                $random .= substr($char_list, (rand() % ($char_length)), 1);
            }
            return $random;
        }

        public function action_index()
        {

            $amount = 100;
            $displacement = 5;
            $distance = $amount / $displacement;
            $start_date = strtotime('-' . ($distance / 2) . ' days');
            $date = new MongoDate($start_date);


            $db = $this->mongo->selectDB('auto');
            $db->drop();


            $reviews = new MongoCollection($db, 'reviews');
            $reviews->ensureIndex(array('date' => 1, 'lid' => 1), array('background' => TRUE));

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

            $location_id = 1;
            $scoreboard_overall = array(
                'type' => 'scoreboard',
                'date' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)),
                'period' => 'overall',
                'aggregates'
                => array(
                    '1'
                    => array(
                        'negative' => 0,
                        'positive' => 0,
                        'neutral' => 0,
                        'points' => 0,
                        'count' => 0
                    )
                )
            );
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
                            'tags' => array(),
                            'notes' => array(),
                            'content' => $content,
                            'title' => substr($content, 0, 40) . '...',
                            'identity' => 'Guest' . mt_rand(600, 1000),
                            'category' => '',
                            'status' => 'OPENED',
                            'lid' => $location_id

                        );
                        $review_entries[] = $doc;
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
                        } else {
                            if ($score >= 3) {
                                $s[$id]['neutral'] += 1;
                                $r[$id][$site]['neutral'] += 1;
                                $scoreboard_overall['aggregates'][$location_id]['neutral']++;
                            } else {
                                $s[$id]['negative'] += 1;
                                $r[$id][$site]['negative'] += 1;
                                $scoreboard_overall['aggregates'][$location_id]['negative']++;
                            }
                        }
                        $s[$id]['points'] += $score;
                        $s[$id]['count'] += 1;
                        $r[$id][$site]['points'] += $score;
                        $r[$id][$site]['count'] += 1;
                        $scoreboard_overall['aggregates'][$location_id]['points'] += $score;
                        $scoreboard_overall['aggregates'][$location_id]['count'] += 1;


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
            $metrics->batchInsert($all_metrics);
            $reviews->batchInsert($review_entries);

            /* $this->apiResponse = array(
                'reviews' => $review_entries,
                'metrics' => $metric_entries
            );*/
            // $this->apiResponse = array('dump' => print_r($metric_entries));
        }


    }
