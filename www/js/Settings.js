/**
 * @todo This requires Class() function defined earlier. Make sure Class() is
 *      defined in common location and before this file is executed.
 */

jQuery(function(){
    var Settings = Class.extend({

        'options': {
            'alertsSettingsSelector': '#alertsSettings',
            'billingSettingsSelector': '#billingSettings',
            'competitorsSettingsSelector': '#competitorsSettings',
            'generalLocationSettingsSelector': '#generalLocationSettings',
            'reportsSettingsSelector': '#reportsSettings',
            'socialMediaSettingsSelector': '#socialMediaSettings',
            'userManagementSelector': '#userManagementSettings'
        },

        'init': function(){
            log('Settings object initialized!');
            this.initialize();
        },

        'initialize': function(){

            // assign containers
            this.alertsSettings = jQuery(this.options.alertsSettingsSelector);
            this.billingSettings = jQuery(this.options.billingSettingsSelector);
            this.competitorsSettings = jQuery(this.options.competitorsSettingsSelector);
            this.generalLocationSettings = jQuery(this.options.generalLocationSettingsSelector);
            this.reportsSettings = jQuery(this.options.reportsSettingsSelector);
            this.socialMediaSettings = jQuery(this.options.socialMediaSettingsSelector);
            this.userManagementSettings = jQuery(this.options.userManagementSelector);

            // execute proper functions, if appropriate containers found
            if (!!this.alertsSettings.length){
                this.initializeAlertsSettings();
            }
            if (!!this.billingSettings.length){
                this.initializeBillingSettings();
            }
            if (!!this.competitorsSettings.length){
                this.initializeCompetitorsSettings();
            }
            if (!!this.generalLocationSettings.length){
                this.initializeGeneralLocationSettings();
            }
            if (!!this.reportsSettings.length){
                this.initializeReportsSettings();
            }
            if (!!this.socialMediaSettings.length){
                this.initializeSocialMediaSettings();
            }
            if (!!this.userManagementSettings.length){
                this.initializeUserManagement();
            }

        },

        'initializeAlertsSettings': function(){
            log('Alerts settings initialized');
        },

        'initializeBillingSettings': function(){
            log('Billing settings initialized');
        },

        'initializeCompetitorsSettings': function(){
            this.competitorsSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                alert('Not yet ready');
            });

            this.competitorsSettings.delegate('a[data-action="delete"]', 'click', function(event){
                event.preventDefault();
                if (confirm('Are you sure?')){
                    jQuery(this).parents('tr').remove(); // @todo do this only when deletion confirmed by server
                    log('Competitor would be deleted here');
                }
            });

            log('Competitors settings initialized');
        },

        'initializeGeneralLocationSettings': function(){
            var self = this;

            this.refreshGeneralLocationSettings();

            // attach events
            this.generalLocationSettings.delegate('form','submit',function(event){
                event.preventDefault();
                var form = jQuery(this);
                jQuery.post('/api/settings/updategeneral', form.serialize(), function(data){
                    if (data.result){
                        log('Data retrieved');
                        self.clearValidationErrors();
                        self.refreshGeneralLocationSettings();
                    }else{
                        if (typeof data.error.validation_errors != 'undefined'){
                            self.displayValidationErrors(data.error.validation_errors, this.generalLocationSettings);
                        }
                    }
                }, 'json');
            });

            log('General settings initialized');
        },

        'initializeReportsSettings': function(){
            var self = this;
            
            this.reportsSettings.delegate('form', 'submit', function(event){
                event.preventDefault();

                // @todo Replace it with some shorthand method for requests
                jQuery.post('/api/settings/addemail', {
                    'email': jQuery(this).find('input[name="email"]').val()
                }, function(data){
                    log('Retrieved data:');
                    log(data);
                    self.refreshReportsSettingsEmails();
                    if (data.error && typeof data.error.validation_errors != 'undefined'){
                        // display error information
                        self.displayValidationErrors(data.error.validation_errors, self.reportsSettings);
                    }else{
                        self.clearValidationErrors();
                    }
                }, 'json');
            });

            this.reportsSettings.delegate('a[data-action="delete"]', 'click', function(event){
                event.preventDefault();
                if (confirm('Are you sure?')){
                    jQuery(this).parents('tr').remove(); // @todo do this only when deletion confirmed by server
                    log('Email would be deleted here');
                }
            });

            log('Reports settings initialized');
        },

        'initializeSocialMediaSettings': function(){
            this.socialMediaSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                alert('Not yet ready');
            });

            log('Social media settings initialized');
        },

        'initializeUserManagement': function(){
            this.userManagementSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                alert('Not yet ready');
            });

            this.userManagementSettings.delegate('form input[type="text"]', 'keydown', function(event){
                if (event.keyCode == 13){
                    jQuery(this).parents('form').submit(); // submit form
                }
            });

            log('User management initialized');
        },



        // display validation information from the data given, into the validation messages' containers
        'clearValidationErrors': function(form){
            if (typeof form == 'undefined'){
                form = jQuery('form');
            }
            form.find('.validation-message[data-validation-for]').each(function(index, element){
                jQuery(this).html('');
                log('Element to be emptied: ');
                log(element);
            });
            log('Validation errors cleared');
        },
        
        // display validation information from the data given, into the validation messages' containers
        'displayValidationErrors': function(errors, form){
            if (typeof form == 'undefined'){
                form = jQuery('form');
            }
            var field;
            for (field_name in errors){
                log('Showing "' + field_name + '" validation feedback: ' + errors[field_name]);
                field = form.find('.validation-message[data-validation-for="' + field_name + '"]');
                field.html(errors[field_name]);
                log(field);
            }
            log('Validation errors displayed.');
        },

        // enter the given data into form fields
        'propagateFormData': function(data, form){
            if (typeof form == 'undefined'){
                form = jQuery('form');
            }
            var field;
            for (field_name in data){
                log('Propagating ' + field_name + ' field with data: ' + data[field_name]);
                field = form.find('input[name="' + field_name + '"]').val(data[field_name]);
                log(field);
            }
        },

        // propagate General Location Settings form with up-to-date data
        'refreshGeneralLocationSettings': function(){
            var self = this;
            
            // propagate data when the page is displayed
            jQuery.post('/api/settings/getgeneral', {}, function(data){
                if (data.result){
                    log('General location data retrieved');
                    var form = self.generalLocationSettings.find('form');
                    self.propagateFormData(data.result, form);
                }else{
                    log('Error fetching initial data for general location settings');
                }
            }, 'json');
        },

        // refresh list of emails on the reports settings page
        'refreshReportsSettingsEmails': function(){
            var self = this;
            
            jQuery.post('/api/settings/getemails', {}, function(data){
                if (data.result){
                    // result received
                    self.reportsSettings.find('.reportsSettingsEmails').replaceWith(data.result.emails_html);
                }else{
                    log('Problem encountered when trying to get list of emails from the server');
                }
            }, 'json');
        }

    });

    Settings = new Settings();
    Settings.init();
});