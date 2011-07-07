<div id="box-ogsi" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Grapevine OGSI'),
            )
        ); 
    ?>
    <div class="box-content">
        <div style="display: none;">
            <table class="wide a-center margin-10 v-top">
                <tr>
                    <td style="width: 33.3%">
                        <div id="ogsi-score-bg-right">
                            <div id="ogsi-score-bg-left">
                                <div id="ogsi-score">
                                    <div id="ogsi-score-ogsi">OGSI</div>
                                    <div id="ogsi-score-value"></div>
                                </div>
                            </div>
                        </div>
                        <div id="ogsi-score-change">
                            <span class="change-value"></span>
                            <span class="change-arrow"></span>
                        </div>
                    </td>
                    <td style="width: 33.3%">
                        <div id="ogsi-rating">
                            <div id="ogsi-rating-rating"><?php echo __('Star Rating'); ?></div>
                            <div id="ogsi-rating-value"></div>
                            <div id="ogsi-rating-stars-off"><div id="ogsi-rating-stars-on"></div></div>
                        </div>
                        <div id="ogsi-rating-change">
                            <span class="change-value"></span>
                            <span class="change-arrow"></span>
                        </div>
                    </td>
                    <td style="width: 33.3%">
                        <div id="ogsi-reviews">
                            <div id="ogsi-reviews-reviews"><?php echo __('Review'); ?></div>
                            <div id="ogsi-reviews-value">
                                
                            </div>
                        </div>
                        <div id="ogsi-reviews-change">
                            <span class="change-value"></span>
                            <span class="change-arrow"></span>
                        </div>
                    </td>
                </tr>
            </table>
            <div id="box-ogsi-review-distribution">
                <div class="title a-    center"><?php echo __('Review Distribution'); ?></div>
                <div class="bar-holder">
                    <div class="bar-negative">
                        <div class="bar-neutral">
                            <div class="bar-positive">
                                <span class="bar-value">1</span>
                            </div>
                            <span class="bar-value">3</span>
                        </div>
                        <span class="bar-value">5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>