<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 5:09 PM
 */

class Industry
{



    public static function is_valid($industry)
    {
        $class = new ReflectionClass(get_class(self));
        array_key_exists($industry, array_flip($class->getConstants()));


    }

}
