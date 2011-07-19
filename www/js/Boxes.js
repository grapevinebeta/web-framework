function Class() { }

Class.prototype.construct = function() {};

Class.__asMethod__ = function(func, superClass) {    
    return function() {
        var currentSuperClass = this.Super;
        this.Super = superClass;
        var ret = func.apply(this, arguments);        
        this.Super = currentSuperClass;
        return ret;
    };
};

Class.extend = function(def) {
    var classDef = function() {
        if (arguments[0] !== Class && this.construct) {
            this.construct.apply(this, arguments);
        }
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

    proto.Super = superClass;
    classDef.prototype = proto;    
    classDef.extend = this.extend;
    return classDef;
};

var boxCollection = new Array();

/**
 * the simplest controller of all and the base on
 * it contain logic for handle with filters, pagination and asynchronic data
 * load.
 */
var BoxController = Class.extend({
    
    /**
     * @var String DOM id of the container div 
     */
    boxId: '',
    

    /**
     * @var DataProvider
     */
    dataProvider: null,
    
    /**
     * @var Object To store data from ajax responces
     */
    data: null,
    
    /**
     * @var Object To store data from ajax responces
     */
    error: null,
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: null,
    
    /**
     * @var Object [optional] filters data key to filter against
     */
    filters: {},
    
    /**
     * @var String [optional] datestamp in mm/dd/yyyy or <value><date_metric>
     *      date_metrics : m = months,d=days,y=years ie 30d,3m, 1y
     */
    range: '1m',
    
    dateInterval: null,
    
    /**
     * @var Boolean this variable is responsible for export control
     *
     */
    ignore: false,
    
    
    /**
     * @var Boolean if there is no data this variable return true
     */
    
    empty: false,
    
    construct: function () {},
    
    init: function () {
        if (this.boxId && this.getContentDom().length) {
            this.refresh();
            this.attachBoxEvents();
        }
    },

    /**
     * Attach events specific to the current box / class. This method will be
     * invoked once, during box initialization. Should rely on .delegate()
     * method or attach events that will not require re-attachment.
     */
    attachBoxEvents: function() {
    // this method can be safely overriden by any of the inheriting classes
    },


    /**
     * @return jQuery DOM element which holds the box
     */
    getBoxDom: function () {
        if (!this._boxDom) {
            this._boxDom = $('#' + this.boxId);
        }
        return this._boxDom;
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
        if (!this._headerDom) {
            this._headerDom = $('#' + this.boxId + ' .box-header:first');
        }
        return this._headerDom;
    },

    /**
     * @return jQuery DOM element which holds filters of the box
     */
    getFiltersDom: function () {
        if (!this._filterDom) {
            this._filterDom = $('#' + this.boxId + ' .box-filters');
        }
        return this._filterDom;
    },
    
    getLoaderHtml: function () {
        return $('#ajax-loader-holder').html();
    },
    
    
    /**
     * @return String Id of the box
     */
    getBoxId: function () {
        return this.boxId;
    },
    
    showContent: function () {
        this.getContentDom().children(':first').show();
        return this
    },
    
    showLoader: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        return this;
    },
    
    hideLoader: function () {
        this.getBoxDom().find('.ajax-loader').remove();
        return this;
    },
    
    /**
     * Called before ajax request, generaly used for set ajax-loader.gif
     */
    beforeLoadData: function () {
        this.data = null;
        this.showLoader();
        this.getHeaderDom().find('.box-header-right-buttons a').removeClass('active');
        return this;
    },
    
    /**
     * Called after ajax request, generaly used for unset ajax-loader.gif 
     * and show new data or display an error
     */
    afterLoadData: function () {
        this.hideLoader();
        this.showContent();
        this.getHeaderDom()
        .find('.box-header-right-buttons a.box-header-button-show-data')
        .addClass('active');
     
        if(this.empty) {
            var holder = this.getContentDom().find('div'),
            div, wrapper, span;
            
            
            // big 100% width no data icon
            if(holder.width() > 291) {
            
                wrapper = $('<div/>', {
                    css: {
                        margin: '20px',
                        'text-align': 'center'
                    
                    }
                });
            
            
                div = $("<div/>", {
                    css: {
                        background: 'url(/images/icons/icons.png) 5px 0px',
                        width: '291px',
                        height: '283px',
                        margin: 'auto auto',
                        position: 'relative'
                    }
                        
                });
                
                span = '<span style="background: #fff; position: absolute; font-size: 10px; font-weight: bold; left: 8px; bottom: -9px;">Nothing heard through the Grapevine for the date range you selected. Expand your date range to see more data.</span>';
            
            }
            else
            {
               
                wrapper = $('<div/>', {
                    css: {
                        margin: '5px',
                        'text-align': 'center'
                    
                    }
                })
               
                div = $('<div/>');
                
                span = '<span style="font-size: 10px; font-weight: bold; left: 8px; bottom: -9px;">Nothing heard through the Grapevine for the date range you selected. Expand your date range to see more data.</span>';
                
            }
            
                    
            div.html(span);
            wrapper.append(div);
                        
                    
            holder.html(wrapper);
            
            
        }

        
        return this;
    },
    
    /**
     * this function work as cache create function for every instance
     * and create it only one time at first call
     *
     */
    loadDataCallback: function(boxController) {
        
        if(!boxController.hasOwnProperty('loadCallback')) {
            
            boxController.loadCallback = function (data, textStatus, jqXHR) {
        
                boxController.data = data;
                
                if(data) {
                    boxController.processData();
                    boxController.afterLoadData();
                }
                else {
                    // when no data is loaded this variable indicate it
                    boxController.empty = true;
                    
                    boxController.afterLoadData();
                }
    
            };
            
        }
        
        return boxController.loadCallback;
    },
    
    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.beforeLoadData();
        
        this.dataProvider.setEndpoint(this.endpoint)
        .setDateRange(this.range)
        .setFilters(this.filters)
        .setDateInterval(null)   
        .setCallback(this.loadDataCallback(this));
        
        this.data = this.dataProvider.fetch();
        
        return this.loadDataCallback;
    },
    
    setDataProvider: function (dataProvider) {
        this.dataProvider = new DataProvider();
    },
    
    resetFilters: function(name) {
        
        this.filters[name]  = [];
        
    },

    /**
     * Sets filter. Requires JS object to be passed in the following form:
     * { 'total': 10, 'value': 'negative' }
     * where 'total' is optional (integer?) and 'value' is required string
     * @todo Actually set filter in compliance to API
     */
    addFilter: function(name, value) {
        
        var exists = false;
        for(var cValue in this.filters[name])
        {

            if(this.filters[name] !== undefined && this.filters[name][cValue] == value)
            {
                this.filters[name].splice(cValue, 1);
                exists = true;
            }

        }
        
        if(!exists)
        {
            if(this.filters[name] === undefined)
                this.filters[name] = [];
            
            this.filters[name].push(value);
        }
        return this;
    },

    /**
     * Setter
     * @param range datestamp in mm/dd/yyyy or <value><date_metric>
     *       date_metrics : m = months,d=days,y=years ie 30d,3m, 1y
     * @return BoxController
     */
    setRange: function(range) {
        this.range = range;
        return this;
    },
    
    /**
     * setter
     * @return BoxController
     */
    setDateInterval: function (dateInterval) {
        
        
        this.dateInterval = dateInterval;
        return this;
    },
    
    /**
     * Alias for loadData
     * @return BoxController
     */
    refresh: function () {
        this.loadData();
        return this;
    },
    
    /**
     * Clears all stored data from ajax responses 
     * @return BoxController
     */
    clearData: function () {
        this.data = null;
        return this;
    },
    
    /**
     * callback that returns the proper js event function and has data variable
     * accesible from local scope
     * 
     * example usage:
     * 
     * $.post(endpoint, this.genericCallbackEventWrapper(function(e, data)) {
     *    // you have access to data you include throught data variable like
     *    data.variable
     * }, {variable: foo});
     * 
     */
    genericCallbackEventWrapper: function(callback, data) {
        
        
        return function (e)
        {
            callback(e, data);            
            
        }
        
    }
    
});


