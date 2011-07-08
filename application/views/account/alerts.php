<h1 class="content-title">
    <?php echo __('Alerts'); ?>
</h1>
<h2 class="content-section-title"><?php echo __('Tags'); ?>:</h2>
<div id="account-alerts-tags-section" class="padding-5">
    <form action="" method="post">
        <div>
            <?php echo form::checkbox('tags[my]', 1), ' ', __('My Tags'); ?>
            &nbsp;&nbsp;
            <?php echo form::checkbox('tags[grapevine]', 1), ' ', __('Grapevine Default'); ?>
        </div>
        <div>
            <?php echo form::textarea('tags[tags]', '', array('class'=> 'wide', 'rows' => 5)); ?>
        </div>
    </form>
</div>
<h2 class="content-section-title"><?php echo __('Alerts Review'); ?>:</h2>
<div id="account-alerts-review-section" class="padding-5">
    <?php echo __('By Default'); ?>
</div>