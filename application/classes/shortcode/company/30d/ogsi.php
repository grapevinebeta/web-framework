<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:16 PM
 */

class Shortcode_Company_30d_Ogsi extends Shortcode_Company_Base
{

    protected $_location_path = "ogsi.loc";
    protected $_value_path = 'ogsi.value';

    public function execute($document = null)
    {
        $score = 0;
        $location = $this->location($document);
        if ($location) {
            $id = $location->id;

            /**
             * @var Kohana_Request
             */
            $request = Request::factory('/api/dataProvider/competition/ogsi');
            $response = $request->post(
                array_merge(array('loc' => $id), $this->post)

            )->execute()->response;
            foreach (
                $response['ogsi'] as $location_name
                => $sections
            ) {
                $loc = Arr::path($sections, $this->_location_path);
                if ($loc == $id) {
                    $score = Arr::path($sections, $this->_value_path);
                    break;
                }


            }
        }
        return $score;

    }

    protected function post()
    {
        
        return array('range' => array('date' => '-1 month -1 day', 'period' => '-1 day'));
    }

}
