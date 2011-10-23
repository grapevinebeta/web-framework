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
        <div class="assets">
            
            <a href="http://www.youtube.com/embed/mkTMj0McIvc?autoplay=1" class="thumb">
                <img src="http://img.youtube.com/vi/mkTMj0McIvc/0.jpg" width="322" />
            </a>
	
            <div class="controls">
                <div class="prev">
                <a href="#"><span>prev</span></a>
                </div>
                <div class="desc">
                    <a href="http://www.youtube.com/embed/mkTMj0McIvc?autoplay=1" class="title" title="Chevy cruise video">Chevy cruise video</a>
                    <span class="date">2/23/2011</span>
                    <span class="text">"Checkout the new chevy.."</span>
                </div>
                <div class="next">
                    <a href="#"><span>next</span></a>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="playlist">
                <a href="http://www.youtube.com/embed/mkTMj0McIvc?autoplay=1" title="Chevy cruise video">
                   <img src="http://img.youtube.com/vi/mkTMj0McIvc/0.jpg" width="322" />
                   <span class="date">2/23/2011</span>
                   <span class="text">"Checkout the new chevy.."</span>
                </a>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        
        $(".thumb, .title").colorbox({iframe:true, innerWidth:425, innerHeight:344});
        
    });

</script>