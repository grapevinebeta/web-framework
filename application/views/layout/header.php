<div id="header-holder">
    <div id="header-menu" class="right padding-10">
        <?php echo __('Hello'), ' ',  'jacek.kromski@polcode.com'; //temporary ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor('account', __('Account Settings')) ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor('account/logout', __('Logout')); ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor('support', __('Support')); ?>
    </div>
    <div class="left">
        <a href="<?php echo url::base(); ?>">
            <?php echo html::image('images/logo.jpg', array('alt' => 'Logo')); ?>
        </a>
    </div>
    <?php echo $menu; ?>
    <div class="clear"></div>
</div>