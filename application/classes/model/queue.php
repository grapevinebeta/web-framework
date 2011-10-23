<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/24/11
 * Time: 1:36 PM
 */

class Model_Queue
{


    private $sites = array();

    private $location_id;
    private $industry;

    public function __construct($location_id, $industry)
    {
        $this->location_id = $location_id;
        $this->industry = $industry;
    }

    public function save()
    {
        $queue_post = array(
            'industry' => $this->industry,
            'location' => $this->location_id, 'queue'
            => $this->sites

        );

        /**
         * @var $queue_response Response
         */
        $queue_response = Request::factory('webhooks/queue/add')
                ->post($queue_post)->execute();
        $queue_response = json_decode($queue_response->body(), true);

        if (count($queue_response['errors'])) {
            //$this->failed('insert_into_queue', $queue_response['errors']);
            return false;
        }
        return true;
    }

    public function add($site, $url, $extra = array())
    {

        $this->sites[$site] = array(
            'url' => $url,
            'extra' => $extra
        );

    }

}