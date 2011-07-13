<div class="light-box box" id="box-ogsi-current">
    <div class="light-box-header">
        <?php echo __('all time score'); ?>
        <?php
        echo html::anchor(
                '#', html::image('images/icons/help.png', array('alt' => '')), array(
            'class' => 'tooltip',
            'title' => __('some tip'),
                )
        );
        ?>
    </div>
    <div class="light-box-content box-content">
        <div style="display: none;">
            <table width="100%">
                <tr>
                    <td>
                        <div class="ogsi-score-bg-right">
                            <div class="ogsi-score-bg-left">
                                <div class="ogsi-score">
                                    <div class="ogsi-score-ogsi">OGSI</div>
                                    <div class="ogsi-score-value"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="ogsi-rating">
                            <div class="ogsi-rating-rating"><?php echo __('Star Rating'); ?>
                            <span class="ogsi-rating-value"></span>
                            </div>
                            <div class="ogsi-rating-stars-off"><div class="ogsi-rating-stars-on"></div></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="ogsi-reviews">
                            <div class="ogsi-reviews-reviews"><?php echo __('Reviews'); ?> <span class="ogsi-reviews-value"></span></div>
                            <div class="bar-holder">
                                <div class="bar-negative">
                                    <div class="bar-neutral">
                                        <div class="bar-positive">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>