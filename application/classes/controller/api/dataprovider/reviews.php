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


            $fields = array('status' => 1, 'score' => 1, 'date' => 1, 'site' => 1, 'title' => 1, '_id' => 1);

            $limit = 10;
            $expand = !is_null($this->id);
            if ($expand) {
                $fields = array_merge($fields, array('content' => 1, 'notes' => 1, 'tags' => 1, 'identity' => 1));
                $this->query = array("_id" => new  MongoId($this->id));
                $limit = -1;
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

        public function action_expand()
        {
            $this->action_index();

        }

        public function action_email()
        {


        }

        public function action_category()
        {

            $error = $this->update(array('$set' => array('category' => $this->request->post('category'))));

            $this->apiResponse = array('error' => $error);
        }

        public function action_notes()
        {
            $error = $this->update(array('$set' => array('notes' => $this->request->post('notes'))));
            $this->response = array('error' => $error);
        }

        public function action_status()
        {
            $status = $this->request->post('status');
            if (in_array($status, array('OPEN', 'CLOSED', 'TODO'))) {
                $error = $this->update(array('$set' => array('notes' => $status)));
            } else {
                $error = true;
            }


            $this->response = array('error' => $error);
        }

        public function action_stats()
        {
            $tags = $this->request->post('tags');
            if (is_array($tags)) {

                $error = $this->update(array('$set' => array('tags' => $tags)));
            } else {
                $error = true;
            }


            $this->response = array('error' => $error);
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
