<div id="boxes-holder">
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
    <div class="box-container active box-container-left">
        <?php echo view::factory('_partials/box/review-sites'); ?>
    </div>
    <div class="box-container active box-container-right">
        <?php echo view::factory('_partials/box/tags-analysis'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="box-container active ignore">
        <?php echo view::factory('_partials/box/reviews-inbox'); ?>
    </div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
<?php echo View::factory('_partials/box/export'); ?>