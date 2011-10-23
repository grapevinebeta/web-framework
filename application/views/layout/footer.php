<div id="footer-holder">
    
    <?php $routes = array(
        
        'legal' => 'Legal',
        'tos' => 'Terms of Service',
        'privacy' => 'Privacy',
        'blog' => 'Blog'
        
    ); ?>
    
    <?php echo html::anchor(url::base(), __('Home')); ?> |
    <?php foreach($routes as $route => $label): ?>
    
        <?php
        $link = Route::get('pages')->uri(array(
                            'name' => $route
                        ), $label);
        echo html::anchor(
                $link, $label) . ' | ';
        ?>
    
    <?php endforeach; ?>
    <?php echo html::anchor('http://pickgrapevine.uservoice.com/', 
            __('Feedback & Support'), array('target', '_blank')); ?>

    <div id="copyrights">
        &copy; Copyright <?php echo html::anchor(url::base(), 'Grapevine') ?> <?php echo date('Y'); ?>
    </div>
</div>

