<h1 class="content-title">
    <?php echo _('User Management'); ?>
</h1>
<div class="padding-5">
    <p>
        <?php echo _('User Accounts'); ?>:
    </p>
    <div id="account-users-list-holder">
        <form action="" method="post">
        <table class="wide data-grid" cellpadding="5">
            <tr>
                <th class="a-left">
                    <?php echo _('User Accounts'); ?>
                </th>
                <th class="a-center">
                    <?php echo _('Admin'); ?>
                </th>
                <th class="a-center">
                    <?php echo _('Read Only'); ?>
                </th>
                <th class="a-center">
                    <?php echo _('Delete'); ?>
                </th>
            </tr>
            <?php if (!empty($users)): ?>
            <?php foreach ($users as $k => $user): ?>
            <?php $_inputPrefix = 'users['. $user['id'] .']'; ?>
            <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                <td>
                    <?php echo form::hidden($_inputPrefix . '[id]', $user['id']); ?>
                    <?php echo $user['name'], ' ', html::anchor('#', _('edit')) ?>
                </td>
                <td class="a-center">
                    <?php echo form::radio($_inputPrefix . '[role]', 'admin', $user['role'] == 'admin'); ?>
                </td>
                <td class="a-center">
                    <?php echo form::radio($_inputPrefix . '[role]', 'user', $user['role'] == 'user'); ?>
                </td>
                <td class="a-center">
                    <?php echo html::anchor(
                        '#', 'x', 
                        array('class' => 'confirm-required', 
                              'onclick' => "return confirm('". _('Are you sure?') ."')")) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
        </form>
    </div>
    <div id="account-users-edit-holder">
        
    </div>
</div>