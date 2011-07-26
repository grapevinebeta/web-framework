<div id="right-panel-holder">
     <div class="light-box">
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
                 <strong>2</strong> reviews need
your attention
             </span>
             </div>
             
             <div class="row end">
             <span class="status-icon todo"></span>
             <span class="desc">
                 <strong>6</strong> reviews are still flagged
             </span>
             </div>
         </div>
     </div>
    
    <?php $urls = array('/dashboard' => 1, '' => 1, '/' => 1); ?>
    <?php if (!isset($urls[Kohana_Request::detect_uri()])): ?>
        <?php echo view::factory('_partials/box/ogsi_mini'); ?>
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