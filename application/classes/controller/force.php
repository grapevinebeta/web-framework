<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:19 PM
 */

class Controller_Force extends Controller
{

    public function action_index()
    {
        echo Auth::instance()->login('tomasz.jaskowski', 'maslo11');
    }
}
