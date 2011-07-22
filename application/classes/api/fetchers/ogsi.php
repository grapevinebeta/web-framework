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

            $db = $metrics = $this->_mongo->selectDB($this->_db);

            $keys = array();
            $locations = array_merge(array($this->_location), $this->_locations);

            $keys = array('type' => 1, 'period' => 1);

            $initial = array('count' => 0);
            $locations = '[' . join(',', $locations) . ']';
            $map
                    = "function(){
                    $locations.forEach(function(location){
                        
                    });
                }";

            $reduce = "function (doc, prev) { prev.count++; }";

            // print_r($options);
            $locations = '[' . join(',', $locations) . ']';
            $map
                    = "function(){
                    var locations=$locations;
                   var agg=this.aggregates;
                    
                    locations.forEach(function(location){
                        var value={count:0,points:0};
                        var loc=agg[location];
                        if(typeof loc != 'undefined'){

                                value.count=loc.count;
                                value.points=loc.points;
                            
                          }
                          emit(location,value);
                     });
                }";
            $reduce
                    = 'function(doc,values){
                var result = {count: 0, points: 0};

                    values.forEach(function(value) {
                      result.count += value.count;
                      result.points += value.points;
                    });

                    return result;
                   }
            ';
            $return = $db->command(
                array(
                    'mapreduce' => 'metrics',
                    'map' => $map,
                    'reduce' => $reduce,
                    'query'
                    => array(
                        'type' => 'scoreboard',
                        'date' => $this->_date,
                        'period' => 'day'

                    ), 'out' => array('inline' => 1)
                )
            );
            print_r($return);


        }
    }
