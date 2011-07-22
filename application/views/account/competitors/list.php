<form action="" method="post" class="competitorsSettingsList">
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
                <tr class="<?php echo ($k % 2?'even':'odd'); ?>">
                    <td>
                        <?php
                            // @todo Fix it, currently it does not have info about which competitor it is about
                            echo form::checkbox('competitors[active]', 1, true);
                        ?>
                    </td>
                    <td class="a-left">
                        <?php echo html::chars($competitor) ?>
                    </td>
                    <td class="a-center">
                        <?php
                        echo html::anchor('#', 'x',array(
                            'class' => 'confirm-required',
                            'data-action' => 'delete',
                            'data-competitor' => $competitor,
                        ));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>