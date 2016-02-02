<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 11.12.2015
 * Time: 01:04
*/

/**
 * @param $className
 * @return bool
 */
function __autoload($className) {
    $filename = $className . ".php";
    $filenameUp = "..\\" . $filename;
    if(file_exists($className)) {
        echo "(Prog) Loading: " . $className;
        require_once $className;
        return true;
    }
    if (file_exists($filename)) {
        echo "(Prog) Loading: " . $filename;
        require_once $filename;
        return true;
    }
    else if(file_exists($filenameUp)) {
        echo "(Prog) Loading: " . $filenameUp;
        require_once $filenameUp;
        return true;
    }
    echo "(Prog) Cannot load: " . $filename . "\n";
    echo "(Prog) Cannot load: " . $filenameUp . "\n";
    return false;
}
