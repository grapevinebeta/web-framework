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

/**
 * this object helps to extend default behaviour of each objects
 *
 */   

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


/**
 * this varaible stores all boxes that should be handled by application logic
 *
 */
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
     * @var When no data is return by endpoints this variable should be set to true
     * and the afterLoadData method should handle this state
     */

    empty: false,


    /**
     * when this variable is set to true it will use custom endpoints instead of shorthand one
     *
     */
    noApiUrl: false,

    /**
     * we need template to cache the original layout of box and recover it after
     * no data indicator that will clear the content
     */

    template: null,

    construct: function () {},

    init: function () {

        $.ajaxSetup({
            timeout: 10000
        });

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
     * if you want to make special actions when data is loaded you should reimplement this function
     */
    afterLoadDataCustom: function() {

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

            this.showNoData('.data-grid-holder', this.emptyMessage);
            this.afterLoadDataCustom();
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

                /*
                 * we need to take some precautionary measures to unsure that
                 * we correctly handle all empty endpoints
                 *
                 */
                boxController.data = data;

                // list of all variables that store data from endpoints
                var store = {
                    sites: 1,
                    tags: 1,
                    reviews: 1,
                    socials: 1,
                    networks: 1,
                    comparision: 1,
                    distribution: 1,
                    overall: 1,
                    current: 1
                };

                var ignore = {

                    filters: 1,
                    pagination: 1

                }

                for(var field in data) {

                    if(field in store) {

                        if(data[field] == false) {

                            if(!boxController.template) {


                                boxController.template =
                                boxController.getContentDom()
                                .children('.data-grid-holder').html();


                            }

                            // when no data is loaded this variable indicate it
                            boxController.empty = true;
                            boxController.afterLoadData();


                        }
                        else {


                            if(boxController.template !== null) {


                                boxController.getContentDom().children('.data-grid-holder').html(boxController.template);

                            }

                            boxController.empty = false;

                            boxController.processData();
                            boxController.afterLoadData();

                        }

                    }
                    else {

                        if(!(field in ignore)) {
                            boxController.processData();
                            boxController.afterLoadData();
                        }

                    }

                }

                if(!data) {
                    boxController.data = false;
                    boxController.empty = true;
                    boxController.emptyMessage =
                        "You need to activate Your facebook or twitter account in Account Settings";
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
        this.dataProvider.noApiUrl = this.noApiUrl;
    },

    resetFilters: function(name) {

        this.filters[name]  = [];

    },


    showNoData: function(id, message) {


        var holder = this.getContentDom().find(id).html(''),
        div, wrapper, span;

        message = message ? message :
            'Nothing heard through the Grapevine for the date range you selected. \n\
             Expand your date range to see more data.';

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

            span = '<span style="background: #fff; position: absolute; font-size: 10px;\n\
 font-weight: bold; left: 8px; bottom: -9px;">' + message +  '</span>';

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

            span = '<span style="font-size: 10px; font-weight: bold; left: 8px; bottom: -9px;">'
                + message +  '</span>';

        }


        div.html(span);
        wrapper.append(div);


        holder.html(wrapper);


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
    endpoint: '/api/box/social',

    ignore: true,

    processRow: function(row, template, timestamp) {

        var link1, link2;

        template.children('.date').text(helpers.formatDate(timestamp));

        link2 = $('<a/>', {
            href: row.link,
            target: '_blank',
            text: row.message.substr(0, 50) + '...'
        });

        template.children('.title').html(link2);

        link1 = $('<a href="#"><span></span></a>')
        .attr('class', row.network);

        template.children('.network').html(link1);
        template.children('.reply').attr(
        {
            href: row.link,
            target: '_blank'
        });

        return template;

    },
    
    
    /**
     * if you want to make special actions when data is loaded you should reimplement this function
     */
    afterLoadDataCustom: function() {

        if(!this.data)
            this.getBoxDom().hide();

    },

    processData: function() {
        var messages = this.data.messages, timestamp
        content = this.getContentDom().find('.data-grid-holder'),
        template = content.find('.row:first');
        content.find('.row').remove();

        var timestamps = [];

        for(timestamp in messages) {

            timestamps.push(timestamp);
        }

        timestamps.sort(function(a,b) {

           return a == b ? 0 : (a > b) ? -1 : 1;

        });

        for(var t in timestamps) {

            timestamp = timestamps[t];

            var row = messages[timestamp];

            if(row instanceof Array) {

                for(var subrow in row) {

                    content.append(this.processRow(row[subrow], template.clone(), timestamp));

                }

            }
            else
                content.append(this.processRow(row, template.clone(), timestamp));
        }

    },

    construct: function () {

        this.noApiUrl = true;


    }

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

        var period = this.range['period'], d;

        switch(period) {

            case '1m':
                d = Math.floor((getPeriodInDays(this.range['period']) )  / 6) + 1;
                break;
            case '3m':
                d = Math.floor((getPeriodInDays(this.range['period']) )  / 6) + 3.2;
                break;
            case '6m':
                d = Math.floor((getPeriodInDays(this.range['period']) )  / 6) + 6.2;
                break;
            case '1y':
                d = Math.floor((getPeriodInDays(this.range['period']) )  / 6) + 13;
                break;
            case 'all':

                var t = new Date();
                var tn = new Date();


                tn.setFullYear(1971, 1, 1);

                var diff = (t.getTime() - tn.getTime()) / (1000 * 3600 * 24)

                d = Math.floor(diff  / 6) + (diff/30);

                break;
            case 'ytd':

                var t = new Date();
                var tn = new Date();

                tn.setMonth(0, 1);

                var diff = (t.getTime() - tn.getTime()) / (1000 * 3600 * 24)

                d = Math.floor(diff  / 6) + (diff/31);
                break;
            default:

                var t = new Date(this.range['date']);
                var tn = new Date(this.range['period']);

                var diff = (tn.getTime() - t.getTime()) / (1000 * 3600 * 24);

                d = Math.floor(diff  / 6) + (diff/31);

                break;

        }


        return d
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
        .setDateInterval(6)
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
            .html('<p style="margin:5%;">Nothing heard through the Grapevine \n\
for the date range you selected. Expand your date range to see more data.</p>')
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

        return this.firstTimestamp = Date.parse(
            new Date(parsed.getFullYear(), parsed.getMonth(), parsed.getDate())
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
                max: 6,
                endOnTick: false
            },
            exporting: {enabled: false},

            series: this.series,

            plotOptions: {
                series: {
                    events: {
                        legendItemClick: function(event) {

                           return false;

                        }
                    }
                }
            }
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
    extraParams: null,

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
            else {
                self.addFilter(key , filter_value);
            }

            // reset pages
            self.currentPage = 1;
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

        self.getBoxDom().delegate("tr.collapsed","mouseenter mouseleave", function(event) {
            if (event.type == 'mouseenter') {

                self.getBoxDom().find('tr.collapsed .in > a.expand').removeClass('show');

                $(event.target).find('a.expand').addClass('show');

            }
            else {
                $(event.target).find('a.expand').removeClass('show');
            }

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

        for(var filter in filters) {

            if(!filters[filter].total && filter != 'Total')
                continue;

            var filterLink = $('<a href="#" data-filter-status="' +
                filters[filter].value + '"></a>');
            if (filters[filter].total) {
                filterLink.text(filters[filter].total +' ');
            }

            if(filters[filter].active == 1 && (filters[filter].total > 0 || (filter == 'Total' || filter == 'All'))) {

                filterLink.addClass('active');
                activeCount++;
            }

            if(filter == 'Total' || filter == 'All') {
                filterLink.addClass('show-all');
            }
            
            filterLink.text(filterLink.text() + filters[filter].value);
            filterHolder.append('<span class="separator">|</span> ');
            filterHolder.append(filterLink);

        }

        if(activeCount > 1) {

            filterHolder.find('.show-all').removeClass('active');

        }


    },

    loadInboxData: function() {
        alert('You must implement it by yourself');
    },

    initFilters: function(forceReload) {

        if(forceReload)
            return this.dataProvider.fetch();
            


        var filters = this.data.filters;


        if(filters)
        {

            for(var activeFilter in filters)
            {
                this.loadFilters(activeFilter);
            }
        }

    },

    afterLoadDataCustom: function() {

      this.initFilters(false);

    },

    processData: function() {

        this.loadInboxData();

        this.initFilters();

        this.initPager();

    },

    /**
     * Load Data by Ajax
     */
    loadData: function () {
        this.initEmailExport();
        this.beforeLoadData();

        this.dataProvider.setEndpoint(this.endpoint)
        .setDateRange(this.range)
        .setFilters(this.filters)
        .setDateInterval(null)
        .setPage(this.currentPage)
        .setExtraParams(this.extraParams)
        .setLimit(this.limit)
        .setCallback(this.loadDataCallback(this));

        this.data = this.dataProvider.fetch();

        return this;
    },

    /**
     * init modal box functionality with validation
     */
    initEmailExport: function() {

        var email = $("#email-export .from"),
        reply = $("#email-export .reply"),
        allFields = $( [] ).add( email, reply );

        $( "#email-export" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Send": function() {

                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && helpers.checkLength(reply, "Send to", 6, 80);
                    bValid = bValid && helpers.checkLength(email, "From Email", 6, 80);
                    var emails = reply.val().split(',');

                    bValid = bValid &&
                    helpers.checkRegexp(email,email.val(), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );

                    for(var e in emails) {
                        bValid = bValid &&
                        helpers.checkRegexp(reply,emails[e], /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
                    }

                    var d = $(this);


                    if (bValid) {
                        email.attr('disabled', 'disabled');
                        reply.attr('disabled', 'disabled');

                        helpers.tips.html('Email is sending to recipients, please wait...');

                        $.post('/api/box/email/post',
                            {
                                from: email.val(),
                                to: emails,
                                data: d.data('post')
                            },
                            function() {
                                email.removeAttr('disabled');
                                reply.removeAttr('disabled');
                                helpers.tips.html('<strong>Email was sent correctly . This message will close in 2 seconds.</strong>');

                                setTimeout(function() {
                                    allFields.attr('value', '')
                                    helpers.tips.html('Please provide email addresses you would like to send this report to‭ (‬use commas to send to multiple‭).');
                                    d.dialog("close");
                                }, 3000);

                            });

                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            close: function() {
                allFields.val("").removeClass("ui-state-error");
            }
        });

    },

    initPager: function() {

        var pager = this.data.pagination;

        this.currentPage = pager.page;
        this.totalPages = pager.pagesCount;
        this.pagerInited = true;

        if(this.getPagerHolder()) {


            this.getPagerHolder().find('.page').text(pager.page);
            this.getPagerHolder().find('.pageCount').text(pager.pagesCount);

        }

        return this;

    },

    expandEndpointCallback: function(e, data) {

        e.preventDefault();

        var param = {};

        var val=$(e.target).val();
        param[data.name] = data.split ? val.split(",") : val;


        var endpoint = data.endpoint + '/' + data.id;

        boxManager.genericRequest(endpoint, param);

    },

    populateFields: function(text, data)
    {
        var tr = $(data.trContext);

        data.context.customPopulateFields(text, data);


        // we define export action for each inbox
        tr.find('.action-email').bind('click', function(e) {

            e.preventDefault();

            if(text.review)
                $("#email-export").data('post', text.review);
            else
                $("#email-export").data('post', text.social);

            $("#email-export").dialog("open");

        });

        data.trContext.prev().find('.expand-preloader').attr('class', 'expand');
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

        data.trContext.prev().find('.expand').attr('class', 'expand-preloader');

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
    endpoint: '/api/dataProvider/competition/ogsi',

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

        ogsiRow.find('.score').text(parseFloat(ogsi.ogsi.value).toFixed(2) + "%");
        ogsiRow.find('.rank').text(ogsi.ogsi.rank.value + " of " + ogsi.ogsi.rank.out);

        avgStarRow.find('.score').text(parseFloat(ogsi.rating.value).toFixed(2));
        avgStarRow.find('.rank').text(ogsi.rating.rank.value + " of " + ogsi.rating.rank.out);


        reviewsRow.find('.score').text(parseInt(ogsi.reviews.value));
        reviewsRow.find('.rank').text(ogsi.reviews.rank.value + " of " + ogsi.reviews.rank.out);

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

    construct: function () {

        this.noApiUrl = true;

    }

});



var BC_Scoreboard = BoxController.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-ogsi',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/scoreboard/overall',

    processData: function() {

        var holder = this.getContentDom(),
        ogsi = this.data.overall;


        if (ogsi) {
            holder.find('.ogsi-score-value').text(ogsi.ogsi);

            holder.find('.ogsi-rating-value').text(ogsi.rating.score);

            holder.find('.ogsi-rating-stars-on').css('width', (ogsi.rating.score / 5) * 100 + 5 + '%');

            holder.find('.ogsi-reviews-value').text(ogsi.reviews);

            holder.show();

            var rating = ogsi.rating;
            var barHolder = holder.find('.bar-holder');

            var maxValue = Math.max(rating.negative, rating.positive, rating.neutral);
            var total = rating.negative + rating.positive + rating.neutral;
            var ratio;
            if (total) {
                barHolder.show();
                var bar = barHolder.find('.bar-negative');
                bar.children('.bar-value').text('');
                if (rating.negative > 0) {

                    ratio = (rating.negative / maxValue) * 100;

                    if(ratio > 10)
                        bar.children('.bar-value').text(rating.negative);
                }
                bar = barHolder.find('.bar-neutral');
                bar.children('.bar-value').text('');
                if (rating.neutral > 0) {

                    ratio = (rating.neutral / maxValue) * 100;

                    bar.css('width', ((rating.neutral + rating.positive)/total)*100+'%');
                   
                    if(ratio > 10)
                        bar.children('.bar-value').text(rating.neutral);
                    
                    
                    bar.show();
                } else if (rating.positive > 0) {
                    bar.css('width', ((rating.positive)/total)*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }
                bar = barHolder.find('.bar-positive');
                bar.children('.bar-value').text('');
                if (rating.positive > 0) {

                    ratio = (rating.positive / maxValue) * 100;

                    if(ratio > 10)
                        bar.children('.bar-value').text(rating.positive);

                    bar.css('width', (rating.positive/(rating.neutral + rating.positive))*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }

            } else {
                barHolder.hide();
            }


        }

    },


    construct: function () {

        this.noApiUrl = true;

    }

});

var BC_StatusUpdate = BoxController.extend({

    boxId: 'box-status-updates',
    endpoint: '/api/box/auth',

    attachBoxEvents: function() {

        var self = this;

        this.getContentDom().find(".status-updater textarea").charCount({
            allowed: 120,
            warning: 20,
            submitEnable: this.getContentDom().find('.buttons button')
        });

        this.getContentDom().delegate('form#wallPoster', 'submit', function(e) {

            e.preventDefault();

            var textarea = $(e.target)
            .children('textarea.content')
            .attr('disabled', 'disabled');

            var params = {};
            params.message = textarea.val();

            $($(this).serializeArray()).each(function() {

                params[this.name] = true

            });


            $.post('/api/box/update', params, function(data) {

            }).error(function() {



            })
            .complete(function() {

                textarea.removeAttr('disabled');
                textarea.val('');
                self.getContentDom().find('.message span').fadeIn();

                setTimeout(function() {
                    self.getContentDom().find('.message span').fadeOut();
                }, 3000);

            });

        });

    },

    processData: function() {

        if(!this.data.facebook_page_name && !this.data.twitter_account) {

            this.getContentDom().find('.status-updater').html('<p class="message">You need to activate Your facebook or twitter account in Account Settings</p>');

        }

        if(this.data.facebook_page_name) {

            this.getContentDom().find('.page_name').text(this.data.facebook_page_name);
        }
        else
            this.getContentDom().find('.facebook_checkbox').remove();


        if(this.data.twitter_account) {

            this.getContentDom().find('.twitter_account').text(this.data.twitter_account);
        }
        else
            this.getContentDom().find('.twitter_checkbox').remove();


    },
    construct: function() {

        this.noApiUrl = true;

    }

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

var BC_ScoreboardCurrent = BoxController.extend({


    boxId: 'box-ogsi-current',
    endpoint: '/api/dataProvider/scoreboard/current',

    processData: function() {

        var holder = this.getContentDom(),
        ogsi = this.data.current,
        rating = ogsi.rating,
        barHolder = holder.find('.bar-holder'),
        ratio;

        if (ogsi) {

            var maxValue = Math.max(rating.negative, rating.positive, rating.negative),
            total = rating.negative + rating.positive + rating.neutral;

            var months = getPeriodInDays(this.range['period']);
            var days;

            if(!months && this.range['period'] == 'ytd') {

                var now = new Date();
                var ytd = new Date();

                ytd.setMonth(0, 1);
                days = Math.ceil((now.getTime() - ytd.getTime()) / (1000 * 3600 * 24));

            }
            else if(months) {
                days = months;
            }
            else {

                if(this.range['period'] == 'all')
                    days = 'All';
                else {

                    var start = Date.parse(this.range['date']);
                    var end = Date.parse(this.range['period']);

                    var timestamp = Math.ceil((end - start) / (1000 * 3600 * 24));

                    days = timestamp;

                }
            }


            holder.find('.days').text(days);

            holder.find('.ogsi-score-value').text(ogsi.ogsi);


            holder.find('.ogsi-rating-value').text(ogsi.rating.score);
            holder.find('.ogsi-rating-stars-on').css('width', (ogsi.rating.score / 5) * 100 + 5 + '%');

            holder.find('.ogsi-reviews-value').text(ogsi.reviews);

            holder.show();

            if (total) {
                barHolder.show();
                var bar = barHolder.find('.bar-negative');
                bar.children('.bar-value').text('');
                if (rating.negative > 0) {

                    ratio = (rating.negative / maxValue) * 100;

                    if(ratio > 5)
                        bar.children('.bar-value').text(rating.negative);
                }
                bar = barHolder.find('.bar-neutral');
                bar.children('.bar-value').text('');

                if (rating.neutral > 0) {

                    ratio = (rating.neutral / maxValue) * 100;

                    if(ratio > 5)
                        bar.children('.bar-value').text(rating.neutral);

                    bar.css('width', ((rating.neutral + rating.positive) / total)*100+'%');
                    bar.show();

                } else if (rating.positive > 0) {

                    bar.css('width', (rating.positive/(total))*100+'%');
                    bar.show();

                } else {
                    bar.hide();
                }


                bar = barHolder.find('.bar-positive');
                bar.children('.bar-value').text('');
                if (rating.positive > 0) {

                    ratio = (rating.positive / maxValue) * 100;

                    if(ratio > 5)
                        bar.children('.bar-value').text(rating.positive);

                    bar.css('width', (rating.positive/(rating.neutral + rating.positive))*100+'%');
                    bar.show();
                } else {
                    bar.hide();
                }

            } else {
                barHolder.hide();
            }


        }

    },

    construct: function() {

        this.noApiUrl = true;

    }

});

var BC_TagsAnalysis = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-tags-analysis',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/reviews/category_breakdown',


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
                },
                series: {
                    legendItemClick: function(event) {
                        event.preventDefault();
                        return false;
                    },
                    point: {
                        events: {
                            legendItemClick: function(event) {
                                event.preventDefault();
                                return false;
                            }
                        }
                    }
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
            series: []
        };


        var s = {
            type: 'pie',
            name: 'Categories',
            data: []
        };

        for (var i = 0; i < this.graphData.length; i++) {
            s.data.push([
                this.graphData[i].category,
                parseFloat(this.graphData[i].percent)
                ]);
        }

        options.series.push(s);



        this.graph = new Highcharts.Chart(options);
    },

    processData: function() {

        var categories = this.data.categories;
        this.graphData = categories;

        var table = this.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr:first').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < categories.length; i++) {
            tr = trTemplate.clone();
            for (n in categories[i]) {
                var value = categories[i][n];
                if (n == 'percent') {
                    value = value + '%';
                }
                tr.find('td.col-' + n).text(value);
            }
            table.find('tbody').append(tr);
        }

    },

    construct: function () {
        this.noApiUrl = true;
    }

});

