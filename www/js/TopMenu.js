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
            buttonImage: "/images/as-select-bg.jpg",
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
        
        openEmailExport: function() {
            
            $( "#dialog-export" ).dialog("open");
            
            
        },

        openSupport: function() {
            
            $("#dialog-support").dialog();
            
            
        },
        
        attachEvents: function() {
            
            var self = this;
          
            $('.export').bind('click', function() {
            
                boxManager.exportBoxes();
            
            });
            
            
            $('.email').bind('click', function(e) {
                e.preventDefault();
                self.openEmailExport();
            
            });
            
            $('#support').bind('click', function(e) {
                e.preventDefault();
                
                self.openSupport();
            
            });
        
        
            this.periodSelector.selectbox().bind('change', function() {
         
                self.selectValue = $(this).val();
                self.period = determineMonthDiff(self.selectValue);
           
                var min = self.datapicker.datepicker('getDate');
           
                if(self.period !== false) {
           
                    self.endDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
                    min.setMonth(min.getMonth() - self.period);
                    self.startDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
                    
                }
                else {
                    
                    switch(self.selectValue) {
                        
                        case 'ytd':
                            
                            self.endDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
                            min.setMonth(0, 1);
                            self.startDate = min.getMonth() + 1 + "/" + min.getDate() + "/" + min.getFullYear();
                            
                            break;
                        case 'all':
                            break;
                        
                    }
                    
                }
           
           
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
        
        helpers: {
            
            tips: $( ".validateTips" ),
            
            updateTips: function(t) {
                this.tips
                .text( t )
                .addClass( "ui-state-highlight" );
                setTimeout(function() {
                    tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
            },
    
            checkLength: function( o, n, min, max ) {
                if ( o.val().length > max || o.val().length < min ) {
                    o.addClass( "ui-state-error" );
                    this.updateTips( "Length of " + n + " must be between " +
                        min + " and " + max + "." );
                    return false;
                } else {
                    return true;
                }
            },
    
            checkRegexp: function(o, value, regexp, n ) {
                if ( !( regexp.test( value ) ) ) {
                    o.addClass( "ui-state-error" );
                    this.updateTips( n );
                    return false;
                } else {
                    return true;
                }
            }
            
        },
        
        initExport: function() {
          
            var email = $( "#email" ),
            allFields = $( [] ).add( email );
            
            var self = this;
          
            $( "#dialog-export" ).dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                modal: true,
                buttons: {
                    "Export": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                
                        bValid = bValid && self.helpers.checkLength(email, "email", 6, 80);
                        var emails = email.val().split(',');
                
                        for(var e in emails) {
                            bValid = bValid && 
                            self.helpers.checkRegexp(email,emails[e], /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
                        }
                
                        var d = $(this);
                        if (bValid) {
                            email.attr('disabled', 'disabled');
                            boxManager.exportBoxes({ 
                                emails: emails, 
                                callback: function() {
                                    email.removeAttr('disabled');
                                    self.helpers.tips.html('<strong>Email was sended correctly. This message will close in 2 seconds.</strong>');
                                
                                    setTimeout(function() {
                                        d.dialog("close");
                                    }, 3000);
                                
                                }
                            });
                        
                        }
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    allFields.val("").removeClass("ui-state-error");
                }
            });
          
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
                
                if(this.period !== false) {
                    
                    this.minDate.setMonth(this.minDate.getMonth() - this.period);
                    
                }
                else {
                    
                    switch(this.selectValue) {
                        
                        case 'ytd':
                            this.minDate.setMonth(0, 1);
                            console.log(this.minDate);
                            break;
                        case 'all':
                            break;
                        
                    }
                    
                }
        
                this.startDate = (this.minDate.getMonth() + 1) + "/" + this.minDate.getDate() + "/" + this.minDate.getFullYear();
                this.endDate = (this.maxDate.getMonth() + 1) + "/" + this.maxDate.getDate() + "/" + this.maxDate.getFullYear();
        
            }
            else {
                
                if(this.period !== false) {
                    
                    var m = new Date();
                    m.setMonth(m.getMonth() - this.period);
                    this.minDate = (-this.period) + "m";
                }
                else {
                    
                    switch(this.selectValue) {
                        
                        case 'ytd':
                            var m = new Date();
                            m.setMonth(0,1);
                            this.minDate = "ytd";
                            break;
                        case 'all':
                            break;
                        
                    }
                    
                }
        
                var mx = new Date();
                mx.setDate(m.getDay() -1);
        
                this.startDate = (m.getMonth() + 1) + "/" + m.getDate() + "/" + m.getFullYear();
                this.endDate = (mx.getMonth() + 1) + "/" + mx.getDate() + "/" + mx.getFullYear();
        
            }
        
            this.dateRange.val(this.startDate + " - " + this.endDate);
            this.datapicker = this.dateSelector.datepicker(this.dataPickerConfig);
            
        },
   
        init: function() {
       
       
          if($("#period-selector").length) {  
            this.initialize();
            this.initRange();
            this.initExport();
            this.attachEvents();
          }
       
        }
   
    });

    TopMenu = new TopMenu();
    TopMenu.init();
    boxManager.init(); // we need to init all boxes only when we init top menu

});