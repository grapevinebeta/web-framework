<div id="top-options-holder">
    <form action="<?php echo url::site(); ?>" method="post">
        <?php echo __('Viewing'); ?>:
        <?php echo html::anchor('#', '?'); ?>
        
        <select name="timePeriod">
            <option>1m</option>
            <option>3m</option>
            <option>6m</option>
            <option>1y</option>
        </select>
        
        <?php echo __('Date Range'); ?>:
        <?php echo form::input('dateRange', date('m/d/Y'), array('id' => 'top-option-date-picker', 'style' => 'width: 75px;')); ?>
        <?php echo html::anchor('#', __('Select')); ?>
        
        <?php echo html::anchor('#email', 'Email'); ?>
        <?php echo html::anchor('#email', 'Export'); ?>
    </form>
</div>

<script type="text/javascript">
    $('#top-option-date-picker').datepicker();
</script>