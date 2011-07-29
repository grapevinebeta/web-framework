<?php $urls = array('/dashboard' => 1, '' => 1, '/' => 1); ?>
<div id="right-panel-holder">
    <?php if (!isset($urls[Kohana_Request::detect_uri()])): ?>
        <?php echo view::factory('_partials/box/ogsi_mini'); ?>
    <?php else: ?>
        <?php echo view::factory('_partials/box/alerts'); ?>
    <?php endif; ?>
    <?php echo view::factory('_partials/box/recent_activity'); ?>

    <?php if(0): ?>
    <div class="light-box">
        <div class="light-box-header">
            <?php echo __('resource & help'); ?>
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
    <?php endif; ?>
</div>