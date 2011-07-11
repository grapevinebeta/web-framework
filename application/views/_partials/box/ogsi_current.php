<div id="box-ogsi-current" class="box">
    <?php
    echo View::factory(
            '_partials/box/header', array(
        'caption' => __('Current Score'),
                'buttons' => array('move'),
            )
    );
    ?>
    <div class="box-content">
        <div style="display: none;">
            <table class="wide a-center v-top" style="margin: 10px 0;">
                <tr>
                    <td style="width: 20%">
                        <h3 class="headline-arrow current">
                            
                        </h3>
                    </td>
                    <td style="width: 10%">
                        <div class="ogsi-score-bg-right">
                            <div class="ogsi-score-bg-left">
                                <div class="ogsi-score">
                                    <div class="ogsi-score-ogsi">OGSI</div>
                                    <div class="ogsi-score-value"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="width: 25%">
                        <div class="ogsi-rating">
                            <div class="ogsi-rating-rating"><?php echo __('Star Rating'); ?></div>
                            <div class="ogsi-rating-value"></div>
                            <div class="ogsi-rating-stars-off"><div class="ogsi-rating-stars-on"></div></div>
                        </div>
                    </td>
                    <td style="width: 35%">
                        <div class="ogsi-reviews">
                            <div class="ogsi-reviews-reviews"><?php echo __('Review'); ?></div>
                            <div class="ogsi-reviews-value">

                            </div>
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
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>