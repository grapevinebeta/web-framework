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
            <p>for preview please look at <a href="http://www.facebook.com/pages/Adamczewski-inc/225509304157435?sk=wall"><strong>this wall</strong></a></p>
            <div class="status-updater network">
                
                
                <form method="post" action="/api/box/status" id="wallPoster">
                    
                <textarea class="content" name="message"></textarea>

                <div class="buttons right">

                    <input id="facebook_send" type="checkbox" name="facebook" checked="checked" />
                    <label for="facebook_send" >
                        <span class="icon facebook"></span>
                        Łukasz Adamczewski    
                    </label>                           
                    <input id="twitter_send" type="checkbox" name="twitter" checked="checked" />
                    <label for="twitter_send"><span class="icon twitter"></span>@tworzenieweb</label>
                    <button type="submit">Share</button>

                </div>
                <div class="clear"></div>

                </form>
            </div>
        </div>    
        <script>
                        
            (function() {
                
                $('#wallPoster').bind('submit', function(e) {
                    
                    
                    $('#wallPoster .content').attr('disabled', 'disabled');
                    
                    e.preventDefault();
                    
                    $.post('/api/box/status', {message: $(e.target).children('textarea').val()}, function(data) {
                        $('#wallPoster .content').removeAttr('disabled');
                    });
                    
                });
                
                
            }());
        </script>

    </div>
</div>