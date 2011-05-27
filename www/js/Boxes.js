
function Class() { }

Class.prototype.construct = function() {};

Class.__asMethod__ = function(func, superClass) {    
    return function() {
        var currentSuperClass = this.$;
        this.$ = superClass;
        var ret = func.apply(this, arguments);        
        this.$ = currentSuperClass;
        return ret;
    };
};

Class.extend = function(def) {
    var classDef = function() {
        if (arguments[0] !== Class && this.construct) { this.construct.apply(this, arguments); }
    };
    
    var proto = new this(Class);
    var superClass = this.prototype;
    
    for (var n in def) {
        var item = def[n];                        
        
        if (item instanceof Function) {
            item = Class.__asMethod__(item, superClass);
        }
        
        proto[n] = item;
    }

    proto.$ = superClass;
    classDef.prototype = proto;    
    classDef.extend = this.extend;        
    return classDef;
};

var boxCollection = new Array();

/**
 * 
 */
var BoxController = Class.extend({
    
    /**
     * @var String DOM id of the container div 
     */
    boxId: '',
    

    /**
     * @var DataProvider
     */
    dataProvider: new DataProvider(),
    
    /**
     * @var Object To store data from ajax responces
     */
    data: null,
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: null,
    
    construct: function () {
        alert('asdad');
    },
    
    
    init: function () {
        //this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        this.loadData();
    },
    
    /**
     * @return jQuery DOM element which holds the box
     */
    getBoxDom: function () {
        return $('#' + this.boxId);
    },

    /**
     * @return jQuery DOM element which holds content of the box
     */
    getContentDom: function () {
        return $('#' + this.boxId + ' .box-content:first');
    },
    
    /**
     * @return jQuery DOM element which holds header of the box
     */
    getHeaderDom: function () {
        return $('#' + this.boxId + ' .box-header:first');
    },
    
    getLoaderHtml: function () {
        return $('#ajax-loader-holder').html();
    },
    
    
    /**
     * @return String
     */
    getBoxId: function () {
        return this.boxId
    },
    
    /**
     * Will handle Ajax response of the loadData
     */
    loadDataCallback: function () {
        
    },
    
    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.data = null;
        this.dataProvider.setEndpoint(this.endpoint);
        this.dataProvider.setCallback(this.loadDataCallback);
        this.data = this.dataProvider.fetch();
    }
});


var BC_KeywordsAnalysis = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-keywords-analysis',
    
    construct: function () {},
    
});

var BC_ReviewSites = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-review-sites',
    
    construct: function () {},
    
});

var BC_RecentReviews = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-recent-reviews',
    
    construct: function () {},
    
});

var BC_SocialActivity = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity',
    
    construct: function () {},
    
});

var BC_SocialReach = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-reach',
    
    construct: function () {},
    
});

var BC_SocialActivityDetails = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity-details',
    
    construct: function () {},
    
});


boxCollection.push(new BC_KeywordsAnalysis());
boxCollection.push(new BC_ReviewSites());
boxCollection.push(new BC_RecentReviews());
boxCollection.push(new BC_SocialActivity());
boxCollection.push(new BC_SocialReach());
boxCollection.push(new BC_SocialActivityDetails());

$(document).ready(function () {
    for (var i = 0; i < boxCollection.length; i++) {
        boxCollection[i].init();
    }
});





