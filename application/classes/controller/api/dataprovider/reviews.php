<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 6:49 AM
 */

    class Controller_Api_DataProvider_Reviews extends Controller_Api_DataProvider_Content
    {


        protected $collection = "reviews";
        protected $default_fields
        = array('rating' => 1, 'status' => 1, 'score' => 1, 'date' => -1, 'site' => 1, 'title' => 1, '_id' => 1);
        protected $expanded_fields = array('content' => 1, 'notes' => 1, 'tags' => 1, 'category' => 1, 'identity' => 1);

        public function before()
        {
            parent::before();

        }


        public function setFilters()
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

        public function action_alerts()
        {
            $status = $this->request->post('status');

            $this->apiResponse['alerts'] = $this->find(
                'reviews', array(
                    'loc' => $this->location, 'status' => $status
                )
            )->count();

        }


        /**
         * @todo Eric change it to the proper implementation, this is
         * just a placeholder
         */
        public function action_categories()
        {

            $automotive = array(
                '' => 'Select',
                'General', 'Sales', 'Service', 'Parts', 'Finance'
            );

            $restaurants = array(
                '' => 'Select',
                'General', 'Food', 'Service'
            );

            $this->apiResponse['categories'] = $automotive;

        }

        public function action_ogsi()
        {
            $ogsi = new Api_Fetchers_Ogsi($this->mongo, $this->location);
            $this->apiResponse = $ogsi->competition(array(2, 3, 4))
                    ->range(new MongoDate(mktime(0, 0, 0, 1, 1, 1970)), $this->endDate)->fetch();
        }

        public function action_sites()
        {
            $metrics = $this->db->selectCollection('metrics');
            $fetcher = new Api_Fetchers_Metrics($this->mongo);
            $fetcher->type('reviews')
                    ->range($this->startDate, $this->endDate)
                    ->location($this->location);

            $sites = array();
            foreach (
                $fetcher as $doc
            ) {

                foreach (
                    $doc as $site
                    => $site_info
                ) {


                    if (!isset($sites[$site])) {
                        $sites[$site] = array(
                            'site' => $site,
                            'positive' => 0,
                            'negative' => 0,
                            'neutral' => 0,
                            'total' => 0,
                            'average' => 0,

                        );
                    }
                    foreach (
                        $site_info as $key
                        => $value
                    ) {
                        if (isset($sites[$site][$key])) {
                            $sites[$site][$key] += $value;
                        }
                    }
                    $sites[$site]['total'] += $site_info['count'];
                    $sites[$site]['average'] += $site_info['points'];
                }


            }

            foreach (
                $sites as $site
                => &$data
            ) {
                $data['average'] = number_format($data['average'] / $data['total'], 1);

            }

            $this->apiResponse['sites'] = $sites;
        }


        public function action_email()
        {


        }

        public function action_category()
        {

            // since all requests are done as an array we get the single instance

            $category = $this->request->post('category');


            $error = $this->update(array('$set' => array('category' => $category)));


            $this->apiResponse = array('error' => $error);
        }

        public function action_notes()
        { // since all requests are done as an array we get the single instance
            $notes = $this->request->post('notes');

            $error = $this->update(array('$set' => array('notes' => $notes)));
            $this->apiResponse = array('error' => $error, 'review' => $this->action_expand());
        }

        public function action_status()
        {
            $status = $this->request->post('status');
            if (in_array($status, array('OPEN', 'CLOSED', 'TODO'))) {
                $error = $this->update(array('$set' => array('status' => $status)));
            } else {
                $error = true;
            }


            $this->apiResponse = array('error' => $error);
        }

        public function action_tags()
        {
            $tags = $this->request->post('tags');
            if (is_array($tags)) {

                $error = $this->update(array('$set' => array('tags' => $tags)));
            } else {
                $error = true;
            }


            $this->apiResponse = array('error' => $error);
        }


    }
