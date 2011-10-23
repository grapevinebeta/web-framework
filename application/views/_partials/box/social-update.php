<div id="box-status-updates" class="box">
    <?php
    echo View::factory(
            '_partials/box/header', array(
        'caption' => __('status updates'),
        'buttons' => array('dashboard-pin', 'move'),
            )
    );
    ?>
    <div class="box-content">
        <div class="data-grid-holder">
            <div class="status-updater network">
                <form method="post" action="/api/box/status" id="wallPoster">
                
                    <div class="message">
                        <span>Your message has been shared</span>
                    </div>
                    
                <textarea class="content" name="message"></textarea>

                <span class="counter"></span>
                
                <div class="buttons right">
                    
                    <span class="facebook_checkbox">
                        <input id="facebook_send" type="checkbox" name="facebook" checked="checked" />
                        <label for="facebook_send" >
                            <span class="icon facebook"></span>
                            <span class="page_name"></span>
                        </label>
                    </span>
                    
                    <span class="twitter_checkbox">
                        <input id="twitter_send" type="checkbox" name="twitter" checked="checked" />
                        <label for="twitter_send">
                            <span class="icon twitter"></span
                            ><span class="twitter_account"></span>
                        </label>
                    </span>
                    <button type="submit"><?php echo __('Share'); ?></button>

                </div>
                <div class="clear"></div>

                </form>
            </div>
        </div>    
    </div>
</div>
<?php echo html::script('js/jquery.charCount.js'); ?>
<script>

</script>