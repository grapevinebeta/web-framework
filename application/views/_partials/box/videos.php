<div id="box-videos" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('Videos'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content padding-5">
        <div class="data-video">
            
            <a  
			 href="http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv"
			 style="display:block;width:335px;height:250px"  
			 id="player"> 
		</a> 
	
		<!-- this will install flowplayer inside previous A- tag. -->
		<script>
			flowplayer("player", "/js/flowplayer/flowplayer-3.2.7.swf");
		</script>
	
            
        </div>
    </div>
</div>