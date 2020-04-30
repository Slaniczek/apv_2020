<?php

namespace App\Core;

use Nette;

class LocationsModel extends DbModel {
    use \Nette\SmartObject;

    public function getLocations($limit = 10): array {
        $arr = [];
        $source = $this->db->query('SELECT * FROM location LIMIT ?', $limit)->fetchAll();
        foreach ($source as $item) {
            array_push($arr, new \Location((array) $item, $item['id_location']));
        }
        return $arr;
    }

    public function getLocation($id): \Location {
        return new \Location((array) $this->db->query('SELECT * FROM location WHERE id_location = ?', $id)->fetch(), $id);
    }

    public function addLocation(\Location $location): void {
        $this->db->query('INSERT INTO location ?', \Location::toSQLReadeble($location));
    }
    public function editLocation(\Location $location): void {
        $this->db->query('UPDATE location SET ? WHERE id_location = ?', \Location::toSQLReadeble($location), $location->id);
    }
}