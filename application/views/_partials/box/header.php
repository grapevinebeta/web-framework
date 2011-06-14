<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parameters passed to this view:
 *  - $caption (required) - the name of the box
 *  - $captionUri (optional) - target link of the caption
 *  - $buttons (optional) - array with code names of the buttons, e.g. show-graph,
 */

if (!isset($buttons)) {
    $buttons = array();
}
 
?>

<div class="box-header">
    <div class="box-header-right-buttons">
        <?php 
            if (in_array('show-graph', $buttons)):
                echo html::anchor(
                    '#', '', 
                    array(
                        'title' => __('Chart'),
                        'class' => 'box-header-button box-header-button-show-graph', 
                        )
                    );
            endif;
            if (in_array('show-data', $buttons)):
                echo html::anchor(
                    '#', '', 
                    array(
                        'title' => __('Data Grid'),
                        'class' => 'box-header-button box-header-button-show-data', 
                        )
                    );
            endif;
            if (in_array('dashboard-pin', $buttons)):
                echo html::anchor(
                    '#', '', 
                    array(
                        'title' => __('Dashboard Pin'),
                        'class' => 'box-header-button box-header-button-dashboard-pin', 
                        )
                    );
            endif;
        ?>
    </div>
    <div class="box-header-left-buttons">
        <?php 
            if (in_array('move', $buttons)):
                echo html::anchor(
                    '#', '', 
                    array(
                        'title' => __('Move'),
                        'class' => 'box-header-button box-header-button-move', 
                        )
                    );
            endif;
        ?>
    </div>
    <?php if (empty($captionUri)): ?>
        <span class="box-header-title"><?php echo html::chars($caption); ?></span>
    <?php else: ?>
        <a href="<?php echo $captionUri; ?>" class="box-header-title"><?php echo html::chars($caption); ?></a>
    <?php endif;?>
    <div class="clear"></div>
</div>