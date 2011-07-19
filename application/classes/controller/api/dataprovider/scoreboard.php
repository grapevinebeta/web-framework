<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 7:21 AM
 */

    class Controller_Api_DataProvider_ScoreBoard extends Controller_Api_DataProvider_Base
    {


        public function fetch_overall()
        {
            $reviews = $this->db->selectCollection('metrics');

            $doc = $reviews->findOne(
                array(
                    'date' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)),
                    'type' => 'scoreboard',
                    'period' => 'overall'
                ), array('aggregates.1' => 1)
            );
            $doc = $doc['aggregates']['1'];

            return array(
                'ogsi' => 0,
                'rating'
                => array(
                    'negative' => $doc['negative'],
                    'positive' => $doc['positive'],
                    'neutral' => $doc['neutral'],
                    'score' => floatval(number_format($doc['points'] / $doc['count'], 1))
                ),
                'reviews' => $doc['count']

            );


        }

        public function action_overall()
        {
            $this->apiResponse = array('overall' => $this->fetch_overall());
        }

        public function action_current()
        {
            $this->apiResponse = array('current' => $this->fetch_current());
        }

        public function action_index()
        {
            $this->apiResponse = array(
                'overall' => $this->fetch_overall(),
                'current' => $this->fetch_current()
            );

        }

        public function fetch_current()
        {
            $reviews = $this->db->selectCollection('metrics');


            $cursor = $reviews->find(
                array(
                    'date'
                    => array(
                        '$gte' => new MongoDate(mktime(0, 0, 0, 1, 1, 1970)), '$lte' => $this->endDate
                    ),
                    'type' => 'scoreboard',
                    'period' => 'day'
                ), array('aggregates.1' => 1)
            );

            /**
             * ScoreBoardObject{
            ogsi:[number:required] -
            rating:{
            negative:[int:required] - number of negative
            positive:[int:required] - number of positive
            neutral:[int:required] - number of neutral
            score:[int:required] - computed star rating
            }
            reviews:[int:required]

            }
             */
            //TODO fetch compentation
            $response = array(
                'ogsi' => 0

            );
            $rating = array(
                'negative' => 0,
                'positive' => 0,
                'neutral' => 0,
                'score' => 0
            );
            $total_counts = 0;
            $total_points = 0;
            foreach (
                $cursor as $doc
            ) {
                $doc = $doc['aggregates']['1'];

                $rating['negative'] += $doc['negative'];
                $rating['positive'] += $doc['positive'];
                $rating['neutral'] += $doc['neutral'];
                $total_counts += $doc['count'];
                $total_points += $doc['points'];

            }
            $rating['score'] = floatval(number_format($total_points / $total_counts, 1));
            $response['rating'] = $rating;
            $response['reviews'] = $total_counts;

            return $response;
        }
    }
