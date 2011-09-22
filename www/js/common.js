Function.prototype.clone = function() {
    var that = this;
    var temp = function temporary() {return that.apply(this, arguments);};
    for( key in this ) {
        temp[key] = this[key];
    }
    return temp;
};


var APP = {
    
    location : null,
    
    init: function(location_id) {
        
        var self = this;
        
        $.getJSON('/api/box/location_js?loc=' + location_id, function(rs) {
            
            self.location = rs;

            var opt = '';
            $.map(rs.locations, function(value, key) {
                opt += '<option value="' + key + '">' + value + '</option>';
            });

            $('body').append('<div id="loc">Select location: <select name="loc">' + opt + '</select></div>');
            $('#loc').bind('change', function() {

                self.location.current_location_id =  parseInt($('option:selected',this).val());

                boxManager.refresh();

            });

            TopMenu = new TopMenu();
            TopMenu.init();
            
            boxManager
            .add(new BC_TagsAnalysis())
            .add(new BC_Scoreboard())
            .add(new BC_ScoreboardCurrent())
            .add(new BC_ReviewSites())
            .add(new BC_ReviewInbox())
            .add(new BC_SocialActivity())
            .add(new BC_SocialSubscribers())
            .add(new BC_SocialMediaInbox())
            .add(new BC_CompetitionDistribution())
            .add(new BC_CompetitionComparision())
            .add(new BC_CompetitionReviewInbox())
            .add(new BC_CompetitionScore())
            //    .add(new BC_Photos())
            //    .add(new BC_Videos())
            .add(new BC_StatusUpdate())
            .add(new BC_RecentActivity())
            .setDataProvider(new DataProvider())
            .setExporter(Exporter)
            .init(); // we need to init all boxes only when we init top menu
        
        });
    }
    
};

jQuery(function(){

    // logging function
    var log = function(log_message){
        try {
            console.log(log_message);
        } catch(e) {
            // do nothing, if can not be written to console
        }
    }

    // pass globals
    window['log'] = log;

    helpers = {
            
        tips: $( ".validateTips" ),
            
        standardDate: function(date) {
                
            return date.getMonth()+1 + '/' + date.getDate() + '/' + date.getFullYear();
                
        },
        
        getMonthName: function(date, fullName) {
            var months= ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            return months[date.getMonth()];
        },
            
        formatDate: function(date) {

            var tmpDate = new Date(date * 1000);
                
            return tmpDate.getMonth() 
            + '/' 
            + tmpDate.getDate() 
            + '/' 
            + tmpDate.getFullYear() 
            + ' ' 
            + (tmpDate.getHours() < 10 ? '0' + tmpDate.getHours() : tmpDate.getHours())
            + ':' 
            + (tmpDate.getMinutes() < 10 ? '0' + tmpDate.getMinutes() : tmpDate.getMinutes());
              
        },
            
        updateTips: function(t) {
            this.tips
            .text( t )
            .addClass( "ui-state-highlight" );
                
            var that = this;
                
            setTimeout(function() {
                that.tips.removeClass( "ui-state-highlight", 1500 );
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
            
    };
        
    $('.tooltip').tipTip();
    
    // user vote for uservoice.com
    var uvOptions = {};
    (function() {
        var uv = document.createElement('script');
        uv.type = 'text/javascript';
        uv.async = true;
        uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/53rkXOUWwEroMaMlYULXrw.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(uv, s);
    })();
    
});

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
        default:
            return false;
    }
}

function getPeriodInDays(period) {
        
        return period == '1y' ? 365 : determineMonthDiff(period) * 30;
      
      
}

var monthNames = [
'Jan',
'Feb',
'March',
'April',
'May',
'June',
'July',
'Aug',
'Sept',
'Oct',
'Nov',
'Dec'
];