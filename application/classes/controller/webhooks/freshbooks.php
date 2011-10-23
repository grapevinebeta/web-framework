<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 7:17 PM
 */

class Controller_Webhooks_Freshbooks extends Controller
{

    public function action_index()
    {
        $name = $this->request->post('name');
        if ($name == 'callback.verify') {
            $mailer = new Model_Mailer();
            $mailer->send(
                'keyston@grapevinebeta.com', 'Freshbooks verify',
                    'verifier :' . $this->request->post('verifier'),
                null, 'app@pickgrapevine.com'
            );
        } else {
            if (strpos($name, 'invoice.pastdue') == FALSE) {
                return;
            }
            $clientId = $this->request->post('object_id');

            //new Client object
            $client = new FreshBooks_Client();

            //try to get client with client_id $clientId
            if (!$client->get($clientId)) {
                //no data - read error
                echo $client->lastError;
            }
            else {
                //investigate populated data
                $location = ORM::factory('location', array('owner_email' => $client->email));
                if ($location->loaded) {
                    $status = $name == 'invoice.pastdue.3' ? Model_Location::STATUS_SUSPENDED
                            : Model_Location::STATUS_PASTDUE;
                    $location->status = $status;
                    $location->save();
                    //Log::instance()->add(Log::DEBUG, print_r($_POST, true));
                    //Log::instance()->add(Log::DEBUG, print_r($client, true));

                }
                /* if (strpos($name, 'invoice.pastdue') != null) {

                }*/
            }


        }

    }
}
