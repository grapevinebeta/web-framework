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


    protected function getFilters()
    {

        $sources = Kohana::config('globals.review_sources');

        $sources = array_merge(
            Arr::get($sources, 'common'),
            Arr::get($sources, $this->industry())
        );

        return array(
            'status'
            => array(
                'Neutral' => 'neutral',
                'Positive' => 'positive',
                'Negative' => 'negative',
                'Alert' => 'alert',
                'Flagged' => 'todo',
                'Completed' => 'closed'
            ),
            'source' => $sources

        );
    }

    public function action_filters()
    {
        $this->apiResponse['filters'] = $this->getFilters();
    }

    public function action_index()
    {
        $expand = !is_null($this->id);


        $fields = $this->default_fields;
        // fetch the id
        $fields['_id'] = 1;

        if ($expand) {
            $fields = array_merge(
                $fields, $this->expanded_fields
            );
            $query = array("_id" => new  MongoId($this->id));

            $doc = $this->findOne($this->collection, $query, $fields);
            $doc['date'] = $doc['date']->sec;
            $doc['id'] = $doc['_id']->{'$id'};
            unset($doc['_id']);


            $this->apiResponse[Kohana_Inflector::singular($this->collection)] = $doc;

            return;


        }

        $cursor = $this->findContent($fields, $this->limit);
        $this->apiResponse = array(
            'filters' => $this->filterResponse,
            'pagination'
            => array('page' => $this->request->post('page'), 'pagesCount' => ceil($cursor->count() / 10))
        );
        $this->apiResponse[$this->collection] = $this->content;


    }

    protected function findContent($fields, $limit = -1)
    {
        $results = array();

        $query = $this->defaultQuery();
        

        $filters = Arr::get($_REQUEST, 'filters'); //$this->request->post('filters');
        $status = Arr::get($filters, 'status', array());
        $status = array_merge($status, Arr::get($filters, 'actions', array()));
        $sources = Arr::get($filters, 'source');
        $actions
                = $conditions = array(
            'rating' => array(),
            'site' => array(),
            'status' => array(),
            'action' => array()

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
                case 'todo':
                case 'closed':
                case 'opened':
                case 'alert' :
                    $conditions['status'][] = $status;
                    break;
                default:
                    $conditions['action'][] = $status;
                }

            }
        }
        if (!empty($sources)) {
            foreach (
                $sources as $source
            ) {
                $conditions['site'][] = $source;
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


        $cursor
                = $this->find($this->collection, $query, $fields, $limit);

        $cursor->sort(
            array(
                'date'
                => -1
            )
        );


        $reviews = array();
        foreach (
            $cursor as $doc
        )
        {

            $doc['date'] = $doc['date']->sec;
            $doc['id'] = $doc['_id']->{'$id'};
            unset($doc['_id']);
            $results[] = $doc;


        }
        $this->content = $results;
        $this->getFilteredCounts($query);
        return $cursor;

    }


    protected function getFilteredCountsMap()
    {
        return 'function(){
                     emit({},{status:this.status,site:this.site,rating:this.rating});

            }';
    }

    protected function getFilteredCountsReduce()
    {
        return
                'function(key,values){
            var results={source:{},status:{}};

            values.forEach(function(value){
               results.source[value.site]=(results.source[value.site]||0)+1;
               results.status[value.status]=(results.status[value.status]||0)+1;
               results.status[value.rating]=(results.status[value.rating]||0)+1;
            });

            return results;
        }';
    }

    protected function getFilterKinds()
    {
        return array("status", "source");
    }

    private function getFilteredCounts($query)
    {
        $map = $this->getFilteredCountsMap();
        $reduce = $this->getFilteredCountsReduce();


        $command = array(
            'mapreduce' => $this->collection,
            'map' => $map,
            'reduce' => $reduce,
            'query' => $query, 'out' => array('inline' => 1)

        );


        $response = array();
        foreach (
            $this->getFilterKinds() as $kind
        ) {
            $response[$kind] = array(
                'Total'
                => array(
                    'value' => null,
                    'active' => true,
                    'total' => 0
                )
            );
        }

        $return = $this->db->command($command);


        if (count($return['results'])) {
            $results = Arr::path($return, 'results.0.value');
        } else {
            $results = array();
        }


        $kinds = $this->getFilters();
        foreach (
            $kinds as $kind
            => $filters
        ) {
            foreach (
                $filters as $name
                => $value
            ) {
                $path = $kind . '.' . $value;

                $total = Arr::path($results, $path, 0);
                $response[$kind][$name] = array(
                    'total' => $total,
                    'value' => $value,
                    'active' => in_array($value, $this->activeFilters)
                );
            }
        }


        $this->filterResponse = $response;
    }

    public function action_expand()
    {
        $this->action_index();

    }

    protected function setFilters()
    {

    }

    protected function update($newobj)
    {

        return !$this->db->selectCollection($this->collection)->update(
            array(
                '_id' => new MongoId($this->id),


            ), $newobj

        );
    }
}
