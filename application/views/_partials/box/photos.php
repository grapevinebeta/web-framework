<div id="box-photos" class="box">
    <?php
    echo View::factory(
            '_partials/box/header', array(
        'caption' => __('photos'),
        'buttons' => array('dashboard-pin', 'move'),
            )
    );
    ?>
    <div class="box-content padding-5">
        <div class="assets">
            <a href="http://www.flickr.com/photos/58402146@N02/5934098842/"><img width="322" src="http://farm7.static.flickr.com/6141/5934098842_ae7d7c5466.jpg"></a>
            <div class="controls">
                <div class="prev">
                    <a href="#"><span>prev</span></a>
                </div>
                <div class="desc">
                    <a href="#" class="title">Chevy cruise</a>
                    <span class="date">2/23/2011</span>
                </div>
                <div class="next">
                    <a href="#"><span>next</span></a>
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>
</div>