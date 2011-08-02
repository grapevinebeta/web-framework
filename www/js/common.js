Function.prototype.clone = function() {
    var that = this;
    var temp = function temporary() { return that.apply(this, arguments); };
    for( key in this ) {
        temp[key] = this[key];
    }
    return temp;
};

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
