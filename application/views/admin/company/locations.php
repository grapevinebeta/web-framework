<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 9/29/11
 * Time: 7:30 PM
 */

/**
 * @var $company Model_Company
 */
$company = null;


?>
<table>
    <thead>
    <td>Location Id</td>
    <th>
        Location Name
    </th>
    <td>
        View Location Info
    </td>
    </thead>
    <?php foreach (
    $locations as $location
): ?>
    <tr>
        <td><?php echo $location->id?></td>
        <td><?php echo $location->name?></td>
        <td><?php echo html::anchor("admin/location/view/$location->id", "View")?></td>
    </tr>
    <?php endforeach?>


</table>