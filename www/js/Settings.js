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
            /**
             * Dummy variable containing location data
             */
            var locationData = {
                'owner_name': 'Tom Jaskowski',
                'owner_email': 'tomasz.jaskowski@polcode.com',
                'owner_phone': '661696776',
                'owner_ext': 'n/a',
                'location_name': 'Plaza',
                'address1': 'Hoza 13',
                'address2': 'Floor no.2',
                'city': 'Warsaw',
                'state': 'Poland',
                'zip': '02-123',
                'phone': '022222222',
                'url': 'http://www.polcode.com/'
            };

            // propagate initial data
            for (item in locationData){
                this.generalLocationSettings.find('input[name="' + item + '"]').val(locationData[item]);
            }

            // attach events
            this.generalLocationSettings.delegate('form','submit',function(event){
                event.preventDefault();
                alert('Not yet ready.');
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