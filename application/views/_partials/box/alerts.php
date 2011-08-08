<div class="light-box hide" id="alerts">
    <div class="light-box-header">
        <?php echo __('alerts'); ?>
        <?php
        echo html::anchor(
                '#', html::image('images/icons/help.png', array('alt' => '')), array(
            'class' => 'tooltip',
            'title' => __('some tip'),
                )
        );
        ?>
    </div>
    <div class="light-box-content">

        <div class="row">
            <span class="status-icon alert"></span>
            <span class="desc">
                <a href="/alerts/alert" class="alert-show">
                    <strong class="alert"></strong> 
                    <?php echo __('reviews need your attention'); ?>
                </a>
            </span>
        </div>

        <div class="row end">
            <span class="status-icon todo"></span>
            <span class="desc">
            <a href="/alerts/todo" class="todo-show">
                <strong class="todo"></strong> 
                <?php echo __('reviews are still flagged'); ?>
            </a>
            </span>
        </div>
    </div>
</div>