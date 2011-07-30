<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/21/11
 * Time: 12:05 PM
 */

    class Controller_Api_DataProvider_Content extends Controller_Api_DataProvider_Base
    {

        protected $collection;
        protected $default_fields;
        protected $expanded_fields;


        protected $content = array();

        public function action_index()
        {
            $expand = !is_null($this->id);
            if (!$expand) {
                $this->setFilters();
            }


            $fields = $this->default_fields;
            // fetch the id
            $fields['_id'] = 1;

            $limit = 10;

            if ($expand) {
                $fields = array_merge(
                    $fields, $this->expanded_fields
                );
                $this->query = array("_id" => new  MongoId($this->id));

                $doc = $this->findOne($this->collection, $this->query, $fields);
                $doc['date'] = $doc['date']->sec;
                $doc['id'] = $doc['_id']->{'$id'};
                unset($doc['_id']);


                $this->apiResponse[Kohana_Inflector::singular($this->collection)] = $doc;

                return;


            }

            $cursor = $this->findContent($fields, $limit);
            $this->apiResponse = array(
                'filters' => $this->filterResponse,
                'pagination'
                => array('page' => $this->request->post('page'), 'pagesCount' => ceil($cursor->count() / 10))
            );
            $this->apiResponse[$this->collection] = $this->content;


        }

        protected function findContent($fields, $limit)
        {
            $results = array();

            $query = $this->defaultQuery();

            $filters = $this->request->post('filters');
            $status = Arr::get($filters, 'status');
            $sources = Arr::get($filters, 'sources');
            $conditions = array(
                'rating' => array(),
                'site' => array(),
                'status' => array(),

            );
            if (!empty($status)) {


                foreach (
                    $status as $status
                ) {
                    switch ($status) {
                    case 'negative':
                    case 'positive':
                    case 'neutral':
                        $conditions['rating'][] = $status;
                        break;
                    default:
                        $conditions['status'][] = $status;
                    }

                }
            }
            if (!empty($source)) {
                foreach (
                    $sources as $source
                ) {
                    $conditions['site'] = $source;
                }
            }
            foreach (
                $conditions as $cond
                => $values
            ) {

                if (empty($values)) {
                    continue;
                }
                if (count($values) == 1) {
                    $query[$cond] = $values[0];
                } else {
                    $query[$cond] = array('$in' => $values);
                }


            }


            //  die(print_r($query));
            $cursor
                    = $this->find($this->collection, $query, $fields, $limit);

            $cursor->sort(
                array(
                    'date'
                    => -1
                )
            );

            $reviews
                    = array();
            foreach (
                $cursor as $doc
            )
            {
                if ($this->matches_filter($doc)) {
                    $doc['date']
                            = $doc['date']->sec;
                    $doc['id']
                            = $doc['_id']->
                    {
                    '$id'
                    };
                    unset($doc['_id']);
                    $results[] = $doc;

                }
            }
            $this->content = $results;
            return $cursor;

        }

        public
        function action_expand()
        {
            $this->action_index();

        }

        protected
        function setFilters()
        {

        }

        protected
        function update(
            $newobj
        )
        {

            return !$this->db->selectCollection($this->collection)->update(
                array(
                    '_id' => new MongoId($this->id),


                ), $newobj

            );
        }
    }
