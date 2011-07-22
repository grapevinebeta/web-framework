<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/21/11
 * Time: 7:23 PM
 */

    class Api_Fetchers_Ogsi extends Api_Fetchers_Base
    {


        private $_location;
        private $_locations;
        private $_db = 'auto';

        /**
         * @var \Mongo
         */
        private $_mongo;

        function __construct(Mongo $mongo, $location)
        {
            $this->_mongo = $mongo;
            $this->_location = $location;
        }


        public function competition(array $locations)
        {
            $this->_locations = $locations;
            return $this;

        }

        private $_distribution = false;

        public function distribution(bool $value)
        {
            $this->_distribution = value;
            return $this;
        }

        private $_reviews;

        public function reviews(bool $value)
        {
            $this->_reviews = value;
            return $this;
        }

        public function rating(bool $value)
        {
            $this->_rating = $value;
            return $this;
        }

        public function fetch()
        {
            $metrics = $this->_mongo->selectDB($this->_db)->selectCollection('reviews');
            $keys = array();
            $locations = array_merge(array($this->_location), $this->_locations);
           /* foreach (
                $locations as $location
            ) {
                $keys["type"] = TRUE;
                $keys['date']=TRUE;
            }*/
            $keys=array('type'=>1,'period'=>1);

         /*   $options = array(
                'condition'
                => array(
                    'type' => 'reviews',
                    'date' => $this->_date,
                    'period' => 'day'

                )
            );*/
            $initial = array('count' => 0);

            $reduce = new MongoCode('function(obj,prev){ prev.count++; }');

            print_r($keys);
            print_r($initial);
            print_r($reduce);
           // print_r($options);

            return $metrics->group($keys, $initial, $reduce);

        }
    }
