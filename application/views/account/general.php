<h1 class="content-title">
    <?php echo __('General'); ?>
</h1>
<div class="padding-5" id="generalLocationSettings">
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
                <?php echo $location->owner_name; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Email'); ?>:
            </td>
            <td>
                <?php echo $location->owner_email; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Contact Phone'); ?>:
            </td>
            <td>
                <?php echo $location->owner_phone; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Extension'); ?>:
            </td>
            <td>
                <?php echo $location->owner_ext; ?>
            </td>
        </tr>
        <tr>
            <td class="b a-right">
                <?php echo __('Current Location'); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Location Name'); ?>:
            </td>
            <td>
                <?php echo $location->location_name; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Address 1'); ?>:
            </td>
            <td>
                <?php echo $location->address1; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Address 2'); ?>:
            </td>
            <td>
                <?php echo $location->address2; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('City'); ?>:
            </td>
            <td>
                <?php echo $location->city; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('State'); ?>:
            </td>
            <td>
                <?php echo $location->state; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Zip'); ?>:
            </td>
            <td>
                <?php echo $location->zip; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('Phone'); ?>:
            </td>
            <td>
                <?php echo $location->phone; ?>
            </td>
        </tr>
        <tr>
            <td class="a-right">
                <?php echo __('URL'); ?>:
            </td>
            <td>
                <?php echo $location->url; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                
                echo __('Want to change your Account Information? :contact_link', array(
                    ':contact_link' => HTML::mailto('info@grapevinebeta.com', __('Contact Us')),
                ));

                ?>
            </td>
        </tr>
    </table>
</div>