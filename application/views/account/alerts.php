<h1 class="content-title">
    <?php echo __('Alerts'); ?>
</h1>
<div id="alertsSettings">
    <h2 class="content-section-title"><?php echo __('Tags'); ?>:</h2>
    <div id="account-alerts-tags-section" class="padding-5">
        <form action="" method="post" class="alertsSettingsForm">
            <div>
                <?php
                echo form::radio('type', 'my', $alert->type == 'my', array(
                    'data-alerts-tags' => ($alert->type == 'my' ? $alert->criteria : ''),
                )), ' ', __('My Tags');
                ?>
                &nbsp;&nbsp;
                <?php
                echo form::radio('type', 'grapevine', $alert->type == 'grapevine', array(
                    'data-alerts-tags' => 'aggravate, aggravated, angry, annoy, annoyed, '
                        . 'argue, attack, attacked, awful, bad, badgered, belittle, belittled, '
                        . 'bitch, bitched, boring, bother, bothered, bullied, bully, cheat, '
                        . 'cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, '
                        . 'criticized, damage, damaged, defective, defiant, degrade, degraded, '
                        . 'dehumanized, demean, demeaned, despicable, dirty, disagreeable, '
                        . 'disappointed, disappointing, discriminate, discriminated, dishonest, '
                        . 'dislike, disliked, disrespect, disrespected, dumb, egotistical, '
                        . 'embarrass, embarrassed, fake, frustrated, furious, harass, harassed, '
                        . 'hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, '
                        . 'infuriated, insult,  insulted, irritate, irritated, lied, mad, mean, '
                        . 'mistreat, mistreated, offend, offended, phony, pissed, ridiculous, '
                        . 'rude, sarcastic',
                )), ' ', __('Grapevine Default');
                ?>
            </div>
            <div>
                <?php echo form::textarea('criteria', $alert->criteria, array('class'=> 'wide', 'rows' => 5)); ?>
            </div>
            <div>
                <?php echo form::submit('', __('Save')); ?>
            </div>
        </form>
    </div>
    <h2 class="content-section-title"><?php echo __('Alerts Review'); ?>:</h2>
    <div id="account-alerts-review-section" class="padding-5">
        <p><?php echo __('By Default'); ?></p>
        <p><?php

        echo __('Notifications will be sent out for all reviews that are 3 Stars or Lower, essentially any review that is either Neutral or Negative. We feel these are high priority ones that need to be reviewed and responded to if possible.');

        ?></p>
    </div>
</div>