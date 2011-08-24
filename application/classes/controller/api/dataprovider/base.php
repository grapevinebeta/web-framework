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

    /**
     * @var MongoDate
     */
    protected $startDate;
    /**
     * @var MongoDate
     */
    protected $endDate;

    /**
     * @var int
     */
    protected $location;
    /**
     * @var array Default date query
     */
    protected $query;

    protected $include_date = TRUE;

    protected $limit; // results limit


    public function before()
    {
        parent::before();


        $this->id = $this->request->param('id');
        $this->limit = $this->request->post('limit');
        $this->limit = $this->limit ? $this->limit : 10;

        $range = $this->request->post('range');
        if (!empty($range)) {
            Session::instance()->set(
                'viewingRange', $range
            );
        } else {
            $range = array('date' => '-1 month -1 day', 'period' => '-1 day');
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
        case 'ytd':
            $period = "-1 day";
        case 'all':
            $period = "-1 day";
            break;
        default:
            $period = false;
            break;

        }

        $include_date = $this->request->post('include_date');
        if (!empty($include_date)) {

            Session::instance()->set(
                'viewingRange', $range
            );

            $this->include_date = $include_date == 'false' ? false : true;
        }


        /**
         *  i change the code and assumed that $range['date'] always return start date
         * and $range['offset'] return positive offset that need to be add to start date.
         *
         *
         */

        $start = strtotime($range['date']);

        if ($period) {
            if (in_array($range['period'], array('all', 'ytd'))) {
                $end = strtotime($period);
            }
            else
            {
                $end = strtotime($period, $start);
            }
        }
        else
        {
            $end = strtotime($range['period']);
        } // this is the case when period has date value

        //
        //        echo date('Y m d', $start), " ", date('Y m d', $end); exit;

        $this->startDate = new MongoDate($start);
        $this->endDate = new MongoDate($end);

        //
        $filters = $this->request->post('filters');

        $this->activeFilters = array();
        if (isset($filters['source'])) {
            $this->activeFilters = $filters['source'];
        }

        if (isset($filters['status'])) {
            $this->activeFilters = array_merge($this->activeFilters, $filters['status']);
        }
        if (isset($filters['actions'])) {
            $this->activeFilters = array_merge($this->activeFilters, $filters['actions']);
        }

        $this->filterEnabled = count($this->activeFilters) ? true : false;


        $this->location = (int)$this->request->post('loc');
        $this->location = $this->location ? $this->location :
                Session::instance()->get('location_id', 1);

        $this->query = array(
            'date' => array('$gte' => $this->startDate, '$lte' => $this->endDate), 'loc' => $this->location
        );

        //            $this->mongo = new Mongo("mongodb://192.168.1.72:27017");
        $this->mongo = new Mongo("mongodb://50.57.109.174:27017");

        $industry=$this->industry();
        $this->db = $this->mongo->selectDB($industry);


    }

    protected function getCompetition()
    {
        // $session = Session::instance();
        // $key = "competitor.{$this->location}";
        //  $competitors = $session->get($key);

        $settings = new Model_Location_Settings($this->location);
        $competitors = $settings->getSetting('competitor');

        // cached every 60 seconds
        $query = DB::select('id', 'name')
                ->from('locations')
                ->where('id', 'IN', array_values($competitors));
        $query->cached(5 * 60); // twenty mins

        $result = $query->execute();
        $competitors = $result->as_array('id', 'name');
        return $competitors;


    }

    /**
     * @return MongoDate
     */
    protected function epoch()
    {
        return new MongoDate(mktime(0, 0, 0, 1, 1, 1970));
    }

    protected function defaultQuery()
    {
        if ($this->include_date) {
            return array(
                'loc' => $this->location, 'date' => array('$gte' => $this->startDate, '$lte' => $this->endDate)
            );
        }

        return array(
            'loc' => $this->location
        );

    }

    protected function time($start = true, $tag = null)
    {
        if ($start) {
            $this->start = microtime();
        } else {

            list($old_usec, $old_sec) = explode(' ', $this->start);
            list($new_usec, $new_sec) = explode(' ', microtime());
            $old_mt = ((float)$old_usec + (float)$old_sec);
            $new_mt = ((float)$new_usec + (float)$new_sec);
            echo $tag . ' : ' . number_format($new_mt - $old_mt, 4) . " seconds\n";

        }
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
    protected function find($name, $query, array  $fields = array(), $limit = -1)
    {
        $collection = new MongoCollection($this->mongo->selectDB($this->industry()), $name);
        $cursor = $collection->find($query, $fields);
        if ($limit > -1) {
            $skip = $this->request->post('page');
            if (empty($skip)) {
                $skip = 1;
            }
            $skip = intval($skip);
            $skip = ($skip - 1) * $limit;
            $cursor->limit($limit)->skip($skip);
        }
        return $cursor;
    }

    protected function findOne($name, $query, $fields = array())
    {
        $db = $this->mongo->selectDB($this->industry());
        $collection = new MongoCollection($db, $name);

        /* @var $collection MongoCollection */
        return $collection->findOne($query, $fields);
    }

    /**
     * @return Returns the industry for the location
     */
    private $_industry;

    protected function industry()
    {
        if (!empty($this->_industry)) {
            return $this->_industry;
        }
        $this->_industry = ORM::factory('location', $this->location)->industry;
        return $this->_industry;
    }

}
