<div id="box-social-activity-box" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('social activity'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content">
        <div class="data-grid-holder">
            
        </div>
    </div>
</div>