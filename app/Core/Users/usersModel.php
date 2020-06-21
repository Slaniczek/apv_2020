<?php

namespace App\Core;

use Nette;

class UsersModel extends DbModel {
    use \Nette\SmartObject;

   public function getUsers($limit = 10): array {
       $arr = [];
       $source = $this->db->query('SELECT * FROM person LIMIT ?', $limit)->fetchAll();
       foreach ($source as $item) {;
            array_push($arr, new \Person((array) $item, $item['id_person']));
       }
       return $arr;
   }

   public function getUserNames(array $userIds): array {
       array_walk_recursive($userIds, function($a) use (&$ids) { $ids[] = $a; });
       if (!isset($ids) or count($ids) == 0) return [];
       $source = $this->db->query('SELECT id_person, nickname FROM person WHERE id_person IN ('.implode(",", $ids).')')->fetchAll();
       return array_reduce((array) $source, function ($arr, $item) {
           $arr[$item['id_person']] = $item['nickname'];
           return $arr;
       });
   }

   public function getUser($id): \Person {
       return new \Person((array) $this->db->query('SELECT * FROM person WHERE id_person = ?', $id)->fetch(), $id);
   }

   public function addUser(\Person $person): void {
        $this->db->query('INSERT INTO person ?', \Person::toSQLReadeble($person));
   }

    public function editUser(\Person $person): void {
        $this->db->query('UPDATE person SET ? WHERE id_person = ?', \Person::toSQLReadeble($person), $person->id);
    }
}