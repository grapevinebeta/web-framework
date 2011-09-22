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
                'images/preloader.gif',
                array(
                    'class' => __('ajax-loading-gif'),
                    'alt' => __('loading ...'), 
                    'title' => __('loading ...'),
                    )) ?>
        </div>
    </div>
    
    <?php if(isset($_location_switch)): ?>
    <script type="text/javascript">
    
        var LOCATION;
    
        $(document).ready(function() {
            
            $.getJSON('/api/box/location_js?loc=' + <?php echo $_location_id; ?>, function(rs) {
                LOCATION = rs;
                
                var opt = '';
                $.map(LOCATION.locations, function(value, key) {
                    opt += '<option value="' + key + '">' + value + '</option>';
                });
                
                
                
                
                $('body').append('<select name="loc" id="loc">' + opt + '</select>');
                
                $('#loc').bind('change', function() {
                    
                    LOCATION.current_location_id =  parseInt($('option:selected',this).val());
                    
                    boxManager.refresh();
                    
                });
                
            });
            
        });
    
    </script>
    <?php endif; ?>
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