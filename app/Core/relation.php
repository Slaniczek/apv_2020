<?php

class Relation
{
    public $id;
    public $userIds;
    public $description;
    public $relationType;



    public function __construct(array $data, $id = null)
    {
        $this->id = (int)$id;
        $this->userIds = [
            $data['id_person1'],
            $data['id_person2']
        ];
        $this->description = $data['description'];
        $this->relationType = new RelationType($data['name'], $data['id_relation_type']);
    }

    public static function toSQLReadeble(Relation $relation): array
    {
        return [
            'id_person1' => $relation->userIds[0],
            'id_person2' => $relation->userIds[1],
            'description' => $relation->description,
            'id_relation_type' => $relation->relationType->id
        ];
    }
}