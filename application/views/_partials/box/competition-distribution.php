<div id="box-competition-distribution" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Reputation Distribution'),
            'buttons' => array('dashboard-pin', 'move', 'show-graph', 'show-data'),
            )
        ); 
    ?>
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <table class="wide data-grid no-outer-border" cellpadding="5">
                <thead>
                    <tr>
                        <th class="a-left"><?php echo __('Dealership'); ?></th>
                        <th><?php echo __('Total'); ?></th>
                        <th><?php echo __('Pos'); ?></th>
                        <th><?php echo __('Neut'); ?></th>
                        <th><?php echo __('Neg'); ?></th>
                        <th><?php echo __('Avg'); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="a-left"><?php echo __('Total'); ?></th>
                        <th class="col-total a-center"></th>
                        <th class="col-positive a-center"></th>
                        <th class="col-neutral a-center"></th>
                        <th class="col-negative a-center"></th>
                        <th class="col-average a-center"></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="col-dealership"></td>
                        <td class="col-total a-center"></td>
                        <td class="col-positive a-center"></td>
                        <td class="col-neutral a-center"></td>
                        <td class="col-negative a-center"></td>
                        <td class="col-average a-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="box-competition-distribution-graph-holder" class="graph-holder"></div>
    </div>
</div>