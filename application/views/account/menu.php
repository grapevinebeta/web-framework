<div id="account-settings-menu">
    <div class="padding-2">
        <div class="menu-title">
            <?php echo __('Settings'); ?>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('General'); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/general', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('Users'); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/users', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('Alerts & Reports'); ?>
            </div>
            <div class="menu-section-item">
                <?php echo html::anchor('account/alerts', __('Alerts'), array('class' => 'menu-section-item-link')); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/reports', __('Reports'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('Competitors'); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/competitors', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('Social Media'); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/socials', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
        <div class="menu-section">
            <div class="menu-section-title">
                <?php echo __('Billing'); ?>
            </div>
            <div class="menu-section-item last">
                <?php echo html::anchor('account/billing', __('Manage'), array('class' => 'menu-section-item-link')); ?>
            </div>
        </div>
    </div>
</div>
