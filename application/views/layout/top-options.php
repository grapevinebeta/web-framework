<div id="top-options-holder">
    <form id="range-form" action="<?php echo url::site(); ?>" method="post">
        <span><?php echo __('Viewing'); ?>:</span>

        <?php $viewingRange = Session::instance()->get('viewingRange'); ?>
        <?php
        
        $periods = array(
            '1m' => '1m',
            '3m' => '3m',
            '6m' => '6m',
            '1y' => '1y',
            'ytd' => 'YTD',
            'all' => 'All',
                );
        
        if(!isset($periods[$viewingRange['period']])) {
            $periods[$viewingRange['period']] = 'custom';
        }
        
        echo form::select(
                'period', $periods, $viewingRange['period'], array(
            'id' => 'period-selector',
                )
        );
        ?>

        <div id="widget">
            <div id="widgetField">
                <span>select your custom range</span>
                <a href="#">Select date range</a>
            </div>
            <div id="widgetCalendar">
            </div>
        </div>
        
        <?php
        echo form::input(
                'date', $viewingRange['date'], array(
            'id' => 'date-selector',
            'style' => 'display:none;'));
        ?>

        <?php
        echo html::image('images/icons/email.png', array('alt' => ''));
        echo html::anchor('#email', 'Email', array('class' => 'as-select with-icon email'));
        ?>
        <?php
        echo html::image('images/icons/export.png', array('alt' => ''));
        echo html::anchor('#export', 'Export', array('class' => 'as-select with-icon export'));
        ?>
    </form>
</div>

<div id="dialog-export" title="Export to Email" class="hide">
    <p class="validateTips">
<?php echo __('Please provide email addresses you would like to send this report to‭ (‬use commas to send to multiple‭) .'); ?>
    </p>
    <form>
        <fieldset>
            <label for="from">From Email Address</label>
            <input type="text" name="from" id="from" value="" class="text ui-widget-content ui-corner-all" />
            
            <label for="reply">Send to</label>
            <input type="text" name="reply" id="reply" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>