 <div id="box-recent-reviews" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Reviews Inbox'),
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
            <table class="wide data-grid no-outer-border" style="padding: 5px;">
                <tbody>
                    <tr>
                        <td class="col-status"></td>
                        <td class="col-rating"></td>
                        <td class="col-submitted a-center" width="10%"></td>
                        <td class="col-title" width="72%"><div class="wrapper"><div class="in"></div></div></td>
                        <td class="col-site a-right"></td>
                    </tr>
                    <?php echo View::factory('_partials/box/generic-row'); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>