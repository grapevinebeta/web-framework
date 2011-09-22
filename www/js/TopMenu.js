/**
 * 
 *  this is class for handling all logic of top menu including selecting range
 *  dates, exporting to email and to file. Because it use Class.extend it has
 *  dependency with Boxes.js and boxManager and so that we initial ize  boxManager
 *  in this class
 * 
 */

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
          
            $('a.export').bind('click', function(e) {
            
                e.preventDefault();
                boxManager.exportBoxes();
            
            });
            
            $('a.email').bind('click', function(e) {
                e.preventDefault();
                self.openEmailExport();
            
            });
            
            $('#support').bind('click', function(e) {
                e.preventDefault();
                
                self.openSupport();
            
            });
        
        
            $('#period-selector').selectbox().bind('change', this.wrapper(this.periodHandler, 
            {
                context: self
            }));
        
            /**
             * we need to update ranges of every box after we change any settings in top menu
             */
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
        
        // we set initial ranges
        initRange: function() {
          
            var rangeArray = this.form.serializeArray();
            var range = {};
        
            for (var i = 0; i < rangeArray.length; i++) {
                range[rangeArray[i].name] = rangeArray[i].value;
            }
            
            boxManager.setRange(range);
          
        },
        
        
        /**
         * we need to create modal box to enable exporting dashboard using email
         */
        initExport: function() {
          
            var email = $( "#from" ),
            reply = $( "#reply" ),
            allFields = $( [] ).add( email, reply );
          
            $( "#dialog-export" ).dialog({
                autoOpen: false,
                height: 300,
                width: 350,
                modal: true,
                buttons: {
                    "Send": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                
                        bValid = bValid && helpers.checkLength(reply, "Send to Email", 6, 80);
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
                            helpers.tips.html('Email is sending to recipients, please wait...');
                            email.attr('disabled', 'disabled');
                            reply.attr('disabled', 'disabled');
                            boxManager.exportBoxes({ 
                                emails: {from: email.val(), to: emails},
                                callback: function() {
                                    email.removeAttr('disabled');
                                    reply.removeAttr('disabled');
                                    helpers.tips.html('<strong>Email was sent correctly. This message will close in 2 seconds.</strong>');
                                
                                    setTimeout(function() {
                                        allFields.attr('value', '')
                                        helpers.tips.html('Please provide email addresses you would like to send this report to‭ (‬use commas to send to multiple‭).');
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
                        this.maxDate = new Date();
                        this.maxDate.setDate(this.maxDate.getDate() -1);
                        
                        this.minDate.setMonth(0, 1);
                        this.minDate.setFullYear(this.maxDate.getFullYear());
                        break;
                    case 'all':
                        this.minDate = new Date(1971,1,1);
                        this.maxDate = new Date();
                        this.maxDate.setDate(this.maxDate.getDate() -1);
                        break;
                    default:
                        this.maxDate = new Date(this.minDate);
                        this.maxDate.setMonth(this.maxDate.getMonth() + this.period);
                        break;
                    
                }

            }
            
            formated = [];
            
            formated[0] = helpers.getMonthName(this.minDate, true) + " " + this.minDate.getDate() + ", " + this.minDate.getFullYear();
            formated[1] = helpers.getMonthName(this.maxDate, true) + " " + this.maxDate.getDate() + ", " + this.maxDate.getFullYear();
            
            $('#widgetField span').get(0).innerHTML = formated.join(' - ');
            
        },
   
        periodHandler: function(e, data) {

            var self = data.context;            
            
            self.selectValue = $(e.target).val();
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
                        self.minDate = new Date(1971,1,1);
                        break;
                    default:
                        self.minDate = new Date();
                        self.minDate.setMonth(self.minDate.getMonth() - self.period, self.minDate.getDate() - 1);
                        self.maxDate = new Date();
                        self.maxDate.setDate(self.maxDate.getDate() - 1);
                        break;
                    
                }
                        
                var d = self.minDate.getMonth()+1 + '/' + self.minDate.getDate() + '/' + self.minDate.getFullYear();
                    
                self.dateSelector.val(d);

                var formated = [];
            
                formated[0] = helpers.getMonthName(self.minDate, true) + " " + self.minDate.getDate() + ", " + self.minDate.getFullYear();
                formated[1] = helpers.getMonthName(self.maxDate, true) + " " + self.maxDate.getDate() + ", " + self.maxDate.getFullYear();
            
                $('#widgetField span').get(0).innerHTML = formated.join(' - ');

                    
                    
                self.picker.DatePickerSetDate([self.minDate, self.maxDate], false);
            }
            
            self.form.trigger('submit');
            
        },
        
        wrapper: function(callback, data) {
            
            return function(e) {
                
                callback(e, data);
                
            }
            
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
                   
                    // we need to check if date range is at least 1 day
                   
                    var diff = Math.floor((date[1].getTime() - date[0].getTime()) / (1000 * 3600 * 24));
                   
                    if(diff) {
                     
                        self.minDate = date[0];
                        self.maxDate = date[1];
                        
                        
                        var d = helpers.standardDate(date[0]);
                        var d2 = helpers.standardDate(date[1]);
                    
                        self.dateSelector.val(d);

                        // if we use custom range we add extra option custom to range selector
                        if(!self.periodSelector.has("option:contains('custom')").length) {
                        
                            self.periodSelector.append($(document.createElement("option")).
                                attr("value", d2).text("custom"))
                        
                        }
                        
                        
                        // we need to recreate the select box
                        self.periodSelector.parents('.jquery-selectbox').unselectbox();
                        
                        self.periodSelector.find("option:contains('custom')")
                        .prop("selected", "selected");
                        self.periodSelector.selectbox().bind('change', self.wrapper(self.periodHandler, 
                        {
                            context: self
                        }));
                    
                        formated[0] = helpers.getMonthName(self.minDate, true) + " " + self.minDate.getDate() + ", " + self.minDate.getFullYear();
                        formated[1] = helpers.getMonthName(self.maxDate, true) + " " + self.maxDate.getDate() + ", " + self.maxDate.getFullYear();
            
                        $('#widgetField span').get(0).innerHTML = formated.join(' - ');
                    
                        self.form.trigger('submit');
                        
                        // we can now slide up data picker
                        $('#widgetCalendar')
                        .stop()
                        .animate({
                            height:  $('#widgetField>a').hasClass('toggled') ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight
                            }, 500);
                
                         $('#widgetField>a').toggleClass('toggled');
                     
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
    boxManager.init();

});