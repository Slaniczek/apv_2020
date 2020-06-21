<?php

class RelationType
{
    public $id;
    public $name;


    public function __construct($name, $id = null)
    {
        $this->id = (int)$id;
        $this->name = $name;
    }

    public static function toSQLReadeble(RelationType $relationType): array
    {
        return [
            'name' => $relationType->name,
        ];
    }
}