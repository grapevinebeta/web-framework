//var ApiUrl = 'http://grapevine/api/dataProvider/';
var ApiUrl = '/api/static/';

var DataProvider = function() {
    
    /**
     * @var String name of the last part of URL
     */
    var endpoint;
    
    /**
     * @var Array
     */
    var filters; 
    
    /**
     * 
     */
    var range;

    /**
     * 
     */
    var dateInterval;
    
    /**
     * 
     */
    var callback;
    
    /**
     * @var Integer page number
     */
    var page;

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
        
        setDateInterval: function (value) {
            
            dateInterval = value;
            return this;
        },
        
        setPage: function (value) {
            
            page = value;
            return this;
            
        },
        
        setCallback: function(value) {
            callback = value;
            return this;
            
        },
        
        fetch:function() {
            
            var params = {
                range: range,
                filters: filters
            }
            
            if (dateInterval) {
                params.dateInterval = dateInterval;
            }
            
            if (page) {
                params.page = page;
            }
            
            $.ajax({
                type: "POST",
                accepts: "application/json; charset=utf-8",
                data: params,
                dataType: "json",
                url: ApiUrl + endpoint,
                success: callback
            });
        }
    }
}