<div id="header-holder">
    <div id="header-menu" class="right padding-10">
        <?php echo __('Hello, :firstname', array(
            ':firstname' => $_current_user->firstname,
        )); //temporary ?>
        <?php if ($_current_user->canManageLocation($_current_location)): ?>
            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <?php echo html::anchor('account', __('Account Settings')) ?>
        <?php endif; ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?php echo html::anchor(Route::url('logout'), __('Logout'), array('class' => 'ignore')); ?>
        
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