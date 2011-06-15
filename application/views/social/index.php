<div id="boxes-holder">

    <div class="box-container active">
        <?php echo view::factory('_partials/box/social-activity'); ?>
    </div>

    <div class="box-container active">
        <?php echo view::factory('_partials/box/social-reach'); ?>
    </div>

    <div class="box-container active">
        <?php echo view::factory('_partials/box/social-activity-details'); ?>
    </div>
    
    <div class="box-container box-container-left active">
        <?php echo view::factory('_partials/box/videos'); ?>
    </div>
    <div class="box-container box-container-right active">
        <?php echo view::factory('_partials/box/photos'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="box-container empty box-container-left"></div>
    <div class="box-container empty box-container-right"></div>
    <div class="clear"></div>
    <div class="box-container empty"></div>
    
</div>
