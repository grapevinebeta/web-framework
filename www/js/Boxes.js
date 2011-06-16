
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
        if (arguments[0] !== Class && this.construct) {this.construct.apply(this, arguments);}
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
    
    construct: function () {},
    
    init: function () {
        if (this.boxId && this.getContentDom().length) {
            this.refresh();
            this.attachCommonEvents();
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
     * Attach events to specific elements within currently processed box. Has to
     * use .delegate() jQuery method on the current box's DOM (eg. retrieved by
     * this.getBoxDom()), to stand the data reloading without the need to attach
     * again and not to impact in extent, like .live() does.
     */
    attachCommonEvents: function() {
        var self = this;

        // Attach event for setting filter by status
        self.getBoxDom().delegate('a[data-filter-status]', 'click', function(event){
            event.preventDefault();
            var filter_value = $(this).attr('data-filter-status');
            self.setFilter({'value': filter_value});
            self.refresh();
        });
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
        this.getContentDom().find('.ajax-loader').remove();
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
        this.getHeaderDom().find('.box-header-right-buttons a.box-header-button-show-data').addClass('active');
        return this;
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
        this.dataProvider.setEndpoint(this.endpoint)
            .setDateRange(this.range)
            .setFilters(this.filters)
            .setDateInterval(null)
            .setCallback(this.loadDataCallback);
        this.data = this.dataProvider.fetch();
        return this;
    },
    
    setDataProvider: function (dataProvider) {
        this.dataProvider = new DataProvider();
    },

    /**
     * Sets filter. Requires JS object to be passed in the following form:
     * { 'total': 10, 'value': 'negative' }
     * where 'total' is optional (integer?) and 'value' is required string
     * @todo Actually set filter in compliance to API
     */
    setFilter: function(filter) {
        log('Filter status of "#' + this.boxId + '" set to "' + filter.value + '"');
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
    }
    
});

