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
    <th>
        Name
    </th>
    <td>
        View Locations
    </td>
    </thead>
    <?php foreach (
    $results as $company
): ?>
    <tr>
        <td><?php echo $company->name?></td>
        <td><?php echo html::anchor("admin/company/locations/$company->id","View Locations")?></td>
    </tr>
    <?php endforeach?>


</table>