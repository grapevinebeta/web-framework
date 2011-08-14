<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 10:53 PM
 */

class Controller_Webhooks_Alerts extends Controller
{


    public function action_send()
    {
        $template = $this->request->post('template');
        try {
            $template = (string)View::factory("emails/$template");
        } catch (Kohana_View_Exception $e) {
            Log::instance()->add(
                Log::ALERT, array(
                    'type' => 'webhooks/alerts',
                    'error' => 'unable to find template',
                    'post' => $this->request->post()
                )
            );
            return;
        }
        $document = $this->request->post('document');
        if (empty($document)) {
            Log::instance()->add(
                Log::ALERT, array(
                    'type' => 'webhooks/alerts',
                    'error' => 'no document',
                    'post' => $this->request->post()
                )
            );
            return;
        }
        $location_id = Arr::get($document, 'loc');
        $expander = new Shortcode_Expander();
        $body = $expander->expand($template, $document);

        /**
         * @var $request Request
         */
        $request = Request::factory('api/settings/getemails');
        // fetch emails from settings controller
        $response = $request->post(
            array(
                'no_auth' => true,
                'loc' => $location_id
            )
        )->execute();
        $emails = Arr::path($response, 'result.emails', array());
        $location = ORM::factory('location', $location_id);
        if (!in_array($location->owner_email, $emails)) {
            $emails[] = $location->owner_email;
        }


        $mailer = new Model_Mailer();
        $reply = array('no-reply@grapevinebeta.com' => 'No-Reply');
        $from = 'reports@grapevinebeta.com';
        $sent = $mailer->send($emails, 'A Message From PickGrapevine.com', $body, null, $from, $reply);
        if (!$sent) {
            Log::instance()->add(
                Log::ALERT, array(
                    'type' => 'webhooks/alerts',
                    'error' => 'unable to send email',
                    'post' => $this->request->post()
                )
            );
        }
    }
}