var BC_ReviewSites = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-review-sites',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/reviews/sites',

    prepareGraph: function () {

        var graphHolderId = this.boxId + '-graph-holder';

        if (!this.graphData) {
            this.showNoData('.graph-holder');
            return;
        }


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
                    stacking: 'normal',
                    events: {

                        legendItemClick: function(event) {

                            event.preventDefault();
                            return false;
                        }

                    }
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

        for (var i in this.graphData) {
            var site = this.graphData[i];
            options.xAxis.categories.push(site.site);
            options.series[0].data.push(site.negative);
            options.series[1].data.push(site.neutral);
            options.series[2].data.push(site.positive);
        }

        this.graph = new Highcharts.Chart(options);
    },

    processData: function() {

        var sites = this.data.sites,
        table = this.getContentDom().find('.data-grid-holder > table'),
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null,
        trFooter = table.find('tfoot tr');

        this.graphData = sites;


        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();

        var c=0;
        for(var i in sites) {
            tr = trTemplate.clone();
            for (n in sites[i]) {
                var value = sites[i][n];
                tr.find('td.col-' + n).text(value);
                if (n != 'site') {
                    var currentTotalValue = 0;
                    if (n == 'average') {
                        currentTotalValue = parseFloat(trFooter.find('th.col-' + n).text());
                        value = parseFloat(value);
                    } else {
                        currentTotalValue = parseInt(trFooter.find('th.col-' + n).text());
                    }
                    trFooter.find('th.col-' + n).text(value + currentTotalValue);
                }
            }
            table.find('tbody').append(tr);
            c++;
        }

        var number = parseFloat(trFooter.find('th.col-average').text()) / c;
        number = number.toFixed(1);
        trFooter.find('th.col-average').text(number);

    },

    construct: function () {
        this.noApiUrl = true;
    }

});

