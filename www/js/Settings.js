(function($) {
    $.extend({
        doGet: function(url, params) {
            document.location = url + '?' + $.param(params);
        },
        doPost: function(url, params) {
            var $form = $("<form method='POST'>").attr("action", url);
            $.each(params, function(name, value) {
                $("<input type='hidden'>")
                    .attr("name", name)
                    .attr("value", value)
                    .appendTo($form);
            });
            $form.appendTo("body");
            $form.submit();
        }
    });
})(jQuery);

/**
 * @todo This requires Class() function defined earlier. Make sure Class() is
 *      defined in common location and before this file is executed.
 */

jQuery(function(){
    GLOBALS.settings = Class.extend({

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
            
            this.location_id = APP.location.current_location_id 
                ? APP.location.current_location_id : GLOBALS.location_id;
            
            
            
            if(GLOBALS.location_id != this.location_id) {
                this.initialize(true);
            }
            else
                this.initialize(false);
            
        },

        'initializeSections': function(onlyFillData) {
            
            // execute proper functions, if appropriate containers found
            if (!!this.alertsSettings.length){
                this.initializeAlertsSettings(onlyFillData);
            }
            if (!!this.billingSettings.length){
                this.initializeBillingSettings(onlyFillData);
            }
            if (!!this.competitorsSettings.length){
                this.initializeCompetitorsSettings(onlyFillData);
            }
            if (!!this.generalLocationSettings.length){
                this.initializeGeneralLocationSettings(onlyFillData);
            }
            if (!!this.reportsSettings.length){
                this.initializeReportsSettings(onlyFillData);
            }
            if (!!this.socialMediaSettings.length){
                this.initializeSocialMediaSettings(onlyFillData);
            }
            if (!!this.userManagementSettings.length){
                this.initializeUserManagement(onlyFillData);
            }
            
        },

        'initialize': function(forceReload){

            // assign containers
            this.alertsSettings = jQuery(this.options.alertsSettingsSelector);
            this.billingSettings = jQuery(this.options.billingSettingsSelector);
            this.competitorsSettings = jQuery(this.options.competitorsSettingsSelector);
            this.generalLocationSettings = jQuery(this.options.generalLocationSettingsSelector);
            this.reportsSettings = jQuery(this.options.reportsSettingsSelector);
            this.socialMediaSettings = jQuery(this.options.socialMediaSettingsSelector);
            this.userManagementSettings = jQuery(this.options.userManagementSelector);

            var self = this;

            jQuery('#loc select').live('change', function() {

                self.location_id =  APP.location.current_location_id;
                
                self.initializeSections(true);

            });

            this.initializeSections(forceReload);

        },

        'initializeAlertsSettings': function(onlyFillData){
            var self = this;
            var form = this.alertsSettings.find('form.alertsSettingsForm');
            
            jQuery.post('/api/settings/getalert', {loc: self.location_id}, function(data){
                if(data.result && typeof data.result.alert != 'undefined'){
                    
                    self.propagateFormData(data.result.alert, form);
                }
            });

            if(!onlyFillData) {
             
                form.delegate('[name="criteria"]', 'keydown', function(){
                    var checked = form.find(':radio[name="type"][value="my"]').prop('checked');
                    if (!checked){
                        form.find(':radio[name="type"][value="my"]').prop('checked', true);
                        log('User has modified default criteria. Checking "my tags" checkbox');
                    }
                });

                form.delegate(':radio[name="type"]', 'change', function(){
                    var element = jQuery(this);
                    form.find('[name="criteria"]').val(element.attr('data-alerts-tags'));
                    log('Criteria field value changed into the following: "' + element.attr('data-alerts-tags') + '"');
                });
            
                this.alertsSettings.delegate('form', 'submit', function(event){
                    event.preventDefault();
                    log('Someone has changed the content of one of the fields in alert edit form: ' + form.serialize());
                    var form_data = form.serializeArray();
                    var params = {};
                    jQuery.each(form_data, function(i, v){
                        params[v.name] = v.value;
                    });

                
                    jQuery.post('/api/settings/updatealert', {
                        'params': params,
                        loc: self.location_id
                    }, function(data){
                        log('Request to update the data sent successfully. The response was:');
                        log(data);
                    });
                });
            
                log('Alerts settings initialized');
             
            }
        },

        'initializeBillingSettings': function(){
            log('Billing settings initialized');
        },

        'initializeCompetitorsSettings': function(reload){
            if(reload) {
             
                $.doPost(location.href, {
                    loc: this.location_id
                });
             
            }
            /*
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
            */

            log('Competitors settings initialized');
        },

        'initializeGeneralLocationSettings': function(reload){
            
            
            if(reload) {
             
                $.doPost(location.href, {
                    loc: this.location_id
                });
             
            }
            
        },

        'initializeReportsSettings': function(reload){
            var self = this;
            
            if(reload) {
             
                $.doPost(location.href, {
                    loc: this.location_id
                });
             
            }
            
            this.reportsSettings.delegate('form', 'submit', function(event){
                event.preventDefault();

                // @todo Replace it with some shorthand method for requests
                jQuery.post('/api/settings/addemail', {
                    'email': jQuery(this).find('input[name="email"]').val(),
                    loc: self.location_id
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
                        'email': email,
                        loc: self.location_id
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

        'initializeSocialMediaSettings': function(reload){
            
            if(reload) {
             
                $.doPost(location.href, {
                    loc: this.location_id
                });
             
            }
            
            var self = this;

            this.socialMediaSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                var form = jQuery(this);
                var twitter_search = form.find('input[name="twitter_search"]').val();
                jQuery.post('/api/settings/updatetwittersearch', {
                    'params': {
                        'twitter_search': twitter_search
                    },
                    loc: self.location_id
                }, function(data){
                    if (data.result){
                        log('Request to change Twitter search setting successful');
                    } else {
                        log('Request to change Twitter search setting was NOT successful');
                    }
                });
            });

            this.socialMediaSettings.delegate('.social-disconnect[data-action="disconnect"]', 'click', function(event){
                event.preventDefault();
                var network = jQuery(this).attr('data-network');
                var network_name = jQuery(this).attr('data-network-name');
                self.disconnectFromSocialNetwork(network, function(result){
                    if (result){
                        log('Correctly disconnected from "' + network_name + '" network');
                        window.location.reload(true); // reload the page - shortcut to refreshing the data
                    } else {
                        log('Disconnecting from "' + network_name + '" network failed');
                    }
                });
            });

            log('Social media settings initialized');
        },

        'initializeUserManagement': function(reload){
            
                        
            if(reload) {
             
                $.doPost(location.href, {
                    loc: this.location_id
                });
             
            }
            
            var self = this;
            var editForm = this.userManagementSettings.find('form.userEditForm');

            var notice = editForm.children('.notice');

            this.userManagementSettings.delegate('form', 'submit', function(event){
                event.preventDefault();
                log('User submitted a form to add/update some user');
                
                notice.text('Updating...');
                
                self.clearValidationErrors(editForm);
                
                var user = {};
                var user_form = editForm.serializeArray();
                jQuery.each(user_form, function(i, v){
                    user[v.name] = v.value;
                });
                jQuery.post('/api/settings/updateuser', {
                    'params': {
                        'user': user
                    },
                    loc: self.location_id
                }, function(data){
                    if(data.result){
                        // success?
                        log('The request probably succeeded:');
                        log(data);
                        self.clearForm(editForm); // clear recently added data
                        if (typeof data.result.users_html != 'undefined'){
                            self.userManagementSettings.find('.usersSettingsList').replaceWith(data.result.users_html);
                        }
                        
                        notice
                           .text('User Updated (This box will close in 3s.)');
                        
                        setTimeout(function() {
                           notice.fadeOut(1000); 
                        }, 4000);
                        editForm.find('#save').hide();
                        editForm.find('table.hide').hide();
                        
                    }else if(data.error && typeof data.error.validation_errors != 'undefined'){
                        // validation failure
                        self.displayValidationErrors(data.error.validation_errors, editForm);
                        notice.text('Please correct errors in form');
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
                    },
                    loc: self.location_id
                }, function(data){
                    log('Propagating user data received from server');
                    self.propagateFormData(data.result.user, editForm);
                }, 'json').complete(function() {
                        
                        notice.text('Please fill the following form to edit existing user').fadeIn();
                        editForm.find('#save').show();
                        editForm.find('table.hide').show();
                        
                    });
            });

            this.userManagementSettings.delegate('a[data-action="delete"][data-user-id]', 'click', function(event){
                // editing user data
                event.preventDefault();
                if (confirm('Are you sure?')){
                    var user_id = jQuery(this).attr('data-user-id');
                    jQuery.post('/api/settings/deleteuser', {
                        'params': {
                            'user_id': user_id
                        },
                        loc: self.location_id
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

            this.userManagementSettings.delegate(':radio[data-action="change-role"]', 'change', function(event){
                // changing access level
                var element = jQuery(this);
                var notice = self.userManagementSettings.find('#account-users-list-section .notice');
                var level = element.attr('data-role');
                var user_id = element.attr('data-user-id');
                log('Location level for user with ID="' + user_id + '" is about to be changed to "' + level + '"');
                jQuery.post('/api/settings/changelocationlevel', {
                    'params' : {
                        'level': level,
                        'user_id': user_id
                    },
                    loc: self.location_id
                }, function(data){
                    log('Answer to the request:');
                    log(data);
                    if (typeof data.result.users_html != 'undefined'){
                        self.userManagementSettings.find('.usersSettingsList').replaceWith(data.result.users_html);
                        log('Users list has been updated');
                        notice.text('Privilages for user was changed').fadeIn();
                        
                        setTimeout(function() {
                            
                            notice.fadeOut();
                            
                        }, 2000);
                        
                    }
                });
            });
            
            this.userManagementSettings.delegate('button[data-action="new"]', 'click', function(event){
                event.preventDefault();
                
                notice.text('Please fill the following form to create a new user').fadeIn();
                editForm.find('#save').show();
                editForm.find('table.hide').show();
                self.clearValidationErrors(editForm);
                self.clearForm(editForm);
            });

            log('User management initialized');
        },



        // clear form (does not work like reset - it clears all the fields,
        // including type="hidden" inputs)
        'clearForm': function(form){
            // text inputs, textareas (?) etc.
            jQuery(':input',form)
                .not(':button, :submit, :reset, :checkbox, :radio')
                .val('');
            // radio buttons, checkboxes etc.
            jQuery(':input',form)
                .not(':button, :submit, :reset')
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

        // deals with disconnecting from social network
        'disconnectFromSocialNetwork': function(network, callback){
            jQuery.post('/api/settings/socialdisconnect', {
                'params': {
                    'network': network
                },
                loc: self.location_id
            }, function(data){
                if (typeof data.result.success !== 'undefined' && data.result.success){
                    // success
                    callback(true);
                } else {
                    // failure
                    callback(false);
                }
            }, 'json');
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
            
            
            if(!data['type']) {
                
                form.find('input[name="type"][value="grapevine"]').trigger('click');
                
            }
            
            for (field_name in data){
                form.find('*[name="' + field_name + '"]').each(function(){
                    
                    if(!data[field_name]) {
                        return;
                    }
                    
                    if (jQuery.inArray(jQuery(this).attr('type'), ['radio', 'checkbox']) != -1){
                        // radio button or checkbox - check if matches value, otherwise uncheck
                        if (jQuery(this).val() == (''+data[field_name])){
                            // this should be checked
                            jQuery(this).attr('checked', true);
                            log('Checking ' + field_name + ' ("' + data[field_name] + '") field');
                        }else{
                            // otherwise it should be unchecked
                            jQuery(this).attr('checked', false);
                            log('Unchecking ' + field_name + ' ("' + data[field_name] + '") field');
                        }
                    }else{
                        
                        
                        jQuery(this).val(data[field_name]);
                        log('Propagating ' + field_name + ' field with data:');
                        log(data[field_name]);
                    }
                });
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

                // propagate data when the page is displayed
                jQuery.post('/api/settings/getgeneral', {
                    'location_id': self.location_id
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
            
            jQuery.post('/api/settings/getemails', {loc: self.location_id}, function(data){
                if (data.result){
                    // result received
                    self.reportsSettings.find('.reportsSettingsEmails').replaceWith(data.result.emails_html);
                }else{
                    log('Problem encountered when trying to get list of emails from the server');
                }
            }, 'json');
        }

    });


});