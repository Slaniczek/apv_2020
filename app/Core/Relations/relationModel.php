<?php

namespace App\Core;

use Nette;

class RelationsModel extends DbModel {
    use \Nette\SmartObject;

    public function getRelations($limit = 10): array {
        $arr = [];
        $source = $this->db->query('SELECT id_relation, id_person1, id_person2, description, relation.id_relation_type, name FROM relation LEFT JOIN relation_type ON relation_type.id_relation_type = relation.id_relation_type LIMIT ?', $limit)->fetchAll();
        foreach ($source as $item) {
            array_push($arr, new \Relation((array) $item, $item['id_relation']));
        }
        return $arr;
    }

    public function getRelationById($id): \Relation {
        return new \Relation((array) $this->db->query('SELECT id_relation, id_person1, id_person2, description, relation.id_relation_type, name FROM relation LEFT JOIN relation_type ON relation_type.id_relation_type = relation.id_relation_type WHERE id_relation = ?', $id)->fetch(), $id);
    }

    public function addRelation(\Relation $relation): void {
        $this->db->query('INSERT INTO relation ?', \Relation::toSQLReadeble($relation));
    }
    public function editRelation(\Relation $relation): void {
        $this->db->query('UPDATE relation SET ? WHERE id_relation = ?', \Relation::toSQLReadeble($relation), $relation->id);
    }


    public function addRelationType(\RelationType $relationType): void {
        $this->db->query('INSERT INTO relation_type ?', \RelationType::toSQLReadeble($relationType));
    }
    public function editRelationType(\RelationType $relationType): void {
        $this->db->query('UPDATE relation_type SET ? WHERE id_relation_type = ?', \RelationType::toSQLReadeble($relationType), $relationType->id);
    }

    public function getRelationTypes(): array {
        $arr = [];
        $source = $this->db->query('SELECT * FROM relation_type')->fetchAll();
        foreach ($source as $item){
            array_push($arr, new \RelationType($item['name'], $item['id_relation_type']));
        }
        return $arr;
    }

    public function getRelationTypeById($id): \RelationType {
        $arr = [];
        $source = $this->db->query('SELECT * FROM relation_type WHERE id_relation_type = ?', $id)->fetch();
        return new \RelationType($source['name'], $id);
    }
    
    public function loadRelationTypeById($id, &$data) {
        $relationType = $this->getRelationTypeById($id);

        $data['name'] = $relationType->name;
        $data['id_relation_type'] = $relationType->id;
    }
}