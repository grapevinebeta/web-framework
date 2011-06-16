Function.prototype.clone = function() {
    var that = this;
    var temp = function temporary() { return that.apply(this, arguments); };
    for( key in this ) {
        temp[key] = this[key];
    }
    return temp;
};


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
