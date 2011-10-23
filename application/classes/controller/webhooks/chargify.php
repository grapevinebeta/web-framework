<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 5:48 PM
 */

class Controller_Webhooks_Chargify extends Controller
{


    public function action_index()
    {

        $event = $this->request->post('event');
        $method = "event_{$event}";
        if (method_exists($this, $method)) {
            call_user_func(array($this, $method));
        }

    }


    private function status($status)
    {
        $post = $this->request->post();
        $email = Arr::path($post, 'customer.email');
        $customer_id = Arr::path($post, 'customer.id');

        if (!empty($email)) {
            $location = ORM::factory('location', array('owner_email' => $email));
            if ($location->loaded) {
                $location->status = $status;
                $location->save();
            }
        }
    }

    /**
     * Any successful signup (Subscription created) via the API, admin UI, or hosted pages
     * payload = subscription
     * @link http://docs.chargify.com/api-subscriptions
     * @return void
     *
     */
    private function event_signup_success()
    {

        $this->status(Model_Location::STATUS_ACTIVE);

    }

    private function event_renewal_success()
    {
        $this->status(Model_Location::STATUS_ACTIVE);
    }


    private function event_renewal_failure()
    {

        $this->status(Model_Location::STATUS_DEACTIVE);

    }

    /**
     * Any successful payment against a credit card4
     * payload = payment
     * @return void
     */
    private function event_payment_success()
    {
        $this->status(Model_Location::STATUS_ACTIVE);
    }

    /**
     * Any failed payment attempt against a credit card4
     * payload = payment
     * @return void
     */
    private function event_payment_failure()
    {
        $this->status(Model_Location::STATUS_DEACTIVE);
    }

    private function event_subscription_state_change()
    {
        if ($this->request->post('status') == Model_Location::STATUS_PASTDUE) {
            $this->status(Model_Location::STATUS_PASTDUE);
        }
    }
}
