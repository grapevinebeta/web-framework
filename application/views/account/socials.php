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
            <p>
                <?php
                echo View::factory('account/_partials/_social_disconnect', array(
                    'network' => 'Facebook',
                ));
                ?>
            </p>
            
            <div class="a-right">

            </div>
        </form>
    </div>
    <h2 class="content-section-title"><?php echo __('Twitter'); ?>:</h2>
    <div id="account-socials-twitter-section" class="padding-5">
        <?php echo __('For best results, please click on "Connect with Twitter" button. If you don\'t have an access to or are not an admin for your business Twitter account, please contact your Twitter account administrator (including any responsible 3rd party) on assistance on this step.'); ?>
        <div class="twitter_login">
            <?php
                echo html::anchor(Route::url('oauth_twitter_connect', array(
                    'location_id' => (int)$location_id,
                )), '<span>' . __('Connect with Twitter') . '</span>', array('class' => 'twitter-connect-button'));
            ?>
        </div>
        <p>
            <?php
            echo View::factory('account/_partials/_social_disconnect', array(
                'network' => 'Twitter',
            ));
            ?>
        </p>
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
<?php echo HTML::script('js/social.js'); ?>