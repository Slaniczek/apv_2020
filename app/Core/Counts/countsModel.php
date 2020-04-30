<?php

namespace App\Core;

use Nette;

class CountsModel extends DbModel {
    use \Nette\SmartObject;

    public function getPersonsCount(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM person')->fetchField();
    }

    public function getMeetingsCount(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM meeting')->fetchField();
    }

    public function getLocationsCount(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM location')->fetchField();
    }

    public function getRelationsCount(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM relation')->fetchField();
    }
}