<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/22/11
 * Time: 8:32 AM
 */

class Controller_Api_DataProvider_Competition extends Controller_Api_DataProvider_Content
{


    protected $collection = "reviews";
    protected $default_fields
    = array('loc' => 1, 'status' => 1, 'score' => 1, 'date' => -1, 'site' => 1, 'title' => 1, '_id' => 1);
    protected $expanded_fields
    = array('loc' => 1, 'content' => 1, 'notes' => 1, 'tags' => 1, 'category' => 1, 'identity' => 1);


    protected function findContent($fields, $limit=-1)
    {
        $this->query['loc'] = array('$in' => array(2, 3, 4));
        $cursor = parent::findContent($fields, $limit);
        // TODO keyston : fetch location names
        $location_names = array(1 => 'Location 1', 2 => 'Location 2', 3 => 'Location 3', 4 => 'Location 4');
        foreach (
            $this->content as &$doc
        ) {

            $doc['competition'] = $location_names[$doc['loc']];
        }
        return $cursor;
    }


    protected function setFilters()
    {
        $this->filters = array(

            new Api_Filters_Neutral(),
            new Api_Filters_Positive(),
            new Api_Filters_Negative(),
            new Api_Filters_Alert(),
            new Api_Filters_Flagged(),
            new Api_Filters_Completed(),
            new Api_Filters_Site(array(
                    'citysearch.com', 'dealerrater.com', 'edmunds.com', 'insiderpages.com', 'judysbook.com',
                    'mydealreport.com', 'superpages.com', 'yelp.com'
                ),
                $this->activeFilters
            )
        );
    }

    public function action_ogsi()
    {
        $fetcher = new Api_Fetchers_Ogsi($this->mongo, $this->location);

        // TODO keyston : fetch location names
        $settings = new Model_Location_Settings($this->location);
        $competitors = $settings->getSetting('competitor');


        $location_names = array(1 => 'Location 1', 2 => 'Location 2', 3 => 'Location 3', 4 => 'Location 4');
        $competition = $location_names;
        unset($competition[$this->location]);

        $competition = array_keys($competition);

        $total_locations = count($location_names);
        $ogsis = $fetcher->competition($competition);
        $alltime = $this->request->post('alltime');
        if (!empty($alltime)) {
            $fetcher->range($this->epoch());
        } else {
            $fetcher->range($this->startDate, $this->endDate);
        }

        $ogsis = $fetcher->all(true)->fetch();


        $fetcher
                = new Api_Fetchers_Distribution($this->mongo, array_keys($location_names));
        $fetcher->range($this->startDate, $this->endDate);
        $distributions = $fetcher->fetch();

        // first -> last
        arsort($ogsis);

        $results = array();
        $rank = 1;
        foreach (
            $ogsis as $location
            => $score
        ) {
            $location_name = $location_names[$location];
            $results[$location_name]['ogsi'] = array(
                'value' => number_format($score, 2),
                'competition' => $location_name,
                'loc' => $location,
                'rank'
                => array(
                    'out' => $total_locations,
                    'value' => $rank++
                )
            );

        }
        $rank = 1;

        /*
        $sort = new Sorter('score', -1);
        $distributions = $sort->sort($distributions);

        foreach (
            $distributions as $location
            => $doc
        ) {
            $location_name = $location_names[$location];
            $results[$location_name]['distribution'] = array(
                'positive' => $doc['positive'],
                'negative' => $doc['negative'],
                'neutral' => $doc['neutral'],
                'total' => $doc['count'],
                'average' => $doc['score'],
                'rank'
                => array(
                    'out' => $total_locations,
                    'value' => $rank++
                )
            );

        }*/
        //reviews
        $sort = new Sorter('count', -1);
        $distributions = $sort->sort($distributions);
        foreach (
            $distributions as $location
            => $doc
        ) {
            $location_name = $location_names[$location];
            $results[$location_name]['reviews'] = array(
                'value' => $doc['count'],
                'competition' => $location_name,
                'rank'
                => array(
                    'value' => $rank++,
                    'out' => $total_locations
                )
            );


        }
        //ratings/score
        $rank = 1;
        $sort = new Sorter('score', -1);
        $distributions = $sort->sort($distributions);
        foreach (
            $distributions as $location
            => $doc
        ) {
            $location_name = $location_names[$location];
            $results[$location_name]['rating'] = array(
                'value' => number_format($doc['score'], 2),
                'competition' => $location_name,
                'rank'
                => array(
                    'value' => $rank++,
                    'out' => $total_locations
                )
            );


        }


        $this->apiResponse['ogsi'] = $results;


    }

