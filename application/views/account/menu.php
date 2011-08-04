<div id="account-settings-menu">
    <div class="padding-2">
        <div class="menu-title">
            <?php echo __('Settings'); ?>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo html::anchor('account/general', __('General'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/users', __('Users'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/alerts', __('Alerts'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/reports', __('Reports'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/competitors', __('Competitors'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/socials', __('Social Media'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-title">
                <?php echo html::anchor('account/billing', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
    </div>
</div>
