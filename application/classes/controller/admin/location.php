<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 9/29/11
 * Time: 7:26 PM
 */

class Controller_Admin_Location extends  Admin_Controller_Base
{


    function action_queue()
    {
        $location_id = $this->request->post('location');
        $site = $this->request->post('site');
        $url = $this->request->post('url');
        $industry = $this->request->post('industry');
        $post = array(
            'location' => $location_id,
            'industry' => $industry,
            'queue'
            => array(
                $site => $url
            )

        );

        $request = Request::factory('/webhooks/queue/add');
        $request->method(Request::POST)->post($post);


        $response = json_decode($request->execute()->body());
        $session = Session::instance();
        $session->set('message', count($response->errors) ? 'Error adding to queue' : 'Added to queue');
        $this->request->redirect("admin/location/view/$location_id");

    }

    function action_view($location_id)
    {
        /*
        *
        * @var Model_Location
        */
        $location = new Model_Location($location_id);
        $mongo = new Mongo();
        $industry = $location->industry;
        $sites = Industry::sitesFor($industry);
        $sites = array_combine($sites, $sites);
        $db = $mongo->selectDB($industry);

        $queue = $mongo->selectDB('dashboard')->selectCollection('queues');

        $cursor = $queue->find(array('loc' => (int)$location_id));

        global $queue_items;
        array_map(
            function($doc)
            {
                global $queue_items;
                $queue_items[$doc['site']] = $doc;
            }, iterator_to_array($cursor, false)
        );


        $settings = new Model_Location_Settings($location_id);
        $competitors = $settings->getSetting('competitor');
        $competitors = array_values($competitors);
        if (!empty($competitors)) {
            // cached every 60 seconds
            $query = DB::select('id', 'name')
                    ->from('locations')
                    ->where('id', 'IN', $competitors);
            $query->cached(5 * 60); // twenty mins

            $result = $query->execute();
            $competitors = $result->as_array('id', 'name');
        } else {
            $competitors = array();
        }

        $query = array('loc' => array('$in' => array_keys($competitors)));
        /*
        $comp_queues = $queue->find($query);
        $comp_queues->sort(array("loc" => 1));
        global $comp_queue;
        $comp_queue = array();
        array_map(
            function($q)
            {
                global $comp_queue;

                $id = $q['loc'];
                if (!isset($comp_queue[$id])) {
                    $comp_queue[$id] = array();
                }
                $comp_queue[$id][] = $q;
            }, iterator_to_array($comp_queues)
        );*/
        $this->template->body = view::factory(
            'admin/location/index', array(
                'queue' => $queue_items,
                'competitors' => $competitors,
                'location' => $location,

                'sites' => $sites
            )
        );
    }


}
