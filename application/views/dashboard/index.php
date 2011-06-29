<div style="width: 442px; margin: 0px 17px 10px 0px; float: left;">
    <?php echo view::factory('_partials/box/ogsi'); ?>
</div>
<div style="width: 441px; margin: 0px 0px 10px 0px; float: left;">
    <?php echo view::factory('_partials/box/competition-rating'); ?>
</div>
<div class="clear"></div>

<div id="boxes-holder">

    <div class="box-container active ignore">
        <?php echo view::factory('_partials/box/reviews-inbox'); ?>
    </div>

    
    <div class="box-container active box-container-left">
        <?php echo view::factory('_partials/box/review-sites'); ?>
    </div>
    <div class="box-container active box-container-right">
        <?php echo view::factory('_partials/box/keywords-analysis'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="box-container active">
        <?php echo view::factory('_partials/box/social-activity'); ?>
    </div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
