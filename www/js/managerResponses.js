/**
 * This is helper function to help with check sites for reviews reply
 */

Site = {

    sites: [],
    init: function() {
        
        this.sites.push({site: 'dealerrater.com', isResponse: true, url: 'http://www.dealerrater.com/login.aspx' });
        this.sites.push({site: 'mydealerreport.com', isResponse: true, url: 'http://www.mydealerreport.com/dealers/index.php' });
        this.sites.push({site: 'edmunds.com', isResponse: true, url: 'http://www.edmunds.com/era/secure/lb/login.jsp?toUrl=http%3A%2F%2Fwww.edmunds.com%2F' });
        this.sites.push({site: 'maps.google.com', isResponse: true, url: 'https://www.google.com/accounts/ServiceLogin?service=lbc' });
        this.sites.push({site: 'citysearch.com', isResponse: true, url: 'http://www.citysearch.com/members/start' });
        this.sites.push({site: 'insiderpages.com', isResponse: true, url: 'http://www.insiderpages.com/session/new?header_link=true' });
        this.sites.push({site: 'local.yahoo.com', isResponse: true, url: 'https://login.yahoo.com/' });
        this.sites.push({site: 'judysbook.com', isResponse: true, url: 'http://www.judysbook.com/login' });
        this.sites.push({site: 'yp.com', isResponse: true, url: 'http://www.yellowpages.com/oauth/login?url=%2Flogin_success' });
        this.sites.push({site: 'yelp.com', isResponse: true, url: 'https://www.yelp.com/login' });
        this.sites.push({site: 'tripadvisor.com', isResponse: true, url: 'http://www.tripadvisor.com/' });
        this.sites.push({site: 'urbanspoon.com', isResponse: true, url: 'http://www.urbanspoon.com/u/signin?' });
        this.sites.push({site: 'zagat.com', isResponse: false, url: '' });
        
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
  
};