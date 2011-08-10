jQuery(function(){

    var TopMenu = Class.extend({
        
        picker: null,
        minDate: null,
        maxDate: null,
        periodSelector: null,
        dateSelector: null,
        selectValue: null,
        period: null,
        form: null,
        
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
                
                var parsed;
                
                
                // we parse maxDate that can be 1m 3m 6m 1y custom in format 1/1/2004
                if(parsed = Date.parse(self.selectValue)) {
                
                    self.maxDate = new Date(parsed);
                    self.picker.DatePickerSetDate([self.minDate, self.maxDate], true);
                    self.form.trigger('submit');
                    return;
                }
                else {                
                    switch(self.selectValue) {
                    
                        case 'ytd':
                            self.minDate.setMonth(0, 1);
                            self.minDate.setFullYear(self.maxDate.getFullYear());
                            break;
                        case 'all':
                            self.minDate = new Date(0);
                            break;
                        default:
                            self.minDate.setMonth(self.maxDate.getMonth() - self.period);
                            self.minDate.setFullYear(self.maxDate.getFullYear());
                            break;
                    
                    }
   
                        
                    var d = self.minDate.getMonth()+1 + '/' + self.minDate.getDate() + '/' + self.minDate.getFullYear();
                    
                    self.dateSelector.val(d);

                    var formated = [];
            
                    formated[0] = self.minDate.getDate() + " " + self.minDate.getMonthName(true) + ", " + self.minDate.getFullYear();
                    formated[1] = self.maxDate.getDate() + " " + self.maxDate.getMonthName(true) + ", " + self.maxDate.getFullYear();

                    $('#widgetField span').get(0).innerHTML = formated.join(' &divide; ');
                    
                    
                    self.picker.DatePickerSetDate([self.minDate, self.maxDate], false);
                }
                
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
        
        initExport: function() {
          
            var email = $( "#from" ),
            reply = $( "#reply" ),
            allFields = $( [] ).add( email, reply );
            
            var self = this;
          
            $( "#dialog-export" ).dialog({
                autoOpen: false,
                height: 300,
                width: 350,
                modal: true,
                buttons: {
                    "Export": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                
                        bValid = bValid && helpers.checkLength(reply, "Reply Email", 6, 80);
                        bValid = bValid && helpers.checkLength(email, "From Email", 6, 80);
                        var emails = reply.val().split(',');
                
                        bValid = bValid && 
                            helpers.checkRegexp(email,email.val(), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );

                        for(var e in emails) {
                            bValid = bValid && 
                            helpers.checkRegexp(reply,emails[e], /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
                        }
                
                        var d = $(this);
                        if (bValid) {
                            email.attr('disabled', 'disabled');
                            reply.attr('disabled', 'disabled');
                            boxManager.exportBoxes({ 
                                emails: {from: email.val(), to: emails},
                                callback: function() {
                                    email.removeAttr('disabled');
                                    reply.removeAttr('disabled');
                                    helpers.tips.html('<strong>Email was sended correctly. This message will close in 2 seconds.</strong>');
                                
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
            
            this.minDate = this.dateSelector.val();
            this.form = $("#range-form");
            
            this.dateRange = $("#date-range");
            
            var parsed;
            

            if(parsed = Date.parse(this.minDate)) {
                
                this.minDate = new Date(parsed);
                
            } 
            
            // we parse maxDate that can be 1m 3m 6m 1y custom in format 1/1/2004
            if(parsed = Date.parse(this.selectValue)) {
                
                this.maxDate = new Date(parsed);
                
            }
            else {

                switch(this.selectValue) {
                    
                    case 'ytd':
                        
                        this.minDate.setMonth(0, 1);
                        this.minDate.setFullYear(this.maxDate.getFullYear());
                        this.maxDate = new Date();
                        this.maxDate.setDate(this.maxDate.getDate() -1);
                        break;
                    case 'all':
                        this.minDate = new Date(0);
                        this.maxDate = new Date();
                        this.maxDate.setDate(this.maxDate.getDate() -1);
                        break;
                    default:
                        this.maxDate = new Date(this.minDate);
                        this.maxDate.setMonth(this.maxDate.getMonth() + this.period);
                        break;
                    
                }

            }
            
            Date.prototype.getMonthName = function(fullName) {
                var months= ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		return months[this.getMonth()];
            };
            
            formated = [];
            
            formated[0] = this.minDate.getDate() + " " + this.minDate.getMonthName(true) + ", " + this.minDate.getFullYear();
            formated[1] = this.maxDate.getDate() + " " + this.maxDate.getMonthName(true) + ", " + this.maxDate.getFullYear();
            
            $('#widgetField span').get(0).innerHTML = formated.join(' &divide; ');
            
        },
   
   
        initRangeSelect: function() {

            var self = this;
            
            this.picker = $('#widgetCalendar').DatePicker({
                flat: true,
                format: 'd B, Y',
                date: [this.minDate, this.maxDate],
                calendars: 2,
                mode: 'range',
                starts: 1,
                onChange: function(formated, date) {
                   
                    if(date[1].getDate() != date[0].getDate()) {
                     
                        self.minDate = date[0];
                        self.maxDate = date[1];
                        
                        
                        var d = date[0].getMonth()+1 + '/' + date[0].getDate() + '/' + date[0].getFullYear();
                        var d2 = date[1].getMonth()+1 + '/' + date[1].getDate() + '/' + date[1].getFullYear();
                    
                        self.dateSelector.val(d);
                                        
                        if(!self.periodSelector.has("option:contains('custom')").length) {
                        
                            self.periodSelector.append($(document.createElement("option")).
                                attr("value", d2).text("custom"))
                    
                            self.periodSelector.parents('.jquery-selectbox').unselectbox();
                        
                            self.periodSelector.find("option:contains('custom')").prop("selected", "selected");
                            self.periodSelector.selectbox();
                        
                        }
                        else {
                        
                            self.periodSelector.find("option:contains('custom')").attr('value',d2);
                        
                        }
                    
                        $('#widgetField span').get(0).innerHTML = formated.join(' &divide; ');
                    
                    
                        TopMenu.form.trigger('submit');
                     
                    }
                },
                onRender: function(date) {
                    
                    var now = new Date();
                    now.setDate(now.getDate() - 1);
                    
                    var disable = date > now;
                    
                    return {
                        
                        disabled: disable
                        
                    };
                }
            });
            $('#widgetField>a').bind('click', function(){
                
                $('#widgetCalendar')
                .stop()
                .animate({height: $(this).hasClass('toggled') ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500);
                
                $(this).toggleClass('toggled');
                return false;
            });
            
        },
   
        init: function() {
       
       
          if($("#period-selector").length) {  
            this.initialize();
            this.initRange();
            this.initRangeSelect();
            this.initExport();
            this.attachEvents();
          }
       
        }
   
    });

    TopMenu = new TopMenu();
    TopMenu.init();
    boxManager.init(); // we need to init all boxes only when we init top menu

});