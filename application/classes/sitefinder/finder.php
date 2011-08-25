<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/17/11
 * Time: 12:31 PM
 */

class SiteFinder_Finder
{

    const SEARCH_ENDPOINT = 'http://api.bing.net/json.aspx?AppId={appId}&Query={query}&Sources=Web';
    private $sites
    = array(
        'automotive'
        => array(
            'edmunds.com' => '/dealerships\//',
            'dealerrater.com' => '/review-[0-9]+\//'
        ),
        'common'
        => array(

            'yelp.com' => '/biz\//',
            'superpages.com' => '/bp\/.+\/.*L[0-9]+\.htm/',
            'yellowpages.com' => '/\/mip\/[^\d]+\d+$/',
            /*'yellowpages.com' => '/-[0-9]+/',*/
            'insiderpages.com' => '/b\/[0-9]+\//',
            'citysearch.com' => '/profile\/[0-9]+\/[^\.]+\.html/',
            'local.yahoo.com' => '/info-\d+-/'
            /* 'places.google.com' => '/maps\/places'*/


        ),
        'restaurant'
        => array(
            'urbanspoon.com' => '/r\/[0-9]+\/[0-9]+\/restaurant\//'
        )
    );

    /**
     * Finds all the sites for a giving location
     * @param SiteFinder_Query $query
     * The array will be returned with a special key named "missing" holding
     * an array of sites that were not found
     * @return array
     */

    public function find(SiteFinder_Query $query)
    {

        $location = (string)$query;
        $sites = array_merge($this->sites[$query->industry], $this->sites['common']);
        $results = $this->search($location, $sites);

      //  if ($query->industry == 'automotive') {
            $judy = $this->search_judysbook($location, $query->city, strtoupper($query->state));

            $results = array_merge($results, $judy);
            if (!count($judy)) {
                $results['missing'][] = 'judybooks.com';
            }
       // }
        //  $results['missing'][$query->industry] = $results['missing'];


        return $results;


    }

    private function search_judysbook($location, $city, $state)
    {

        $url = 'http://www.judysbook.com/searchresult/';
        $url .= urlencode($city) . '/';
        $url .= urlencode($state);

        $params = array(
            'q' => $location,
            'afsq' => $location . " $city $state",
            'loc' => ''
        );


        //$url .= http_build_query($params);
        /**
         * @var $request Request
         */
        $request = Request::factory($url)->query($params);
        $client = $request->get_client();
        $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
        $client->options(CURLOPT_USERAGENT, $useragent);


        $response = $request->execute();

        $content = $response->body();
        $matches = array();
        //'judysbook.com' => '',
        preg_match('/cities\/[^0-9]+[0-9]+\/[^\.]+\.htm/', $content, $matches);
        if (count($matches)) {
            return array(
                'judysbook.com'
                => array('title' => 'Found you !!!', 'url' => 'http://www.judysbook.com/' . $matches[0])
            );
        }
        return array();


        /*San+Antonio/TX?q=Northside+Ford+12300+San+Pedro+Ave+San+Antonio+TX+78216
                &afsq=Northside+Ford+12300+San+Pedro+Ave+San+Antonio+TX+78216+San+Antonio%2c+TX&loc=
        http://www.judysbook.com/searchresult/San+Antonio/TX?q=Northside+Ford+12300+San+Pedro+Ave+San+Antonio+TX+78216&afsq=Northside+Ford+12300+San+Pedro+Ave+San+Antonio+TX+78216+San+Antonio%2c+TX&loc=*/
    }

    private function search($location, $sites, $retry = true)
    {

        $mh = curl_multi_init();
        $curls = array();
        $appId = Kohana::config("bing.appId");
        foreach (
            $sites as $site
            => $regex

        ) {
            $query = urlencode($location . " site:$site");


            $tokens = array(
                '{appId}' => $appId,
                '{query}' => $query
            );
            $url = str_replace(array_keys($tokens), array_values($tokens), self::SEARCH_ENDPOINT);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //return the image value

            curl_multi_add_handle($mh, $curl);
            $curls[$site] = $curl;
        }

        $active = null;
        //execute the handles
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);


        $found = array();

        $missing = array();
        foreach (
            $curls as $site
            => $curl
        ) {
            $json = json_decode(curl_multi_getcontent($curl));
            if ($json) {
                if (!$json->SearchResponse->Web->Total) {
                    if ($retry) {
                        $missing[$site] = $sites[$site];
                    }
                } else {
                    $results = $json->SearchResponse->Web->Results;
                    foreach (
                        $results as $result
                    ) {
                        $regex = $sites[$site];
                        if (preg_match($regex, $result->Url)) { // matches site
                            $found[$site] = array(
                                'title' => $result->Title,
                                'url' => preg_replace('/\?.*/', '', $result->Url)
                            );
                            break;
                        }
                    }
                }
            }
            curl_multi_remove_handle($mh, $curl);
        }


        curl_multi_close($mh);
        if (count($missing)) {
            $found_missing = $this->search($location, $missing, false);
            $found = array_merge($found, $found_missing);
            $found['missing'] = array_keys(array_diff_key($missing, $found));

        }
        return $found;
    }
}
