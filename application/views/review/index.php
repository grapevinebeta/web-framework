<div id="boxes-holder">

    <div class="box-container active box-container-left">
        <div id="box-review-sites" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button-show-graph" href="#" title="Close">g</a>
                    <a class="box-header-button-dashboard-pin" href="#" title="Close">p</a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button-move" href="#" title="Move">m</a>
                </div>
                <?php echo __('Review Sites'); ?>:
            </div>
            <div class="box-content padding-5">
                <div class="data-grid-holder" style="display: none;">
                    <table class="wide data-grid">
                        <thead>
                            <tr>
                                <th class="a-left"><?php echo __('Site'); ?></th>
                                <th><?php echo __('Total'); ?></th>
                                <th><?php echo __('Pos'); ?></th>
                                <th><?php echo __('Neut'); ?></th>
                                <th><?php echo __('Neg'); ?></th>
                                <th><?php echo __('Avg'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="a-left"><?php echo __('Total'); ?></td>
                                <th class="col-total a-center"></td>
                                <th class="col-positive a-center"></td>
                                <th class="col-neutral a-center"></td>
                                <th class="col-negative a-center"></td>
                                <th class="col-average a-center"></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td class="col-site"></td>
                                <td class="col-total a-center"></td>
                                <td class="col-positive a-center"></td>
                                <td class="col-neutral a-center"></td>
                                <td class="col-negative a-center"></td>
                                <td class="col-average a-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="graph-holder"></div>
            </div>
        </div>
    </div>
    <div class="box-container active box-container-right">
        <div id="box-keywords-analysis" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button-show-graph" href="#" title="Close">g</a>
                    <a class="box-header-button-dashboard-pin" href="#" title="Close">p</a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button-move" href="#" title="Move">m</a>
                </div>
                <?php echo __('Analysis of Review Keywords'); ?>:
            </div>
            <div class="box-content padding-5">
                <div class="data-grid-holder" style="display: none;">
                    <table class="wide data-grid">
                        <thead>
                            <tr>
                                <th class="a-left"><?php echo __('Important Keywords'); ?></th>
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
                <div class="graph-holder"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    
    <div class="box-container active">
        <div id="box-recent-reviews" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button-show-graph" href="#" title="Close">g</a>
                    <a class="box-header-button-dashboard-pin" href="#" title="Close">p</a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button-move" href="#" title="Move">m</a>
                </div>
                <div style="margin: 0px 30px 0px 15px;">
                    <div>
                        <?php echo __('Review Status Filter'); ?>:
                        <span id="box-header-status-filters"></span>
                    </div>
                    <div>
                        <?php echo __('Review Source Filter'); ?>:
                        <span id="box-header-source-filters"></span>
                    </div>
                </div>
            </div>
            <div class="box-content">
                <div class="data-grid-holder" style="display: none;">
                    <table class="wide data-grid no-outer-border" cellpadding="5">
                        <?php /*
                        <thead>
                            <tr>
                                <th class="a-left"><?php echo __('Important Keywords'); ?></th>
                                <th><?php echo __('Times Used'); ?></th>
                                <th><?php echo __('Avg star rating'); ?></th>
                                <th><?php echo __('% of Total'); ?></th>
                            </tr>
                        </thead>
                         * 
                         */?>
                        <tbody>
                            <tr>
                                <td class="col-checkbox"></td>
                                <td class="col-rating"></td>
                                <td class="col-submitted a-center"></td>
                                <td class="col-title"></td>
                                <td class="col-site"></td>
                                <td class="col-status a-right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
<div class="clear"></div>