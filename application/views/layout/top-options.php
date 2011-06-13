<div id="top-options-holder">
    <form id="range-form" action="<?php echo url::site(); ?>" method="post">
        <span><?php echo __('Viewing'); ?>:</span>
        <?php echo html::anchor(
            '#', 
            html::image('images/icons/help.png', array('alt' => '')),
            array(
                'class' => 'tooltip',
                'title' => __('some tip'),
                )
            ); ?>
        <?php $viewingRange = Session::instance()->get('viewingRange'); ?>
        <?php echo form::select(
            'period',
            array(
                '1m' => '1m',
                '3m' => '3m',
                '6m' => '6m',
                '1y' => '1y',
                ),
            $viewingRange['period'],
            array(
                'id' => 'period-selector',
                )
            );
        ?>
        <?php 
            echo html::image('images/icons/pickdate.png', array('alt' => ''));
            echo form::input(
            'date', 
            $viewingRange['date'], 
            array(
                'id' => 'date-selector', 
                'class' => 'as-select with-icon', 
                'style' => 'width: 65px;')); ?>
        
        <?php 
            echo html::image('images/icons/email.png', array('alt' => '')); 
            echo html::anchor('#email', 'Email', array('class' => 'as-select with-icon')); ?>
        <?php 
            echo html::image('images/icons/export.png', array('alt' => '')); 
            echo html::anchor('#email', 'Export', array('class' => 'as-select with-icon')); ?>
    </form>
</div>

<script type="text/javascript">
    $('#top-options-holder #date-selector').datepicker();
    $('#period-selector').selectbox();
</script>