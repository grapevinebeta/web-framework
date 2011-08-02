<div class="light-box" id="box-social-activity-mini">
    <div class="light-box-header">
        <?php echo __('social activity'); ?>
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
        <div class="data-grid-holder">
            <div class="row">
                <span class="date"></span>
                <span class="network"></span>
                <h5 class="title"></h5>
                <a href="#" class="reply"><?php echo __('Reply'); ?></a>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>