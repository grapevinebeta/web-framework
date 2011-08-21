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


    protected function getFilters()
    {
        
        $sources = array(
            'Facebook' => 'facebook.com', 'Twitter' => 'twitter.com', 'Foursquare' => 'fouresquare.com'
        );
        $actions = array(
            'tweet',
            'mention',
            'hashtag',
            'follower',
            'wall-post',
            'comment',
            'like',
            'page-visit',
            'photo-post',
            'video-post',
            'check-in',
            'active-users',
            'check-in',
            'tip',
            'photo'
        );
        $actions = array_combine(array_map('ucfirst', array_values($actions)), array_values($actions));
        return array(
            'actions'
            => $actions,
            'source' => $sources

        );
    }
    protected function getFilterKinds(){
        return array("status","actions");
    }
     protected function getFilteredCountsMap()
    {
        return 'function(){
                     emit({},{site:this.site,action:this.action});

            }';
    }

    protected function getFilteredCountsReduce()
    {
        return
                'function(key,values){
            var results={source:{},actions:{}};

            values.forEach(function(value){
               results.source[value.site]=(results.source[value.site]||0)+1;
               results.actions[value.action]=(results.actions[value.action]||0)+1;
               
            });

            return results;
        }';
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
        $fetcher = new Api_Fetchers_Metrics($this->mongo,$this->industry());
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
                $site = str_replace('.com', '', $site);
                $site = ucfirst($site);
                foreach (
                    $actions as $name
                    => $value
                ) {

                    if (!isset($entries[$site])) {
                        $entries[$site] = array(
                            'network' => $site,
                            'categories' => array(),
                            'total' => 0
                        );
                    }
                    $entries[$site]['categories'][$name] = $value;
                    $entries[$site]['total'] += $value;
                }

            }
        }

        return array_values($entries);
    }
}
