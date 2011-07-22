<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/22/11
 * Time: 8:32 AM
 */

    class Controller_Api_DataProvider_Competition extends Controller_Api_DataProvider_Base
    {


        public function action_ogsi()
        {
            $fetcher = new Api_Fetchers_Ogsi($this->mongo, $this->location);

            // TODO keyston : fetch location names
            $location_names = array(1 => 'Location 1', 2 => 'Location 2', 3 => 'Location 3', 4 => 'Location 4');
            $competition = $location_names;
            unset($competition[$this->location]);

            $competition = array_keys($competition);

            $total_locations = count($location_names);
            $ogsis = $fetcher->competition($competition)
                    ->range($this->startDate, $this->endDate)->all(true)->fetch(
            );


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
                    'value' => $score,
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
            $sort->sort($distributions);
            foreach (
                $distributions as $location
                => $doc
            ) {
                $location_name = $location_names[$location];
                $results[$location_name]['reviews'] = array(
                    'value' => $doc['count'],
                    'rank'
                    => array(
                        'value' => $rank++,
                        'out' => $total_locations
                    )
                );


            }
            //ratings/score
            $rank=1;
            $sort = new Sorter('score', -1);
            $sort->sort($distributions);
            foreach (
                $distributions as $location
                => $doc
            ) {
                $location_name = $location_names[$location];
                $results[$location_name]['rating'] = array(
                    'value' => $doc['score'],
                    'rank'
                    => array(
                        'value' => $rank++,
                        'out' => $total_locations
                    )
                );


            }
            

            $this->apiResponse['ogsi'] = $results;


        }
    }

    class Sorter
    {
        protected $column;

        private $direction = 1;

        function __construct($column, $direction = 1)
        {
            $this->column = $column;
            $this->direction = $direction;
        }

        function sort($table)
        {
            uasort($table, array($this, 'compare'));
            return $table;
        }

        function compare($a, $b)
        {
            if ($a[$this->column] == $b[$this->column]) {
                return 0;
            }
            $value = ($a[$this->column] < $b[$this->column]);
            if ($this->direction == 1) {
                return $value ? -1 : 1;
            }
            return $value ? 1 : -1;


        }
    }