<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 10:53 PM
 */

class Controller_Webhooks_Emails extends Controller
{


    public function action_alerts()
    {


        $template = (string)View::factory("emails/review_alert");

        $document = $this->request->post('document');
        if (empty($document)) {
            Log::instance()->add(
                Log::ALERT, array(
                    'type' => 'webhooks/emails/alerts',
                    'error' => 'no document',
                    'post' => $this->request->post()
                )
            );
            return;
        }
        $location_id = Arr::get($document, 'loc');
        $expander = new Shortcode_Expander();
        $body = $expander->expand($template, $document);


    }

    public function action_monthly()
    {
        $location_ids = $this->request->post('locations');
        if (empty($location_ids)) {
            return;
        }
        set_time_limit(0);
        if (!is_array($location_ids)) {
            $location_ids = array($location_ids);
        }
        $template = (string)View::factory('emails/monthly_report');
        $expander = new Shortcode_Expander();
        foreach (
            $location_ids as $location_id
        ) {
            $body = $expander->expand($template, $location_id);
            $this->send($location_id, $body);
        }


    }

    protected function send($location_id, $body)
    {
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
                    'type' => 'webhooks/emails/alerts',
                    'error' => 'unable to send email',
                    'post' => $this->request->post()
                )
            );
        }
    }
}