/**
 * @TODO make html markup more generic, correcponding to row-detail partial
 */
var BC_ReviewInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-recent-reviews',

    endpoint: '/api/dataProvider/reviews',

    alerts: {}, // store all status counts


    dateHelper: function(date) {

        var tmpDate = new Date(date * 1000);
        return monthNames[tmpDate.getMonth()]
            + ' '
            + tmpDate.getDate();

    },

    titleLink: $('<a href="#" class="title"></a>'),
    expandButton: $('<a href="#" class="expand"></a>'),

    /**
     * this method populate every row of collapsed messages
     * based on specific message template
     *
     */
    prepareMessage: function(template, message) {

        template = template.clone();
        template.addClass('collapsed').attr('data-row-id', message.id);

        for(var key in message)
        {
            var value = message[key],
            col = template.find('td.col-' + key),
            titleLink;

            switch(key) {

                case 'date':
                    col.text(this.dateHelper(value));
                    break;
                case 'title':
                    titleLink = this.titleLink.clone();

                    var link = message.link ? message.link : Site.check(message.site);

                    if(link)
                        titleLink.prop({
                            'href': link,
                            'target': '_blank'

                        });

                    titleLink.text(value ? value : 'No Title Available');
                    col.find('div.in')
                    .html(titleLink)
                    .prepend(this.expandButton.clone());
                    break;
                case 'score':
                    col.html($('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><span style="text-align:center;">' + (value ? value + ' stars' : 'No rating') + '</span></div></div>'));
                    break;
                case 'status':
                    value = value.toLowerCase();
                    var icon = value in {'new': 1, 'blank': 1, 'no status': 1} ? ' ' : (value == 'closed' ? ' x ' : '!');
                    col.html($('<div class="reviewStatus reviewStatus-' + value.replace(' ', '-') + '" style="text-align:center;"><span> ' + icon + ' </span></div>'));
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
        checkboxes = tr.find('.single-check > input:checkbox'),
        status = message.status.toLowerCase(),
        self = tr;

        tr.find('.recent-review-status-icon')
        .removeClass('open closed todo')
        .addClass(status);

        tr.find('.review-details-title').text(message.title ? message.title : 'No Title Available');
        tr.find('.review-details-content').text(message.content);

        if(message.identity) {

            tr.find('.author').text(message.identity);

        }

         if(message.link)
                tr.find('.action-review').attr('href', message.link);
         else {
                tr.find('.actions-review').remove();


                var url = Site.check(message.site);

                if(url) {
                    tr.find('.actions-reply').attr('href', url);
                    tr.find('.actions-reply').show();
                }
                else {
                    tr.find('.recentReviewDetailsButtons span.man-disabled').remove();
                    tr.find('.recentReviewDetailsButtons').prepend('<span class="man-disabled">Management Responses Not Available for this Review Site</span>');
                    tr.find('.actions-reply').hide();

                }


        }


        checkboxes.prop('checked', false);
        checkboxes.each(function() {

            if($(this).val() == status)
                $(this).prop('checked', true);

        });


        checkboxes.bind('change', function() {

            var checked = $(this).is(':checked');

            var nbrChecked = checkboxes.filter(':checked').length;

            var value = $(this).val();
            checkboxes.attr('disabled','disabled');

            if(checked) {
                checkboxes.prop('checked', false);
                $(this).prop('checked', true);

                boxManager.genericRequest('/api/dataProvider/reviews' + '/status/' + data.id, {
                    status: value
                }, function() {

                    data.context.initFilters(true);
                    data.context.renderAlerts();
                    

                    tr.find('.recent-review-status-icon')
                    .removeClass('new closed todo')
                    .addClass(value);

                    var icon = value in {'new': 1, 'blank': 1} ? '&nbsp;' : (value == 'closed' ? ' x ' : '!');
                    var reviewStatus = $('<div class="reviewStatus reviewStatus-' + value + '"><span>[ ' + icon + ' ]</span></div>');

                    tr.prev().find('.col-status').html(reviewStatus);
                    checkboxes.removeAttr('disabled');
                })


            }
            else if(!nbrChecked && message.score >= 3) {

                boxManager.genericRequest('/api/dataProvider/reviews' + '/status/' + data.id, {
                    status: 'blank'
                }, function() {

                    data.context.initFilters(true);
                    data.context.renderAlerts();

                    tr.find('.recent-review-status-icon')
                    .removeClass('new closed todo blank')
                    .addClass('blank');

                    status = 'blank';

                    var reviewStatus = $('<div class="reviewStatus reviewStatus-blank"><span>[  ]</span></div>');
                    tr.prev().find('.col-status').html(reviewStatus);
                    checkboxes.removeAttr('disabled');
                })

            }


        });

        tr.find('select[name="category"]').val(message.category)
        .bind('change',
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback,
                {
                    id: data.id,
                    endpoint: '/api/dataProvider/reviews/category',
                    name: 'category',
                    context: data.context
                }
                )
            );

        tr.find('input.review-tags').val(message.tags ? message.tags.join(',') : '')
        .bind('save',
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback,
                {
                    id: data.id,
                    endpoint: '/api/dataProvider/reviews/tags',
                    name: 'tags',
                    context: data.context,
                    split: true
                }
            )
        );
        tr.find('textarea[name="notes"]').val(message.notes)
        .bind('save',
            data.context.genericCallbackEventWrapper(
                data.context.expandEndpointCallback,
                {
                    id: data.id,
                    endpoint: '/api/dataProvider/reviews/notes',
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
      boxManager.genericRequest('/api/dataProvider/reviews' + '/categories', {}, function(response) {

            var select = data.trContext.find('.review-categories').html('');
            var option = $('<option />');
            $.each(response.categories, function(i, item) {

               select.append(option.clone().val(i).text(item));

            });

            data.customPopulateFields = this.reviewPopulate;

            boxManager.genericRequest('/api/dataProvider/reviews' + '/expand/' + data.id, {},
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

            var currentId = data[i].id,
            status = data[i].status,
            statusLower = status.toLowerCase();

            tr = this.prepareMessage(trTemplate, data[i]);

            trContent = trContentTemplate.clone().attr('data-row-id', currentId)
            .bind('expand',this.genericCallbackEventWrapper(
                this.expandedPopulate,
                {
                    context:this,
                    id: currentId
                }
                )
            );


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


        if(this.filter = this.getBoxDom().attr('filter')) {

            this.loaded = true;

        }

    },

    renderAlerts: function() {

        var alerts = $('#alerts .light-box-content');

        var loc = APP.location.current_location_id ? APP.location.current_location_id : GLOBALS.location_id;

        if(!alerts.length)
            return;

        var self = this;

        $.post('/api/dataProvider/reviews/alerts', {
            status: 'alert',
            loc: loc
        }, function(data) {

            self.alerts['alert'] = data.alerts;

            $.post('/api/dataProvider/reviews/alerts', {
                status: 'todo',
                loc: GLOBALS.location_id
            }, function(data) {

                self.alerts['todo'] = data.alerts;

                if(self.alerts['alert'] !== null) {

                    for(var key in self.alerts) {

                        alerts.find('.desc .' + key).text(self.alerts[key]);

                    }

                    alerts.parent().removeClass('hide');

                }

            });

        });

    },

    initBoxEvents: function() {

      this.renderAlerts();

      $('#alerts a.alert-show, #alerts a.todo-show').bind('click', function(e) {

        e.preventDefault();
        var strWindowFeatures = "width=800,height=600,menubar=no,location=no,resizable=no,scrollbars=yes,status=no";
        window.open(this.href, "alerts", strWindowFeatures);

      });

    },

    construct: function () {
        this.noApiUrl = true;

        // when we open reviews in special mode in separate window
        if(this.filter = this.getBoxDom().attr('filter')) {

            var d = new Date();

            this.addFilter('status' , this.filter);
            this.setRange({
                period: this.getBoxDom().attr('period'),
                date: this.getBoxDom().attr('date')
            });
            this.extraParams = {
                include_date: false
            }

            var self = this;

            this.getBoxDom().resize(function(e) {


                if(self.loaded) {
                    $('.window-close').css('top', self.getBoxDom().height() + 35);
                }


            });

            $('.window-close').bind('click', function() {
                window.close();
            });

        }

        this.initBoxEvents();
    }

});

var BC_SocialActivity = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-social-activity',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/socials/activity',

    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }

        var graphHolderId = this.boxId + '-graph-holder',
        data = [],
        self = this,
        s = function(name, categories, data, color) {
            self.graph.xAxis[0].setCategories(categories);
            self.graph.series[0].remove();
            self.graph.addSeries({
                name: name,
                data: data,
                color: color || 'white'
            });
        },
        bigCategories = [],
        colors = Highcharts.getOptions().colors,
        i=0;

        for(var key in this.graphData) {

            bigCategories.push(this.graphData[key].network);

            var categories = [], values = [];

            for(var c in this.graphData[key].categories) {
                categories.push(c);
                values.push(this.graphData[key].categories[c]);
            }


            data.push({

                y:  this.graphData[key].total,
                color: colors[i],
                drilldown: {

                    name: this.graphData[key].network,
                    categories: categories,
                    data: values,
                    color: colors[i++]

                }

            });

        }


        var options = {
            chart: {
                renderTo: graphHolderId,
                type: 'bar'
            },
            title: {
                text: false
            },

            xAxis: {
                categories: bigCategories,
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: false
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },

            plotOptions: {
                bar: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;

                                if (drilldown) { // drill down
                                    s(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    s(false, bigCategories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                    s = this.x +':<b>'+ this.y +' actions</b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view details';
                    } else {
                        s += 'Click to return to overall graph';
                    }
                    return s;
                }
            },
            series: [{
                data: data
            }],

            exporting: {
                enabled: false
            }
        }

        this.graph = new Highcharts.Chart(options);
    },

    processData: function() {

        var networks = this.data.networks,
        table = this.getContentDom().find('.data-grid-holder > table'),
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null;

        this.graphData = networks;

        trFooter = table.find('tfoot tr');
        trFooter.find('th.col-total').text('0');
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


                    trFooter.find('th.col-' + n).text(parseInt(value) + currentTotalValue);
                }
            }

            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }

            table.find('tbody').append(tr);
        }