var BC_RecentActivity = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity-mini',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'socials',
    
    limit: 4,
    
    ignore: true,

    prepareMessage: function(template, data) {
      
        template = template.clone();
      
        template.find('.title').text(data.title);
      
        var tmpDate = new Date(data.submitted * 1000);
        var formatted = tmpDate.getMonth() + "/" + tmpDate.getDate() +
        '/' + tmpDate.getFullYear();
      
        template.find('.date').text(formatted);
      
        titleLink = $('<a href="#"><span></span></a>');
        titleLink.attr('class', data.network.toLowerCase());
        
        template.find('.network').html(titleLink);
      
        return template;
      
    },
    
    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.beforeLoadData();
        
        this.data = this.dataProvider
        .setEndpoint(this.endpoint)
        .setDateRange(this.range)
        .setFilters(this.filters)
        .setDateInterval(null)
        .setLimit(this.limit)
        .setCallback(this.loadDataCallback(this))
        .fetch();
        
        return this;
    },
    
    processData: function() {
      
        var content = this.getContentDom().find('.data-grid-holder'),
        template = content.find('.row:first'),
        row,
        socials = this.data.socials;
        
        content.find('.row').remove();
        for (var i = 0; i < socials.length; i++) {

            row = this.prepareMessage(template, socials[i]);   
            content.append(row); // append two elements
            
        }
      
    },
    
    construct: function () {}

});


var BC_GraphBoxController = BoxController.extend({
    
    /**
     * @var Object To store data from ajax responces for graph
     */
    graphData: null,
    // date format for different range @see getPeriodInDays
    
    getGraphHolder: function () {
        if (!this._graphHolder) {
            this._graphHolder = $('#' + this.boxId + '-graph-holder'); 
        }
        return this._graphHolder;
    },
    
    init: function () {
        this.getContentDom().children().hide();
        this.getContentDom().parent().find('.box-header-button-show-graph').click(this.showGraph);
        this.getContentDom().parent().find('.box-header-button-show-data').click(this.showData);
        if (this.getContentDom().length) {
            this.refresh();
        }
    },

    /**
     * we should separate data to 6 equal size points
     *
     */
    computeDateInterval: function() {

        return Math.floor((getPeriodInDays(this.range['period']) )  / 6) + 1;
    },
    
    beforeLoadData: function () {
        this.showLoader();
        this.getHeaderDom().find('.box-header-right-buttons a').removeClass('active');
        this.data = null;
        
        if (this.graph) {
            
            this.graph.destroy();
            this.graph = null;
            this.graphData = null;
        }
    },
    
    showData: function () {
        
        
        var box = null;
        if (this instanceof BoxController) {
            box = this.getBoxDom();
        } else {
            box = $(this).parents('.box:first');
        }
        
        var boxContent = box.find('.box-content');
        boxContent.children().hide();
        box.find('.box-header-button').removeClass('active');

        var dataGrid = box.find('.data-grid-holder');
        if (!dataGrid.is(':visible')) {
            dataGrid.show();
        }
        box.find('.box-header-button-show-data').addClass('active');
        return false;
    },
    
    showGraph: function () {
        var box = null;
        if (this instanceof BoxController) {
            box = this.getBoxDom();
        } else {
            box = $(this).parents('.box:first');
        }
        var boxContent = box.find('.box-content');
        
        boxContent.children().hide();
        
        var graphHolder = boxContent.find('.graph-holder');
        var boxController = boxManager.getBox(box.attr('id'));
        
        box.find('.graph-holder').show();
        boxController.getHeaderDom().find('.box-header-right-buttons a')
        .removeClass('active')
        .filter('.box-header-button-show-graph')
        .addClass('active');
        
        if (!boxController.graphData) {
            boxController.loadGraphData();

        } else if (graphHolder.children().length){
            graphHolder.children().show();
        } else {
            boxController.prepareGraph();
        }
        
        
        return false;
    },
    
    beforeLoadGraphData: function () {
        this.getHeaderDom().find('.box-header-right-buttons a').removeClass('active');
        if (this.graph) {
            this.graph.destroy();
            this.graph = null;
        }
        this.graphData = null;
        this.getGraphHolder().append(this.getLoaderHtml());
    },
    
    processData: function() {
      
      this.graphData = this.data;
      this.afterLoadGraphData();
      
    },
    
    loadGraphData: function() {
        this.beforeLoadGraphData();
        
        this.graphData = null;
        
        
        this.graphData = this.dataProvider
        .setEndpoint(this.endpoint)
        .setDateRange(this.range)
        .setFilters(this.filters)
        .setDateInterval(this.computeDateInterval())
        .setCallback(this.loadDataCallback(this))
        .fetch();
        return this;
    },
    
    afterLoadGraphData: function () {
        
        
        
        this.getGraphHolder().children().remove();
        this.getHeaderDom()
        .find('.box-header-right-buttons a.box-header-button-show-graph')
        .addClass('active');
        
        
        for(var key in this.graphData);
        

        if(!this.graphData[key]) {
            
            this.getContentDom().find('.graph-holder')
            .html('<p style="margin:5%;">Nothing heard through the Grapevine for the date range you selected. Expand your date range to see more data.</p>')
            .show();
        }
        else
            this.showGraph();
        
        return this;
    },
    
    prepareGraph: function () {
        alert("'prepareGraph' is not implemented!!!");
    },
    
    clearData: function () {
        this.data = null;
        this.graphData = null;
    }
    
});

/**
 * Base class for all boxes that share linear graph functionality
 * It all requires data indexed by timestamps in specific interval
 *
 */
var BC_LinearGraphBoxController = BC_GraphBoxController.extend({
    
    /*
     * @var Array holds all data series
     */
    series: [],
    
    /*
     * @var Array holds all data labels
     */
    seriesLabels: [],
    
    /*
     * @var int timestamp of first point that should begin the graph
     */
    firstTimestamp: null,
    
    /*
     * @var Helper constant for computations
     */
    dayInterval: 3600 * 24, // day in seconds
    
    
    /*
     * @var Max value for proper graph drawing
     */
    maxValue: null,
    
    /*
     * @var Callback for creating x label specyfic to range
     */
    formatterCallback: null,
    
    getFirstDate: function()
    {
        
        if(this.firstTimestamp)
            return this.firstTimestamp;
        
        for(var dataPrefix in this.graphData); 
            
        
        for(var timestamp in this.graphData[dataPrefix]){
        
            var parsed = parseInt(timestamp, 10);
            break;
        }
        
        
        parsed = new Date(parsed * 1000);
        var offset = Math.floor(getPeriodInDays(this.range['period']) / 30);
        
        return this.firstTimestamp = Date.parse(
            new Date(parsed.getFullYear(), parsed.getMonth() - offset, parsed.getDate())
        );
        
        
    },
    
    populateGraph: function() {
        alert("Must be implemented in extending class");
    },
    
    
    reset: function() {
        this.firstTimestamp = null;
        this.series = [];
        this.seriesLabels = [];
    },
   
    prepareGraph: function() {
       
        if (!this.graphData) {
            return;
        }
        
        // reset cached data
        this.reset();
        
        this.populateGraph();
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                type: 'spline'
            },
            title: {
                text: false
            },
            credits: {
                enabled: false
            },
            colors: [
            '#80699B', 
            '#AA4643', 
            '#4572A7', 
            '#89A54E', 
            '#3D96AE', 
            '#DB843D', 
            '#92A8CD', 
            '#A47D7C', 
            '#B5CA92'
            ],
            xAxis: {
                
                startOfWeek: 0,
                type: 'datetime',
                
                labels: {
                    formatter: this.formatterCallback     
                }
 
            },
            yAxis: {
                title: {
                    text: false,
                    align: 'high'
                },
                min: 0,
                max: this.maxValue + 1,
                endOnTick: false
            },
            exporting: {enabled: false},
            
            series: this.series
        }
        
        this.graph = new Highcharts.Chart(options);
       
    },

    construct: function() {}
    
});

