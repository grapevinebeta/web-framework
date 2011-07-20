<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 6:49 AM
 */

    class Controller_Api_DataProvider_Reviews extends Controller_Api_DataProvider_Base
    {


        /**
         * @var MongoCollection
         */
        protected $reviews;

        public function before()
        {
            parent::before();
            $this->reviews = $this->db->selectCollection('reviews');
        }

        public function action_index()
        {

            $expand = !is_null($this->id);
            if (!$expand) {
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


            $fields = array('status' => 1, 'score' => 1, 'date' => 1, 'site' => 1, 'title' => 1, '_id' => 1);

            $limit = 10;

            if ($expand) {
                $fields = array_merge($fields, array('content' => 1, 'notes' => 1, 'tags' => 1, 'category' => 1, 'identity' => 1));
                $this->query = array("_id" => new  MongoId($this->id));
                
                $doc = $this->findOne('reviews', $this->query, $fields);
                $doc['date'] = $doc['date']->sec;
                $doc['id'] = $doc['_id']->{'$id'};
                unset($doc['_id']);
                
                $this->apiResponse = array(
                    'review' =>$doc
                );
                
                return;
                        
                
            }

            $cursor = $this->query('reviews', $this->query, $fields, $limit);

            $reviews = array();
            foreach (
                $cursor as $doc
            ) {
                if ($this->matches_filter($doc)) {
                    $doc['date'] = $doc['date']->sec;
                    $doc['id'] = $doc['_id']->{'$id'};
                    unset($doc['_id']);
                    $reviews[] = $doc;

                }
            }
            $this->apiResponse = array(
                'reviews' => $reviews,
                'filters' => $this->filterResponse,
                'pagination'
                => array('page' => $this->request->post('page'), 'pagesCount' => ceil($cursor->count() / 10))
            );


        }
        
        
        /**
         * @todo Eric change it to the proper implementation, this is 
         * just a placeholder
         */
        public function action_categories()
        {
            $this->apiResponse['categories'] = 
                    array(1 => 'shopping', 2 => 'important', 3 => 'it', 4 => 'travel', 5 => 'sport');

        }
        
        public function action_sites()
        {
            $metrics = $this->db->selectCollection('metrics');
            $cursor = $metrics->find(
                array(
                    'date' => array('$gte' => $this->startDate, '$lte' => $this->endDate),
                    'type' => 'reviews',

                    'period' => 'day'

                ), array("aggregates.{$this->location}" => 1)
            );
            $sites = array();
            foreach (
                $cursor as $doc
            ) {
                $doc = $doc['aggregates'][$this->location];
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

        public function action_expand()
        {
            $this->action_index();

        }

        public function action_email()
        {


        }

        public function action_category()
        {

            // since all requests are done as an array we get the single instance

            $category=$this->request->post('category');
            
            $error = $this->update(array('$set' => array('category' => $category)));

            $this->apiResponse = array('error' => $error);
        }

        public function action_notes()
        {// since all requests are done as an array we get the single instance
            $notes=$this->request->post('notes');
            
            $error = $this->update(array('$set' => array('notes' => $notes)));
            $this->apiResponse = array('error' => $error);
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

        protected function update($newobj)
        {
            
            $this->reviews->update(
                array(
                    '_id' => new MongoId($this->id),


                ), $newobj

            );
        }
    }