//        trFooter.find('th.col-average').text(
//            parseFloat(trFooter.find('th.col-average').text()) /
//            networks.length
//            );
//
    },

    construct: function() {


        this.noApiUrl = true;

    }

});

var BC_SocialSubscribers = BC_GraphBoxController.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-social-reach',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/socials/subscribers',


    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }

        var graphHolderId = this.boxId + '-graph-holder',
        data = [],
        self = this,
        s = function(name, categories, data, color) {
            self.graph.xAxis[0].setCategories(categories);
            self.graph.series[0].remove();
            self.graph.addSeries({
                name: name,
                data: data,
                color: color || 'white'
            });
        },
        bigCategories = [],
        colors = Highcharts.getOptions().colors,
        i=0;

        for(var key in this.graphData) {

            bigCategories.push(this.graphData[key].network);

            var categories = [], values = [];

            for(var c in this.graphData[key].categories) {
                categories.push(c);
                values.push(this.graphData[key].categories[c]);
            }


            data.push({

                y:  this.graphData[key].total,
                color: colors[i],
                drilldown: {

                    name: this.graphData[key].network,
                    categories: categories,
                    data: values,
                    color: colors[i++]

                }

            });

        }


        var options = {
            chart: {
                renderTo: graphHolderId,
                type: 'bar'
            },
            title: {
                text: false
            },

            xAxis: {
                categories: bigCategories,
                title: {
                    text: ''
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: false
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },

            plotOptions: {
                bar: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;

                                if (drilldown) { // drill down
                                    s(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    s(false, bigCategories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                    s = this.x +':<b>'+ this.y +' actions</b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view details';
                    } else {
                        s += 'Click to return to overall graph';
                    }
                    return s;
                }
            },
            series: [{
                data: data
            }],

            exporting: {
                enabled: false
            }
        }

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

    construct: function () {

        this.noApiUrl = true;

    }

});

