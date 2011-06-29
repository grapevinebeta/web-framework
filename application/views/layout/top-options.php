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
            echo html::anchor('#email', 'Export', array('class' => 'as-select with-icon export')); ?>
    </form>
</div>

<script type="text/javascript">

    $.extend(Highcharts.Chart.prototype, {
        addChart: function(formParams) {
            var form,
            chart = this,
            svg = chart.getSVG();
            
            var options = chart.options.exporting;
            
            options.width = 380;
            options.type = 'image/png';
            
            if(formParams.charts.length == 0) {
                
                formParams.options = options;
                
                formParams.submit = function() {
                    
                    var form = Highcharts.createElement('form', {
                        method: 'post',
                        action: "/api/static/highchart"
                    }, {
                        display: 'NONE'
                    }, document.body);
                    
                    var self = this;
                    
                    $.each(["filename", "type", "width", "url", "extra"], function(index, name) {
                        
                        Highcharts.createElement('input', {
                            type: 'HIDDEN',
                            name: name,
                            value: { 
                                filename: self.options.filename || 'chart', 
                                type: self.options.type, 
                                width: self.options.width, 
                                url: self.options.url,
                                extra: self.extra
                            }
                            [name]
                        }, null, form);
                    });
                    
                    
                    $.each(this.charts, function(svg) {
                        
                        Highcharts.createElement('input', {
                            type: 'HIDDEN',
                            name: 'svg[]',
                            value: self.charts[svg]
                        }, null, form);
                        
                    });
                    
                    
                    
                    form.submit();
                    
                    form = null;
                    
                    
                }
                
                
            }
            
            formParams.charts.push(svg);
        }
    });

    var startDate, endDate;
    var periodSelector = $("#period-selector");
    var dateSelector = $("#date-selector");
    var selectValue = periodSelector.val();
    
    var period = determineMonthDiff(selectValue);
    var minDate;
    var maxDate = dateSelector.val();
    var form = $("#range-form");
    var dateRange = $("#date-range");
    var datapicker;
    
        
    // default date = yesterday
    maxDate = maxDate.length ? new Date(maxDate) : '-1d';
    
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
            
            datapicker.datepicker("option", {
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

    $(document).ready(function() {


        dateRange.val(startDate + " - " + endDate);
        datapicker = dateSelector.datepicker(config);
        
        $('.export').bind('click', function() {
            
            var template = $('<div class="block"><div class="inner"></div></div>');
            
            var code = $('<div id="page"></div>');
            
            $('.box-container').not('.ignore').find('.box').each(function() {
                
                var t = template.clone();
                
                var title = $("<h2/>").text($(this).find('.box-header-title').text());
                var table = $(this).find('.data-grid-holder table');
                
                
                title.clone().appendTo(t.find('.inner'));
                table.clone().appendTo(t.find('.inner'));
                
                code.append(t);
                
            });
            
            var formParams = {
              
              extra: code.html(),
              charts: [],
              submit: null // callback function
              
            };
            
            for(var id in boxManager.collection)
            {

                if(id.indexOf('inbox')) {
                    
                    var box = boxManager.collection[id];
                    if(box.hasOwnProperty('graph')) {
                        box.graph.addChart(formParams);   
                    }
                    
                }

            }
            
            formParams.submit();
            
            
            
        });
        
        periodSelector.selectbox().bind('change', function() {
         
           selectValue = $(this).val();
           period = determineMonthDiff(selectValue);
           
           var min = datapicker.datepicker('getDate');
           var max = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           min.setMonth(min.getMonth() - period);
           min = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           
           datapicker.datepicker('option', 'minDate', min);
           
           dateRange.val(min + " - " + max);

           form.trigger('submit');
            
        });
        
    });
    
</script>