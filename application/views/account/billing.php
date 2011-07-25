<h1 class="content-title">
    <?php echo __('Billing'); ?>
</h1>
<div id="billingSettings">
    <div id="account-billing-section" class="padding-5">
        <?php $billingMethod = $billing_type ? ucwords($billing_type) : __('not set'); ?>
        <?php echo __('Current Billing Method'); ?>:
        <?php echo html::anchor('#', $billingMethod); ?>
        <br /><br />
        <?php echo __('Want to change your billing?'), ' ', html::anchor(Route::url('contact'), __('Contact Us')); ?>
    </div>
</div>