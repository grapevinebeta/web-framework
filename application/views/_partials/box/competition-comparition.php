<div id="box-competition-comparision" class="box">
    <?php echo View::factory(
        '_partials/box/header', 
        array(
            'caption' => __('competition comparison'),
            'buttons' => array('dashboard-pin', 'move'),
            )
        ); 
    ?>
    <div class="box-content">
        <div id="box-competition-comparision-graph-holder" class="graph-holder"></div>
    </div>
</div>