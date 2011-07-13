<div id="box-photos" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('photos'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content padding-5">
        <div class="data-grid-holder">
            <table class="wide data-photo">
                <a href="http://www.flickr.com/photos/58402146@N02/5934098842/"><img src="http://farm7.static.flickr.com/6141/5934098842_ae7d7c5466_m.jpg"></a>
            </table>
        </div>
    </div>
</div>