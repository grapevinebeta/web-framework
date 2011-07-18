<div id="boxes-holder">

    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
    <div class="box-container active box-container-left">
        <?php echo view::factory('_partials/box/social-activity'); ?>
    </div>

    <div class="box-container active box-container-right">
        <?php echo view::factory('_partials/box/social-reach'); ?>
    </div>
    <div class="clear"></div>
    <div class="box-container active ignore">
        <?php echo view::factory('_partials/box/social-media-inbox'); ?>
    </div>
    
    <div class="box-container box-container-left active ignore">
        <?php echo view::factory('_partials/box/videos'); ?>
    </div>
    <div class="box-container box-container-right active ignore">
        <?php echo view::factory('_partials/box/photos'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