/**
 * More generic class for inbox funtionalities, includes filters, pagers and
 * more readable data preparation
 * 
 */

var BC_Inbox = BoxController.extend({
    
    /**
     * @var first page that will be displayed
     */
    currentPage: 1,
     /**
     * @var the number of pages that api return
     */
    totalPages: null,
    limit: 10,
    ignore: false,
    
    /**
     * @return jQuery DOM element which holds pager of the box
     */
    
    getPagerHolder: function() {
        
        if (!this._pagerDom) {
            this._pagerDom = $('#' + this.boxId + ' .box-pager');
        }
        return this._pagerDom;
        
    },
    
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        
        
        this.getFiltersDom().find('.box-filter')
        .html(this.getLoaderHtml());
    },
    
    
    /**
     * Attach events associated with Inbox boxes, such as expanding review
     * details when the review snippet is being clicked.
     */
    attachBoxEvents: function() {
        var self = this;

        // Attach event for setting filter by status
        self.getBoxDom().delegate('a[data-filter-status]', 'click', function(event){
            event.preventDefault();
            var filter_value = $(this).attr('data-filter-status');
            
            var key = $(this).parent().attr('class');
            key = key.replace("box-filter box-filter-", "");
            
            if($(this).hasClass('show-all')) {
                self.resetFilters(key);
            }
            
            self.addFilter(key , filter_value);
            self.refresh();
        });
        
        // pager event delegation
        self.getPagerHolder().delegate('.prev, .next','click', function(e) {
            
            e.preventDefault();
            
            var reload = false;
            
            if($(this).hasClass('next')) {
                
                if(self.currentPage < self.totalPages) {
                    self.currentPage++;
                    reload = true;
                }
                    
                
            }
            if($(this).hasClass('prev')) {
                
                if(self.currentPage > 1) {
                    self.currentPage--;
                    reload = true;
                }
            } 
            
            if(reload)
                self.loadData();
            
            
        });

        // show expand button on hover
        self.getBoxDom().delegate('tr.collapsed', 'hover', function(e) {
            
            $(this).find('.expand').toggleClass('show');
            
            
        });

        // close row detail on close or save button
        self.getBoxDom().delegate('.close-button, .save-button', 'click', function(e) {
          
            e.preventDefault();
            $(this).parents('tr.expanded')
            .addClass('hidden-row')
            .prev()
            .removeClass('border');

          
        });

        // Attach event for expanding and collapsing review details
        self.getBoxDom().delegate('table tr[data-row-id].collapsed', 'click', 
            function(event){
            
                event.preventDefault();
            
                var expanded = $(this).next();
                if (!$(this).hasClass('border')) {
                    
                    expanded.trigger('expand');
                    
                } else {
                    expanded.addClass('hidden-row');
                
                }
                $(this).toggleClass('border');
            });
    },
    
    loadFilters: function (filterType) {
        
        var filters = this.data.filters[filterType];
        var activeCount = 0;
        var filterHolder = this.getFiltersDom().find('.box-filter-' + filterType);
        filterHolder.html('');
        for (var i = 0; i < filters.length; i++) {
            
            var filterLink = $('<a href="#" data-filter-status="' + 
                filters[i].value.toLowerCase() + '"></a>');
            if (filters[i].total) {
                filterLink.text(filters[i].total +' ');
            }
            
            if(filters[i].active == 1) {
                
                filterLink.addClass('active');
                activeCount++;
            }
            
            if(i === 0) {
                filterLink.addClass('show-all');
            }
            
            filterLink.text(filterLink.text() + filters[i].value);
            filterHolder.append('<span class="separator">|</span> ');
            filterHolder.append(filterLink);
        }
        
        if(!activeCount)
        {
            filterHolder.find('.show-all').addClass('active');
        }
        
    },
    
    loadInboxData: function() {
        alert('You must implement it by yourself');
    },
    
    processData: function() {
      
        this.loadInboxData();
        
        var filters = this.data.filters;
        
        if(filters) 
        {

            for(var activeFilter in filters) 
            {
                this.loadFilters(activeFilter); 
            }
        }
        
        this.initPager();
      
    },

    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.beforeLoadData();

        this.dataProvider.setEndpoint(this.endpoint)
        .setDateRange(this.range)
        .setFilters(this.filters)
        .setDateInterval(null)
        .setPage(this.currentPage)
        .setLimit(this.limit)
        .setCallback(this.loadDataCallback(this));
        
        this.data = this.dataProvider.fetch();
        
        return this;
    },
    
    initPager: function() {
      
        var pager = this.data.pagination;
        
        this.currentPage = pager.page;
        this.totalPages = pager.pages;
        this.pagerInited = true;
      
        if(this.getPagerHolder()) {
            
            
            this.getPagerHolder().find('.page').text(pager.page);
            this.getPagerHolder().find('.pageCount').text(pager.pages);
            
        }
        
        return this;
      
    },
    
    genericRequest: function(endpoint, data, callback) {
                 
        $.ajax({
            type: "POST",
            accepts: "application/json; charset=utf-8",
            data: data,
            dataType: "json",
            url: ApiUrl + endpoint,
            success: callback
        });
      
    },
    
    expandEndpointCallback: function(e, data) {
        
        e.preventDefault();
        
        var param = {};
        param[data.name] = $(e.target).val();
        

        var endpoint = data.endpoint + '/' + data.id;

        data.context.genericRequest(endpoint, param);
        
    },
    
    populateFields: function(text, data) 
    {
        var tr = $(data.trContext);
        
        data.context.customPopulateFields(text, data);
        
        
        data.trContext.prev().find('.expand-preloader').removeClass('expand-preloader').addClass('expand');
        tr.removeClass('hidden-row');
        
    },
    
    /**
     * this callback is executed when expand event is triggered
     * is include custom user expand callback that need to be implemented
     * e.target points to tr row that need to be populated
     */
    expandedPopulate: function(e, data) 
    {
        // we need to unbind all descendants events to avoid event duplication
        $(e.target).find('*').unbind();
        
        data.trContext = $(e.target);
        
        data.trContext.prev().find('.expand').removeClass('expand').addClass('expand-preloader');
        data.context.expandedPopulateCallback(data);
        
        
            
    },
    
    /**
     * this is placefolder for method than need to be implemented in 
     * every class that extend inbox to provide custom data population when row
     * is expanded
     *
     */
    expandedPopulateCallback: function(data) {
      
      alert('not implemented');
      
    },
    
    construct: function () {}
    
});

var BC_CompetitionScore = BoxController.extend({
    
    boxId: 'box-competition-score',
    endpoint: 'competition/ogsi',
    
    populateColumns: function(ogsi, template, row) {
      
      var t;
      for(var col in ogsi) {
            t = template.clone();
            t.text(col);
            row.append(t);

      }

    },
    
    addColumn: function(ogsi, template, tbody, isOdd) {
        
        var ogsiRow = template.clone();
        var avgStarRow = template.clone();
        var reviewsRow = template.clone();
        
        ogsiRow.find('.score').text(ogsi.ogsi.value.toFixed(2) + "%");
        ogsiRow.find('.growth').text(ogsi.ogsi.value.toFixed(2) + "%");
        ogsiRow.find('.rank').text(ogsi.ogsi.rank.value + " of " + ogsi.ogsi.rank.out);
        
        avgStarRow.find('.score').text(ogsi.distribution.average.toFixed(2));
        
        reviewsRow.find('.score').text(ogsi.reviews.value.toFixed(2));
        reviewsRow.find('.rank').text(ogsi.reviews.value + " of " + ogsi.reviews.rank.out);

        var data = [ogsiRow, avgStarRow, reviewsRow];

        var i = 0;

        tbody.find('tr').each(function() {
            $(this).append('<td ' + (isOdd ? 'class="even"' : '') +  '>' + data[i++].html() + '</td>');
            
        });
        
        
    },
    
    filterRowsCallback:  function(table) {
        
        return this.genericCallbackEventWrapper(function(e, data) {
            
            e.preventDefault();
            
            var filter = $(e.target).attr('filter');
            
            data.table.find('tr.' + filter).toggleClass('hide');
            
            
            $(e.target).toggleClass('active');
            
  
        }, {
            table: table
        });
        
    },
    
    processData: function() {
      
        var holder = this.getContentDom().find('.data-grid-holder');
      
        var table;
        
        if(!this.cachedTable) {
            table = holder.find('table');
            this.getBoxDom().delegate('a[filter]', 'click', this.filterRowsCallback(table));
            
            this.cachedTable = table.clone();

        }
        else if(this.cachedTable) {
            
            holder.find('table').remove();
            table = this.cachedTable.clone();
            holder.append(table);
            
            
            this.getBoxDom().undelegate('a')
            .delegate('a[filter]', 'click', this.filterRowsCallback(table))
            .find('a[filter]').removeClass('active').addClass('active');
            
        }
        
        var row = table.find('thead tr'),
        tbody = table.find('tbody'),
        template = row.find('th'),
        ogsi = this.data.ogsi,
        score = table.find('tbody tr th:nth-child(2)'),
        scoreTemplate = score.clone(),
        i=0;
        
        score.remove();
        

        this.populateColumns(ogsi, template, row);
        
        for(var competitor in ogsi) {
            
            this.addColumn(ogsi[competitor], scoreTemplate, tbody, (i++ % 2));
            
        }
      
    },
    
    construct: function () {}
    
});



