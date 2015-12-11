<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 07.12.2015
 * Time: 11:15
 */

namespace quality;


class ApiResource extends \stdClass
{
    public function __construct(\stdClass $class)
    {
        $this->_copy($class);
    }

    /**
     * @param $obj
     */
    protected function _copy($obj)
    {
        foreach (get_object_vars($obj) as $key => $val) {
            $this->$key = $val;
        }
    }
}