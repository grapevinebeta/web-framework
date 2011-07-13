<div id="box-videos" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('videos'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content padding-5">
        <div class="data-video">
            
            <iframe width="322" height="197" src="http://www.youtube.com/embed/mkTMj0McIvc" 
                    frameborder="0" allowfullscreen></iframe>
	
            <div class="controls">
                <div class="prev">
                <a href="#"><span>prev</span></a>
                </div>
                <div class="desc">
                    <a href="#" class="title">Chevy cruise video</a>
                    <span class="date">2/23/2011</span>
                    <span class="desc">"Checkout the new chevy.."</span>
                </div>
                <div class="next">
                
                    <a href="#"><span>next</span></a>
                    
                </div>
            </div>
        </div>
    </div>
</div>