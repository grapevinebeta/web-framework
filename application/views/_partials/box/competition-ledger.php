<div id="box-competition-ledger" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Competition Review Inbox'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    
    <?php echo View::factory(
        '_partials/box/filters', 
        array(
            'filters' => array('activity' => 'Review Filter'),
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
                            <td class="col-checkbox"></td>
                            <td class="col-rating"></td>
                            <td class="col-submitted a-center"></td>
                            <td class="col-title"></td>
                            <td class="col-site"></td>
                            <td class="col-status a-right"></td>
                        </tr>
                        
                        <?php echo View::factory('_partials/box/row-detail'); ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>