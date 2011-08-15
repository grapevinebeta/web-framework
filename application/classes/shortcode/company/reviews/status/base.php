<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 1:17 AM
 */

class Shortcode_Company_Reviews_Status_Base extends Shortcode_Company_Base
{

    protected $_status;
    public function execute($document = null)
    {
        $id = $this->location_id($document);
        if ($id) {
            $response = Request::factory('api/dataProvider/reviews/alerts')
                    ->post(array('status' => $this->_status))->execute()->response;
            return Arr::get($response, 'status',0);
        }
        return 0;
    }
}
