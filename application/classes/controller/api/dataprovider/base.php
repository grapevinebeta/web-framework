<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:04 AM
 */

    class Controller_Api_DataProvider_Base extends Controller
    {
        /**
         * @var
         * */
        protected $apiResponse;
        protected $apiRequest;
        protected $filterResponse = array();
        protected $activeFilters = array();
        protected $filterEnabled = false;
        /**
         * @var Mongo
         */
        protected $mongo;
        /**
         * @var MongoDB
         */
        protected $db;

        /**
         * @var Api_Filters_Base[]
         */
        protected $filters;

        /**
         * @var String
         */
        protected $id;

        protected $startDate;
        protected $endDate;

        /**
         * @var int
         */
        protected $location;


        public function before()
        {
            parent::before();


            $this->id = $this->request->param('id');
            $range = $this->request->post('range');
            if (!empty($range)) {
                Session::instance()->set(
                    'viewingRange', $range
                );
            } else {
                $range = array('date' => 'now', 'period' => '1m');
            }
            $period = $range['period'];
            switch ($period) {
            case '1m':
                $period = "+1 month";
                break;
            case '3m':
                $period = "+3 months";
                break;
            case '6m':
                $period = "+6 months";
                break;
            case '1y':
                $period = "+1 year";
                break;
            default:
                $period = "+1 month";
            }
            $start = strtotime($range['date']);
            $this->startDate = new MongoDate($start);
            $this->endDate = new MongoDate(strtotime($period, $start));

            //
            $filters = $this->request->post('filters');
            $this->activeFilters = array();
            if (isset($filters['source'])) {
                $this->activeFilters = $filters['source'];
            }
            
            if (isset($filters['status'])) {
                $this->activeFilters = array_merge($this->activeFilters, $filters['status']);
            }
            $this->filterEnabled = count($this->activeFilters) ? true : false;


            //
            $this->query = array('date' => array('$gte' => $this->startDate, '$lte' => $this->endDate));


            $location = $this->request->post('loc');
            if (empty($location)) {
                $location = 1;
            }
            $this->location = intval($location);
            $this->mongo = new Mongo();
            $this->db = $this->mongo->auto;


        }


        public function after()
        {
            $this->response->headers('Content-Type', 'application/json');
            $this->response->body(json_encode($this->apiResponse));
            parent::after();
        }


        private $total_docs = 0;

        protected function matches_filter($doc)
        {


            $allow = false;
            foreach (
                $this->filters as $filter
            ) {

                $name = $filter->name($doc);
                $kind = $filter->kind();
                if (!isset($this->filterResponse[$kind])) {
                    $this->filterResponse[$kind] = array(
                        'Total'
                        => array(
                            'total' => &$this->total_doc,
                            'value' => null,
                            'active' => false
                        )
                    );

                }
                if (!isset($this->filterResponse[$kind][$name])) {
                    $this->filterResponse[$kind][$name] = array(
                        'total' => 0,
                        'value' => $filter->key($doc),
                        'active' => isset($this->activeFilters[$filter->key($doc)])
                    );
                }
                $this->filterResponse[$kind][$name] ['total']++;

                if ($filter->test($doc)) {


                    if ($this->filterEnabled) {
                        $allow = true;
                    }
                }
            }
            $this->total_doc++;
            return $this->filterEnabled ? $allow : true;

        }


        /**
         * @param $name
         * @param $query
         * @param $fields
         * @param $limit
         * @return MongoCursor
         */
        protected function query($name, $query, $fields, $limit = -1)
        {
            $collection = new MongoCollection($this->mongo->selectDB('auto'), $name);
            $cursor = $collection->find($query, $fields);
            if ($limit) {
                $skip = 1; //intval($this->request->post('page', 1));
                $skip = ($skip - 1) * $limit;
                $cursor->limit($limit)->skip($skip);
            }
            return $cursor;
        }
        
        protected function findOne($name, $query, $fields) {
            $collection = new MongoCollection($this->mongo->selectDB('auto'), $name);
            
            /* @var $collection MongoCollection */
            return $collection->findOne($query, $fields);
        }
        
    }
