<?php

class Meeting
{
    public $id;
    public $description;
    public $start;
    public $duration;
    public $idLocation;
    public $persons;

    public function __construct(array $data, $id = null)
    {;
        $this->id = (int)$id;
        Utils::ifset($data['start'], $this->start, null);
        Utils::ifset($data['persons'], $this->persons, []);
        $this->description = $data['description'];
        $this->duration = $data['duration'];
        $this->idLocation = $data['id_location'];
    }

    public static function toSQLReadeble(Meeting $meeting): array
    {
        return [
            'description' => $meeting->description,
            'duration' => ((string) $meeting->duration),
            'id_location' => $meeting->idLocation,
        ];
    }
}