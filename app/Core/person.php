<?php

class Person {
    public $id;
    public $nickname;
    public $firstName;
    public $lastName;
    public $idLocation;
    public $birthDay;
    public $height;
    public $gender;

    public function __construct(array $data, $id = null)
    {
        $this->id = (int) $id;
        $this->nickname = $data['nickname'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->idLocation = (int) $data['id_location'];
        $this->birthDay = $data['birth_day'];
        $this->height = (int) $data['height'];
        $this->gender = $data['gender'];
    }

    public static function toSQLReadeble(Person $person): array {
        return [
            'nickname' => $person->nickname,
            'first_name' => $person->firstName,
            'last_name' => $person->lastName,
            'id_location' => $person->idLocation,
            'birth_day' => $person->birthDay,
            'height' => $person->height,
            'gender' => $person->gender
        ];
    }
}