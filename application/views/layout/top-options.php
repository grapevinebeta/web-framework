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
                'style' => 'width: 120px;'));
            
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
    
    var selectValue = '<?php echo $viewingRange['period'] ?>';
    var period = determineMonthDiff(selectValue);
    var maxDate = $("#date-selector").val();
    maxDate = maxDate.length ? maxDate : '-1d';
    
    $(document).ready(function() {
        
        var d = new Date();
        
        d.setDate(d.getDate() - 1);
        
        d = d.getMonth() + 1 + "/" + d.getDate() + "/" + d.getFullYear();
        
        var m = new Date();
        m.setMonth(m.getMonth() - period);
        
        m = m.getMonth() + 1 + "/" + m.getDate() + "/" + m.getFullYear();

        $("#date-range").val(m + " - " + d)
        
        var d = $('#top-options-holder #date-selector').datepicker({
            showOn: "button",
            buttonImage: "images/as-select-bg.jpg",
            buttonImageOnly: true,
            numberOfMonths: 2,
            defaultDate: "-1d",
            maxDate: maxDate,
            minDate: -period + 'm',
            onSelect: function(dateText, inst) {
                
                var max = new Date(dateText);
                var current = new Date();
                
                if(max > current)
                {

                    max.setDate(max.getDate() -1);

                }
                
                var min = new Date(max);
                
                min.setMonth(min.getMonth() - period);
                
                d.datepicker("option", {
                    maxDate: max,
                    minDate: min
                });
                
                min = min.getMonth()+1 + "/" + min.getDate() + "/" + min.getFullYear();
                max = min.getMonth()+1 + "/" + max.getDate() + "/" + max.getFullYear();
                
                $("#date-range").val(min + " - " + max);
                
            }
            
        });
        
        
        
        $('#period-selector').selectbox().bind('change', function() {

           
           selectValue = $(this).val();
           period = determineMonthDiff(selectValue);
           
           var min = d.datepicker('getDate');
           
           var max = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           
           min.setMonth(min.getMonth() - period);
           
           d.datepicker('option', 'minDate', min);
           
           min = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           $("#date-range").val(min + " - " + max);
           
            
        });
        
    });
    
    
</script>