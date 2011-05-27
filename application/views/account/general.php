<h1 class="content-title">
    <?php echo __('General'); ?>
</h1>
<div class="padding-5">
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
                    <?php echo form::input('name'); ?>
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
                    <?php echo __('Extension'); ?>:
                </td>
                <td>
                    <?php echo form::input('extension'); ?>
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
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Address 1'); ?>:
                </td>
                <td>
                    <?php echo form::input('adress1'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Address 2'); ?>:
                </td>
                <td>
                    <?php echo form::input('adress2'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('City'); ?>:
                </td>
                <td>
                    <?php echo form::input('city'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('State'); ?>:
                </td>
                <td>
                    <?php echo form::input('state'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Zip'); ?>:
                </td>
                <td>
                    <?php echo form::input('zip'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('Phone'); ?>:
                </td>
                <td>
                    <?php echo form::input('location_phone'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo __('URL'); ?>:
                </td>
                <td>
                    <?php echo form::input('url'); ?>
                </td>
            </tr>
        </table>
        <div class="a-right">
            <?php echo form::submit('', __('Save')); ?>
        </div>
    </form>
</div>