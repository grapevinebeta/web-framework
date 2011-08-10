<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/22/11
 * Time: 10:09 AM
 */

class Api_Fetchers_Distribution extends Api_Fetchers_Base
{


    private $_locations;

    function __construct($mongo, array $locations)
    {
        parent::__construct($mongo);
        $this->_locations = $locations;
        return $this;

    }

    public function fetch()
    {

        $js_locations = '[' . join(',', $this->_locations) . ']';
        $map
                = "function(){
                        var agg=this.aggregates;
                     var locs = $js_locations;
                    locs.forEach(function(location){
                        if(agg[location]){
                            emit(location,agg[location]);
                         }

                    });
                    }";

        $reduce
                = 'function(key,values){
                        var results={negative:0,positive:0,neutral:0,points:0,count:0};
                        values.forEach(function(value){
                                for(var type in value){
                                 results[type]+=value[type];
                                }
                          });

                        return results;
                    }';
        $finalize
                = 'function(key,results){
                    results.score = (results.points/results.count).toFixed(3);
                    return results;
            }';
        $db = $this->_mongo->selectDB('auto');
        $command = array(
            'mapreduce' => 'metrics',
            'query'
            => array(
                'type' => 'scoreboard',
                'date'
                => $this->_date,

                'period' => $this->_period
            ),
            'map' => $map,
            'reduce' => $reduce,
            'out' => array('inline' => TRUE),
            'finalize' => $finalize
        );

        $results = $db->command($command);

        $defaults = array('negative', 'positive', 'neutral', 'points', 'count', 'score');
        $single = count($this->_locations) == 1;
        $return = array_fill_keys($this->_locations, array_fill_keys($defaults, 0));
        foreach (
            $results['results'] as $doc
        ) {
            if ($single) {
                return $doc['value'];
            }
            $return[$doc['_id']] = $doc['value'];

        }
        return !$single ? $return : $return[$this->_locations[0]];
    }
}
