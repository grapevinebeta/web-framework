 <div id="box-recent-reviews" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Review Inbox'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    
    <?php echo View::factory(
        '_partials/box/filters', 
        array(
            'filters' => array('status' => 'Status Filter', 'source' => 'Source Filter'),
            )
        ); 
    ?>
    
    <div class="box-content">
        <div class="data-grid-holder" style="display: none;">
            <form action="">
                <table class="wide data-grid no-outer-border" style="padding: 5px;">
                    <thead>
                        <tr>
                            <th class="a-left"><?php echo __('Status'); ?></th>
                            <th class="a-left"><?php echo __('Rating'); ?></th>
                            <th><?php echo __('Date'); ?></th>
                            <th><?php echo __('Review'); ?></th>
                            <th class="a-right"><?php echo __('Source'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-review-id="" class="reviewSnippet">
                            <td class="col-status"></td>
                            <td class="col-rating"></td>
                            <td class="col-submitted a-center"></td>
                            <td class="col-title"></td>
                            <td class="col-site a-right"></td>
                        </tr>
                        <tr data-review-id="" class="reviewDetails">
                            <td colspan="5">
                                <div class="recentReviewDetails" style="display: none;">
                                    <div style="clear: both;">
                                        <div class="recentReviewDetailsForm">
                                            <h2 class="review-details-title"></h2>
                                            <p class="review-details-review"></p>
                                            <form action="" method="post">
                                                <table class="wide" style="vertical-align: top;">
                                                    <tr>
                                                        <td class="a-right">
                                                            <?php echo __('categorize'); ?>:
                                                        </td>
                                                        <td class="a-left">
                                                            <select name="Category">
                                                                <option value=""></option>
                                                                <option value="category 1">category 1</option>
                                                                <option value="category 2">category 2</option>
                                                            </select>
                                                        </td>
                                                        <td class="a-right">
                                                            <?php echo __('Keywords'); ?>:
                                                            <input type="text" value="" name="keywords" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="a-right">
                                                            <?php echo __('Keywords'); ?>:
                                                        </td>
                                                        <td colspan="2">
                                                            <textarea type="text" name="notes" style="width: 99%;"></textarea>
                                                            <input type="submit" name="" value="Send" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="recentReviewDetailsMenu">
                                            <p></p>
                                            <ul>
                                                <li>Completed</li>
                                                <li>Mark</li>
                                                <li>ToDo</li>
                                                <li>Email</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="recentReviewDetailsButtons">
                                        some buttons
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>