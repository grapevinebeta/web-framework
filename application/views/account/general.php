<h1 class="content-title">
    <?php echo _('General'); ?>
</h1>
<div class="padding-5">
    <form action="" method="post">
        <table>
            <tr>
                <td class="b a-right">
                    <?php echo _('Account Owner'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Name'); ?>:
                </td>
                <td>
                    <?php echo form::input('name'); ?>
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
                    <?php echo _('Extension'); ?>:
                </td>
                <td>
                    <?php echo form::input('extension'); ?>
                </td>
            </tr>
            <tr>
                <td class="b a-right">
                    <?php echo _('Current Location'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo _('Your business information is based on your original account set up. Use form below to make any needed chages.'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Location Name'); ?>:
                </td>
                <td>
                    <?php echo form::input('location_name'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Address 1'); ?>:
                </td>
                <td>
                    <?php echo form::input('adress1'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Address 2'); ?>:
                </td>
                <td>
                    <?php echo form::input('adress2'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('City'); ?>:
                </td>
                <td>
                    <?php echo form::input('city'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('State'); ?>:
                </td>
                <td>
                    <?php echo form::input('state'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Zip'); ?>:
                </td>
                <td>
                    <?php echo form::input('zip'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('Phone'); ?>:
                </td>
                <td>
                    <?php echo form::input('location_phone'); ?>
                </td>
            </tr>
            <tr>
                <td class="a-right">
                    <?php echo _('URL'); ?>:
                </td>
                <td>
                    <?php echo form::input('url'); ?>
                </td>
            </tr>
        </table>
        <div class="a-right">
            <?php echo form::submit('', _('Save')); ?>
        </div>
    </form>
</div>