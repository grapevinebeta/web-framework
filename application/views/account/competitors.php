<h1 class="content-title">
    <?php echo __('Competitors'); ?>
</h1>
<div id="competitorsSettings">
    <h2 class="content-section-title"><?php echo __('Competition List'); ?>:</h2>
    <div id="account-competitors-list-section" class="padding-5">
        <?php echo __('Grapevine allows you to track and compare your business online reputation with up to 6 competitors. Insert competitors name below, with carefull attention to spelling and verifying official business name before clicking on "Add Competitor" button. We will  manually add any reporter "Unknown" non-matches.'); ?>
        <?php echo View::factory('account/competitors/list', array(
            'competitors' => $competitors,
        )); ?>
        <p><?php

        echo __('Want to change your Competitors? :contact_link', array(
            ':contact_link' => HTML::mailto('info@grapevinebeta.com', __('Contact Us')),
        ));

        ?></p>
    </div>
</div>