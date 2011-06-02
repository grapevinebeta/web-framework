<div id="top-menu">
    <?php echo html::anchor(Route::url('dashboard'), __('Dashboard'), array('class' => 'top-menu-item')); ?>
    <?php echo html::anchor(Route::url('review'), __('Review Breakdown'), array('class' => 'top-menu-item')); ?>
    <?php echo html::anchor(Route::url('social'), __('Social'), array('class' => 'top-menu-item')); ?>
    <?php echo html::anchor(Route::url('competition'), __('Competition'), array('class' => 'top-menu-item')); ?>
</div>