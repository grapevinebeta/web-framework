<div id="box-competition-review-inbox" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('competition review inbox'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    
    <?php echo View::factory(
        '_partials/box/filters', 
        array(
            'filters' => array('status' => 'Status Filter', 'source' => 'Source Filter'),
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
                            <td class="col-score"></td>
                            <td class="col-date a-center" style="width:54px;"></td>
                            <td class="col-title" style="width:466px;"><div class="wrapper"><div class="in"></div></div></td>
                            <td class="col-site a-right"></td>
                            <td class="col-competition a-right" style="width:70px;"></td>
                        </tr>
                        
                        <?php echo View::factory('_partials/box/row-detail'); ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>