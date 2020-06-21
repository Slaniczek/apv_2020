<?php

class Contact
{
    public $id;
    public $idPerson;
    public $contact;
    public $nickname;
    public $contactType;

    public function __construct(array $data, $id = null)
    {
        $this->id = (int)$id;
        $this->idPerson = $data['id_person'];
        $this->contact = $data['contact'];

        $this->contactType = new ContactType([
            'name' => $data['name'],
            'validation_regexp' => $data['validation_regexp']
        ], $data['id_contact_type']);


        Utils::ifset($data['nickname'], $this->nickname, '');
    }

    public static function toSQLReadeble(Contact $contact): array
    {
        return [
            'id_person' => $contact->idPerson,
            'id_contact_type' => $contact->contactType->id,
            'contact' => $contact->contact
        ];
    }
}