<h1 class="content-title">
    <?php echo __('User Management'); ?>
</h1>
<div id="userManagementSettings">
    <h2 class="content-section-title"><?php echo __('User Accounts'); ?>:</h2>
    <div id="account-users-list-section" class="padding-5">
        <div id="account-users-list-holder">
            <?php echo View::factory('account/users/list', array(
                'users' => $users,
                'location' => $location,
            )); ?>
        </div>
    </div>
    <h2 class="content-section-title"><?php echo __('Add / Edit User'); ?></h2>
    <div id="account-users-edit-section" class="padding-5">
        <div id="account-users-edit-holder">
            <a href="#" title="" data-action="new"><?php echo __('New user'); ?></a>
            <form action="" method="post" class="userEditForm">
                <input type="hidden" value="" name="id" />
                <table>
                    <tr>
                        <td class="a-right">
                            <?php echo __('First Name'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('firstname'); ?>
                            <span class="validation-message" data-validation-for="firstname"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Last Name'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('lastname'); ?>
                            <span class="validation-message" data-validation-for="lastname"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Email'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('email'); ?>
                            <span class="validation-message" data-validation-for="email"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Contact Phone'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('phone'); ?>
                            <span class="validation-message" data-validation-for="phone"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Username'); ?>:
                        </td>
                        <td>
                            <?php echo form::input('username'); ?>
                            <span class="validation-message" data-validation-for="username"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Password'); ?>:
                        </td>
                        <td>
                            <?php echo form::password('password'); ?>
                            <span class="validation-message" data-validation-for="password"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <?php echo __('Confirm Password'); ?>:
                        </td>
                        <td>
                            <?php echo form::password('password_confirm'); ?>
                            <span class="validation-message" data-validation-for="password_confirm"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="a-right">
                            <!-- empty cell -->
                        </td>
                        <td>
                            <?php echo form::submit('', __('Save')); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>