    public function action_distribution()
    {
        $location_names = array(1 => 'Location 1', 2 => 'Location 2', 3 => 'Location 3', 4 => 'Location 4');
        $competition = $location_names;
        unset($competition[$this->location]);


        $total_locations = count($location_names);
        $fetcher
                = new Api_Fetchers_Distribution($this->mongo, array_keys($location_names));
        $fetcher->range($this->startDate, $this->endDate);
        $distributions = $fetcher->fetch();

        $sort = new Sorter('score', -1);
        $distributions = $sort->sort($distributions);

        $results = array();
        $rank = 1;
        foreach (
            $distributions as $location
            => $doc
        ) {
            $location_name = $location_names[$location];
            $results[$location_name] = array(
                'positive' => $doc['positive'],
                'negative' => $doc['negative'],
                'neutral' => $doc['neutral'],
                'total' => $doc['count'],
                'average' => number_format($doc['score'], 2),
                'competition' => $location_name,
                'rank'
                => array(
                    'out' => $total_locations,
                    'value' => $rank++
                )
            );

        }
        $this->apiResponse['distribution'] = $results;
    }


    public function action_comparsion()
    {
        $location_names = array(1 => 'Location 1', 2 => 'Location 2', 3 => 'Location 3', 4 => 'Location 4');


        $dateInterval = $this->request->post('dateInterval');
        if (empty($dateInterval)) {
            $dateInterval = 6;
        }
        $start_time = $this->startDate->sec;


        $end_time = $this->endDate->sec;

        $seconds_step = floor(($end_time - $start_time) / $dateInterval);
        $dates = array();
        for (
            $i = 0; $i < $dateInterval; $i++
        ) {
            $dates[] = strtotime('+ ' . ($seconds_step * $i) . ' seconds', $start_time);
        }


        $js_locations = '[' . join(',', array_keys($location_names)) . ']';
        $js_dates = '[' . join(',', $dates) . ']';
        $map
                = "function(){
                var dates=$js_dates;
                var date;
                var len=dates.length;
                var time =this.date.getTime()/ 1000;

                for(var i=0;i<len;i++){
                    date =dates[i];
                    if(time>=date && time<=dates[i+1])break;
                }
                var agg=this.aggregates;
                  var locs = $js_locations;
                    locs.forEach(function(location){
                        if(agg[location]){
                            emit({date:date,location:location},agg[location]);
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
        $db = $this->mongo->selectDB('auto');
        $command = array(
            'mapreduce' => 'metrics',
            'query'
            => array(
                'type' => 'scoreboard',
                'date'
                => array('$gte' => $this->startDate, '$lte' => $this->endDate),

                'period' => 'day'
            ),
            'map' => $map,
            'reduce' => $reduce,
            'out' => array('inline' => TRUE),
            'finalize' => $finalize
        );

        $return = $db->command($command);
        $results = array();
        foreach (
            $return['results'] as $doc
        ) {
            $id = $doc['_id'];


            $results[$id['date']][$id['location']] = $doc['value']['score'];


        }
        $final = array();
        foreach (
            $dates as $date
        ) {
            foreach (
                $location_names as $location_id
                => $name
            ) {
                $value = 0;
                if (isset($results[$date]) && isset($results[$date][$location_id])) {
                    $value = $results[$date][$location_id];
                }
                $final[$date][] = array(
                    'competition' => $name,
                    'value' => number_format($value, 2)
                );
            }
        }
        $this->apiResponse['comparision'] = $final;
    }


}


