<?php

namespace App\Core;

use Nette;

class DbModel {
    use \Nette\SmartObject;

    /** @var Nette\Database\Context */
    protected $db;

    function __construct(Nette\Database\Context $db) {
        $this->db = $db;
    }
}
