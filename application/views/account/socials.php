<h1 class="content-title">
    <?php echo __('Social Media'); ?>
</h1>
<div id="socialMediaSettings">
    <h2 class="content-section-title"><?php echo __('Facebook'); ?>:</h2>
    <div id="account-socials-facebook-section" class="padding-5">
        <?php echo __('To see information posted to your Facebook Wall, you will need to have an unrestricted (public) Facebook Business Page. Click to "Connect to Facebook" button. If you don\'t have an access to or are not an admin for your business Twitter account, please contact your Facebook account administrator (including any responsible 3rd party) on assistance on this step.'); ?>
        <form action="/" method="post">
            <div id="fb-root">
                <div class="login hide" style="">
                    
                    <fb:login-button perms="offline_access, manage_pages, publish_stream"><?php echo __('Connect to Facebook'); ?></fb:login-button>
                    
                </div>
            </div>  
            
            <div class="a-right">

            </div>
        </form>
    </div>
    <h2 class="content-section-title"><?php echo __('Twitter'); ?>:</h2>
    <div id="account-socials-twitter-section" class="padding-5">
        <?php echo __('For best results, please click on "Connect with Twitter" button. If you don\'t have an access to or are not an admin for your business Twitter account, please contact your Twitter account administrator (including any responsible 3rd party) on assistance on this step.'); ?>
        <div class="twitter_login">
            <?php echo html::anchor('#', '<span>' . __('Connect with Twitter') . '</span>', array('class' => 'twitter')); ?>
        </div>
        <p>
            <?php echo __('You may also add a general Twitter "tweet-search" related to your business. You will need to spacify which words (called "tags") and phrses should be used to identify data that is revelant to you. You may type single tags, or entire phrases. You may type any number and combination of tags and phrases, as long as you separate each term with a comma.'); ?>
        </p>
        <p class="i">
            <?php echo __('Examples for search: Anderson Chevrolet, Anderson Chevy, Anderson Chevy dealer'); ?>
            <br />
            <?php echo __('Examples for account name: @AndersonChevrolet'); ?>
        </p>
        <form action="" method="post">
            <table>
                <tr>
                    <td class="a-right"><?php echo __('Twitter Search'); ?>:</td>
                    <td><?php echo form::input('twitter[search]', ''); ?></td>
                </tr>
                <tr>
                    <td class="a-right"><?php echo __('Twitter Account Name'); ?>:</td>
                    <td><?php echo form::input('twitter[account]', ''); ?></td>
                </tr>
            </table>
            <p class="a-right">
                <?php echo form::submit('', __('Save')); ?>
            </p>
        </form>
    </div>
    <h2 class="content-section-title"><?php echo __('Other Social Sites'); ?>:</h2>
    <div id="account-socials-other-section" class="padding-5">
        Description ...
    </div>
</div>
<style>
    

    
</style>

<script>
    
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
                                console.log(response)
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
            
            if(data.twitter_url != '') {

                $('.twitter').attr({
                href: data.twitter_url
                });
                
            }
            else
            {

                $('.twitter_login').html('<p style="font-size:16px; font-weight:bold;">You are linked as ' + credentials.twitter_account + '</p>');
                

            }

            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
            
        });
        
        
    }());
</script>