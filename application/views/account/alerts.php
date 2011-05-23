<h1 class="content-title">
    <?php echo _('Alerts'); ?>
</h1>
<h2 class="content-section-title"><?php echo _('Keywords'); ?>:</h2>
<div id="account-alerts-keywords-section" class="padding-5">
    <form action="" method="post">
        <div>
            <?php echo form::checkbox('keywords[my]', 1), ' ', _('My Keywords'); ?>
            &nbsp;&nbsp;
            <?php echo form::checkbox('keywords[grapevine]', 1), ' ', _('Grapevine Default'); ?>
        </div>
        <div>
            <?php echo form::textarea('keywords[keywords]', '', array('class'=> 'wide', 'rows' => 5)); ?>
        </div>
    </form>
</div>
<h2 class="content-section-title"><?php echo _('Alerts Review'); ?>:</h2>
<div id="account-alerts-review-section" class="padding-5">
    <?php echo _('By Default'); ?>
</div>