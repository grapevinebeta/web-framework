var credentials;
function checkCredentials(response, callback) {
        
        
    if (response.perms) {
            
        var perms = $.parseJSON(response.perms);
        for(var i=0; i < perms.extended.length; i++) {
                
            if(perms.extended[i] == 'offline_access' && credentials.facebook_page_name) {
                    
                $('.login').removeClass('hide').html('<p style="font-size:16px; font-weight:bold;">You are linked as ' + credentials.facebook_page_name + '</p>');
                    
                if(callback)
                    callback();
                    
                return;
                    
            }
                
        }
            
    }
        
    if(callback)
        callback();
            
    $('.login').removeClass('hide')
        
    return;
}
    
window.fbAsyncInit = function() {
    FB.init({
        appId  : credentials.appId,
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true  // parse XFBML
    });
        
    FB.getLoginStatus(function(response) {
            
        checkCredentials(response, function() {
                
            FB.Event.subscribe('auth.statusChange', function(response) {
                    
                    
                if(response.status == "connected")
                {

                    FB.api('/me/accounts', function(response) {
                        if (!response || response.error) {
                            alert('Error with facebook connection');
                        } else {
                            var option, select = document.createElement('select');
                            select.setAttribute('name', 'page_selector');
                            select.setAttribute('id', 'page_selector');
                                
                            option = document.createElement('option');
                            option.setAttribute('value', '');
                            option.innerHTML = 'Please select page that you want to connect';
                            select.appendChild(option);

                            for(var i in response.data) {
                                    
                                option = document.createElement('option');
                                option.setAttribute('value', response.data[i].id);
                                option.setAttribute('token', response.data[i].access_token);
                                option.innerHTML = response.data[i].name;
                                select.appendChild(option);
                                    
                            }
                           
                            $('.login').html(select).delegate('select','change', function() {
                                    
                                var selected = $(this).children("option:selected");
                                    
                                if(!selected.attr('value'))
                                    return;
                                    
                                $.post('/api/settings/facebook', {
                                    'facebook_oauth_token' : selected.attr('token'),
                                    'facebook_page_id' : selected.attr('value'),
                                    'facebook_page_name' : selected.text()
                                }, function() {
                                        
                                    $('.login').removeClass('hide').html('<p style="font-size:16px; font-weight:bold;">You are linked as ' + selected.text() + '</p>');
                                        
                                });
                                    
                            });

                        }
                    });


                }
                    
            });
                
        });
            
            
    });
        
        
        
};
    
(function() {
        
    $.post('/api/box/auth', null, function(data) {
            
            
        credentials = data;
            
        if(data.twitter_url) {

            $('.twitter').attr({
                href: data.twitter_url
            });
                
        }
        else if(data.twitter_account)
        {

            $('.twitter_login').html('<p style="font-size:16px; font-weight:bold;">You are linked as ' + credentials.twitter_account + '</p>');
                

        }
        else {
            alert('Nie skonfigurowano klucza aplikacji');
        }

        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
            
    });
        
        
}());