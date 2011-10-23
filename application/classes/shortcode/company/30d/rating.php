<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:47 PM
 */

class Shortcode_Company_30d_Rating extends Shortcode_Company_Base
{

    protected $_endpioint = "current";
    protected $_path = "rating.score";

    public function execute($document = null)
    {
        $id = $this->location_id($document);
        if (is_int($id)) {
            $response = Request::factory("/api/dataProvider/scoreboard/$this->_endpoint")
                    ->post(
                array_merge(
                    array(
                        'loc' => $id
                    ), $this->post()
                )
            )->execute()->response;
            return Arr::path($response, $this->_path, 0);
        }
        return 0;
    }

    protected function post()
    {
        return array('range' => array('date' => '-1 month -1 day', 'period' => '-1 day'));
    }
}
