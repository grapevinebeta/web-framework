var ApiUrl = 'http://grapevine/';

var DataProvider = function() {
    
    /**
     * 
     */
    var endpoint;
    
    /**
     * 
     */
    var filters; 
    
    /**
     * 
     */
    var range;
    
    /**
     * 
     */
    var callback;

    return {
        
        setEndpoint: function(value) {
            endpoint = value;
            return this;
        },
        
        setFilters: function(value) {
            filters = value;
            return this;
        },
        
        setDateRange: function(value) {
            range = value;
            return this;
        },
        
        setCallback: function(value) {
            callback = value;
            return this;
            
        },
        
        fetch:function() {
            $.ajax({
                type: "POST",
                contentType: "application/json; charset=utf-8",
                data: {
                    range: range,
                    filters: filters
                    },
                dataType: "json",
                url: ApiUrl + endpoint,
                success: callback
            });
        }
    }
}