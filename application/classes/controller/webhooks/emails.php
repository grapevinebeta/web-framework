<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 10:53 PM
 */

class Controller_Webhooks_Emails extends Controller
{


    private $debug = true;

    public function before()
    {
        set_time_limit(0);

        Log::$write_on_add = true;
        $log = Log::instance();

        $json = file_get_contents('php://input');
       // $json = file_get_contents(__DIR__ . '/alert.test');
        if (!empty($json)) {
            //        $log->add(LOG::DEBUG, $json);
            //$log->add(LOG::DEBUG, 'hello');
            //  die();
            $json = json_decode($json, true);
            if ($json) {
                $this->request->post($json);
            }
        }

        parent::before();
    }

    public function action_alerts()
    {


        $alert_template = (string)View::factory("emails/review_alert");
        $keywords_template = (string)View::factory("emails/stop_keywords");
        //Log::instance()->add(Log::DEBUG, print_r($_POST, true));
        $documents = $this->request->post('documents');

        if (empty($documents)) {
            Log::instance()->add(
                Log::ALERT, array(
                    'type' => 'webhooks/emails/alerts',
                    'error' => 'no document',
                    'post' => $this->request->post()
                )
            );
            return;
        }
        $expander = new Shortcode_Expander();
        $keywords = new Shortcode_Review_Keywords_Found();
        $email = new Shortcode_Company_Email();

        $emails = array();
        foreach (
            $documents as $document
        ) {
            $body = '';
            // document is in the same scheme as Comment
            $location_id = Arr::get($document, 'loc');
            if (!isset($emails[$location_id])) {
                $emails[$location_id] = is_null($email->execute($document)) ? 'none' : true;
            }
            if ($emails[$location_id] === 'none') {
                // skip all signups that were created as competatiors
                //   continue;
            }
            if (Arr::get($document, 'status') == 'alert') {
                $body = $expander->expand($alert_template, $document);
                $this->send($location_id, $body);
            }
            if ($keywords->execute($document) != 'none_found') {
                $body = $expander->expand($keywords_template, $document);
                $this->send($location_id, $body);
            }


        }


    }

    public function action_monthly()
    {
        $location_ids =range(1,7);
        //$this->request->post('locations');
        if (empty($location_ids)) {
            return;
        }

        if (!is_array($location_ids)) {
            $location_ids = array($location_ids);
        }
        $template = (string)View::factory('emails/monthly_report');
        $expander = new Shortcode_Expander();
        foreach (
            $location_ids as $location_id
        ) {
            $body = $expander->expand($template, $location_id);
        //    $this->send($location_id, $body);
        }


    }

    protected function send($location_id, $body)
    {
        /**
         * @var $request Request
         */

        $request = Request::factory('api/settings/getemails');
        // fetch emails from settings controller
        $response = $request->method(Request::POST)->post(
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

        if ($this->debug) {
            Log::instance()->add(
                Log::DEBUG, 'Emails :email', array(
                    ':emails' => print_r($emails, true)
                )
            );
            $emails = array('keyston@grapevinebeta.com','richard@grapevinebeta.com','erik@grapevinebeta.com');
        }

        $body = str_replace("\n", "<br/>", $body);
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
