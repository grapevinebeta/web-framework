<!DOCTYPE HTML>
<html>
<head>
    <?php 
        foreach ($styles as $style) {
            if (is_string($style)) {
                echo html::style($style);
            } elseif (is_array()) {
                echo html::style(current($style), next($style));
            }
        }
        
        foreach ($scripts as $script) {
            if (is_string($script)) {
                echo html::script($script);
            } elseif (is_array()) {
                echo html::script(current($style), next($style));
            }
        }
        
    ?>
    <title><?php echo isset($title)?$title:'Grapevine'; ?></title>
</head>
<body>
    <div id="main-wrapper">
        <?php echo $header; ?>
        <div id="main-body">
            <div style="margin: 24px">
                <?php if (!empty($topOptions)): ?>
                    <?php echo $topOptions; ?>
                <?php endif; ?>
    
                <?php echo $body; ?>
    
                <?php if (!empty($rightPanel)): ?>
                    <?php echo $rightPanel; ?>
                <?php endif; ?>
                
                <div class="clear"></div>
                
            </div>
        </div>
        <?php echo $footer; ?>
    </div>
    <div id="ajax-loader-holder">
        <div class="ajax-loader">
            <?php echo html::image(
                'images/ajax-loader.gif',
                array(
                    'class' => __('ajax-loading-gif'),
                    'alt' => __('loading ...'), 
                    'title' => __('loading ...'),
                    )) ?>
        </div>
    </div>
</body>
</html> 