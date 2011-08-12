<!DOCTYPE HTML>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        foreach ($styles as $style) {
            if (is_string($style)) {
                echo html::style($style);
            } elseif (is_array()) {
                echo html::style(current($style), next($style));
            }
        }

        ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <title><?php echo isset($title) ? $title : 'Grapevine'; ?></title>
    </head>
    <body>
        <?php echo $body; ?>

        <div id="ajax-loader-holder">
            <div class="ajax-loader">
                <?php
                echo html::image(
                        'images/preloader.gif', array(
                    'class' => __('ajax-loading-gif'),
                    'alt' => __('loading ...'),
                    'title' => __('loading ...'),
                ))
                ?>
            </div>
        </div>
        <?php
            foreach ($scripts as $script) {
                if (is_string($script)) {
                    echo html::script($script);
                } elseif (is_array()) {
                    echo html::script(current($style), next($style));
                }
            }
        ?>
    </body>
</html> 