<div id="account-settings-menu">
    <div class="menu-title">
        <?php echo _('Settings'); ?>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('General'); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/general', _('Manage'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('Users'); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/users', _('Manage'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('Alerts & Reports'); ?>
        </div>
        <div class="menu-section-item">
            <?php echo html::anchor('account/alerts', _('Alerts'), array('class' => 'menu-section-item-link')); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/reports', _('Reports'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('Competitors'); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/competitors', _('Manage'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('Social Media'); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/socials', _('Manage'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-section-title">
            <?php echo _('Billing'); ?>
        </div>
        <div class="menu-section-item last">
            <?php echo html::anchor('account/billing', _('Manage'), array('class' => 'menu-section-item-link')); ?>
        </div>
    </div>
</div>
