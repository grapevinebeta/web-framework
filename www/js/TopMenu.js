jQuery(function(){

    var TopMenu = Class.extend({
   
        startDate: null,
        endDate: null,
        minDate: null,
        datapicker: null,
        periodSelector: null,
        dateSelector: null,
        selectValue: null,
        period: null,
        maxDate: null,
        form: null,
        dateRange: null,
        dataPickerConfig: {
            showOn: "button",
            buttonImage: "images/as-select-bg.jpg",
            buttonImageOnly: true,
            numberOfMonths: 2,
            maxDate: '-1d',
            minDate: this.minDate,
            onSelect: function(dateText, inst) {
            
                TopMenu.maxDate = new Date(dateText);
            
                TopMenu.minDate.setDate(TopMenu.maxDate.getDate());
                TopMenu.minDate.setMonth(TopMenu.maxDate.getMonth() - TopMenu.period);
            
                TopMenu.datapicker.datepicker("option", {
                    maxDate: TopMenu.maxDate,
                    minDate: TopMenu.minDate
                });
            
                TopMenu.startDate = (TopMenu.minDate.getMonth() + 1 ) 
                + "/" + TopMenu.minDate.getDate() 
                + "/" + TopMenu.minDate.getFullYear();
                TopMenu.endDate = (TopMenu.maxDate.getMonth() + 1 ) 
                + "/" + TopMenu.maxDate.getDate() 
                + "/" + TopMenu.maxDate.getFullYear();
            
                TopMenu.dateRange.val(TopMenu.startDate + " - " + TopMenu.endDate);
            
                TopMenu.form.trigger('submit');
            
            }
        
        },
        
        attachEvents: function() {
          
            $('.export').bind('click', function() {
            
                boxManager.exportBoxes();
            
            });
        
            var self = this;
        
            this.periodSelector.selectbox().bind('change', function() {
         
                self.selectValue = $(this).val();
                self.period = determineMonthDiff(self.selectValue);
           
                var min = self.datapicker.datepicker('getDate');
                self.endDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
                min.setMonth(min.getMonth() - self.period);
                self.startDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
           
                self.datapicker.datepicker('option', 'minDate', min);
           
                self.dateRange.val(self.startDate + " - " + self.endDate);

                self.form.trigger('submit');
            
            });
        
            this.form.submit(function (e) {
            
                e.preventDefault();
                var range = {};
                var rangeArray = $(this).serializeArray();
                for (var i = 0; i < rangeArray.length; i++) {
                    range[rangeArray[i].name] = rangeArray[i].value;
                }
                boxManager.setRange(range);
                boxManager.clearData();
                boxManager.refresh();

            });
          
        },
        
        initRange: function() {
          
            var rangeArray = this.form.serializeArray();
            var range = {};
        
            for (var i = 0; i < rangeArray.length; i++) {
                range[rangeArray[i].name] = rangeArray[i].value;
            }
            
            boxManager.setRange(range);
          
        },
        
        initialize: function() {
          
            this.periodSelector = $("#period-selector");
            this.dateSelector = $("#date-selector");
            this.selectValue = this.periodSelector.val();
            this.period = determineMonthDiff(this.selectValue);
            this.maxDate = this.dateSelector.val();
            this.form = $("#range-form");
            this.dateRange = $("#date-range");
       
       
            this.maxDate = this.maxDate.length ? new Date(this.maxDate) : '-1d';
            if(this.maxDate instanceof Date) {
                this.minDate = new Date(this.maxDate);
                this.minDate.setMonth(this.minDate.getMonth() - this.period);
        
                this.startDate = (this.minDate.getMonth() + 1) + "/" + this.minDate.getDate() + "/" + this.minDate.getFullYear();
                this.endDate = (this.maxDate.getMonth() + 1) + "/" + this.maxDate.getDate() + "/" + this.maxDate.getFullYear();
        
            }
            else {
                var m = new Date();
                m.setMonth(m.getMonth() - this.period);
        
                var mx = new Date();
                mx.setDate(m.getDay() -1);
        
                this.startDate = (m.getMonth() + 1) + "/" + m.getDate() + "/" + m.getFullYear();
                this.endDate = (mx.getMonth() + 1) + "/" + mx.getDate() + "/" + mx.getFullYear();
        
                this.minDate = (-this.period) + "m";
        
            }
        
            this.dateRange.val(this.startDate + " - " + this.endDate);
            this.datapicker = this.dateSelector.datepicker(this.dataPickerConfig);
            
        },
   
        init: function() {
       
       
          if($("#period-selector").length) {  
            this.initialize();
            this.initRange();
            this.attachEvents();
          }
       
        }
   
    });

    TopMenu = new TopMenu();
    TopMenu.init();
    boxManager.init(); // we need to init all boxes only when we init top menu

});