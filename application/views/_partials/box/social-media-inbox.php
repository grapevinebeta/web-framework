<div id="box-social-media-inbox" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('social media inbox'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    
    <?php echo View::factory(
        '_partials/box/filters', 
        array(
            'filters' => array('activity' => 'Activity Filter'),
            'has_pager' => true
            )
        ); 
    ?>
    
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <form action="">
                <table class="wide data-grid no-outer-border">
                    <tbody>
                        <tr>
                            <td class="col-network"></td>
                            <td class="col-date a-center" width="13%"></td>
                            <td class="col-title" style="width:466px;"><div class="wrapper"><div class="in"></div></div></td>
                            <td class="col-site" width="15%"></td>
                        </tr>
                        
                        <?php echo View::factory('_partials/box/row-detail'); ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>