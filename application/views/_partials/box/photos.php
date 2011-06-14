<div id="box-photos" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('photos'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content padding-5">
        <div class="data-grid-holder" style="display: none;">
            <table class="wide data-grid">
                <thead>
                    <tr>
                        <th class="a-left"><?php echo __('Network'); ?></th>
                        <th class="a-left"></th>
                        <th><?php echo __('Activity'); ?></th>
                        <th><?php echo __('Change'); ?></th>
                        <th><?php echo __('Total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-network"></td>
                        <td class="col-action"></td>
                        <td class="col-value a-center"></td>
                        <td class="col-change a-center"></td>
                        <td class="col-total a-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>