
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
            this.loadData();
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
    
    /**
     * Called before ajax request, generaly used for set ajax-loader.gif
     */
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
    },
    
    /**
     * Called after ajax request, generaly used for unset ajax-loader.gif 
     * and show new data or display an error
     */
    afterLoadData: function () {
        this.getContentDom().find('.ajax-loader').remove();
        this.getContentDom().children(':first').show();
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
        return this;
    },
    
    /**
     * setter
     * @return BoxController
     */
    setDateInterval: function (dateInterval) {
        return this;
    },
    
    /**
     * Alias for loadData
     * @return BoxController
     */
    refresh: function () {
        this.loadData();
        return this;
    }
    
});

var GraphBoxController = BoxController.extend({
    
    getGraphHolder: function () {
        return $('#' + this.boxId + '-graph-holder'); 
    },
    
    init: function () {
        this.getContentDom().children().hide();
        this.toggleGraph.boxController = this;
        this.getContentDom().parent().find('.box-header-button-show-graph').click(this.toggleGraph);
        if (this.getContentDom().length) {
            this.loadData();
        }
    },
    
    beforeLoadData: function () {
        this.getContentDom().children().hide();
        this.getContentDom().append(this.getLoaderHtml());
        if (this.graph) {
            this.graph.destroy();
        }
    },
    
    toggleGraph: function () {
        var boxControllerId = $(this).parents('.box:first').attr('id');
        var boxController = boxManager.getBox(boxControllerId);
        var box = $(this).parents('.box:first');
        var dataGrid = box.find('.data-grid-holder');
        if (dataGrid.css('display') != 'none') {
            dataGrid.hide();
            box.find('.graph-holder').show();
            if (!box.find('.graph-holder').children().length) {
                boxController.prepareGraph();
            }
            //$(window).resize();
        } else {
            box.find('.graph-holder').hide();
            dataGrid.show();
        }
        return false;
        
    },
    
    prepareGraph: function () {
        alert("'prepareGraph' is not implemented!!!");
    }
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
        if (!this.data) {
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
        for (var i = 0; i < this.data.keywords.length; i++) {
            options.series[0].data.push(new Array(
                this.data.keywords[i].keyword,
                this.data.keywords[i].percent
            ));
        }
        
        this.graph = new Highcharts.Chart(options);
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
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
        
        for (var i = 0; i < this.data.sites.length; i++) {
            var site = this.data.sites[i];
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

var BC_SocialActivity = GraphBoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/activity',
    
    
    prepareGraph: function () {
        if (!this.data) {
            return;
        }
        return;
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
        for (var i = 0; i < this.data.networks.length; i++) {
            options.series[0].data.push(new Array(
                this.data.networks[i].keyword,
                this.data.networks[i].percent
            ));
        }
        
        this.graph = new Highcharts.Chart(options);
        
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.networks.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.networks[i]) {
                var value = boxController.data.networks[i][n];
                if (n == 'change') {
                    value = value + '%';
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

var BC_SocialReach = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-reach',
    
    /**
     * @var String Name of the requested resource, used in Ajax URL
     */
    endpoint: 'social/reach',
    
    prepareGraph: function () {
        if (!this.data) {
            return;
        }
        return;
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
        for (var i = 0; i < this.data.networks.length; i++) {
            options.series[0].data.push(new Array(
                this.data.networks[i].keyword,
                this.data.networks[i].percent
            ));
        }
        
        this.graph = new Highcharts.Chart(options);
        
    },
    
    loadDataCallback: function (data, textStatus, jqXHR) {
        var boxController = this.success.boxController;
        boxController.data = data;
        var table = boxController.getContentDom().find('.data-grid-holder > table');
        var trTemplate = table.find('tbody tr').clone();
        var tr = null;
        table.find('tbody tr').remove();
        for (var i = 0; i < boxController.data.networks.length; i++) {
            tr = trTemplate.clone();
            for (n in boxController.data.networks[i]) {
                var value = boxController.data.networks[i][n];
                if (n == 'change') {
                    value = value + '%';
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

var BC_CompetitionComparision = GraphBoxController.extend({
   
    boxId: 'box-competition-comparision',
    endpoint: 'comparision',
    categories: [],
    series: [],
    seriesLabels: [],
   
  
    /*
     * We iterate throught the json populated object 1 time for x axis labels
     * and second time form data set labels
     */
    prepareCategories: function() {
        
        var key;
        
        for (key in this.data.comparision) {
            
            var date = new Date(key);
            
            this.categories.push(key);
        }
        
        timeObject = this.data.comparision[key];

        for (var cKey in timeObject) {

            var comparisionObject = timeObject[cKey];
            this.seriesLabels.push(comparisionObject['competition']);

        }

        

    },
    
    prepareDataForSet: function(competition)
    {
      
        var data = [];
        
        for (var tKey in this.data.comparision) {
            
            
            timeObject = this.data.comparision[tKey];
            
            for (var cKey in timeObject) {
            
                var comparisionObject = timeObject[cKey];
                
                if(comparisionObject.competition == competition) {
                    data.push(comparisionObject["value"]);
                }
            }
        }
        
        
        
        var set = {name: competition, data: data};

        this.series.push(set);
      
    },
    
    prepareSeries: function() {
      
        for (var key in this.seriesLabels) {

            this.prepareDataForSet(this.seriesLabels[key]);
        }
      
    },
    
   
    prepareGraph: function() {
       
        if (!this.data) {
            return;
        }
        
        this.prepareCategories();
        this.prepareSeries();
        
        var graphHolderId = this.boxId + '-graph-holder';
        
        var graphHolder = $('#' + graphHolderId);
        
        var options = {
            chart: {
                renderTo: graphHolderId,
                defaultSeriesType: 'line'
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
                categories: this.categories,
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
            
            series: this.series
        }
        
        
        console.log(options);
        this.graph = new Highcharts.Chart(options);
       
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
        
        for (var i = 0; i < this.data.dists.length; i++) {
            var dist = this.data.dists[i];
            options.xAxis.categories.push(dist.site);
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

var BC_SocialActivityDetails = BoxController.extend({

    /**
     * @var String DOM id of the container div 
     */
    boxId: 'box-social-activity-details',

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
        var trTemplate = table.find('tbody tr').clone();
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
        this.initBoxes();
        $('#range-form').submit(function () {
            self.setRange($(this).serializeArray());
            self.refresh();
            return false;
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
        for (i in this.collection) {
            this.collection[i].setRange(range);
        }
        return this;
    },
    
    setDateInterval: function (dateInterval) {
        for (i in this.collection) {
            this.collection[i].setDateInterval(dateInterval);
        }
        return this;
    }
};


$(document).ready(function () {
    boxManager.add(new BC_KeywordsAnalysis())
              .add(new BC_ReviewSites())
              .add(new BC_RecentReviews())
              .add(new BC_SocialActivity())
              .add(new BC_SocialReach())
              .add(new BC_SocialActivityDetails())
              .add(new BC_CompetitionDistribution())
              .add(new BC_CompetitionComparision())
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


