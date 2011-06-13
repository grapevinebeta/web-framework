<div id="boxes-holder">

    <div class="box-container active">
        <div id="box-competition-comparision" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-show-graph" href="#" title="Chart"></a>
                    <a class="box-header-button box-header-button-show-data" href="#" title="Data"></a>
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="<?php echo __('Pin to Dashboard'); ?>"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button-move" href="#" title="<?php echo __('Move'); ?>"></a>
                </div>
                <?php echo __('Competition comparision'); ?>
            </div>
            <div class="box-content">
                <div id="box-competition-comparision-graph-holder" class="graph-holder"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div class="box-container active">
        <div id="box-competition-distribution" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-show-graph" href="#" title="Chart"></a>
                    <a class="box-header-button box-header-button-show-data" href="#" title="Data"></a>
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="<?php echo __('Pin to Dashboard'); ?>"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button-move" href="#" title="<?php echo __('Move'); ?>"></a>
                </div>
                <div class="box-header-title-holder">
                    <div>
                        <?php echo __('Reputation Distribution'); ?>
                    </div>
                </div>
            </div>
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
    </div>

    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>

</div>
<div class="clear"></div>