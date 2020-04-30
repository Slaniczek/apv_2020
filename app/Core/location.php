<?php

class Location
{
    public $id;
    public $city;
    public $streetName;
    public $streetNumber;
    public $zip;
    public $country;
    public $name;
    public $latitude;
    public $longitude;


    public function __construct(array $data, $id = null)
    {
        $this->id = (int)$id;
        $this->city = $data['city'];
        $this->streetName = $data['street_name'];
        $this->streetNumber = $data['street_number'];
        $this->zip = $data['zip'];
        $this->country = $data['country'];
        $this->name = $data['name'];
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }

    public static function toSQLReadeble(Location $location): array
    {
        return [
            'city' => $location->city,
            'street_name' => $location->streetName,
            'street_number' => $location->streetNumber,
            'zip' => $location->zip,
            'country' => $location->country,
            'name' => $location->name,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ];
    }
}