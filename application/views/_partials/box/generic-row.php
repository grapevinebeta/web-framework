<tr class="expanded">
    <td colspan="5">

        <form action="">
            <div class="details" style="display: none;">
                    <div class="recentReviewDetailsForm">
                        <div class="innerForm">
                        <h2 class="review-details-title"></h2>
                        <p class="review-details-review"></p>
                        <form action="" method="post">
                            <table class="wide" style="vertical-align: top;">
                                <tr>
                                    <td class="a-right">
                                        <?php echo __('Categorize'); ?>:
                                    </td>
                                    <td class="a-left">
                                        <select name="category" class="review-categories">
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
                    </div>
                    <div class="recentReviewDetailsMenu">
                        <p></p>
                        <div class="a-center v-padding-5">
                            <span class="recent-review-status-icon open"></span>
                            <p>
                                (<?php echo __('After responding to a review check the completed box'); ?>)
                            </p>
                        </div>
                        <div class="v-padding-5">
                            <span class="mono-icon icon-checkbox"></span>
                            <?php echo __('Completed'); ?>
                        </div>
                        <div class="v-padding-5">
                            <span class="mono-icon icon-email"></span>
                            Email
                        </div>
                        <div class="v-padding-5">
                            <span class="mono-icon icon-todo"></span>
                            <?php echo __('Flag "To Do"'); ?>
                        </div>
                        <div class="v-padding-5">
                            <span class="mono-icon icon-goto"></span>
                            <?php echo __('Go to Review'); ?>
                        </div>
                    </div>
                <div class="clear"></div>
                <p class="recentReviewDetailsButtons a-right">
                    <a class="reply-to-review-button" href=""></a>
                    <a class="save-button" href=""></a>
                </p>
            </div>
        </form>


    </td>
</tr>