var GraphBoxController = BoxController.extend({
    
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
    
    
    getPeriodInDays: function() {
        var startPoint;
 
        switch(this.range['period']) {
            case '1m':
                startPoint = 30;
                break;
            case '3m':
                startPoint = 90;
                break;
            case '6m':
                startPoint = 180;
                break;
            case '1y':
                startPoint = 365;
                break;
            default:
                startPoint = 30;
                break;
        }
        
        return startPoint;
      
      
    },
    
    computeDateInterval: function() {
      

        return Math.floor((this.getPeriodInDays() * 7)  / 30);
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
        var boxController = boxManager.getBox(box.attr('id'));
        var dataGrid = box.find('.data-grid-holder');
        if (dataGrid.css('display') == 'none') {
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

    /**
     * Will handle Ajax response of the loadGraphData
     */
    loadGraphDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        
        boxController.graphData = data;
        boxController.afterLoadGraphData();
    },
    
    loadGraphData: function() {
        this.beforeLoadGraphData();

        console.log(this);
        this.graphData = null;
//        if (!this.loadGraphDataCallback.boxController) {
            this.loadGraphDataCallback.boxController = this;
//        }
        this.graphData = this.dataProvider
            .setEndpoint(this.endpoint)
            .setDateRange(this.range)
            .setFilters(this.filters)
            .setDateInterval(this.computeDateInterval())
            .setCallback(this.loadGraphDataCallback)
            .fetch();
        return this;
    },
    
    afterLoadGraphData: function () {
        this.getGraphHolder().children().remove();
        this.getHeaderDom().find('.box-header-right-buttons a.box-header-button-show-graph').addClass('active');
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
var LinearGraphBoxController = GraphBoxController.extend({
    
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
        var offset = Math.floor(this.getPeriodInDays() / 30);
        
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
                text: this.getHeaderDom().find('.box-header-title').text()
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
                    text: this.getHeaderDom().find('.box-header-title').text(),
                    align: 'high'
                },
                min: 0,
                max: this.maxValue
            },
            
            series: this.series
        }
        
        this.graph = new Highcharts.Chart(options);
       
    },

    construct: function() {}
    
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
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        var holder = boxController.getContentDom();
        if (data.ogsi) {
            holder.find('#ogsi-score-value').text(data.ogsi.ogsi.value);
            holder.find('#ogsi-score-change .change-value').text(data.ogsi.ogsi.change + '%');
            holder.find('#ogsi-score-change .change-arrow')
                .removeClass('positive')
                .removeClass('negative')
                .addClass((data.ogsi.ogsi.change >= 0) ? 'positive': 'negative');
                
            holder.find('#ogsi-rating-value').text(data.ogsi.rating.value);
            holder.find('#ogsi-rating-change .change-value').text(data.ogsi.rating.change + '%');
            holder.find('#ogsi-rating-change .change-arrow')
                .removeClass('positive')
                .removeClass('negative')
                .addClass((data.ogsi.rating.change >= 0) ? 'positive': 'negative');
            holder.find('#ogsi-rating-stars-on').css('width', (data.ogsi.rating.value / 5) * 100 + '%');

            holder.find('#ogsi-reviews-value').text(data.ogsi.reviews.value);
            holder.find('#ogsi-reviews-change .change-value').text(data.ogsi.reviews.change + '%');
            holder.find('#ogsi-reviews-change .change-arrow')
                .removeClass('positive')
                .removeClass('negative')
                .addClass((data.ogsi.reviews.change >= 0) ? 'positive': 'negative');
            holder.show();
            
            var distribution = data.ogsi.distribution;
            var barHolder = holder.find('#box-ogsi-review-distribution .bar-holder');
            if (distribution.total) {
                barHolder.show();
                var bar = barHolder.find('.bar-negative');
                bar.children('.bar-value').text('');
                if (distribution.negative > 0) {
                    bar.children('.bar-value').text(distribution.negative);
                }
                bar = barHolder.find('.bar-neutral');
                bar.children('.bar-value').text('');
                if (distribution.neutral > 0) {
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
        boxController.afterLoadData();
    },
    
    construct: function () {}
    
});


var BC_KeywordsAnalysis = GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-keywords-analysis',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'keywords',
    
    
    prepareGraph: function () {
        if (!this.graphData) {
            return;
        }
        
        var graphHolder = this.getGraphHolder();
        
        var graphHolderId = graphHolder.attr('id');
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                margin: [10, 10, 10, 10],
                animation: false,
                defaultSeriesType: 'pie'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                       enabled: false
                    },
                    showInLegend: true
                }
            },
            events: {
                load: function (e) {
                    var container = $(this.container);
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                }
            },
            legend: {
                borderRadius: 0
            },
            series: [{
                 type: 'pie',
                 name: 'Browser share',
                 data: new Array()
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
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        boxController.graphData = data.keywords;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr:first').clone();
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

var BC_ReviewSites = GraphBoxController.extend({

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
                type: 'bar'
            },
            title: {
                text: this.getHeaderDom().find('.box-header-title').text()
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
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: this.getHeaderDom().find('.box-header-title').text(),
                    align: 'high'
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
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
            series: [{
                name: 'Average',
                data: []
            }, {
                name: 'Negative',
                data: []
            }, {
                name: 'Neutral',
                data: []
            }, {
                name: 'Positive',
                data: []
            }]
        }
        
        for (var i = 0; i < this.graphData.length; i++) {
            var site = this.graphData[i];
            options.xAxis.categories.push(site.site);
            options.series[0].data.push(site.average);
            options.series[1].data.push(site.negative);
            options.series[2].data.push(site.neutral);
            options.series[3].data.push(site.positive);
        }
        
        this.graph = new Highcharts.Chart(options);
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        boxController.graphData = data.sites;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr:first').clone();
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

    /**
     * Attach events associated with RecentReviews box, such as expanding review
     * details when the review snippet is being clicked.
     */
    attachBoxEvents: function() {
        var self = this;

        // Attach event for expanding and collapsing review details
        self.getBoxDom().delegate('table tr[data-review-id].reviewSnippet', 'click', function(event){
            event.preventDefault();
            var review_id = $(this).attr('data-review-id');
            log('Toggling details of review with ID="' + review_id + '"');
            var detailsBox = self.getBoxDom().find('tr[data-review-id="' + review_id + '"].reviewDetails .recentReviewsDetails');
            if (detailsBox.css('display') == 'none') {
                detailsBox.show();
                log('showing...');
            } else {
                detailsBox.hide();
                log('hiding...');
            }
        });
    },

    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        this.getHeaderDom().find('#box-header-status-filters').html($(this.getLoaderHtml()).children());
        this.getHeaderDom().find('#box-header-source-filters').html($(this.getLoaderHtml()).children());
    },

    /**
     * Get the table header
     */
    getHeader: function (review_id) {
        return $('<thead>'
            + '<tr>'
            + '<th>Status</th>'
            + '<th>Rating</th>'
            + '<th>Date</th>'
            + '<th>Review</th>'
            + '<th>Source</th>'
            + '</tr>'
            + '</thead>');
    },

    /**
     * Get the template for details of specific review
     */
    getReviewDetailsTemplate: function (review_id) {
        return $('<tr data-review-id="' + review_id + '" class="reviewDetails">'
            + '<td colspan="' + this.getReviewSnippetTemplate().find('td').length + '">'
                + '<div class="recentReviewsDetails" style="display: none;">'
                    + '<div style="clear: both;">'
                        + '<div class="recentReviewsDetailsForm">'
                            + '<h2>Some review title</h2>'
                            + '<p>Some review content Some review content Some review content Some review content '
                            + 'Some review content Some review content Some review content Some review content '
                            + 'Some review content Some review content Some review content Some review content '
                            + 'Some review content Some review content Some review content Some review content '
                            + 'Some review content Some review content Some review content Some review content '
                            + 'Some review content Some review content Some review content Some review content </p>'
                            + '<form action="" method="post">'
                                + '<input type="text" value="asd" name="field1" /> '
                                + '<input type="text" value="asd" name="field2" /><br />'
                                + '<textarea type="text" name="content"></textarea>'
                                + '<input type="submit" name="" value="Send" />'
                            + '</form>'
                        + '</div>'
                        + '<div class="recentReviewsDetailsMenu">'
                            + '<p>[status icon]</p>'
                            + '<ul><li>Completed</li><li>Mark</li><li>ToDo</li><li>Email</li></ul>'
                        + '</div>'
                    + '</div>'
                    + '<div class="recentReviewsDetailsButtons">'
                        + 'some buttons'
                    + '</div>'
                + '</div>'
            + '</td>'
            + '</tr>');
    },

    /**
     * Get the snippet of specific review
     */
    getReviewSnippetTemplate: function (review_id) {
        return $('<tr data-review-id="' + review_id + '" class="reviewSnippet">'
            //+ '<td class="col-checkbox"></td>' // no need for checkbox
            + '<td class="col-status"></td>'
            + '<td class="col-rating"></td>'
            + '<td class="col-submitted a-center"></td>'
            + '<td class="col-title"></td>'
            + '<td class="col-site a-right"></td>'
            + '</tr>');
    },
    
    loadFilters: function (filterType) {
        if (filterType != 'status') {
            return;
        }
        var filters = this.data.filters[filterType];
        var filterHolder = this.getHeaderDom().find('#box-header-' + filterType + '-filters');
        filterHolder.html('');
        for (var i = 0; i < filters.length; i++) {
            var filterLink = $('<a href="#" data-filter-status="' + filters[i].value.toLowerCase() + '"></a>');
            if (filters[i].total) {
                filterLink.text(filters[i].total +' ');
            }
            filterLink.text(filterLink.text() + filters[i].value);
            filterHolder.append(filterLink);
            filterHolder.append(' ');
        }
    },
    
    loadReviews: function () {
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var tr = null;
        var trContent = null;
        var current_id = null;
        table.find('tbody tr').remove();
        table.prepend(this.getHeader()); // prepend header
        for (var i = 0; i < this.data.reviews.length; i++) {
            current_id = parseInt(this.data.reviews[i].id);
            log('Generating row for review with ID="' + current_id + '"');
            tr = this.getReviewSnippetTemplate(current_id);
            log('Generating content row for review with ID="' + current_id + '"');
            trContent = this.getReviewDetailsTemplate(current_id);
            
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
                } else if (n == 'rating') {
                    var ratingStars = $('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><!-- ' + value + ' --></div></div>');
                    tr.find('td.col-' + n).html(ratingStars);
                } else if (n == 'status') {
                    var reviewStatus = $('<div class="reviewStatus reviewStatus-' + value.toLowerCase() + '"></div>');
                    tr.find('td.col-' + n).html(reviewStatus);
                } else {
                    tr.find('td.col-' + n).text(value);
                }
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', this.data.reviews[i].id);
            tr.find('td.col-checkbox').html(checkbox);
            
            table.find('tbody').append(tr, trContent); // append two elements
        }
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().find('.data-grid-holder').show();
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        
        if (data.reviews) {
            boxController.loadReviews();
        }
        
        if (data.filters && data.filters.status) {
            boxController.loadFilters('status');
        }
        
        if (data.filters && data.filters.source) {
            boxController.loadFilters('source');
        }
    },
    
    construct: function () {}
    
});


