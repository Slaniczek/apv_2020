<?php

namespace App\Core;

use Nette;

class MeetingModel extends DbModel {
    use \Nette\SmartObject;

    public function getMeetings($limit = 10): array {
        $arr = [];
        $source = $this->db->query('SELECT * FROM meeting LIMIT ?', $limit)->fetchAll();
        foreach ($source as $item) {
            array_push($arr, new \Meeting((array) $item, $item['id_meeting']));
        }
        return $arr;
    }

    public function removeMeeting($id){
        $this->db->query('DELETE FROM person_meeting WHERE id_meeting = ?; DELETE FROM meeting WHERE id_meeting = ?', $id, $id);
    }

    public function getMeetingById($id): \Meeting {
        return new \Meeting((array) $this->db->query('SELECT * FROM meeting WHERE id_meeting = ?', $id)->fetch(), $id);
    }

    public function getPeopleOnMeeting($id): array {
        return (array) $this->db->query('SELECT id_person FROM person_meeting WHERE id_meeting = ?', $id)->fetchAll();
    }

    public function getMeetingsByPersonId($id, $limit = 10): array {
        $arr = [];
        $source = $this->db->query('SELECT meeting.id_meeting, start, description, duration, id_location FROM meeting INNER JOIN person_meeting ON person_meeting.id_meeting = meeting.id_meeting WHERE person_meeting.id_person = ? ORDER BY start DESC LIMIT ?', $id, $limit)->fetchAll();
        foreach ($source as $item) {
            array_push($arr, new \Meeting((array) $item, $item['id_meeting']));
        }
        return $arr;
    }

    public function addMeeting(\Meeting $meeting): void {
        $this->db->query('INSERT INTO meeting ?;', \Meeting::toSQLReadeble($meeting));
    }
    public function editMeeting(\Meeting $meeting): void {
        $this->db->query('UPDATE meeting SET ? WHERE id_meeting = ?', \Meeting::toSQLReadeble($meeting), $meeting->id);
    }


    public function updatePersonsOnMeeting($persons, $id) {
        $this->db->query('DELETE FROM person_meeting WHERE id_meeting = ?', $id);
        $this->db->query('INSERT INTO person_meeting ?;', array_map(function($item) use ($id){
            return [
                'id_meeting' => (int) $id,
                'id_person' => (int) $item
            ];
        }, $persons));
    }
}