var BC_CompetitionReviewInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-competition-review-inbox',

    endpoint: '/api/dataProvider/competition',


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
                    titleLink.text(value ? value : 'No Title Available');

                    var url = Site.check(message.site);

                    if(url)
                        titleLink.prop({
                            'href': url,
                            'target': '_blank'

                        });

                    col = col.find('div.in');

                    col.html(titleLink);
                    col.prepend('<a href="#" class="expand"></a>');
                    break;
                case 'score':
                    col.html($('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><span style="text-align:center;">' + (value ? value + ' stars' : 'No rating') + '</span></div></div>'));
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


        var message = text.review;

        var tr = $(data.trContext);

        tr.find('.details-title').text(message.title ? message.title : 'No Title Available');
        tr.find('.details-content').text(message.content);

        if(message.link !== undefined)
            tr.find('.goto-link').attr('href', message.link);
        else
            tr.find('.goto').remove();

        if(message.identity) {

            tr.find('.author').text(message.identity);

        }


        tr.find('.actions-network').remove();

    },

    expandedPopulateCallback: function(data) {


            boxManager.genericRequest('/api/dataProvider/competition' + '/expand/' + data.id, {},
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

        var data = this.data.reviews;

        for (var i = 0; i < data.length; i++) {

            var currentId = data[i].id;

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

    construct: function () {

        this.noApiUrl = true;

    }

});


var BC_CompetitionComparision = BC_LinearGraphBoxController.extend({

    boxId: 'box-competition-comparision',
    series: [],
    endpoint: '/api/dataProvider/competition/comparsion',
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
            default:
                dateFormat = '%a %e';
                break;
        }

        return Highcharts.dateFormat(dateFormat, this.value);
    },


    populateGraph: function() {

        var seriesMappings = []; // maapping of label values to corresponding series index
        var seriesMappingInited = false;
        this.series = [];
        var val;
        
        var timestamps = [];
        
        for(timestamp in this.graphData.comparision) {
        
            timestamps.push(parseInt(timestamp));
        }
        
        timestamps.sort(function(a,b) {
            
           return a == b ? 0 : ((a < b) ? 1 : -1);
            
        });
        
        
        
        for (var tKey in timestamps) {
            
            var timeObject = this.graphData.comparision[timestamps[tKey]];
            
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

                val = parseFloat(comparisionObject.value);

                this.maxValue = this.maxValue < val
                ? val : this.maxValue;

                // add series single data to right place based on previously defined
                // mappings
                this.series[seriesMappings[comparisionObject.competition]]
                .data.unshift(val);

            }


            if(!seriesMappingInited) {
                seriesMappingInited = true;
            }
        }

    },

    loadData: function() {

        this.loadGraphData();

    },

    construct: function() {

        this.noApiUrl = true;

    }

});