/**
 * @TODO create base class for linar graph controllers
 */
var BC_SocialActivity = LinearGraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/activity',
    
    formatterCallback: function() {
                        
        var dateFormat;
        var box = boxManager.getBox('box-social-activity');
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
        var seriesMappings = []; // mapping of label values to corresponding series index
        var seriesMappingInited = false;
        
        for (var tKey in this.graphData.networks) {
            
            var timeObject = this.graphData.networks[tKey];
            
            for (var cKey in timeObject) {
            
                var comparisionObject = timeObject[cKey];
                
                if(!seriesMappingInited)
                {
                    // set specific options to each spline
                    // all timestamps must be expand to miliseconds
                    
                    seriesMappings[comparisionObject.network] = this.series.length;
                    
                    this.series.push({
                        name: comparisionObject.network, 
                        data: [], 
                        pointStart: this.getFirstDate(),
                        pointInterval: (this.computeDateInterval()+1) * this.dayInterval * 1000
                    });
                    
                }
                
                this.maxValue = this.maxValue < comparisionObject.value 
                    ? comparisionObject.value : this.maxValue;
                
                // add series single data to right place based on previously defined
                // mappings
                this.series[seriesMappings[comparisionObject.network]]
                    .data.unshift(parseInt(comparisionObject.value, 10));
                
            }
            
            if(!seriesMappingInited) 
                seriesMappingInited = true;

        }
     
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        boxController.graphData = null;

        var table = boxController.getContentDom().find('.data-grid-holder > table');
        
        var trTemplate = table.find('tbody tr:first').clone();
        var tr = null;
        var trFooter = table.find('tfoot tr');
        trFooter.find('th.col-total, th.col-value').text('0');
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.networks.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.networks[i]) {
                var value = boxController.data.networks[i][n];
                
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
            table.find('tbody').append(tr);
        }
        trFooter.find('th.col-average').text(
            parseFloat(trFooter.find('th.col-average').text()) / 
            boxController.data.networks.length
            );
                
        boxController.afterLoadData();
        

    },
   
    construct: function() {}
    
});