var BC_Ogsi = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-ogsi',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'ogsi',
    
    processData: function() {
      
        var holder = this.getContentDom(),
        ogsi = this.data.ogsi;
        
        
        if (ogsi) {
            holder.find('.ogsi-score-value').text(ogsi.ogsi.value);
            holder.find('.ogsi-score-change .change-value').text(ogsi.ogsi.change + '%');
            holder.find('.ogsi-score-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.ogsi.change >= 0) ? 'positive': 'negative');
                
            holder.find('.ogsi-rating-value').text(ogsi.rating.value);
            holder.find('.ogsi-rating-change .change-value').text(ogsi.rating.change + '%');
            holder.find('.ogsi-rating-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.rating.change >= 0) ? 'positive': 'negative');
            holder.find('.ogsi-rating-stars-on').css('width', (ogsi.rating.value / 5) * 100 + '%');

            holder.find('.ogsi-reviews-value').text(ogsi.reviews.value);
            holder.find('.ogsi-reviews-change .change-value').text(ogsi.reviews.change + '%');
            holder.find('.ogsi-reviews-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.reviews.change >= 0) ? 'positive': 'negative');
            holder.show();
            
            var distribution = ogsi.distribution;
            var barHolder = holder.find('.bar-holder');
            
            var maxValue = Math.max(distribution.negative, distribution.positive, distribution.negative);
            
            var ratio;
            if (distribution.total) {
                barHolder.show();
                var bar = barHolder.find('.bar-negative');
                bar.children('.bar-value').text('');
                if (distribution.negative > 0) {
                    
                    ratio = (distribution.negative / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.negative);
                }
                bar = barHolder.find('.bar-neutral');
                bar.children('.bar-value').text('');
                if (distribution.neutral > 0) {
                    
                    ratio = (distribution.neutral / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.neutral);
                
                    bar.css('width', ((distribution.neutral + distribution.positive)/distribution.total)*100+'%');
                    bar.show();
                } else if (distribution.positive > 0) {
                    bar.css('width', ((distribution.positive)/distribution.total)*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }
                bar = barHolder.find('.bar-positive');
                bar.children('.bar-value').text('');
                if (distribution.positive > 0) {
                    
                    ratio = (distribution.positive / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.positive);
                    
                    bar.css('width', (distribution.positive/(distribution.neutral + distribution.positive))*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }
                
            } else {
                barHolder.hide();
            }
            
            
        }
      
    },
    
    
    construct: function () {}
    
});

var BC_Photos = BoxController.extend({
    
    boxId: 'box-photos',
    endpoint: 'photos',
    
    processData: function() {
        
    },
    construct: function() {}
    
});

var BC_Videos = BoxController.extend({
    
    boxId: 'box-videos',
    endpoint: 'videos',
    
    processData: function() {
        
    },
    construct: function() {}
    
});

var BC_OgsiCurrent = BoxController.extend({
    
    
    boxId: 'box-ogsi-current',
    endpoint: 'ogsi',
    
    processData: function() {

        var holder = this.getContentDom(),
        ogsi = this.data.ogsi,
        distribution = ogsi.distribution,
        barHolder = holder.find('.bar-holder'),
        maxValue = Math.max(distribution.negative, distribution.positive, distribution.negative),
        ratio;
        
        if (ogsi) {
            
            holder.find('.days').text(getPeriodInDays(this.range['period']));
            
            holder.find('.ogsi-score-value').text(ogsi.ogsi.value);
            holder.find('.ogsi-score-change .change-value').text(ogsi.ogsi.change + '%');
            holder.find('.ogsi-score-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.ogsi.change >= 0) ? 'positive': 'negative');
                
            holder.find('.ogsi-rating-value').text(ogsi.rating.value);
            holder.find('.ogsi-rating-change .change-value').text(ogsi.rating.change + '%');
            holder.find('.ogsi-rating-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.rating.change >= 0) ? 'positive': 'negative');
            holder.find('.ogsi-rating-stars-on').css('width', (ogsi.rating.value / 5) * 100 + '%');

            holder.find('.ogsi-reviews-value').text(ogsi.reviews.value);
            holder.find('.ogsi-reviews-change .change-value').text(ogsi.reviews.change + '%');
            holder.find('.ogsi-reviews-change .change-arrow')
            .removeClass('positive')
            .removeClass('negative')
            .addClass((ogsi.reviews.change >= 0) ? 'positive': 'negative');
            holder.show();
            
            if (distribution.total) {
                barHolder.show();
                var bar = barHolder.find('.bar-negative');
                bar.children('.bar-value').text('');
                if (distribution.negative > 0) {
                    
                    ratio = (distribution.negative / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.negative);
                }
                bar = barHolder.find('.bar-neutral');
                bar.children('.bar-value').text('');
                
                if (distribution.neutral > 0) {
                    
                    ratio = (distribution.neutral / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.neutral);
                
                    bar.css('width', ((distribution.neutral + distribution.positive)/distribution.total)*100+'%');
                    bar.show();
                    
                } else if (distribution.positive > 0) {
                    
                    bar.css('width', ((distribution.positive)/distribution.total)*100+'%');
                    bar.show();
                    
                } else {
                    bar.hide();
                }
                
                
                bar = barHolder.find('.bar-positive');
                bar.children('.bar-value').text('');
                if (distribution.positive > 0) {
                    
                    ratio = (distribution.positive / maxValue) * 100;
                    
                    if(ratio > 5)
                        bar.children('.bar-value').text(distribution.positive);
                    
                    bar.css('width', (distribution.positive/(distribution.neutral + distribution.positive))*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }
                
            } else {
                barHolder.hide();
            }
            
            
        }  
        
    },
    
    construct: function() {}
    
});

var BC_TagsAnalysis = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-tags-analysis',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'tags',
    
    
    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }
        
        var graphHolder = this.getGraphHolder();
        
        var graphHolderId = graphHolder.attr('id');
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                margin: [0, 0, 30, 0],
                defaultSeriesType: 'pie'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                }
            },
            title: '',
            exporting: {enabled: false},
            credits: {
                enabled: false
            },
            legend: {
                borderRadius: 0
            },
            series: [{
                type: 'pie',
                name: 'Tags use',
                data: []
            }]
        };
        for (var i = 0; i < this.graphData.length; i++) {
            options.series[0].data.push(new Array(
                this.graphData[i].keyword,
                this.graphData[i].percent
                ));
        }
        
        this.graph = new Highcharts.Chart(options);
    },
    
    processData: function() {
        
        var tags = this.data.tags;
        this.graphData = tags;
        
        var table = this.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr:first').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < tags.length; i++) {
            tr = trTemplate.clone();
            for (n in tags[i]) {
                var value = tags[i][n];
                if (n == 'percent') {
                    value = value + '%';
                } 
                tr.find('td.col-' + n).text(value);
            }
            table.find('tbody').append(tr);
        }
        
    },
    
    construct: function () {}
    
});

