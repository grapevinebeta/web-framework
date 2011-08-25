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
    private $_all = false;
    private $_db = 'automotive';


    function __construct(Mongo $mongo, $location, $db = 'automotive')
    {
        parent::__construct($mongo);
        $this->_location = $location;
        $this->_db = $db;
    }


    public function all($value)
    {
        $this->_all = $value;
        return $this;
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


        $locations = array_merge(array($this->_location), $this->_locations);


        $js_locations = '[' . join(',', $locations) . ']';
        $map
                = "function(){
                    var agg=this.aggregates;
                    var locs = $js_locations;
                    locs.forEach(function(location){
                        if(agg[location]){
                            emit(location,{count:agg[location].count,points:agg[location].points});
                         }

                    });
                 }";

        $reduce
                = 'function(key,values){
                        var results={count:0,points:0};
                        values.forEach(function(value){
                               results.count+=value.count;
                               results.points+=value.points;

                          });

                        return results;
                    }';
        $finalize
                = 'function(key,results){
                    results.score = (results.points/results.count).toFixed(3);
                    return results;
                    
            }';

        $command = array(
            'mapreduce' => 'metrics',
            'map' => $map,
            'reduce' => $reduce,
            'query'
            => array(
                'type' => 'scoreboard',
                'date' => $this->_date,
                'period' => $this->_period

            ), 'out' => array('inline' => 1),
            'finalize' => $finalize
        );

        $db = $this->_mongo->selectDB($this->_db);
        $return = $db->command(
            $command
        );


        $final = array();

        $for = $this->_all ? $locations : array($this->_location);
        foreach (
            $for as $location
        ) {
            $score = $this->compute($location, $return['results']);
            if (!$this->_all) {
                return $score;
            }
            $final[$location] = $score;
        }
        return $final;


    }

    private function compute($location, array &$docs)
    {
        $competition_set_average = 0;
        $locations = 0;
        $location_score = 0;
        foreach (
            $docs as $doc
        ) {
            if ($doc['_id'] == $location) {
                $location_score = $doc['value']['score'];
            }
            $competition_set_average += $doc['value']['score'];
            $locations++;
        }
        if (!$locations || !$competition_set_average) {
            return 0;
        }
        /* echo "Total score: $competition_set_average \n";
        echo "Total locations : " . count($locations) . "\n";*/
        $competition_set_average = $competition_set_average / $locations;
        /*  echo "competition_set_average : $competition_set_average\n";
        echo "location $this->_location score : " . $location_score. "\n";*/
        return ($location_score / $competition_set_average) * 100;

    }
}
