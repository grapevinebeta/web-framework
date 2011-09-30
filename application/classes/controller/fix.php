<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/24/11
 * Time: 1:41 PM
 */

class Controller_Fix extends Controller
{


    public function action_index()
    {
        /**
         * @var user User
         */
        $user=Auth::instance()->get_user();
        $company = $user->company->company;
        $locations = $company->locations;
        echo $locations;
        /*$queue = new Model_Queue($location_id, $this->_location->industry);
        $url = 'http://facebook.com/pages/' . $queue_extra['facebook_page_id'];
        $queue->add('facebook.com', $url, $queue_extra);
        $queue->save();*/
    }
}
