Function.prototype.clone = function() {
    var that = this;
    var temp = function temporary() {return that.apply(this, arguments);};
    for( key in this ) {
        temp[key] = this[key];
    }
    return temp;
};

jQuery(function(){
    helpers = {
            
            tips: $( ".validateTips" ),
            
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


(function(){

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
    
})();

$(document).ready(function () {
    $('.tooltip').tipTip();
});
