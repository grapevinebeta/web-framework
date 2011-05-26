<div id="header-holder">
    <div id="header-menu" class="right padding-10">
        <?php echo _('Hello'), ' ',  'jacek.kromski@polcode.com'; //temporary ?> | 
        <?php echo html::anchor('account', _('Account Settings')) ?> |
        <?php echo html::anchor('account/logout', _('Logout')); ?> | 
        <?php echo html::anchor('support', _('Support')); ?>
    </div>
    <div class="padding-10 left">
        <a href="<?php echo url::base(); ?>">
            <?php echo html::image('images/logo.jpg', array('alt' => 'Logo')); ?>
        </a>
    </div>
    <?php echo $menu; ?>
</div>