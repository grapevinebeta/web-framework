<h1 class="content-title">
    <?php echo __('General'); ?>
</h1>
<div class="padding-5" id="generalLocationSettings">
    <form action="" method="post">
        <table>
            <tr>
                <td class="b a-right">
                    <?php echo __('Account Owner'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Name'); ?>:
                </td>
                <td>
                    <?php echo form::input('owner_name'); ?>
                    <span class="validation-message" data-validation-for="owner_name"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Email'); ?>:
                </td>
                <td>
                    <?php echo form::input('owner_email'); ?>
                    <span class="validation-message" data-validation-for="owner_email"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Contact Phone'); ?>:
                </td>
                <td>
                    <?php echo form::input('owner_phone'); ?>
                    <span class="validation-message" data-validation-for="owner_phone"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Extension'); ?>:
                </td>
                <td>
                    <?php echo form::input('owner_ext'); ?>
                    <span class="validation-message" data-validation-for="owner_ext"></span>
                </td>
            </tr>
            <tr>
                <td class="b a-right">
                    <?php echo __('Current Location'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo __('Your business information is based on your original account set up. Use form below to make any needed chages.'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Location Name'); ?>:
                </td>
                <td>
                    <?php echo form::input('location_name'); ?>
                    <span class="validation-message" data-validation-for="location_name"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Address 1'); ?>:
                </td>
                <td>
                    <?php echo form::input('address1'); ?>
                    <span class="validation-message" data-validation-for="address1"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Address 2'); ?>:
                </td>
                <td>
                    <?php echo form::input('address2'); ?>
                    <span class="validation-message" data-validation-for="address2"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('City'); ?>:
                </td>
                <td>
                    <?php echo form::input('city'); ?>
                    <span class="validation-message" data-validation-for="city"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('State'); ?>:
                </td>
                <td>
                    <?php echo form::input('state'); ?>
                    <span class="validation-message" data-validation-for="state"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Zip'); ?>:
                </td>
                <td>
                    <?php echo form::input('zip'); ?>
                    <span class="validation-message" data-validation-for="zip"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Phone'); ?>:
                </td>
                <td>
                    <?php echo form::input('phone'); ?>
                    <span class="validation-message" data-validation-for="phone"></span>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('URL'); ?>:
                </td>
                <td>
                    <?php echo form::input('url'); ?>
                    <span class="validation-message" data-validation-for="url"></span>
                </td>
            </tr>
        </table>
        <div class="a-right">
            <?php echo form::submit('', __('Save')); ?>
        </div>
    </form>
</div>