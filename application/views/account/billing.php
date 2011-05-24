<h1 class="content-title">
    <?php echo _('Billing'); ?>
</h1>
<div id="account-billing-section" class="padding-5">
    <?php $billingMethod = _('Invoicing Quarterly'); ?>
    <?php echo _('Current Billing Method'); ?>: 
    <?php echo html::anchor('#', $billingMethod); ?>
    <br /><br />
    <?php echo _('Want to change your billing?'), ' ', html::anchor('contact', _('Contact Us')); ?>
</div>
