<div id="box-ogsi" class="box">
    <?php
    echo View::factory(
            '_partials/box/header', array(
        'caption' => __('Grapevine OGSI'),
                'buttons' => array('move'),
            )
    );
    ?>
    <div class="box-content">
        <div style="display: none;">
            <table class="wide a-center v-top" style="margin: 10px 0;">
                <tr>
                    <td style="width: 20%">
                        <h3 class="headline-arrow">
                            all time
                            <span class="big">score</span>
                        </h3>
                    </td>
                    <td style="width: 10%">
                        <div id="ogsi-score-bg-right">
                            <div id="ogsi-score-bg-left">
                                <div id="ogsi-score">
                                    <div id="ogsi-score-ogsi">OGSI</div>
                                    <div id="ogsi-score-value"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="width: 25%">
                        <div id="ogsi-rating">
                            <div id="ogsi-rating-rating"><?php echo __('Star Rating'); ?></div>
                            <div id="ogsi-rating-value"></div>
                            <div id="ogsi-rating-stars-off"><div id="ogsi-rating-stars-on"></div></div>
                        </div>
                    </td>
                    <td style="width: 35%">
                        <div id="ogsi-reviews">
                            <div id="ogsi-reviews-reviews"><?php echo __('Review'); ?></div>
                            <div id="ogsi-reviews-value">

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