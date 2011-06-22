<div id="top-options-holder">
    <form id="range-form" action="<?php echo url::site(); ?>" method="post">
        <span><?php echo __('Viewing'); ?>:</span>

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
                'style' => 'display:none;'));
            
            echo form::input(
            'date_range', 
            null, 
            array(
                'id' => 'date-range', 
                'class' => 'as-select with-icon',
                'maxlength' => '10',
                'disabled' => 'disabled',
                'style' => 'width: 120px; background: #fff;'));
            
            ?>
        
        <?php 
            echo html::image('images/icons/email.png', array('alt' => '')); 
            echo html::anchor('#email', 'Email', array('class' => 'as-select with-icon')); ?>
        <?php 
            echo html::image('images/icons/export.png', array('alt' => '')); 
            echo html::anchor('#email', 'Export', array('class' => 'as-select with-icon')); ?>
    </form>
</div>

<script type="text/javascript">
    
    function determineMonthDiff(period)
    {
        
        switch(period) {
            
            case '1m':
                return 1;
            case '3m':
                return 3;
            case '6m':
                return 6;
            case '1y':
                return 12;
            
        }
        
    }
    
    var startDate, endDate;
    var periodSelector = $("#period-selector");
    var dateSelector = $("#date-selector");
    var selectValue = periodSelector.val();
    var period = determineMonthDiff(selectValue);
    var maxDate = dateSelector.val();
    var form = $("#range-form");
    var dateRange = $("#date-range");
    
    
    // default date = yesterday
    maxDate = maxDate.length ? new Date(maxDate) : '-1d';
    var minDate;
    
    if(maxDate instanceof Date) {
        minDate = new Date(maxDate);
        minDate.setMonth(minDate.getMonth() - period);
        
        startDate = (minDate.getMonth() + 1) + "/" + minDate.getDate() + "/" + minDate.getFullYear();
        endDate = (maxDate.getMonth() + 1) + "/" + maxDate.getDate() + "/" + maxDate.getFullYear();
        
    }
    else {
        
        m = new Date();
        m.setMonth(m.getMonth() - period);
        
        mx = new Date();
        mx.setDate(m.getDay() -1);
        
        startDate = (m.getMonth() + 1) + "/" + m.getDate() + "/" + m.getFullYear();
        endDate = (mx.getMonth() + 1) + "/" + mx.getDate() + "/" + mx.getFullYear();
        
        minDate = - period + "m";
        
    }


    $(document).ready(function() {

        dateRange.val(startDate + " - " + endDate);
        
        var config = {
            showOn: "button",
            buttonImage: "images/as-select-bg.jpg",
            buttonImageOnly: true,
            numberOfMonths: 2,
            maxDate: '-1d',
            minDate: minDate,
            onSelect: function(dateText, inst) {
                
                maxDate = new Date(dateText);
                
                minDate.setMonth(maxDate.getMonth() - period);
                
                d.datepicker("option", {
                    maxDate: maxDate,
                    minDate: minDate
                });
                
                var minString = (minDate.getMonth() + 1 ) 
                    + "/" + minDate.getDate() 
                    + "/" + minDate.getFullYear();
                var maxString = (maxDate.getMonth() + 1 ) 
                    + "/" + maxDate.getDate() 
                    + "/" + maxDate.getFullYear();
                
                dateRange.val(minString + " - " + maxString);
                
                form.trigger('submit');
                
            }
            
        };
        
        var d = dateSelector.datepicker(config);

        periodSelector.selectbox().bind('change', function() {
         
           selectValue = $(this).val();
           period = determineMonthDiff(selectValue);
           
           var min = d.datepicker('getDate');
           
           var max = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           
           min.setMonth(min.getMonth() - period);
           
           d.datepicker('option', 'minDate', min);
           
           min = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           dateRange.val(min + " - " + max);
           
           
           form.trigger('submit');
            
        });
        
    });
    
</script>