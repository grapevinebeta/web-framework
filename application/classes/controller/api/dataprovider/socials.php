<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/21/11
 * Time: 12:06 PM
 */

    class Controller_Api_DataProvider_Socials extends Controller_Api_DataProvider_Content
    {

        protected $collection = "socials";
        protected $default_fields = array('status' => 1, 'date' => -1, 'site' => 1, 'network' => 1, 'title' => 1);
        protected $expanded_fields = array('content' => 1, 'notes' => 1, 'identity' => 1);

        protected function setFilters()
        {
            $this->filters = array();
        }

        protected function findMetrics($name, $date, $config, $period)
        {

        }

        public function action_activity()
        {
            $this->apiResponse['networks'] = $this->fetch_metric('activity');

        }

        public function action_subscribers()
        {
            $this->apiResponse['networks'] = $this->fetch_metric('subscribers');

        }

        protected function fetch_metric($type, $period = 'day')
        {
            $fetcher = new Api_Fetchers_Metrics($this->mongo);
            $fetcher->type("social.$type")->location($this->location)
                    ->range($this->startDate, $this->endDate)
                    ->period($period);


            $entries = array();
            foreach (
                $fetcher as $doc
            ) {
                /**
                 * {
                 *  site:{
                 *      type:value
                 * },
                 * site:{
                 * type:value
                 * }
                 */
                foreach (
                    $doc as $site
                    => $actions
                ) {
                    foreach (
                        $actions as $name
                        => $value
                    ) {
                        $key = "$site.$name";
                        if (!isset($entries[$key])) {
                            $entries[$key] = array(
                                'network' => $site,
                                'action' => $name,
                                'total' => 0
                            );
                        }
                        $entries[$key]['total'] += $value;
                    }

                }
            }

            return array_values($entries);
        }
    }