var BC_CompetitionDistribution = BC_GraphBoxController.extend({

    boxId: 'box-competition-distribution',

    endpoint: '/api/dataProvider/competition/distribution',

    prepareGraph: function () {
        if (!this.data) {
            return;
        }

        var graphHolderId = this.boxId + '-graph-holder';

        var graphHolder = $('#' + graphHolderId);

        var options = {
            chart: {
                renderTo: graphHolderId,
                defaultSeriesType: 'bar'
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
                    stacking: 'normal',
                    events: {
                        legendItemClick: function(event) {

                            return false;

                        }
                    }
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

        for (var i in this.graphData) {
            var dist = this.graphData[i];
            options.xAxis.categories.push(i);
            options.series[0].data.push(dist.negative);
            options.series[1].data.push(dist.neutral);
            options.series[2].data.push(dist.positive);
        }

        this.graph = new Highcharts.Chart(options);
    },

    processData: function() {


        var c = 0,
        distribution = this.data.distribution,
        table = this.getContentDom().find('.data-grid-holder > table'),
        trTemplate = table.find('tbody tr:first').clone(),
        tr = null,
        trFooter = table.find('tfoot tr');

        this.graphData = distribution;

        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();


        for (var i in distribution) {
            tr = trTemplate.clone();
            for (n in distribution[i]) {
                var value = distribution[i][n];

                tr.find('td.col-' + n).text(value);
                var currentTotalValue = 0;
                if (n == 'average') {
                    currentTotalValue = parseFloat(trFooter.find('th.col-' + n).text());
                } else {
                    currentTotalValue = parseInt(trFooter.find('th.col-' + n).text());
                }
                trFooter.find('th.col-' + n).text(parseFloat(value) + currentTotalValue);

                tr.find('td.col-dealership').text(i);
            }
            table.find('tbody').append(tr);
            c++;
        }

        var number = parseFloat(trFooter.find('th.col-average').text()) / c;
        number = number.toFixed(2);
        trFooter.find('th.col-average').text(number)

    },

    construct: function() {

        this.noApiUrl = true;

    }



});

var BC_SocialMediaInbox = BC_Inbox.extend({

    /**
     * @var String DOM id of the container div
     */
    boxId: 'box-social-media-inbox',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: '/api/dataProvider/socials',


    prepareMessage: function(template, message) {

        template = template.clone();
        template.addClass('collapsed').attr('data-row-id', message.id);

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
                    titleLink.text(value ? value : 'No Title Available');


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

        var title;
        if(message.link) {

            title = $('<a/>', {
                href: message.link,
                text: message.title ? message.title : 'No Title Available'
            });

        }
        else {
            title = message.title ? message.title : 'No Title Available';
        }

        tr.find('.details-title').html(title);
        tr.find('.details-content').text(message.content);
        tr.find('.details-network').addClass(message.network.toLowerCase());

        if(message.identity) {

            tr.find('.author').text(message.identity);

        }

        if(message.link !== undefined)
            tr.find('.goto-link').attr('href', message.link);
        else
            tr.find('.goto').remove();


    },

    expandedPopulateCallback: function(data) {


            boxManager.genericRequest('/api/dataProvider/socials' + '/expand/' + data.id, {},
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
        for (var i = 0; i < data.length; i++) {

            var currentId = data[i].id;

            trContent = trContentTemplate.clone().attr('data-row-id', currentId)
            .bind('expand',this.genericCallbackEventWrapper(
                this.expandedPopulate,
                {
                    context:this,
                    id: currentId
                }
                )
            );

            tr =this.prepareMessage(trTemplate, data[i]);

            if (i % 2) {
                tr.addClass('odd');
            } else {
                tr.addClass('even');
            }


            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', data[i].id);
            tr.find('td.col-checkbox').html(checkbox);

            table.children('tbody').append(tr); // append two elements
            table.children('tbody').append(trContent); // append two elements

        }
    },

    construct: function () {

        this.noApiUrl = true;

    }

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
                        location_id: GLOBALS.location_id,
                        box_class: fromContainer.attr('class')

                    };

                    collection[holder_id] =
                    {
                        box_id: $(ui.draggable).attr('id'),
                        location_id: GLOBALS.location_id,
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
                        location_id: GLOBALS.location_id,
                        box_class: $(this).attr('class'),
                        section_id: boxManager.section_id
                    };

                    fromContainer.addClass('empty').removeClass('active');
                }
                $(this).append(ui.draggable);

                $(this).removeClass('empty').addClass('active');


                if(boxManager.positions.length && !boxManager.positions[holder_id]) {
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

        $( "#boxes-holder .box" ).not('.not-draggable').draggable({
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
        settings.location_id = GLOBALS.location_id;
        settings.holders = [];

        $('.box-container').each(function() {

            var id = self.section_id  + '-' + $(this).index();

            $(this).addClass('hide');
            $(this).attr('id', id);


            if($(this).is(':parent')) {

                settings.holders.push({

                    holder_id: this.id,
                    box_id: $(this).find('.box').attr('id'),
                    location_id: GLOBALS.location_id,
                    section_id: self.section_id,
                    box_class: $(this).attr('class')

                });
            }
        });

      /**
       * this is logic for setting boxes in right position
       * it firstly do some ajax request that return json positions mapping
       */
        if($("#boxes-holder").length) {
            
            this.genericRequest('/api/box/positions/' + this.section_id, $.param(settings), function(data) {

                self.positions = data;
                
                var populated = {};

                for(var box in data) {
                    

                    var j = data[box],
                    current = self.collection[j.box_id];

                    if(!current) {

                        return;

                    }

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

        }


    },

    init: function () {

        this.section_id = $('.top-menu-item.active')
        .text()
        .toLowerCase()
        .replace(/\s+/g,"_") || location.pathname.replace(/[\s|\/]+/g,"_");

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
                    boxesHolder.append(box).append(tmp);

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
        for (var i in this.collection) {
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
    exportBoxes: function (params) {

      if(!params) {
          params = null;
      }

      $('#boxes-holder .box-container .box').each(function() {

            var block,
            content,
            box = boxManager.getBox(this.id);

            // not all boxes are handled by js
            if(!box || box.ignore)
                return;

            // choose template corresponding to box floating
            if(!box.getBoxDom().parent().is('.box-container-left, .box-container-right')) {
                block = Exporter.template.blockWide.clone();
            }
            else {
                block = Exporter.template.block.clone().addClass(box.getBoxDom().parent().attr('class'));

            }

            // we show only the selected view of box
            if(box.hasOwnProperty('graph') && (box.getHeaderDom().find('.box-header-button-show-graph.active').length || box.getContentDom().children().length == 1)) {

                var block2 = block.clone();
                var content2 = box.graph.getSVG();
                var title2 = $("<h2/>").text(box.getHeaderDom().find('.box-header-title').text());

                title2.add(content2).appendTo(block2.find('.inner'));

                block2.appendTo(boxManager.exporter.template.container);

            }
            else {

                content = box.getContentDom()
                .find('.data-grid-holder table:visible:first')
                .clone();

                if(!content.length && this.id == 'box-ogsi') {
                    content = box.getBoxDom().clone();
                    content.find('.box-header').remove();
                }

                switch(this.id) {

                    case 'box-competition-review-inbox':
                        var code = '<thead><tr><th>Rating</th><th>Date</th><th>Review Title</th><th>Source</th><th>Competitor</th></tr></thead>';
                        content.prepend(code);
                        break;
                    case 'box-recent-reviews':
                        var code = '<thead><tr><th>Status</th><th>Rating</th><th>Date</th><th>Title</th><th>Source</th></tr></thead>';
                        content.prepend(code);
                        
                        block.prepend(box.getContentDom().find('.legend table').clone());
                        
                        break;
                    case 'box-social-media-inbox':
                        var code = '<thead><tr><th>Network</th><th>Date</th><th>Title</th><th>Site</th></tr></thead>';
                        content.prepend(code);
                        var links = content.find('a.title');

                        links.replaceWith(links.html());

                        links = content.find('.col-network a');

                        links.replaceWith(links.html());

                        break;


                }

                content.find('tr.expanded').remove();

                content.find('td').removeAttr('style');

                if(content.length) {
                    var title = $("<h2/>").text(box.getHeaderDom()
                        .find('.box-header-title').text());
                    title.add(content).appendTo(block.find('.inner'));
                    block.appendTo(boxManager.exporter.template.container);

                    if(box.getBoxDom().parent().is('.box-container-right')) {
                        $('<div class="clear"/>').appendTo(boxManager.exporter.template.container);
                    }
                }

            }


        });

        boxManager.exporter.submit(params);

    }
};


var Exporter = {

    options: {
        action: "/api/box/export",
        width: 380
    },

    template: {

        block: $('<div class="block"><div class="inner"></div></div>'),
        blockWide: $('<div class="block2"><div class="inner"></div></div>'),
        container: $('<div id="page"></div>')

    },

    submit: function(params) {

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

        if(params && params['emails']) {

            $.post('/api/box/export', {

                html: self.template.container.html(),
                email: params['emails']

            }, function() {

                params.callback();

            });

        }
        else
            form.submit();

        H.discardElement(form);

        this.template.container = $('<div id="page"></div>');

    }

};

/**
 * This is helper function to help with check sites for reviews reply
 */

Site = {

    sites: [],
    init: function() {

        this.sites.push({site: 'dealerrater.com', isResponse: true, url: 'http://www.dealerrater.com/login.aspx'});
        this.sites.push({site: 'mydealerreport.com', isResponse: true, url: 'http://www.mydealerreport.com/dealers/index.php'});
        this.sites.push({site: 'edmunds.com', isResponse: true, url: 'http://www.edmunds.com/era/secure/lb/login.jsp?toUrl=http%3A%2F%2Fwww.edmunds.com%2F'});
        this.sites.push({site: 'maps.google.com', isResponse: true, url: 'https://www.google.com/accounts/ServiceLogin?service=lbc'});
        this.sites.push({site: 'citysearch.com', isResponse: true, url: 'http://www.citysearch.com/members/start'});
        this.sites.push({site: 'insiderpages.com', isResponse: true, url: 'http://www.insiderpages.com/session/new?header_link=true'});
        this.sites.push({site: 'local.yahoo.com', isResponse: true, url: 'https://login.yahoo.com/'});
        this.sites.push({site: 'judysbook.com', isResponse: true, url: 'http://www.judysbook.com/login'});
        this.sites.push({site: 'yp.com', isResponse: true, url: 'http://www.yellowpages.com/oauth/login?url=%2Flogin_success'});
        this.sites.push({site: 'yelp.com', isResponse: true, url: 'https://www.yelp.com/login'});
        this.sites.push({site: 'tripadvisor.com', isResponse: true, url: 'http://www.tripadvisor.com/'});
        this.sites.push({site: 'urbanspoon.com', isResponse: true, url: 'http://www.urbanspoon.com/u/signin?'});
        this.sites.push({site: 'zagat.com', isResponse: false, url: ''});

    },
    check: function(site) {

        if(!this.sites.length)
            this.init();

        for(var i=0, max=this.sites.length; i < max; i++) {

            if(this.sites[i].site == site)
                return this.sites[i].isResponse ? this.sites[i].url : false;

        }

        return false;

    }

}