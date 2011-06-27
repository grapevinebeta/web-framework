<div id="box-social-media-inbox" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Social Media Inbox'),
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
                <table class="wide data-grid no-outer-border" style="padding: 5px;">
                    <tbody>
                        <tr>
                            <td class="col-network"></td>
                            <td class="col-submitted a-center"></td>
                            <td class="col-title"><div class="wrapper"><div class="in"></div></div></td>
                            <td class="col-site"></td>
                        </tr>
                        
                        <?php echo View::factory('_partials/box/row-detail'); ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>