var BC_ReviewSites = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-review-sites',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'sites',
    
    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var graphHolder = $('#' + graphHolderId);
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                defaultSeriesType: 'bar'
            },
            title: {
                text: ''
            },
            colors: [
            '#80699B', 
            '#AA4643', 
            '#4572A7', 
            '#89A54E', 
            '#3D96AE', 
            '#DB843D', 
            '#92A8CD', 
            '#A47D7C', 
            '#B5CA92'
            ],
            xAxis: {
                categories: [],
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            legend: {
                verticalAlign: 'bottom',
                borderWidth: 1,
                borderRadius: 0,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            exporting: {enabled: false},
            series: [{
                name: 'Negative',
                data: [],
                color: '#be1622',
                shadow: false
            }, {
                name: 'Neutral',
                data: [],
                color: 'rgb(243,190,0)',
                shadow: false
            }, {
                name: 'Positive',
                data: [],
                color: '#218D48',
                shadow: false
            }]
        }
        
        for (var i = 0; i < this.graphData.length; i++) {
            var site = this.graphData[i];
            options.xAxis.categories.push(site.site);
            options.series[0].data.push(site.negative);
            options.series[1].data.push(site.neutral);
            options.series[2].data.push(site.positive);
        }
        
        this.graph = new Highcharts.Chart(options);
    },
    
    processData: function() {
        
        var table = this.getContentDom().find('.data-grid-holder > table'),
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null,
        trFooter = table.find('tfoot tr'),
        sites = this.data.sites;
        
        this.graphData = sites;
        
        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();
        
        
        
        for (var i = 0; i < sites.length; i++) {
            tr = trTemplate.clone();
            for (n in sites[i]) {
                var value = sites[i][n];
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
            sites.length
            );  
        
    },
       
    construct: function () {}
    
});

/**
 * @TODO make html markup more generic, correcponding to row-detail partial
 */
var BC_ReviewInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-recent-reviews',
    
    endpoint: 'reviews',


    /**
     * this method populate every row of collapsed messages
     * based on specific message template
     *
     */
    prepareMessage: function(template, message) {
        
        template = template.clone();
        var currentId = parseInt(message.id);
        template.addClass('collapsed').attr('data-row-id', currentId);
        
        for(key in message)
        {
            var value = message[key];
            var col = template.find('td.col-' + key);
            var titleLink;
            switch(key) {
                
                case 'date':
                    var tmpDate = new Date(value * 1000);
                    var formatted = monthNames[tmpDate.getMonth()] +
                    ' ' + tmpDate.getDate();
                    col.text(formatted);
                    break;
                case 'title':
                    titleLink = $('<a href="#" class="title"></a>');
                    titleLink.text(value);
                    
                    col = col.find('div.in');
                    
                    col.html(titleLink);
                    col.prepend('<a href="#" class="expand"></a>');
                    break;
                case 'score':
                    var ratingStars = $('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><span>' + value + ' stars</span></div></div>');
                    col.html(ratingStars);
                    break;
                case 'status':
                    
                    value = value.toLowerCase();
                    
                    var icon = value == 'open' ? '&nbsp;' : (value == 'closed' ? ' x ' : '!');
                    
                    var reviewStatus = $('<div class="reviewStatus reviewStatus-' + value + '"><span>[ ' + icon + ' ]</span></div>');
                    col.html(reviewStatus);
                    break;
                default:
                    col.text(value);
                    break;
                
            }

        }
        
        return template
        
    },

    /**
     * redefinie this function on every class to ensure population of data from
     * callback
     *
     */
    customPopulateFields: function(text, data) {
        
        var message = text.review,
        tr = $(data.trContext),
        status = message.status.toLowerCase(),
        self = tr;
        
        tr.find('.recent-review-status-icon')
        .removeClass('open closed todo')
        .addClass(status);
        
        tr.find('.review-details-title').text(message.title);
        tr.find('.review-details-content').text(message.content);
        
        tr.find('.action-completed').bind('click', function(e) {
            
             e.preventDefault();
            
             $(this).remove();
             
             tr.find('.action-todo').remove();
            
             data.context.genericRequest('review' + '/status/' + data.id, {
                 status: 'CLOSED'
             }, function() {
                
                tr.find('.recent-review-status-icon')
                .removeClass('open closed todo')
                .addClass('closed');
                
                var reviewStatus = $('<div class="reviewStatus reviewStatus-closed"><span>[ x ]</span></div>');
                tr.prev().find('.col-status').html(reviewStatus); 
                 
             })
            
        });
        
        tr.find('.action-todo').bind('click', function(e) {
            
            e.preventDefault();
            
            $(this).remove();
             
            tr.find('.action-complete').remove();
            
            data.context.genericRequest('review' + '/status/' + data.id, {
                status: 'TODO'
            }, function() {
                
                tr.find('.recent-review-status-icon')
                .removeClass('open closed todo')
                .addClass('todo');
                
                var reviewStatus = $('<div class="reviewStatus reviewStatus-todo"><span>[ ! ]</span></div>');
                tr.prev().find('.col-status').html(reviewStatus); 
                 
            })
            
        });


        if(status == 'closed') {
            tr.find('.actions-todo, .actions-completed').remove();
        }
        else
            tr.find('.actions-' + status).remove();
        
        
        tr.find('select[name="category"]').val(message.category)
        .bind('change', 
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback, 
                {
                    id: data.id,
                    endpoint: 'review/category',
                    name: 'category',
                    context: data.context
                }
                )
            );
        
        tr.find('input[name="tags"]').val(message.tags.join(', '))
        .bind('save', 
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback, 
                {
                    id: data.id,
                    endpoint: 'review/tags',
                    name: 'tags',
                    context: data.context
                }
                )
            );
        tr.find('textarea[name="notes"]').val(message.notes)
        .bind('save', 
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback, 
                {
                    id: data.id,
                    endpoint: 'review/notes',
                    name: 'notes',
                    context: data.context
                }
                )
            );
        
        tr.find('.save-button').bind('click', function(e) {
            
            $.each(['tags', 'notes'], function() {
                
                self.find('*[name=' + this + ']').trigger('save');
                
            });
            
        });
        
    },

    expandedPopulateCallback: function(data) {
      
      // we need to populate selectbox before we fetch another data
      data.context.genericRequest('review' + '/categories', {}, function(response) {
        
            var select = data.trContext.find('.review-categories').empty();
            var option = $('<option />');
            $.each(response.categories, function(i, item) {

               select.append(option.clone().val(i).text(item));
               
            });
            
            data.customPopulateFields = this.reviewPopulate;
            
            data.context.genericRequest('review' + '/expand/' + data.id, {}, 
            data.context.genericCallbackEventWrapper(
                data.context.populateFields, 
                data
                ));
        
        });
      
    },
    
    
    loadInboxData: function () {
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var trTemplate = table.find('tbody tr:first').clone().removeClass('odd even border');
        var trContentTemplate = table.find('tbody:first > tr:last').clone();
        var tr = null;
        var trContent = null;
        table.find('tbody tr').remove();
        var data = this.data.reviews;
        for (var i = 0; i < data.length; i++) {
            
            var currentId = parseInt(data[i].id);
                      
            trContent = trContentTemplate.clone().attr('data-row-id', currentId)
            .bind('expand',this.genericCallbackEventWrapper(
                this.expandedPopulate, 
                {
                    context:this, 
                    id: currentId
                }
                )
            );
            
            tr = this.prepareMessage(trTemplate, data[i]);
            
            
            if (i % 2) {
                tr.addClass('odd');
            } else {
                tr.addClass('even');
            }
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', currentId);
            tr.find('td.col-checkbox').html(checkbox);
            
            
            table.children('tbody').append(tr); // append two elements
            table.children('tbody').append(trContent); // append two elements
            
        }
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().find('.data-grid-holder').show();
        
        
    },
    
    construct: function () {}
    
});


