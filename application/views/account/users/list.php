<form action="" method="post" class="usersSettingsList">
    <table class="wide data-grid" cellpadding="5">
        <tr>
            <th class="a-left">
                <?php echo __('User Accounts'); ?>
            </th>
            <th class="a-center">
                <?php echo __('Admin'); ?>
            </th>
            <th class="a-center">
                <?php echo __('Read Only'); ?>
            </th>
            <th class="a-center">
                <?php echo __('Delete'); ?>
            </th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $k => $user): ?>
                <?php $_inputPrefix = 'users['. $user->id .']'; ?>
                <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                    <td>
                        <?php echo form::hidden($_inputPrefix . '[id]', $user->id); ?>
                        <?php echo $user->firstname.' '.$user->lastname, ' ', html::anchor('#', __('edit'), array(
                            'data-action' => 'edit',
                            'data-user-id' => $user->id,
                        )); ?>
                    </td>
                    <td class="a-center">
                        <?php echo form::radio($_inputPrefix . '[role]', 'admin', false); ?>
                    </td>
                    <td class="a-center">
                        <?php echo form::radio($_inputPrefix . '[role]', 'user', true); ?>
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