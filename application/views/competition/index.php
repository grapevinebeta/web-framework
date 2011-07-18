<div id="boxes-holder">

    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
    
    <div class="box-container active">
        <?php echo view::factory('_partials/box/competition-comparition'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="box-container active">
        <?php echo view::factory('_partials/box/competition-score'); ?>
    </div>
    
    <div class="box-container active">
        <?php echo view::factory('_partials/box/competition-distribution'); ?>
    </div>
    
    <div class="box-container active ignore">
        <?php echo view::factory('_partials/box/competition-review-inbox'); ?>
    </div>

    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>

</div>
