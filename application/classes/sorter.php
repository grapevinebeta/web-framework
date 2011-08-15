<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 11:42 AM
 */
 
class Sorter
{
    protected $column;

    private $direction = 1;

    function __construct($column, $direction = 1)
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    function sort($table)
    {
        uasort($table, array($this, 'compare'));
        return $table;

    }

    function compare($a, $b)
    {
        if ($a[$this->column] == $b[$this->column]) {
            return 0;
        }
        $value = ($a[$this->column] < $b[$this->column]);
        if ($this->direction == 1) {
            return $value ? -1 : 1;
        }
        return $value ? 1 : -1;


    }
}