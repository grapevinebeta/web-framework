<div id="right-panel-holder">
    <?php $urls = array('/dashboard' => 1, '' => 1); ?>
<?php if( !isset($urls[Kohana_Request::detect_uri()])): ?>
    <div class="light-box box" id="box-ogsi-current">
        <div class="light-box-header">
            <?php echo __('Current Status'); ?>
            <?php echo html::anchor(
                '#', 
                html::image('images/icons/help.png', array('alt' => '')),
                array(
                    'class' => 'tooltip',
                    'title' => __('some tip'),
                    )
                ); ?>
        </div>
        <div class="light-box-content box-content">
                <div style="display: none;">
                    <table>
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
                                    <div class="ogsi-rating-rating"><?php echo __('Star Rating'); ?></div>
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
<?php endif; ?>
    <div class="light-box" id="box-social-activity-mini">
        <div class="light-box-header">
            <?php echo __('Recent Activity'); ?>
            <?php echo html::anchor(
                '#', 
                html::image('images/icons/help.png', array('alt' => '')),
                array(
                    'class' => 'tooltip',
                    'title' => __('some tip'),
                    )
                ); ?>
        </div>
        <div class="light-box-content box-content">
            <div class="data-grid-holder">
                <div class="row">
                    <span class="date"></span>
                    <span class="network"></span>
                    <h5 class="title"></h5>
                    <a href="#" class="reply">Reply</a>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="light-box">
        <div class="light-box-header">
            <?php echo __('Resource & Help'); ?>
            <?php echo html::anchor(
                '#', 
                html::image('images/icons/help.png', array('alt' => '')),
                array(
                    'class' => 'tooltip',
                    'title' => __('some tip'),
                    )
                ); ?>
        </div>
        <div class="light-box-content">
            <table>
                <tr>
                    <td>
                        <a href="#">
                            <?php echo html::image('images/icons/question.png', array('alt' => '')); ?>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            FAQs
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            <?php echo html::image('images/icons/example.png', array('alt' => '')); ?>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            Examples And Replies
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            <?php echo html::image('images/icons/video.png', array('alt' => '')); ?>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            Video Tutorials
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
</div>