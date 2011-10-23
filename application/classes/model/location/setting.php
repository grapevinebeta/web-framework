<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The class for a single setting.
 * @todo Maybe make it extend ORM?
 */
class Model_Location_Setting extends ORM {

    public function rules() {
        return array(
            'value' => array(
                array('not_empty', null),
                array(array($this, 'is_unique_competitor_for_location')),
            ),
        );
    }
    
    /**
     * Check if the given competitor name can be added for specific location
     * @param string $competitor competitor name to be added
     */
    public function is_unique_competitor_for_location($competitor) {
        
        if ($this->type != 'competitor') {
            return true;
        }
        
        return !(bool) DB::select(array(DB::expr('COUNT(id)'), 'total'))
                ->from($this->_table_name)
                ->where('type', '=', 'competitor')
                ->and_where('value', '=', $competitor)
                ->execute()
                ->get('total');
        
    }

}