<h1 class="content-title">
    <?php echo __('User Management'); ?>
</h1>
<div id="userManagementSettings">
    <h2 class="content-section-title"><?php echo __('User Accounts'); ?>:</h2>
    <div id="account-users-list-section" class="padding-5">
        <div id="account-users-list-holder">
            <form action="" method="post">
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
                <?php $_inputPrefix = 'users['. $user['id'] .']'; ?>
                <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                    <td>
                        <?php echo form::hidden($_inputPrefix . '[id]', $user['id']); ?>
                        <?php echo $user['name'], ' ', html::anchor('#', __('edit'), array(
                            'data-action' => 'edit',
                            'data-user-id' => $user['id'],
                        )); ?>
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
                                  'onclick' => "return confirm('". __('Are you sure?') ."')")) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </table>
            </form>
        </div>
    </div>
    <h2 class="content-section-title"><?php echo __('Add / Edit User'); ?></h2>
    <div id="account-users-edit-section" class="padding-5">
        <div id="account-users-edit-holder">
            <form action="" method="post">
                <table>
                    <tr>
                        <td class="a-right">
                            <?php echo __('First Name'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('first_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Last Name'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('last_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Email'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('email'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Contact Phone'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('phone'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Username'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('username'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Password'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('password'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Confirm Password'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('password2'); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>