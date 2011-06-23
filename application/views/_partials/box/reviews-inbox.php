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
                <!--
                <thead>
                    <tr>
                        <th class="a-left"><?php echo __('Status'); ?></th>
                        <th class="a-left"><?php echo __('Rating'); ?></th>
                        <th><?php echo __('Date'); ?></th>
                        <th><?php echo __('Review'); ?></th>
                        <th class="a-right"><?php echo __('Source'); ?></th>
                    </tr>
                </thead>
                -->
                <tbody>
                    <tr data-review-id="" class="reviewSnippet">
                        <td class="col-status"></td>
                        <td class="col-rating"></td>
                        <td class="col-submitted a-center"></td>
                        <td class="col-title"><div></div></td>
                        <td class="col-site a-right"></td>
                    </tr>
                    <tr data-review-id="" class="reviewDetails">
                        <td colspan="5">
                            <form action="">
                                <div class="recentReviewDetails" style="display: none;">
                                    <div style="clear: both;">
                                        <div class="recentReviewDetailsForm">
                                            <h2 class="review-details-title"></h2>
                                            <p class="review-details-review"></p>
                                            <form action="" method="post">
                                                <table class="wide" style="vertical-align: top;">
                                                    <tr>
                                                        <td class="a-right">
                                                            <?php echo __('Categorize'); ?>:
                                                        </td>
                                                        <td class="a-left">
                                                            <select name="category">
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
                                                            <?php echo __('Review Notes'); ?>:
                                                            <br /><br />
                                                            <span class="i">
                                                                (<?php echo __('Internal use only'); ?>)
                                                            </span>
                                                        </td>
                                                        <td colspan="2">
                                                            <textarea type="text" name="notes" style="width: 99%; height: 75px;"></textarea>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="recentReviewDetailsMenu">
                                            <p></p>
                                            <div class="a-center v-padding-2">
                                                <span class="recent-review-status-icon open"></span>
                                                <p>
                                                    (<?php echo __('After responding to a review check the completed box'); ?>)
                                                </p>
                                            </div>
                                            <div class="v-padding-2">
                                                <span class="mono-icon icon-checkbox"></span>
                                                <?php echo __('Completed'); ?>
                                            </div>
                                            <div class="v-padding-2">
                                                <span class="mono-icon icon-email"></span>
                                                Email
                                            </div>
                                            <div class="v-padding-2">
                                                <span class="mono-icon icon-todo"></span>
                                                <?php echo __('Flag "To Do"'); ?>
                                            </div>
                                            <div class="v-padding-2">
                                                <span class="mono-icon icon-goto"></span>
                                                <?php echo __('Go to Review'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="recentReviewDetailsButtons a-right">
                                        <a class="reply-to-review-button" href=""></a>
                                        <a class="close-button" href=""></a>
                                    </p>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>