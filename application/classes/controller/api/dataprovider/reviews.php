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


    protected function setFilters()
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


    public function action_category_breakdown()
    {


        $query = $this->defaultQuery();
        $fields = array('category', 'score');
        $cursor = $this->find($this->collection, $query, $fields);

        $categories = array();
        $total = $cursor->count();
        
        foreach (
            $cursor as $doc
        ) {
            //print_r($doc);
            $category = $doc['category'];
            if (!isset($categories[$category])) {
                $categories[$category] = array(
                    'used' => 0,
                    'rating' => 0,
                    'percent' => 0,
                    'category'=>$category

                );

            }
            $categories[$category]['used']++;
            $categories[$category]['rating'] += $doc['score'];

        }


        $sorter = new Sorter('used', -1);
        $categories = $sorter->sort($categories);
        foreach (
            $categories as &$category
        ) {


            $category['rating'] = number_format($category['rating'] / $category['used'], 2);
            $category['percent'] = number_format(($category['used'] / $total) * 100, 2);

        }
        // category , #of instance, avg rating which category( score),


        /*
        $return = array(
            array(
                'category' => '',
                'used' => 0,
                'rating' => '',
                'percent'
                        =>
            )
        );*/

        $this->apiResponse['categories'] = array_values($categories);


    }

    public function action_categories()
    {

        $rs = DB::select('industry')
                ->from('locations')
                ->where('id', '=', $this->location)
                ->limit(1)
                ->as_assoc()
                ->execute()
                ->current();

        if (!$rs) {
            return;
        }

        $key = current($rs);

        $categories = Kohana::config('globals.reviews_categories');

        $key = $key ? $key : '';

        $c = array_combine($categories[$key], $categories[$key]);
        
        $this->apiResponse['categories'] = $c;

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
                $site = str_replace('.com', '', $site);
                $site = ucfirst($site);

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
        $status = strtolower($this->request->post('status'));
        if (in_array($status, array('opened', 'closed', 'todo', 'alert'))) {
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
