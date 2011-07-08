<div id="box-tags-analysis" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Analysis of Review Tags'),
            'buttons' => array('show-graph', 'show-data', 'dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <table class="wide data-grid">
                <thead>
                    <tr>
                        <th class="a-left"><?php echo __('Important Tags'); ?></th>
                        <th><?php echo __('Times Used'); ?></th>
                        <th><?php echo __('Avg star rating'); ?></th>
                        <th><?php echo __('% of Total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-keyword"></td>
                        <td class="col-used a-center"></td>
                        <td class="col-rating a-center"></td>
                        <td class="col-percent a-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="box-tags-analysis-graph-holder" class="graph-holder"></div>
    </div>
</div>