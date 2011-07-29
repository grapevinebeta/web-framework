<tr class="expanded hidden-row">
    <td colspan="5">
        <div class="details">
            <div class="recentReviewDetailsForm">
                <div class="innerForm">
                    <h2 class="review-details-title"></h2>
                    <p class="review-details-content"></p>
                        <table class="wide">
                            <tr>
                                <td class="a-right">
                                    <?php echo __('Categorize'); ?>:
                                </td>
                                <td class="a-left">
                                    <select name="category" class="review-categories">
                                    </select>
                                </td>
                                <td class="a-right">
                                    <?php echo __('Tags'); ?>:
                                    <input type="text" name="tags" class="review-tags" />
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
                                    <textarea name="notes" rows="9" cols="9" class="review-notes"></textarea>
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
            <div class="recentReviewDetailsMenu">
                <div class="actions-status a-center v-padding-5">
                    <span class="recent-review-status-icon"></span>
                    <p>
                        (<?php echo __('After responding to a review check the completed box'); ?>)
                    </p>
                </div>
                <div class="single-check actions-completed v-padding-5">
                    <?php echo Form::checkbox('status', 'closed') ?>
                    <span class="action action-completed">
                        <span class="mono-icon icon-checkbox"></span>
                        <?php echo __('Completed'); ?>
                    </span>
                </div>
                <div class="single-check actions-todo v-padding-5">
                    <?php echo Form::checkbox('status', 'todo') ?>
                    <span class="action action-todo">
                        <span class="mono-icon icon-todo"></span>
                        <?php echo __('Flag "To Do"'); ?>
                    </span>
                </div>
                <div class="actions-email v-padding-5">
                    <a href="#" class="action action-email">
                        <span class="mono-icon icon-email"></span>
                        Email
                    </a>
                </div>
                <div class="actions-review v-padding-5">
                    <a href="#" class="action action-review">
                        <span class="mono-icon icon-goto"></span>
                        <?php echo __('Go to Review'); ?>
                    </a>
                </div>
            </div>
            <div class="clear"></div>
            <p class="recentReviewDetailsButtons a-right">
                <a class="actions-reply reply-to-review-button" href=#""></a>
                <a class="save-button" href="#"></a>
            </p>
        </div>
    </td>
</tr>