var BC_SocialReach = LinearGraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-reach',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/reach',
    
    formatterCallback: function() {
                        
        var dateFormat;
        var box = boxManager.getBox('box-social-activity');
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
        var seriesMappings = []; // mapping of label values to corresponding series index
        var seriesMappingInited = false;
        
        for (var tKey in this.graphData.networks) {
            
            var timeObject = this.graphData.networks[tKey];
            
            for (var cKey in timeObject) {
            
                var comparisionObject = timeObject[cKey];
                
                if(!seriesMappingInited)
                {
                    // set specific options to each spline
                    // all timestamps must be expand to miliseconds
                    
                    seriesMappings[comparisionObject.network] = this.series.length;
                    
                    this.series.push({
                        name: comparisionObject.network, 
                        data: [], 
                        pointStart: this.getFirstDate(),
                        pointInterval: (this.computeDateInterval()+1) * this.dayInterval * 1000
                    });
                    
                }
                
                this.maxValue = this.maxValue < comparisionObject.value 
                    ? comparisionObject.value : this.maxValue;
                
                // add series single data to right place based on previously defined
                // mappings
                this.series[seriesMappings[comparisionObject.network]]
                    .data.unshift(parseInt(comparisionObject.value, 10));
                
            }
            
            if(!seriesMappingInited) 
                seriesMappingInited = true;

        }
     
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        boxController.graphData = null;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr:first').clone();
        var tr = null;
        
        var trFooter = table.find('tfoot tr');
        trFooter.find('.col-value, .col-total').text('0');
        
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.networks.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.networks[i]) {
                var value = boxController.data.networks[i][n];
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
        boxController.afterLoadData();
    },
    
    construct: function () {}
    
});

