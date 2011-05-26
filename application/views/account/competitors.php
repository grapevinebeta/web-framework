<h1 class="content-title">
    <?php echo __('Competitors'); ?>
</h1>
<h2 class="content-section-title"><?php echo __('Competition List'); ?>:</h2>
<div id="account-competitors-list-section" class="padding-5">
    <?php echo __('Grapevine allows you to track and compare your business online reputation with up to 6 competitors. Insert competitors name below, with carefull attention to spelling and verifying official business name before clicking on "Add Competitor" button. We will  manually add any reporter "Unknown" non-matches.'); ?>
    <form action="" method="post">
        <table class="wide data-grid" cellpadding="5">
            <tr>
                <th class="a-left">
                    <?php echo __('Active'); ?>
                </th>
                <th class="a-left">
                    <?php echo __('Competitors'); ?>
                </th>
                <th class="a-center">
                    <?php echo __('Delete'); ?>
                </th>
            </tr>
            <?php if (!empty($competitors)): ?>
            <?php foreach ($competitors as $k => $competitor): ?>
            <?php $_inputPrefix = 'competitors['. $competitor['id'] .']'; ?>
            <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                <td>
                    <?php echo form::hidden($_inputPrefix . '[id]', $competitor['id']); ?>
                    <?php echo form::hidden($_inputPrefix . '[active]', 0); ?>
                    <?php echo form::checkbox($_inputPrefix . '[active]', 1, $competitor['active'] != false); ?>
                </td>
                <td class="a-left">
                    <?php echo html::chars($competitor['name']) ?>
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
    <form action="" method="post">
        <p>
            <input type="text" name="newCompetitor" />
            <?php echo form::submit('', __('Add Competitor')); ?>
        </p>
    </form>
</div>