var BC_SocialActivity = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/activity',

    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                defaultSeriesType: 'bar'
            },
            title: {
                text: ''
            },
            colors: [
            '#80699B', 
            '#AA4643', 
            '#4572A7', 
            '#89A54E', 
            '#3D96AE', 
            '#DB843D', 
            '#92A8CD', 
            '#A47D7C', 
            '#B5CA92'
            ],
            xAxis: {
                categories: [],
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    colorByPoint: true
                }
            },
            exporting: {enabled: false},
            series: []
        }
         
        var data = [];
        

        
        for (var i = 0; i < this.graphData.length; i++) {
            
            var site = this.graphData[i];
            
            data.push(site.value);
            options.xAxis.categories.push(site.network);
            
            
        }
        
        options.series.push({
            name: 'value',
            data: data
        });
        
        
        this.graph = new Highcharts.Chart(options);
    },

    processData: function() {
        
        var networks = this.data.networks,
        table = this.getContentDom().find('.data-grid-holder > table'),
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null;
        
        this.graphData = networks;
        
        trFooter = table.find('tfoot tr');
        trFooter.find('th.col-value').text('0');
        table.find('tbody tr').remove();
        
        for (var i = 0; i < networks.length; i++) {
            tr = trTemplate.clone();
            for (n in networks[i]) {
                var value = networks[i][n];
                
                tr.find('td.col-' + n).text(value);
                if (n != 'network') {
                    var currentTotalValue = 0;
                    if (n == 'average') {
                        currentTotalValue = parseFloat(trFooter.find('th.col-' + n).text());
                    } else {
                        currentTotalValue = parseInt(trFooter.find('th.col-' + n).text());
                    }
                    trFooter.find('th.col-' + n).text(value + currentTotalValue);
                }
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            table.find('tbody').append(tr);
        }
        trFooter.find('th.col-average').text(
            parseFloat(trFooter.find('th.col-average').text()) / 
            networks.length
            );
        
    },
   
    construct: function() {}
    
});

var BC_SocialSubscribers = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-reach',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/subscribers',
    
    
    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                defaultSeriesType: 'bar'
            },
            title: {
                text: ''
            },
            colors: [
            '#80699B', 
            '#AA4643', 
            '#4572A7', 
            '#89A54E', 
            '#3D96AE', 
            '#DB843D', 
            '#92A8CD', 
            '#A47D7C', 
            '#B5CA92'
            ],
            xAxis: {
                categories: [],
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    colorByPoint: true
                }
            },
            exporting: {enabled: false},
            series: []
        }
         
        var data = [];
        

        
        for (var i = 0; i < this.graphData.length; i++) {
            
            var site = this.graphData[i];
            
            data.push(site.value);
            options.xAxis.categories.push(site.network);
            
            
        }
        
        options.series.push({
            name: 'value',
            data: data
        });
        
        
        this.graph = new Highcharts.Chart(options);
    },
    
    processData: function() {
        
        var table = this.getContentDom().find('.data-grid-holder > table'),
        networks = this.data.networks,
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null,
        trFooter = table.find('tfoot tr');
        
        this.graphData = networks;
        trFooter.find('.col-value, .col-total').text('0');
        
        table.find('tbody tr').remove();
        for (var i = 0; i < networks.length; i++) {
            tr = trTemplate.clone();
            for (n in networks[i]) {
                var value = networks[i][n];
                if (n == 'change') {
                    value = value + '%';
                }
                else if (n == 'value' || n == 'total') {
                    var currentTotalValue = 0;
                    currentTotalValue = parseFloat(trFooter.find('th.col-' + n).text());
                    trFooter.find('th.col-' + n).text(value + currentTotalValue);
                }
                
                tr.find('td.col-' + n).text(value);
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            table.find('tbody').append(tr);
        }
        
    },
    
    construct: function () {}
    
});

var BC_CompetitionReviewInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-competition-review-inbox',
    
    endpoint: 'competition_ledger',

    
    prepareMessage: function(template, message) {
        
        template = template.clone();
        var currentId = parseInt(message.id);
        template.addClass('collapsed').attr('data-row-id', currentId);
        
        for(key in message)
        {
            var value = message[key];
            var col = template.find('td.col-' + key);
            var titleLink;
            switch(key) {
                
                case 'submitted':
                    var tmpDate = new Date(value * 1000);
                    var formatted = monthNames[tmpDate.getMonth()] +
                    ' ' + tmpDate.getDate();
                    col.text(formatted);
                    break;
                case 'title':
                    titleLink = $('<a href="#" class="title"></a>');
                    titleLink.text(value);
                    
                    col = col.find('div.in');
                    
                    col.html(titleLink);
                    col.prepend('<a href="#" class="expand"></a>');
                    break;
                case 'rating':
                    var ratingStars = $('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><span>' + value + ' stars</span></div></div>');
                    col.html(ratingStars);
                    break;
                default:
                    col.text(value);
                    break;
                
            }

        }
        
        return template
        
    },
    
    /**
     * redefinie this function on every class to ensure population of data from
     * callback
     *
     */
    customPopulateFields: function(text, data) {
        
        var message = text.competition;
        
        var tr = $(data.trContext);
        
        tr.find('.details-title').text(message.title);
        tr.find('.details-review').text(message.review);
        tr.find('.details-network').addClass(message.network.toLowerCase());
        
    },

    expandedPopulateCallback: function(data) {

            
            data.context.genericRequest('competition' + '/expand/' + data.id, {}, 
            data.context.genericCallbackEventWrapper(
                data.context.populateFields, 
                data));
      
    },
    
    loadInboxData: function () {
        
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var trTemplate = table.find('tbody tr:first').clone().removeClass('odd even border');
        var trContentTemplate = table.find('tbody:first > tr:last').clone();

        var tr = null;
        var trContent = null;
        table.find('tbody tr').remove();
        
        var data = this.data.competitions;
        
        for (var i = 0; i < data.length; i++) {
            
            var currentId = parseInt(data[i].id);
            
            trContent = trContentTemplate.clone().attr('data-row-id', currentId)
            .bind('expand',this.genericCallbackEventWrapper(
                this.expandedPopulate, 
                {
                    context:this, 
                    id: currentId
                }
                )
            );
            tr = this.prepareMessage(trTemplate, data[i]);
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', data[i].id);
            tr.find('td.col-checkbox').html(checkbox);
            
            table.find('tbody').append(tr, trContent); // append two elements
        }
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().find('.data-grid-holder').show();
    },
    
    construct: function () {}
    
});


var BC_CompetitionComparision = BC_LinearGraphBoxController.extend({
   
    boxId: 'box-competition-comparision',
    series: [],
    endpoint: 'comparision',
    seriesLabels: [],
    firstTimestamp: null,
    pointInterval: null,
    scaleFactor: null, // scale factor computed from date interval
    dayInterval: 3600 * 24, // day in seconds
    
    formatterCallback: function() {
                        
        var dateFormat;
        var box = boxManager.getBox('box-competition-comparision');
        switch(box.range['period']) {
            case '1m':
                dateFormat = '%a %e';
                break;
            case '3m':
                dateFormat = '%d %b';
                break;
            case '6m':
                dateFormat = '%d %b';
                break;
            case '1y':
                dateFormat = '%b %Y';
                break;
        }
                        
        return Highcharts.dateFormat(dateFormat, this.value);                  
    },
    
    
    populateGraph: function() {
        
        var seriesMappings = []; // maapping of label values to corresponding series index
        var seriesMappingInited = false;
        this.series = [];
        for (var tKey in this.graphData.comparision) {
            
            var timeObject = this.graphData.comparision[tKey];
            
            for (var cKey in timeObject) {
            
                var comparisionObject = timeObject[cKey];
                
                if(!seriesMappingInited)
                {
                    // set specific options to each spline
                    // all timestamps must be expand to miliseconds
                    
                    seriesMappings[comparisionObject.competition] = this.series.length;
                    
                    this.series.push({
                        name: comparisionObject.competition, 
                        data: [], 
                        pointStart: this.getFirstDate(),
                        pointInterval: (this.computeDateInterval()) * this.dayInterval * 1000
                    });
                    
                }
                
                this.maxValue = this.maxValue < comparisionObject.value 
                ? comparisionObject.value : this.maxValue;
                
                // add series single data to right place based on previously defined
                // mappings
                this.series[seriesMappings[comparisionObject.competition]]
                .data.unshift(parseInt(comparisionObject.value, 10));
            
            }
            
            
            if(!seriesMappingInited) {
                seriesMappingInited = true;
            }
        }
     
    },
    
    loadData: function() {
      
        this.loadGraphData();
      
    },
   
    construct: function() {}
   
});

