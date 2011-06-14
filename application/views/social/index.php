<div id="boxes-holder">

    <div class="box-container active">
        <div id="box-social-activity" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-show-graph" href="#" title="Chart"></a>
                    <a class="box-header-button box-header-button-show-data" href="#" title="Data"></a>
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="Close"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button box-header-button-move" href="#" title="Move"></a>
                </div>
                <span class="box-header-title">
                    <?php echo __('Social Activity'); ?>
                </span>
                <div class="clear"></div>
            </div>
            <div class="box-content">
                
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
                
                <div id="box-social-activity-graph-holder" class="graph-holder"></div>
            </div>
        </div>
    </div>

    <div class="box-container active">
        <div id="box-social-reach" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-show-graph" href="#" title="Chart"></a>
                    <a class="box-header-button box-header-button-show-data" href="#" title="Data"></a>
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="Close"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button box-header-button-move" href="#" title="Move"></a>
                </div>
                <span class="box-header-title">
                    <?php echo __('Social Reach'); ?>
                </span>
                <div class="clear"></div>
            </div>
            <div class="box-content">
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
                <div id="box-social-reach-graph-holder" class="graph-holder"></div>
            </div>
        </div>
    </div>

    <div class="box-container active">
        <div id="box-social-activity-details" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="Close"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button box-header-button-move" href="#" title="Move"></a>
                </div>
                <div style="margin: 0px 30px 0px 15px;">
                    <div>
                        <?php echo __('Activity Filter'); ?>:
                        <span id="box-header-activity-filters"></span>
                    </div>
                    <div>
                        <?php echo __('Network Filter'); ?>:
                        <span id="box-header-network-filters"></span>
                    </div>
                </div>
            </div>
            <div class="box-content">
                <div class="data-grid-holder" style="display: none;">
                    <form action="">
                        <table class="wide data-grid no-outer-border" style="padding: 5px;">
                            <tbody>
                                <tr>
                                    <td class="col-checkbox"></td>
                                    <td class="col-rating"></td>
                                    <td class="col-submitted a-center"></td>
                                    <td class="col-title"></td>
                                    <td class="col-site"></td>
                                    <td class="col-status a-right"></td>
                                </tr>
                                <tr style="display: none;">
                                    <td colspan="6">
                                        <div>
                                            
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box-container empty box-container-left">
        <div id="box-videos" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="Close"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button box-header-button-move" href="#" title="Move"></a>
                </div>
                <span class="box-header-title">
                    <?php echo __('Videos'); ?>
                </span>
                <div class="clear"></div>
            </div>
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
    </div>
    <div class="box-container empty box-container-right">
        <div id="box-photos" class="box">
            <div class="box-header">
                <div class="box-header-right-buttons">
                    <a class="box-header-button box-header-button-dashboard-pin" href="#" title="Close"></a>
                </div>
                <div class="box-header-left-buttons">
                    <a class="box-header-button box-header-button-move" href="#" title="Move"></a>
                </div>
                <span class="box-header-title">
                    <?php echo __('Photos'); ?>
                </span>
                <div class="clear"></div>
            </div>
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
    </div>
    <div class="clear"></div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
<div class="clear"></div>