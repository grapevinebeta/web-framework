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
            <?php if (!empty($topOptions)): ?>
                <?php echo $topOptions; ?>
            <?php endif; ?>

            <?php if (!empty($rightPanel)): ?>
                <?php echo $rightPanel; ?>
            <?php endif; ?>

            <?php echo $body; ?>
        </div>
        <?php echo $footer; ?>
    </div>
    <div id="ajax-loader-holder">
        <div class="ajax-loader">
            <?php echo html::image(
                'images/ajax-loader.gif', 
                array('alt' => _('loading ...'), 'title' => _('loading ...') )) ?>
        </div>
    </div>
    <script type="text/javascript">
        var b = BoxController();
    </script>
</body>
</html> 