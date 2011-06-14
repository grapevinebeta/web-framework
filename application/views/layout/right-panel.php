<div id="right-panel-holder">
    <div class="light-box">
        <div class="light-box-header">
            <?php echo __('All Time Snapshot'); ?>
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
            <h3>OGSI 115%</h3>
        </div>
    </div>

    <div class="light-box">
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
        <div class="light-box-content">
            test content
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