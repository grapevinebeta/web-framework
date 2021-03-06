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
        /* 'superpages.com' => '/bp\/.+\/.*L[0-9]+\.htm/',*/
        'yellowpages.com' => '/-[0-9]+/',
        'insiderpages.com' => '/b\/[0-9]+\//',
        'citysearch.com' => '/profile\/[0-9]+\/[^\.]+\.html/',
        'edmunds.com' => '/dealerships\//',
        'dealerrater.com' => '/review-[0-9]+\//'


    );


    public function action_add()
    {
        $post = array(

            'billing_type' => 'invoice',
            'package' => 'starter',
            'firstname' => 'Keyston',
            'lastname' => 'Clay',
            'owner_name' => 'Keyston Clay',
            'owner_email' => 'keyston@conceptual-ideas.com',
            'email' => 'keyston@conceptual-ideas.com',
            'owner_phone' => '210-725-4484',
            'username' => 'keyston',
            'password' => 'cideasdev',
            'industry' => 'automotive',
            'location_name' => 'Tom Benson Chevrolet',
            'address1' => '9400 San Pedro Avenue',
            'city' => 'San Antonio',
            'state' => 'TX',
            'zip' => '78216',
            'phone' => '210-341-3311'
        );
        $query = array();
        foreach (
            array('location_name', 'address1', 'city', ',', 'state', 'zip') as $key
        ) {
            $query[] = isset($post[$key]) ? trim($post[$key]) : $key;
        }
        $query = join(' ', $query);
        $query = str_replace('  ', ' ', $query);
        $db = Database::instance();
        $db->begin();

        try {

            // create company user
            $user = ORM::factory('user');
            $values = array();
            foreach (
                array('username', 'password', 'firstname', 'lastname', 'phone', 'email') as $key
            ) {
                $values[$key] = $post[$key];
            }
            $user->values($values);

            $user->save();
            // add login  role
            $user->add('roles', ORM::factory('role', array('name' => 'login')));


            // create company
            $company = ORM::factory('company');
            $company->name = $post['location_name'];
            $company->save();
            // add to companies_users
            $company->add('users', $user);

            // create location
            $location = ORM::factory('location');

            unset($post['firstname']);
            unset($post['lastname']);
            unset($post['username']);
            unset($post['password']);
            $location->values($post);
            $location->save();
            // add to locations_users with level = 0
            $location->add('users', $user);

            // add to companies_locations
            $company->add('locations', $location);
            $company->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }

        echo $query;
    }

    public function action_find()
    {
        $location = $this->request->query('location');

        $results = $this->search($location, array_keys($this->sites));

        $results = array_merge($results, $this->search_judysbook($location, 'San Antonio', 'TX'));

        var_dump($results);


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
