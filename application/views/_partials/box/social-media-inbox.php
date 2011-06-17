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
            'filters' => array('activity' => 'Activity Filter', 'network' => 'Social Network Filter'),
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
                            <td class="col-title"></td>
                            <td class="col-site"></td>
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