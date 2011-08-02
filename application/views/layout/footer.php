<div id="footer-holder">
    
    <?php $routes = array(
        
        'legal' => 'Legal',
        'tos' => 'Terms of Service',
        'privacy' => 'Privacy',
        'blog' => 'Blog',
        
    ); ?>
    
    <?php echo html::anchor(url::base(), __('Home')); ?> |
    <?php foreach($routes as $route => $label): ?>
    
        <?php echo html::anchor(
            Route::get('pages')->uri(array(
                'name' => $route
            )),
            $label
        ), ' | '; ?>
    
    <?php endforeach; ?>

    <div id="copyrights">
        &copy; Copyright <?php echo html::anchor(url::base(), 'Grapevine') ?> 2011
    </div>
</div>

