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
                echo html::style($script);
            } elseif (is_array()) {
                echo html::style(current($style), next($style));
            }
        }
        
    ?>
    <title><?php echo isset($title)?$title:'Grapevine'; ?></title>
</head>
<body>
    <div id="main-wrapper">
        <?php echo $header; ?>
        <div id="main-body">
            <?php echo $body; ?>
        </div>
        <?php echo $footer; ?>
    </div>
</body>
</html> 