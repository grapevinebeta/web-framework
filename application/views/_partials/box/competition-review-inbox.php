<div id="box-competition-review-inbox" class="box">
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
                            <td class="col-rating"></td>
                            <td class="col-submitted a-center"></td>
                            <td class="col-title" width="72%"><div class="wrapper"><div class="in"></div></div></td>
                            <td class="col-author a-right"></td>
                            <td class="col-competition a-right"></td>
                        </tr>
                        
                        <?php echo View::factory('_partials/box/row-detail'); ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>