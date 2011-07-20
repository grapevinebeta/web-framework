<h1 class="content-title">
    <?php echo __('User Management'); ?>
</h1>
<div id="userManagementSettings">
    <h2 class="content-section-title"><?php echo __('User Accounts'); ?>:</h2>
    <div id="account-users-list-section" class="padding-5">
        <div id="account-users-list-holder">
            <?php echo View::factory('account/users/list', array(
                'users' => $users,
            )); ?>
        </div>
    </div>
    <h2 class="content-section-title"><?php echo __('Add / Edit User'); ?></h2>
    <div id="account-users-edit-section" class="padding-5">
        <div id="account-users-edit-holder">
            <form action="" method="post">
                <input type="hidden" value="" name="id" />
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