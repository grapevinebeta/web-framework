<div id="top-menu">
    <?php $currentController = Request::current()->controller(); ?>
    <?php echo html::anchor(
        Route::url('dashboard'), 
        '<span class="top-menu-item-label">' . __('Dashboard') . '</span>', 
        array('class' => 'top-menu-item' . ($currentController == 'dashboard'?' active':''))); ?>
    <?php echo html::anchor(
        Route::url('review'), 
        '<span class="top-menu-item-label">' . __('Review Breakdown') . '</span>', 
        array('class' => 'top-menu-item' . ($currentController == 'review'?' active':''))); ?>
    <?php echo html::anchor(
        Route::url('social'), 
        '<span class="top-menu-item-label">' . __('Social') . '</span>', 
        array('class' => 'top-menu-item' . ($currentController == 'social'?' active':''))); ?>
    <?php if ($_current_location->package != 'starter'): ?>
        <?php echo html::anchor(
            Route::url('competition'),
            '<span class="top-menu-item-label">' . __('Competition') . '</span>',
            array('class' => 'top-menu-item' . ($currentController == 'competition'?' active':''))); ?>
    <?php endif; ?>
    <div class="clear"></div>
</div>