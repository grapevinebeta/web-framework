<h1 class="content-title">
    <?php echo __('Billing'); ?>
</h1>
<div id="billingSettings">
    <div id="account-billing-section" class="padding-5">
        <?php
        /*echo __('Current Billing Method: :method', array(
            ':method' => $billing_type ? ucwords($billing_type) : __('not set'),
        )); 
         *         <br /><br />
         * 
         */
        ?>
        <?php
        echo __('Have questions on a recent billing statement or want to change your current billing method‭? <strong>:contact_link</strong>', array(
            ':contact_link' => HTML::mailto('support@pickgrapevine.com', __('Please contact us.?')),
        ));
        ?>
    </div>
</div>