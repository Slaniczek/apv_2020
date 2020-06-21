<?php

namespace App\Core;

use Nette;

class ContactModel extends DbModel {
    use \Nette\SmartObject;

    public function getContacts($limit = 10): array {
        $arr = [];
        $source = $this->db->query('SELECT id_contact, contact.id_person, contact.id_contact_type, person.nickname ,name, contact, validation_regexp FROM contact LEFT JOIN contact_type ON contact.id_contact_type = contact_type.id_contact_type LEFT JOIN person ON contact.id_person = person.id_person LIMIT ?', $limit)->fetchAll();
        foreach ($source as $item) {
            array_push($arr, new \Contact((array) $item, $item['id_contact']));
        }
        return $arr;
    }


    public function getContactTypes(): array {
        $arr = [];
        $source = $this->db->query('SELECT * FROM contact_type')->fetchAll();
        foreach ($source as $item){
            array_push($arr, new \ContactType((array) $item, $item['id_contact_type']));
        }
        return $arr;
    }

    public function getContactTypeById($id): \ContactType {
        $arr = [];
        $source = $this->db->query('SELECT * FROM contact_type WHERE id_contact_type = ?', $id)->fetch();
        return new \ContactType((array)$source, $id);
    }

    public function getContactById($id): \Contact {
        $source = $this->db->query('SELECT id_contact, id_person, contact.id_contact_type ,name, contact, validation_regexp FROM contact LEFT JOIN contact_type ON contact.id_contact_type = contact_type.id_contact_type WHERE id_contact = ?', $id)->fetch();
        if($source !== null) {
            return new \Contact((array) $source, $id);
        } else {
            throw new Nette\Neon\Exception('Contact doesn\'t found');
        }
    }

    public function getContactsByPersonId($id_person, $limit = 25): array {
        $contacts = [];
        $queryRes = $this->db->query('SELECT id_contact, id_person, contact.id_contact_type ,name, contact, validation_regexp FROM contact LEFT JOIN contact_type ON contact.id_contact_type = contact_type.id_contact_type WHERE id_person = ? LIMIT ?', $id_person, $limit)->fetchAll();
        foreach ($queryRes as $contactRes) {
            array_push($contacts, new \Contact((array) $contactRes, $contactRes['id_contact']));
        }
        return $contacts;
    }

    public function updateContacts(array $contacts): void {
        $this->db->query("INSERT INTO contact (id_contact, id_person, id_contact_type) VALUES ? ON DUPLICATE KEY UPDATE id_person = VALUES(id_person), id_contact_type = VALUES(id_contact_type)", implode(', ', $contacts));
    }

    public function addContact(\Contact $contact): void {
        $this->db->query('INSERT INTO contact ?', \Contact::toSQLReadeble($contact));
    }
    public function editContact(\Contact $contact): void {
        $this->db->query('UPDATE contact SET ? WHERE id_contact = ?', \Contact::toSQLReadeble($contact), $contact->id);
    }

    public function addContactType(\ContactType $contactType): void {
        $this->db->query('INSERT INTO contact_type ?', \ContactType::toSQLReadeble($contactType));
    }
    public function editContactType(\ContactType $contactType): void {
        $this->db->query('UPDATE contact_type SET ? WHERE id_contact_type = ?', \ContactType::toSQLReadeble($contactType), $contactType->id);
    }

    public function loadContactTypeById($id, &$data) {
        $contactType = $this->getContactTypeById($id);

        $data['name'] = $contactType->name;
        $data['validation_regexp'] = $contactType->validationRegExp;
        $data['id_contact_type'] = $contactType->id;
    }
}