<h1 class="content-title">
    <?php echo __('Reports'); ?>
</h1>
<h2 class="content-section-title"><?php echo __('Email Addresses for Reports'); ?>:</h2>
<div id="account-reports-list-section" class="padding-5">
    <p>
        <?php echo __('We send a weekly Grapevine report to highlight key item like your OGSI Score, Current Star Rating, Review samples and more. Please add your desired email recipients below.'); ?>
    </p>
    <form action="" method="post">
        <table class="wide data-grid" cellpadding="5">
            <tr>
                <th class="a-left">
                    <?php echo __('Email Address'); ?>
                </th>
                <th class="a-center">
                    <?php echo __('Delete'); ?>
                </th>
            </tr>
            <?php if (!empty($emails)): ?>
            <?php foreach ($emails as $k => $email): ?>
            <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                <td class="a-left">
                    <?php echo html::chars($email) ?>
                </td>
                <td class="a-center">
                    <?php echo html::anchor(
                        '#', 'x', 
                        array('class' => 'confirm-required', 
                              'onclick' => "return confirm('". __('Are you sure?') ."')")) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </form>
    <form action="" method="post">
        <p>
            <input type="text" name="newEmail" />
            <?php echo form::submit('', __('Add Email')); ?>
        </p>
    </form>
    * <?php echo __('PLEASE add <a href="mailto:customer.service@grapevinebeta.com">customer.service@grapevinebeta.com</a> to your email address book "whitelist" to guarantee you will receive these reports.'); ?>
</div>