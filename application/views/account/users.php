<h1 class="content-title">
    <?php echo _('User Management'); ?>
</h1>
<h2 class="content-section-title"><?php echo _('User Accounts'); ?>:</h2>
<div id="account-users-list-section" class="padding-5">
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
</div>
<h2 class="content-section-title"><?php echo _('Add / Edit User'); ?></h2>
<div id="account-users-edit-section" class="padding-5">
    <div id="account-users-edit-holder">
        <form action="" method="post">
            <table>
                <tr>
                    <td class="a-right">
                        <?php echo _('First Name'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('first_name'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Last Name'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('last_name'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Email'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('email'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Contact Phone'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('phone'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Username'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('username'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Password'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('password'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="a-right">
                        <?php echo _('Confirm Password'); ?>:
                    </td>
                    <td>
                        <?php echo form::input('password2'); ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>