var BC_CompetitionDistribution = BC_GraphBoxController.extend({
 
    boxId: 'box-competition-distribution',
 
    endpoint: 'distribution',
 
    prepareGraph: function () {
        if (!this.data) {
            return;
        }
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var graphHolder = $('#' + graphHolderId);
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                type: 'bar'
            },
            title: '',
            xAxis: {
                categories: [],
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {text: ''}
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            legend: {
                verticalAlign: 'bottom',
                borderWidth: 1,
                borderRadius: 0,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            exporting: {enabled: false},
            series: [{
                name: 'Negative',
                data: [],
                color: '#be1622',
                shadow: false
            }, {
                name: 'Neutral',
                data: [],
                color: 'rgb(243,190,0)',
                shadow: false
            }, {
                name: 'Positive',
                data: [],
                color: '#218D48',
                shadow: false
            }]
        }
        
        for (var i = 0; i < this.graphData.length; i++) {
            var dist = this.graphData[i];
            options.xAxis.categories.push(dist.dealership);
            options.series[0].data.push(dist.negative);
            options.series[1].data.push(dist.neutral);
            options.series[2].data.push(dist.positive);
        }
        
        this.graph = new Highcharts.Chart(options);
    },
 
    processData: function() {
        
        
        var distribution = this.data.distribution,        
        table = this.getContentDom().find('.data-grid-holder > table'),        
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null,
        trFooter = table.find('tfoot tr');
        
        this.graphData = distribution;
        
        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();
        for (var i = 0; i < distribution.length; i++) {
            tr = trTemplate.clone();
            for (n in distribution[i]) {
                var value = distribution[i][n];
                
                tr.find('td.col-' + n).text(value);
                if (n != 'dealership') {
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
            distribution.length
            );
        
    },
 
    construct: function() {}
 
 
 
});

var BC_SocialMediaInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-media-inbox',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'socials',
    

    prepareMessage: function(template, message) {
        
        template = template.clone();
        template.addClass('collapsed').attr('data-row-id', message.id);
        
        for(key in message)
        {
            var value = message[key];
            var col = template.find('td.col-' + key);
            var titleLink;
            switch(key) {
                
                case 'submitted':
                    var tmpDate = new Date(value * 1000);
                    var formatted = monthNames[tmpDate.getMonth()] +
                    ' ' + tmpDate.getDate();
                    col.text(formatted);
                    break;
                case 'title':
                    titleLink = $('<a href="#" class="title"></a>');
                    titleLink.text(value);
                    
                    col = col.find('div.in');
                    
                    col.html(titleLink);
                    col.prepend('<a href="#" class="expand"></a>');
                    break;
                case 'network':
                    titleLink = $('<a href="#"><span>' + value.toLowerCase() + '</span></a>');
                    titleLink.attr('class', value.toLowerCase());
                    titleLink.filter('span').text(value);
                    col.html(titleLink);
                    break;
                default:
                    col.text(value);
                    break;
                
            }

        }
        
        return template
        
    },
    
    /**
     * redefinie this function on every class to ensure population of data from
     * callback
     *
     */
    customPopulateFields: function(text, data) {
        
        var message = text.social;
        
        var tr = $(data.trContext);
        
        tr.find('.details-title').text(message.title);
        tr.find('.details-review').text(message.review);
        tr.find('.details-network').addClass(message.network.toLowerCase());
        
    },

    expandedPopulateCallback: function(data) {

            
            data.context.genericRequest('social' + '/expand/' + data.id, {}, 
            data.context.genericCallbackEventWrapper(
                data.context.populateFields, 
                data));
      
    },
    
    
    loadInboxData: function () {
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var trTemplate = table.find('tbody tr:first').clone().removeClass('odd even border');
        var trContentTemplate = table.find('tbody:first > tr:last').clone();
        var tr = null;
        var trContent = null;
        table.find('tbody tr').remove();
        var data = this.data.socials;
        for (var i = 0; i < this.data.socials.length; i++) {
            
            var currentId = parseInt(data[i].id);
            
            trContent = trContentTemplate.clone().attr('data-row-id', currentId)
            .bind('expand',this.genericCallbackEventWrapper(
                this.expandedPopulate, 
                {
                    context:this, 
                    id: currentId
                }
                )
            );
            
            tr =this.prepareMessage(trTemplate, this.data.socials[i]);
            
            if (i % 2) {
                tr.addClass('odd');
            } else {
                tr.addClass('even');
            }
            
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', this.data.socials[i].id);
            tr.find('td.col-checkbox').html(checkbox);
            
            table.children('tbody').append(tr); // append two elements
            table.children('tbody').append(trContent); // append two elements
            
        }
    },
    
    construct: function () {}
    
});

