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
            var self = this;
            var form = this.alertsSettings.find('form.alertsSettingsForm');
            
            jQuery.post('/api/settings/getalert', {}, function(data){
                if(data.result && typeof data.result.alert != 'undefined'){
                    self.propagateFormData(data.result.alert, form);
                }
            });
            
            /**
             * The following part of the code should make request when the form
             * content has been changed.
             * @todo Make it work in a way that will send the request is being
             *      sent only after some period of inactivity
             */
            form.delegate('form input, form textarea', 'change', function(event){
                log('Someone has changed the content of one of the fields in alert edit form: ' + form.serialize());
                var form_data = form.serializeArray();
                var params = {};
                jQuery.each(form_data, function(i, v){
                    params[v.name] = v.value;
                });
                jQuery.post('/api/settings/updatealert', {
                    'params': params
                }, function(data){
                    log('Request to update the data sent successfully. The response was:');
                    log(data);
                });
            });
            
            log('Alerts settings initialized');
        },

        'initializeBillingSettings': function(){
            log('Billing settings initialized');
        },

        'initializeCompetitorsSettings': function(){
            var self = this;
            
            this.competitorsSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                log('User attempts to add new competitor');
                var new_competitor = jQuery(this).find('input[name="competitor"]').val();
                jQuery.post('/api/settings/addcompetitor', {
                    'params': {
                        'competitor': new_competitor
                    }
                }, function(data){
                    if (data.result && data.result.success){
                        self.clearValidationErrors();
                        self.competitorsSettings.find('.competitorsSettingsList').replaceWith(data.result.competitors_list_html);
                    } else if(data.error && typeof data.error.validation_errors != 'undefined'){
                        self.displayValidationErrors(data.error.validation_errors, self.competitorsSettings);
                    }
                });
            });

            this.competitorsSettings.delegate('a[data-action="delete"]', 'click', function(event){
                event.preventDefault();
                if (confirm('Are you sure?')){
                    var competitor_name = jQuery(this).attr('data-competitor');
                    //jQuery(this).parents('tr').remove(); // @todo do this only when deletion confirmed by server
                    log('Competitor "' + competitor_name + '" would be deleted here');
                    jQuery.post('/api/settings/deletecompetitor', {
                        'params': {
                            'competitor': competitor_name
                        }
                    }, function(data){
                        if (data.result && data.result.success){
                            log('Competitor "' + competitor_name + '" has been deleted');
                            if (typeof data.result.competitors_list_html != 'undefined'){
                                log('Updating list of competitors');
                                self.competitorsSettings.find('.competitorsSettingsList').replaceWith(data.result.competitors_list_html);
                            }
                        } else if(data.result && !data.result.success){
                            log('Competitor "' + competitor_name + '" has not been deleted');
                        }
                    });
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
                        if (typeof data.result.general_settings != 'undefined'){
                            self.refreshGeneralLocationSettings(data.result.general_settings);
                        }
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
                    var email = jQuery(this).attr('data-email');
                    log('Attempting to delete mail "' + email + '" from the current location');

                    jQuery.post('/api/settings/deleteemail', {
                        'email': email
                    }, function(data){
                        if (data.result && data.result.success){
                            self.refreshReportsSettingsEmails();
                            log('List of report emails updated after successful deletion of email');
                        }else{
                            log('Some error occured while trying to delete email from reports section.')
                        }
                    }, 'json');
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
            var self = this;
            var editForm = this.userManagementSettings.find('form.userEditForm');

            this.userManagementSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                log('User submitted a form to add/update some user');
                
                self.clearValidationErrors(editForm);
                
                var user = {};
                var user_form = editForm.serializeArray();
                jQuery.each(user_form, function(i, v){
                    user[v.name] = v.value;
                });
                jQuery.post('/api/settings/updateuser', {
                    'params': {
                        'user': user
                    }
                }, function(data){
                    if(data.result){
                        // success?
                        log('The request probably succeeded:');
                        log(data);
                        self.clearForm(editForm); // clear recently added data
                        if (typeof data.result.users_html != 'undefined'){
                            self.userManagementSettings.find('.usersSettingsList').replaceWith(data.result.users_html);
                        }
                    }else if(data.error && typeof data.error.validation_errors != 'undefined'){
                        // validation failure
                        self.displayValidationErrors(data.error.validation_errors, editForm);
                    }
                }, 'json');
            });

            this.userManagementSettings.delegate('a[data-action="edit"][data-user-id]', 'click', function(event){
                // editing user data
                event.preventDefault();
                self.clearValidationErrors(editForm); // validation is not needed
                self.clearForm(editForm); // get rid of the older data
                var user_id = jQuery(this).attr('data-user-id');
                jQuery.post('/api/settings/getuser', {
                    'params': {
                        'user_id': user_id
                    }
                }, function(data){
                    log('Propagating user data received from server');
                    self.propagateFormData(data.result.user, editForm);
                }, 'json');
            });

            this.userManagementSettings.delegate('a[data-action="delete"][data-user-id]', 'click', function(event){
                // editing user data
                event.preventDefault();
                if (confirm('Are you sure?')){
                    var user_id = jQuery(this).attr('data-user-id');
                    jQuery.post('/api/settings/deleteuser', {
                        'params': {
                            'user_id': user_id
                        }
                    }, function(data){
                        if (data.result){
                            log('User has been successfully deleted');
                            if (typeof data.result.users_html != 'undefined'){
                                self.userManagementSettings.find('.usersSettingsList').replaceWith(data.result.users_html);
                            }
                        }else{
                            log('Some error occured while trying to delete the user:');
                            log(data);
                        }
                    }, 'json');
                }
            });
            
            this.userManagementSettings.delegate('a[data-action="new"]', 'click', function(event){
                event.preventDefault();
                self.clearValidationErrors(editForm);
                self.clearForm(editForm);
            });

            // this is for saving data, as there is no other way to submit a form
            this.userManagementSettings.delegate('form input[type="text"], form input[type="password"]', 'keydown', function(event){
                if (event.keyCode == 13){
                    jQuery(this).parents('form').submit(); // submit form
                }
            });

            log('User management initialized');
        },



        // clear form (does not work like reset - it clears all the fields,
        // including type="hidden" inputs)
        'clearForm': function(form){
            jQuery(':input',form)
                .not(':button, :submit, :reset')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected');
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

        /**
         * Propagate General Location Settings form with up-to-date data. If
         * data has been provided as parameter, then use it instead of making
         * separate request to the server.
         */
        'refreshGeneralLocationSettings': function(settings){
            var self = this;
            var form = self.generalLocationSettings.find('form');

            if (typeof settings == 'undefined'){
                var location_id = self.generalLocationSettings.find('input[name="location_id"]').val();
                if (location_id == '') {
                    location_id = null;
                }

                // propagate data when the page is displayed
                jQuery.post('/api/settings/getgeneral', {
                    'location_id': location_id
                }, function(data){
                    if (data.result){
                        log('General location data retrieved');
                        self.propagateFormData(data.result, form);
                    }else{
                        log('Error fetching data for general location settings');
                    }
                }, 'json');
            }else{
                self.propagateFormData(settings, form);
            }
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