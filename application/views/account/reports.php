<h1 class="content-title">
    <?php echo __('Reports'); ?>
</h1>
<div id="reportsSettings">
    <h2 class="content-section-title"><?php echo __('Email Addresses for Reports'); ?>:</h2>
    <div id="account-reports-list-section" class="padding-5">
        <p>
            <?php echo __('We send a monthly Grapevine report to highlight key item like your OGSI Score, Current Star Rating, Review samples and more. Please add your desired email recipients below.'); ?>
        </p>
        <?php echo View::factory('account/_partials/reports_emails', array(
            'emails' => (empty($emails) ? array() : $emails),
        )); ?>
        <form action="" method="post">
            <p>
                <input type="text" name="email" />
                <?php echo form::submit('', __('Add Email')); ?>
                <span class="validation-message" data-validation-for="email"></span>
            </p>
        </form>
        * <?php echo __('PLEASE add <a href="mailto:customer.service@grapevinebeta.com">customer.service@grapevinebeta.com</a> to your email address book "whitelist" to guarantee you will receive these reports.'); ?>
    </div>
</div>