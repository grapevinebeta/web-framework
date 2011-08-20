<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 5:01 PM
 */

class Controller_Webhooks_Queue extends Controller
{

    protected $apiResponse;

    public function action_index()
    {

    }

    public function after()
    {
        $this->response->headers('Content-Type', 'application/json');
        $this->response->body(json_encode($this->apiResponse));
        parent::after();
    }

    public function action_add()
    {
        $location = $this->request->post('location');
        $location = intval($location);
        $industry = $this->request->post('industry');

        if (!Model_Location::validIndustry($industry)) {
            return;
        }
        $mongo = new Mongo();

        $entries = $this->request->post('queue');
        //automotive,hospitality,restaurant
        $mongo_db = $mongo->selectDB("dashboard");

        $queue = $mongo_db->selectCollection('queues');
        $queue->ensureIndex(array('loc' => 1, 'site' => 1), array('background' => TRUE, 'unique' => TRUE));
        $queue->ensureIndex(array('status' => 1, "site" => 1), array('background' => TRUE));


        $errors = array();
        foreach (
            $entries as $site
            => $value
        ) {
            if (is_string($value)) {
                $url = $value;
                $extra = array();
            } else {
                $url = Arr::get($value, 'url');
                $extra = Arr::get($value, 'extra', array());

            }
            if (!$url) {
                continue;
            }

            try {
                $queue->update(
                    array(
                        'loc' => $location,
                        'site' => $site
                    ),
                    array(
                        '$set'
                        => array(
                            'status' => 'waiting', // waiting,processing,finished
                            'url' => $url,
                            'started_at' => null,
                            'finished_at' => null,
                            'extra' => $extra,
                            'loc' => $location,
                            'site' => $site
                        )
                    )
                    , array('upsert' => TRUE, 'safe' => TRUE)
                );
            } catch (MongoCursorException $e) {
                $errors[$site] = $url;
            }
        }
        $this->apiResponse = array(
            'errors' => $errors
        );
    }
}
