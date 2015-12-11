<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 01:04
 */
function __autoload($className) {
    $filename = "../" . $className . ".php";
    if(file_exists($className)) {
        //echo "(Prog) Loading: " . $className;
        require_once $className;
        return true;
    }
    if (file_exists($filename)) {
        //echo "(Prog) Loading: " . $filename;
        require_once $filename;
        return true;
    }
    //echo "(Prog) Cannot load: " . $filename;
    return false;
}
