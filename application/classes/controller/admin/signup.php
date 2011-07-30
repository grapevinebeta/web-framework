<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/30/11
 * Time: 8:56 AM
 */

    define('SEARCH_ENDPOINT', 'http://api.bing.net/json.aspx?AppId={appId}&Query={query}&Sources=Web');
    class Controller_Admin_Signup extends Controller
    {

        private $sites
        = array(

            'yelp.com' => '/biz\//',
            'judysbook.com' => '/cities\/[^0-9]+[0-9]+\/[^\.]+\.htm/',
            'superpages.com' => '/bp\/.+\/.*L[0-9]+\.htm/',
            'insiderpages.com' => '/b\/[0-9]+\//',
            'citysearch.com' => '/profile\/[0-9]+\/[^\.]+\.html/',
            'edmunds.com' => '/dealerships\//',
            'mydealerreport.com' => '/DealerID=[0-9]+/',
            'dealerrater.com' => '/review-[0-9]+\//'


        );

        public function action_find()
        {
            $location = $this->request->query('location');

            # $results = $this->search($location, array_keys($this->sites));

            $this->search_judysbook($location, 'San Antonio', 'TX');
            #var_dump($results);


        }

        private function search_judysbook($location, $city, $state)
        {

            $url = 'http://www.judysbook.com/searchresult/';
            $url .= urlencode($city) . '/';
            $url .= urlencode($state) . '?';

            $params = array(
                'q' => $location,
                'afsq' => $location . " $city $state",
                'loc' => ''
            );

            //  $url .= http_build_query($params);

            $request = Request::factory($url)->method('GET')->query($params);
    
            var_dump($request);
            $response = $request->execute();
            var_dump($response);

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

            ) {
                $query = urlencode($location . " site:$site");


                $tokens = array(
                    '{appId}' => $appId,
                    '{query}' => $query
                );
                $url = str_replace(array_keys($tokens), array_values($tokens), SEARCH_ENDPOINT);

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


            $found = array_fill_keys($sites, '');

            $missing = array();
            foreach (
                $curls as $site
                => $curl
            ) {
                $json = json_decode(curl_multi_getcontent($curl));
                if ($json) {
                    if (!$json->SearchResponse->Web->Total) {
                        if ($retry) {
                            $missing[] = $site;
                        }
                    } else {
                        $results = $json->SearchResponse->Web->Results;
                        foreach (
                            $results as $result
                        ) {
                            $regex = $this->sites[$site];
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
                $missing = $this->search($location, array_values($missing), false);
                $found = array_merge($found, $missing);
            }
            return $found;
        }
    }
