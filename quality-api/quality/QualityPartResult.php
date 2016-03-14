<?php
/**
 * Created by PhpStorm.
 * User: ferdinand
 * Date: 2/24/16
 * Time: 7:50 AM
 */

namespace quality;
require_once 'ApiResource.php';

class QualityPartResult extends ApiResource {
    var $id;

    var $representationId;

    var $start;

    var $end;

    var $values;

    public function __construct(\stdClass $class)
    {
        parent::__construct($class);
    }

    public static function create($json) {
        return new self(json_decode($json));
    }
}