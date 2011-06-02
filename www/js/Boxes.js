
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
    
    construct: function () {},
    
    init: function () {
        //this.getContentDom().children().hide();
        if (this.getContentDom().length) {
            this.loadData();
        }
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
        if (!this._contentDom) {
            this._contentDom = $('#' + this.boxId + ' .box-content:first');
        }
        return this._contentDom;
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
    
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
    },
    
    afterLoadData: function () {
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().children().show();
    },
    
    /**
     * Will handle Ajax response of the loadData
     */
    loadDataCallback: function () {
        this.boxController.afterLoadData();
    },
    
    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.beforeLoadData();
        if (!this.loadDataCallback.boxController) {
            this.loadDataCallback.boxController = this;
        }
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
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'keywords',
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.keywords.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.keywords[i]) {
                var value = boxController.data.keywords[i][n];
                if (n == 'percent') {
                    value = value + '%';
                } 
                tr.find('td.col-' + n).text(value);
            }
            table.find('tbody').append(tr);
        }
        boxController.afterLoadData();
    },
    
    construct: function () {}
    
});

var BC_ReviewSites = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-review-sites',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'sites',
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr').clone();
        var tr = null;
        var trFooter = table.find('tfoot tr');
        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.sites.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.sites[i]) {
                var value = boxController.data.sites[i][n];
                tr.find('td.col-' + n).text(value);
                if (n != 'site') {
                    var currentTotalValue = 0;
                    if (n == 'average') {
                        currentTotalValue = parseFloat(trFooter.find('th.col-' + n).text());
                    } else {
                        currentTotalValue = parseInt(trFooter.find('th.col-' + n).text());
                    }
                    trFooter.find('th.col-' + n).text(value + currentTotalValue);
                }
            }
            table.find('tbody').append(tr);
        }
        trFooter.find('th.col-average').text(
            parseFloat(trFooter.find('th.col-average').text()) / 
            boxController.data.sites.length
        );
        boxController.afterLoadData();
    },
    
    construct: function () {}
    
});

var BC_RecentReviews = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-recent-reviews',
    
    endpoint: 'reviews',
    
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        this.getHeaderDom().find('#box-header-status-filters').html($(this.getLoaderHtml()).children());
        this.getHeaderDom().find('#box-header-source-filters').html($(this.getLoaderHtml()).children());
    },
    
    loadHeaderFilters: function (filterType) {
        if (filterType != 'status' && filterType != 'source') {
            return;
        }
        var filters = this.data.filters[filterType];
        var filterHolder = this.getHeaderDom().find('#box-header-' + filterType + '-filters');
        filterHolder.html('');
        for (var i = 0; i < filters.length; i++) {
            var filterLink = $('<a href="#"></a>');
            if (filters[i].total) {
                filterLink.text(filters[i].total +' ');
            }
            filterLink.text(filterLink.text() + filters[i].value);
            filterHolder.append(filterLink);
            filterHolder.append(' ');
        }
    },
    
    loadReviews: function (reviews) {
        var table = this.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < this.data.reviews.length; i++) {
            tr = trTemplate.clone();
            
            for (n in this.data.reviews[i]) {
                var value = this.data.reviews[i][n];
                if (n == 'submitted') {
                    var tmpDate = new Date(value * 1000);
                    tr.find('td.col-' + n).text(
                        monthNames[tmpDate.getMonth()] +
                        ' ' +
                        tmpDate.getDate()
                    );
                } else if (n == 'title') {
                    var titleLink = $('<a href="#"></a>');
                    titleLink.text(value);
                    tr.find('td.col-' + n).html(titleLink);
                } else {
                    tr.find('td.col-' + n).text(value);
                }
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            table.find('tbody').append(tr);
        }
        this.getContentDom().find('.ajax-loader').remove()
        this.getContentDom().find('.data-grid-holder').show();
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        
        if (data.reviews) {
            boxController.loadReviews();
        }
        
        if (data.filters && data.filters.status) {
            boxController.loadHeaderFilters('status');
        }
        
        if (data.filters && data.filters.source) {
            boxController.loadHeaderFilters('source');
        }
    },
    
    construct: function () {}
    
});

var BC_SocialActivity = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity',
    
    construct: function () {}
    
});

var BC_SocialReach = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-reach',
    
    construct: function () {}
    
});

var BC_SocialActivityDetails = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity-details',
    
    construct: function () {}
    
});

boxManager = {
    
    collection: {},
    
    add: function (box) {
        if (!(box instanceof BoxController)) {
            return;
        }
        if (!box.getBoxId()) {
            return;
        }
        
        this.collection[box.getBoxId()] = box;
    },
    
    moveEmptyToBottom: function () {
        
        var boxesHolder = $('#boxes-holder');
        var boxes = $('#boxes-holder .box-container');
        
        boxes.each(function (index) {
            var box = $(this);
            if (!box.children().length) {
                if (box.hasClass('box-container-left')
                    && !box.next().hasClass('active')) {
                        var tmp = box.next();
                        tmp.next('.clear').remove();
                        boxesHolder.append(box);
                        boxesHolder.append(tmp);
                        boxesHolder.append('<div class="clear"></div>');
                } else if (!box.hasClass('box-container-left')
                    && !box.hasClass('box-container-right')) {
                    box.nextAll(':last').after(box);
                }
            }
        });
    },
    
    init: function () {
        $( ".box" ).draggable({ 
            snap: ".box-container", 
            snapMode: 'inner',
            handle: ".box-header-button-move",
            revert: 'invalid',
            appendTo: 'body',
            zIndex: 10,
            start: function(event, ui) {
                $(this).css({});
                $('.box-container.empty').addClass('box-dropable')
                    .css('min-height', $(this).height());
            },
            stop: function (event, ui) {
                $(this).css({
                        top: 0,
                        left: 0,
                        width: 'auto'
                        });
                $('.box-container').css('min-height', '');
                $('.box-container.empty').removeClass('box-dropable');
            }
        });
        $('.box-container')
            .droppable({
                accept: '.box',
                activeClass: "box-dropable",
                hoverClass: "box-drag-over",
                drop: function (event, ui) {
                    var oldBox = $(this);
                    var fromContainer = ui.draggable.parent();
                    if (oldBox.children().length > 0) {
                        ui.draggable.parent().append(oldBox.children());
                    } else {
                        ui.draggable.parent().addClass('empty').removeClass('active');
                    }
                    $(this).removeClass('empty').addClass('active');
                    $(this).append(ui.draggable);
                    
                    boxManager.moveEmptyToBottom();
                }
            });
    }
};

//boxManager = new BoxManager();


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
    
    boxManager.init();
});


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