var BC_CompetitionLedger = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-competition-ledger',
    
    endpoint: 'competition_ledger',

    /**
     * Attach events associated with RecentReviews box, such as expanding review
     * details when the review snippet is being clicked.
     */
    attachBoxEvents: function() {
        var self = this;

        // Attach event for expanding and collapsing review details
        self.getBoxDom().delegate('table tr[data-review-id].reviewSnippet', 'click', function(event){
            event.preventDefault();
            var review_id = $(this).attr('data-review-id');
            log('Toggling details of review with ID="' + review_id + '"');
            self.getBoxDom().find('tr[data-review-id="' + review_id + '"].reviewDetails').toggle('slow');
        });
    },

    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        this.getHeaderDom().find('#box-header-status-filters').html($(this.getLoaderHtml()).children());
        this.getHeaderDom().find('#box-header-source-filters').html($(this.getLoaderHtml()).children());
    },

    /**
     * Get the template for details of specific review
     */
    getReviewDetailsTemplate: function (review_id) {
        return $('<tr data-review-id="' + review_id + '" class="reviewDetails" style="display: none;">'
            + '<td colspan="' + this.getReviewSnippetTemplate().find('td').length + '">some review '
            + 'details placeholder, some review details placeholder, some review details placeholder, '
            + 'some review details placeholder, some review details placeholder, some review details '
            + 'placeholder, some review details placeholder, some review details placeholder, some '
            + 'review details placeholder, some review details placeholder, some review details '
            + 'placeholder, some review details placeholder, some review details placeholder, some '
            + 'review details placeholder</td>'
            + '</tr>');
    },

    /**
     * Get the snippet of specific review
     */
    getReviewSnippetTemplate: function (review_id) {
        return $('<tr data-review-id="' + review_id + '" class="reviewSnippet">'
            //+ '<td class="col-checkbox"></td>' // no need for checkbox
            + '<td class="col-rating"></td>'
            + '<td class="col-submitted a-center"></td>'
            + '<td class="col-title"></td>'
            + '<td class="col-competition a-right"></td>'
            + '</tr>');
    },
    
    loadFilters: function (filterType) {
        if (filterType != 'status') {
            return;
        }
        var filters = this.data.filters[filterType];
        var filterHolder = this.getHeaderDom().find('#box-header-' + filterType + '-filters');
        filterHolder.html('');
        for (var i = 0; i < filters.length; i++) {
            var filterLink = $('<a href="#" data-filter-status="' + filters[i].value.toLowerCase() + '"></a>');
            if (filters[i].total) {
                filterLink.text(filters[i].total +' ');
            }
            filterLink.text(filterLink.text() + filters[i].value);
            filterHolder.append(filterLink);
            filterHolder.append(' ');
        }
    },
    
    loadReviews: function () {
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var tr = null;
        var trContent = null;
        var current_id = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < this.data.reviews.length; i++) {
            current_id = parseInt(this.data.reviews[i].id);
            log('Generating row for review with ID="' + current_id + '"');
            tr = this.getReviewSnippetTemplate(current_id);
            log('Generating content row for review with ID="' + current_id + '"');
            trContent = this.getReviewDetailsTemplate(current_id);
            
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
                } else if (n == 'rating') {
                    var ratingStars = $('<div class="reviewRating"><div class="stars-' + value + '-of-5-front"><!-- ' + value + ' --></div></div>');
                    tr.find('td.col-' + n).html(ratingStars);
                } else {
                    tr.find('td.col-' + n).text(value);
                }
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', this.data.reviews[i].id);
            tr.find('td.col-checkbox').html(checkbox);
            
            table.find('tbody').append(tr, trContent); // append two elements
        }
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().find('.data-grid-holder').show();
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        
        if (data.reviews) {
            boxController.loadReviews();
        }
        
        if (data.filters && data.filters.status) {
            boxController.loadFilters('status');
        }
        
        if (data.filters && data.filters.source) {
            boxController.loadFilters('source');
        }
    },
    
    construct: function () {}
    
});


var BC_CompetitionComparision = LinearGraphBoxController.extend({
   
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
                        pointInterval: (this.computeDateInterval()+1) * this.dayInterval * 1000
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
   
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        
        boxController.afterLoadData();
        

    },
   
    construct: function() {}
   
});

var BC_CompetitionDistribution = GraphBoxController.extend({
 
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
            title: {
                text: this.getHeaderDom().find('.box-header-title').text()
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
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: this.getHeaderDom().find('.box-header-title').text(),
                    align: 'high'
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
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
            series: [{
                name: 'Average',
                data: []
            }, {
                name: 'Negative',
                data: []
            }, {
                name: 'Neutral',
                data: []
            }, {
                name: 'Positive',
                data: []
            }]
        }
        
        for (var i = 0; i < this.graphData.length; i++) {
            var dist = this.graphData[i];
            options.xAxis.categories.push(dist.dealership);
            options.series[0].data.push(dist.average);
            options.series[1].data.push(dist.negative);
            options.series[2].data.push(dist.neutral);
            options.series[3].data.push(dist.positive);
        }
        
        this.graph = new Highcharts.Chart(options);
    },
 
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        boxController.graphData = data.dists;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        
        var trTemplate = table.find('tbody tr:first').clone();
        var tr = null;
        var trFooter = table.find('tfoot tr');
        trFooter.find('th:not(:first)').text('0');
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.dists.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.dists[i]) {
                var value = boxController.data.dists[i][n];
                
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
            boxController.data.dists.length
            );
                
        boxController.afterLoadData();
        

    },
 
    construct: function() {}
 
 
 
});

