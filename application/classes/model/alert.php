<?php defined('SYSPATH') or die('No direct script access.');

class Model_Alert extends ORM {

    /**
     * List of tags default to the alert settings.
     * @var array
     */
    public static $default_tags = array('aggravate', 'aggravated', 'angry', 'annoy',
            'annoyed', 'argue', 'attack', 'attacked', 'awful', 'bad', 'badgered',
            'belittle', 'belittled', 'bitch', 'bitched', 'boring', 'bother',
            'bothered', 'bullied', 'bully', 'cheat', 'cheated', 'clueless',
            'conn', 'conned', 'cowardly', 'crap', 'crappy', 'criticized',
            'criticized', 'damage', 'damaged', 'defective', 'defiant',
            'degrade', 'degraded', 'dehumanized', 'demean', 'demeaned',
            'despicable', 'dirty', 'disagreeable', 'disappointed',
            'disappointing', 'discriminate', 'discriminated', 'dishonest',
            'dislike', 'disliked', 'disrespect', 'disrespected', 'dumb',
            'egotistical', 'embarrass', 'embarrassed', 'fake', 'frustrated',
            'furious', 'harass', 'harassed', 'hateful', 'horrible', 'ill-temper',
            'ill-tempered', 'incompetent', 'infuriate', 'infuriated', 'insult',
            'insulted', 'irritate', 'irritated', 'lied', 'mad', 'mean',
            'mistreat', 'mistreated', 'offend', 'offended', 'phony', 'pissed',
            'ridiculous', 'rude', 'sarcastic');

    /**
     * Save alert, taking default begaviour into account (if default type has
     * been chosen, override tags with default ones).
     * @param Validation $validation
     * @uses self::$default_tags for determining default value for criteria
     */
    public function save(Validation $validation = NULL) {
        if ($this->type == 'grapevine') {
            $this->criteria = implode(', ', self::$default_tags);
        }
        return parent::save($validation);
    }

}