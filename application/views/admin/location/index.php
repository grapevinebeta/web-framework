<script>
    /*  $(function() {
        $("#url").blur(function(){
            $(this).val().split("//")
        })
    })*/
</script>
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

echo "<strong>Viewing : $location->name ( $location->id )</strong> <br/>";
?>
<?php echo html::anchor('admin/company', '<< Back to Companies ') ?>
<?php echo form::open('admin/location/queue') ?>
<table>
    <thead>
    <th>
        Site
    </th>
    <th>
        URL
    </th>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php echo form::select('site', $sites, null, array('id' => 'site'))?>
        </td>
        <td width="80%">
            <?php echo form::input('url', '', array('style' => 'width:100%;'), array('id' => 'url'))?>
        </td>
        <td>
            <?php echo form::submit('submit', 'Update')?>
        </td>
    </tr>
    <?php echo form::hidden('industry', $location->industry);
    echo form::hidden('location', $location->id);?>

    </tbody>

</table>
<?php form::close() ?>
Queue

<table>
    <thead>
    <td width="10%">Site</td>
    <td width="80%">
        Url
    </td>
    <td>
        Link
    </td>
    </th>

    <?php foreach (
    $sites as $site

): $q = (object)Arr::get($queue, $site, array('url' => 'Empty'));
    ?>
    <tr>
        <td><?php echo $site?></td>
        <td><?php echo $q->url?></td>
        <td><?php echo html::anchor($q->url, "View Site")?></td>
    </tr>
    <?php endforeach ?>


</table>

<table>
    <thead>
    <td width="250">Competitor</td>
    <td width="140">Site</td>
    <td>
        Url
    </td>
    <td>Link</td>
    </th>


<?php
foreach (
    $competitors as $id
    => $name
):?>

    <tr>
        <td><?php echo $name?></td>

        <td><?php echo html::anchor("admin/location/view/$id", "View Info")?></td>
    </tr>
    <?php endforeach;?>


</table>

