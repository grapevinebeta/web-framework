<div id="header-holder">
    <div id="header-menu" class="right padding-10">
        <?php echo __('Hello :user_email', array(
            ':user_email' => $_current_user->email,
        )); //temporary ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor('account', __('Account Settings')) ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor(Route::url('logout'), __('Logout')); ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor('support', __('Support'), array('id' => 'support')); ?>
    </div>
    <div class="left">
        <a href="<?php echo url::base(); ?>">
            <?php echo html::image('images/logo.png', array('alt' => 'Logo')); ?>
        </a>
    </div>
    <?php echo $menu; ?>
    <div class="clear"></div>
</div>
<div id="dialog-support" class="hide" title="Grapevine Support">
    <p>
        
        For help,‭ ‬please email‭ 
        <strong><?php echo html::mailto('info@grapevinebeta.com'); ?></strong> 
        or contact us directly at‭ ‬210.386.0293 
        
    </p>
</div>