boxManager = {
    collection: {},
    section_id: null, // the name of selected tab
    
    dataProvider: null,

    range: null,
    
    positions: null, //positions of boxes from db
    
    exporter: null, // exporter class for dynamic exporting
    
    add: function (box) {
        if (
            (box instanceof BoxController) 
            && box.getBoxId() 
            && box.endpoint 
            && box.getContentDom().length
            )
            {
            if (!box.dataProvider && this.dataProvider) {
                box.setDataProvider(this.dataProvider);
            }
            this.collection[box.getBoxId()] = box;
        } else {
            delete box;
        }
        return this;
    },
    
    getBox: function (id) {
        if (this.collection[id]) {
            return this.collection[id];
        }
        return false;
    },
    
    droppable: function(selector) {
        
        return {
            accept: selector,
            activeClass: "box-dropable",
            hoverClass: "box-drag-over",
            drop: function (event, ui) {
                
                var oldBox = $(this),
                fromContainer = ui.draggable.parent(),
                collection = {},
                holder_id = $(this).attr('id'),
                swap_holder_id = fromContainer.attr('id');
                
                // if there is any child we need to swap the dragged child with holder child
                if (oldBox.children().length > 0) {
                    
                    collection[swap_holder_id] = {
                        
                        box_id: $(oldBox).children().attr('id'),
                        location_id: 1,
                        box_class: fromContainer.attr('class')
                  
                    };
                    
                    collection[holder_id] =
                    {
                        box_id: $(ui.draggable).attr('id'),
                        location_id: 1,
                        box_class: $(this).attr('class')
                    };
                    

                    fromContainer.append(oldBox.children());
                    
                    
                    
                } 
                else 
                {
                    collection[holder_id] =
                    {
                        holder_id: holder_id,
                        box_id: $(ui.draggable).attr('id'),
                        location_id: 1,
                        box_class: $(this).attr('class'),
                        section_id: boxManager.section_id
                    };
                    
                    fromContainer.addClass('empty').removeClass('active');    
                }
                $(this).append(ui.draggable);
            
                $(this).removeClass('empty').addClass('active');

                
                if(!boxManager.positions[holder_id]) {
                    collection[holder_id].delete_previous = true;

                }

                boxManager.genericRequest('/api/box/move', $.param({
                    holders: collection
                }));
                

            }
        }
    },
    initDragAndDrop: function() {
      
        var self = this;
      
        $( "#boxes-holder .box" ).draggable({ 
            snap: ".box-container", 
            snapMode: 'inner',
            handle: ".box-header-button-move",
            cursor: 'move',
            helper: function() {
              return $('<div />', {
                  css: {
                      width: $(this).width()-14,
                      background: '#fff',
                      padding: '10px',
                      border: '1px solid gray',
                      'font-size': '14px',
                      'font-weight': 'bold',
                      height: '30px'
                  }
              }).text($(this).find('.box-header-title').text());
            },
            appendTo: 'body',
            zIndex: 10,
            start: function(event, ui) {
                
                // show only holders that can really contain dragged box
                var filter = $(this).parent().is('.box-container-left, .box-container-right') ?
                    $('.box-container.empty.box-container-left, .box-container.empty.box-container-right')
                    :
                    $('.box-container.empty').not('.box-container-left, .box-container.empty.box-container-right');
                
                filter.addClass('box-dropable');
            },
            stop: function (event, ui) {
                $(this).css({
                    bottom: 0,
                    left: 0,
                    width: 'auto'
                });
                
                $('.box-container.empty').removeClass('box-dropable');
            }
        });
        
        
        $('.box-container').each(function() {
            
            
            var filter = $(this).is('.box-container-left, .box-container-right') ?
                    '.box-container.box-container-left .box, .box-container.box-container-right .box'
                    :
                    '.box-container:not(.box-container-left, .box-container-right) .box';
            
            if(!$(this).children().length) {
                $(this).removeClass('active').addClass('empty');
            }
            
            $(this).droppable(self.droppable(filter));
            
        })
      
    },
    
    genericRequest: function(endpoint, data, callback) {
                 
        $.ajax({
            type: "POST",
            accepts: "application/json; charset=utf-8",
            data: data,
            dataType: "json",
            url: endpoint,
            success: callback
        });
      
    },

    initHolders: function() {
        
        var self = this,
        settings = {};
        settings.holders = [];

        $('.box-container').each(function() {
            
            var id = self.section_id  + '-' + $(this).index();
            
            $(this).addClass('hide');
            $(this).attr('id', id);
            
            
            if($(this).is(':parent')) {
              
                settings.holders.push({
                  
                    holder_id: this.id,
                    box_id: $(this).find('.box').attr('id'),
                    location_id: 1,
                    section_id: self.section_id,
                    box_class: $(this).attr('class')
                  
                });
            }
        });
      
      
        this.genericRequest('/api/box/positions/' + this.section_id, $.param(settings), function(data) {
          
            self.positions = data;
           
            var populated = {};
           
            for(var box in data) {
                
                var j = data[box],
                current = self.collection[j.box_id];
                
                populated[j.box_id] = true;
                
                box_holder = current.getBoxDom().parent();
                holder_id = box_holder.attr('id');
                
                if(holder_id != j.holder_id) {
                    
                    var holder_2 = $('#' + j.holder_id);
                    var holder_2_box = holder_2.children();
                    
                    holder_2.html(current.getBoxDom());
                    holder_2.removeClass('empty').addClass('active');
                    box_holder.html(holder_2_box);
                    
                    
                }
                
                current.init();
                
            }
            
            for (var i in boxManager.collection) {
             
                if(populated[i]) 
                    continue;
                
                boxManager.collection[i].init();
            }
           
            self.initDragAndDrop();
            $('.box-container').removeClass('hide');
          
        });
      
      
    },

    init: function () {
        
        this.section_id = $('.top-menu-item.active')
            .text()
            .toLowerCase()
            .replace(/\s+/g,"_");
        
        var rangeArray = $('#range-form').serializeArray();
        var range = {};
        
        for (var i = 0; i < rangeArray.length; i++) {
            range[rangeArray[i].name] = rangeArray[i].value;
        }
        this.setRange(range);
        
        var self = this;
        $('#range-form').submit(function (e) {
            
            e.preventDefault();
            var range = {};
            var rangeArray = $(this).serializeArray();
            for (var i = 0; i < rangeArray.length; i++) {
                range[rangeArray[i].name] = rangeArray[i].value;
            }
            self.setRange(range);
            self.clearData();
            self.refresh();

        }).find('#period-selector, #date-selector').change(function () {
            $(this).parents('form:first').submit();
        });
        
        this.initHolders();
    
    
    return this;
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
    
    return this;
},
    
refresh: function () {
    for (i in this.collection) {
        this.collection[i].refresh();
    }
    return this;
},
    
setDataProvider: function (dataProvider) {
    this.dataProvider = dataProvider;
    for (i in this.collection) {
        this.collection[i].setDataProvider(dataProvider);
    }
    return this;
},
    
setExporter: function (exporter) {
      
    this.exporter = exporter;
      
    return this;
      
},
    
    
setFilter: function(filters) {
    for (i in this.collection) {
        this.collection[i].setFilter(filters);
    }
    return this;
},

setRange: function(range) {
    this.range = range;
    for (i in this.collection) {
        this.collection[i].setRange(this.range);
    }
    return this;
},
    
setDateInterval: function (dateInterval) {
    for (i in this.collection) {
        this.collection[i].setDateInterval(dateInterval);
    }
    return this;
},
    
clearData: function () {
    for (i in this.collection) {
        this.collection[i].clearData();
    }
    return this;
},
    
    /**
     * get all boxes from manager and fetch graph, inbox and tabular data
     */
    exportBoxes: function () {
      
        for (i in this.collection) {

            var block;
            var content;
            var box = this.collection[i];
        
            if(box.ignore)
                continue;

            if(!box.getBoxDom().parent().is('.box-container-left, .box-container-right')) {
                block = Exporter.template.blockWide.clone();
            }
            else
                block = Exporter.template.block.clone();
            

            if(box.hasOwnProperty('graph')) {
                
                var block2 = block.clone();
                var content2 = box.graph.getSVG();
                var title2 = $("<h2/>").text(box.getHeaderDom().find('.box-header-title').text());
            
                title2.add(content2).appendTo(block2.find('.inner'));

                block2.appendTo(this.exporter.template.container);
                
            }
        
            content = box.getContentDom()
            .find('.data-grid-holder table:visible:first').clone();
            
            content.find('tr.expanded').remove();

            content.find('td').removeAttr('style');
        
            if(content.length) {
                var title = $("<h2/>").text(box.getHeaderDom()
                    .find('.box-header-title').text());
                title.add(content).appendTo(block.find('.inner'));
                block.appendTo(this.exporter.template.container);
            }
 
        }
 
        this.exporter.submit();

    }
};


$(document).ready(function () {
    boxManager.add(new BC_TagsAnalysis())
    .add(new BC_Ogsi())
    .add(new BC_ReviewSites())
    .add(new BC_ReviewInbox())
    .add(new BC_SocialActivity())
    .add(new BC_SocialSubscribers())
    .add(new BC_SocialMediaInbox())
    .add(new BC_CompetitionDistribution())
    .add(new BC_CompetitionComparision())
    .add(new BC_CompetitionReviewInbox())
    .add(new BC_RecentActivity())
    .add(new BC_CompetitionScore())
    .add(new BC_OgsiCurrent())
    .add(new BC_Photos())
    .add(new BC_Videos())
    .setDataProvider(new DataProvider())
    .setExporter(Exporter)
    .init();
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


var Exporter = {

    options: {
        action: "/api/static/export",
        width: 380
    },
        
    template: {
            
        block: $('<div class="block"><div class="inner"></div></div>'),
        blockWide: $('<div class="block2"><div class="inner"></div></div>'),
        container: $('<div id="page"></div>')
            
    },
       
    submit: function() {
            
            
        var H = Highcharts;
        var self = this;
            
        var options = H.merge(this.options, H.getOptions()['exporting']);
            
        var form = H.createElement('form', {
            method: 'POST',
            action: options.action
        }, {
            display: 'NONE'
        }, document.body);
            
            
        H.createElement('input', {
            type: 'HIDDEN',
            name: 'html',
            value: self.template.container.html()
        }, null, form);
            
        form.submit();
            
            
        H.discardElement(form);
            
        this.template.container = $('<div id="page"></div>');

    }
    
};