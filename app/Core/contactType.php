<?php

class ContactType
{
    public $id;
    public $name;
    public $validationRegExp;


    public function __construct(array $data, $id = null)
    {
        $this->id = (int)$id;
        $this->name = $data['name'];
        $this->validationRegExp = $data['validation_regexp'];
    }

    public static function toSQLReadeble(ContactType $contactType): array
    {
        return [
            'name' => $contactType->name,
            'validation_regexp' => $contactType->validationRegExp
        ];
    }
}