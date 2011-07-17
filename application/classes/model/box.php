<?php defined('SYSPATH') or die('No direct script access.');


class Model_Box extends Model_Database {

    const TABLE = 'box_settings';

    /**
     * Create initial settings
     * @param type $settings
     * @return type 
     */
    public function persists($settings) {
        
        foreach($settings as $setting) {
            DB::insert(self::TABLE, array_keys($setting))->values(array_values($setting))->execute($this->_db);
        }
        
        
    }
    
    /**
     * Return all positions for specific location
     * @return Kohana_Database_Result 
     */
    public function getPositions($locationId, $sectionId) {
        
        $rs = DB::select('*')
                ->from(self::TABLE)
                ->where('location_id', '=', $locationId)
                ->and_where('section_id', '=', $sectionId)
                ->execute($this->_db);
        
        return $rs;
        
    }
    
    public function updateByBoxHolderId($holderId, $settings, $deletePrevious) {

        if($deletePrevious) {
            DB::delete(self::TABLE)
            ->where('box_id', '=', $settings['box_id'])
            ->where('section_id', '=', $settings['section_id'])->execute($this->_db);
            DB::insert(self::TABLE, array_keys($settings))->values(array_values($settings))->execute($this->_db);
        }
        
        
        return DB::update(self::TABLE)
                ->set($settings)
                ->where('holder_id', '=', $holderId)
                ->where('location_id', '=', $settings['location_id'])
                ->execute($this->_db);
        
    }
    
    
    
    
}