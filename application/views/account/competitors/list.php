<form action="" method="post" class="competitorsSettingsList">
    <table class="wide data-grid" cellpadding="5">
        <tr>
            <th class="a-left">
                <?php echo __('Competitors'); ?>
            </th>
        </tr>
        <?php if (!empty($competitors)): ?>
            <?php foreach ($competitors as $k => $competitor): ?>
                <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                    <td class="a-left">
                        <?php echo html::chars($competitor) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>