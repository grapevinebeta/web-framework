<div id="top-options-holder">
    <form action="" method="post">
        <?php echo _('Viewing'); ?>: 
        <?php echo html::image('', array('alt' => '?')); ?>
        <select name="timePeriod">
            <option>1m</option>
            <option>3m</option>
            <option>6m</option>
            <option>1y</option>
        </select>
        
        <?php echo _('Date Range'); ?>:
        <?php echo form::input('dateRange', date('m/d/Y'), array('id' => 'top-option-date-picker', 'style' => 'width: 75px;')); ?>
        <?php echo html::anchor('#', _('Select')); ?>
        
        <?php echo html::anchor('#email', 'Email'); ?>
        <?php echo html::anchor('#email', 'Export'); ?>
    </form>
</div>

<script type="text/javascript">
    $('#top-option-date-picker').datepicker();
</script>