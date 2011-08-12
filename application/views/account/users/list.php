<form action="" method="post" class="usersSettingsList">
    <table class="wide data-grid" cellpadding="5">
        <tr>
            <th class="a-left">
                <!--<?php echo __('User Accounts'); ?>-->
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
            <?php

            foreach ($users as $k => $user):
                $access_level = $user->getAccessLevelForLocation($location, true);

            ?>
                <?php $_inputPrefix = 'users['. $user->id .']'; ?>
                <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                    <td>
                        <?php echo form::hidden($_inputPrefix . '[id]', $user->id); ?>
                        <?php echo $user->firstname.' '.$user->lastname, ' ', html::anchor('#', '', array(
                            'class' => 'action-edit',
                            'data-action' => 'edit',
                            'data-user-id' => $user->id,
                        )); ?>
                    </td>
                    <td class="a-center">
                        <?php echo form::radio($_inputPrefix . '[role]', 'admin', $access_level === 1, array(
                            'data-action' => 'change-role',
                            'data-role' => 'admin',
                            'data-user-id' => $user->id,
                        )); ?>
                    </td>
                    <td class="a-center">
                        <?php echo form::radio($_inputPrefix . '[role]', 'user', $access_level === 2, array(
                            'data-action' => 'change-role',
                            'data-role' => 'readonly',
                            'data-user-id' => $user->id,
                        )); ?>
                    </td>
                    <td class="a-center">
                        <?php
                        echo html::anchor('#', '', array(
                            'class' => 'confirm-required action-delete',
                            'data-action' => 'delete',
                            'data-user-id' => (int)$user->id,
                        ));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>