<div id="top-options-holder">
    <form id="range-form" action="<?php echo url::site(); ?>" method="post">
        <?php echo __('Viewing'); ?>:
        <?php echo html::anchor('#', html::image('images/icons/help.png', array('alt' => '', 'class'=> 'icon'))); ?>
        
        <?php $viewingRange = Session::instance()->get('viewingRange'); ?>
        <?php echo form::select(
            'range[period]', 
            array(
                '1m' => '1m',
                '3m' => '3m',
                '6m' => '6m',
                '1y' => '1y',
                ),
            $viewingRange['period']
            );
        ?>
        
        <?php echo __('Date Range'); ?>:
        <?php echo form::input('range[date]', $viewingRange['date'], array('id' => 'top-option-date-picker', 'style' => 'width: 75px;')); ?>
        <?php echo form::submit('', __('Select')); ?>
        
        <?php echo html::anchor('#email', 'Email'); ?>
        <?php echo html::anchor('#email', 'Export'); ?>
    </form>
</div>

<script type="text/javascript">
    $('#top-option-date-picker').datepicker();
</script>