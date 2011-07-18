<form action="" method="post" class="reportsSettingsEmails">
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
                    <?php
                    echo html::anchor('#', 'x',array(
                        'class' => 'confirm-required', // @todo is it really still needed?
                        'data-action' => 'delete',
                        'data-email' => html::chars($email),
                    ));
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>