var BC_SocialMediaInbox = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-media-inbox',

    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'socials',
    
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        this.getHeaderDom().find('#box-header-activity-filters').html($(this.getLoaderHtml()).children());
        this.getHeaderDom().find('#box-header-network-filters').html($(this.getLoaderHtml()).children());
    },
    
    loadHeaderFilters: function (filterType) {
        if (filterType != 'activity' && filterType != 'network') {
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
    
    loadSocials: function () {
        var table = this.getContentDom().find('.data-grid-holder table.data-grid');
        var trTemplate = table.find('tbody tr:first').clone();
        var trContentTemplate = '<tr><td colspan="6"></td></tr>';
        var tr = null;
        var trContent = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < this.data.socials.length; i++) {
            tr = trTemplate.clone();
            
            for (n in this.data.socials[i]) {
                var value = this.data.socials[i][n];
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
                    titleLink.click(function () {
                        $(this).parents('tr:first').next().toggle('slow');
                        return false;
                    });
                    tr.find('td.col-' + n).html(titleLink);
                } 
                else if(n == 'network')
                {

                    var titleLink = $('<a href="#"><span></span></a>');
                    titleLink.attr('class', value.toLowerCase());
                    titleLink.filter('span').text(value);
                    tr.find('td.col-' + n).html(titleLink);

                }
                else {
                    tr.find('td.col-' + n).text(value);
                }
            }
            
            if (i % 2) {
                tr.addClass('even');
            } else {
                tr.addClass('odd');
            }
            
            var checkbox = $('<input type="checkbox" name="id[]" value=""  />');
            checkbox.attr('value', this.data.socials[i].id);
            tr.find('td.col-checkbox').html(checkbox);
            
            table.find('tbody').append(tr);
            
            trContent = $(trContentTemplate);
            trContent.css('display', 'none').find('td').text('adsfsf fsadfsa');
            table.find('tbody').append(trContent);
        }
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().find('.data-grid-holder').show();
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        
        if (data.socials) {
            boxController.loadSocials();
        }
        
        if (data.filters && data.filters.activity) {
            boxController.loadHeaderFilters('activity');
        }
        
        if (data.filters && data.filters.network) {
            boxController.loadHeaderFilters('network');
        }
    },
    
    construct: function () {}
    
});

boxManager = {
    
    collection: {},
    
    dataProvider: null,

    range: null,
    
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
    
    initBoxes: function () {
        for (i in this.collection) {
            this.collection[i].init();
        }
        return this;
    },
    
    init: function () {
        var self = this;
        
        var rangeArray = $('#range-form').serializeArray();
        var range = {};
        
        for (var i = 0; i < rangeArray.length; i++) {
            range[rangeArray[i].name] = rangeArray[i].value;
        }
        this.setRange(range);
        
        this.initBoxes();
        
        $('#range-form').submit(function () {
            var range = {};
            var rangeArray = $(this).serializeArray();
            for (var i = 0; i < rangeArray.length; i++) {
                range[rangeArray[i].name] = rangeArray[i].value;
            }
            self.setRange(range);
            self.clearData();
            self.refresh();
            return false;
        }).find('#period-selector, #date-selector').change(function () {
            $(this).parents('form:first').submit();
        });
        $( ".box" ).draggable({ 
            snap: ".box-container", 
            snapMode: 'inner',
            handle: ".box-header-button-move",
            cursor: 'move',
            cursorAt: { 
                cursor: "move", 
                top: 10, 
                left: 100 
            },
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
    }
};


$(document).ready(function () {
    boxManager.add(new BC_KeywordsAnalysis())
              .add(new BC_Ogsi())
              .add(new BC_ReviewSites())
              .add(new BC_RecentReviews())
              .add(new BC_SocialActivity())
              .add(new BC_SocialReach())
              .add(new BC_SocialMediaInbox())
              .add(new BC_CompetitionDistribution())
              .add(new BC_CompetitionComparision())
              .add(new BC_CompetitionLedger())
              .setDataProvider(new DataProvider())
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


