<?php

require_once("DatabaseObject.php");
require_once("Station.php");

class Measurement implements DatabaseObject, JsonSerializable
{
    private $id;
    private $time;
    private $temperature;
    private $rain;
    private $station_id;   // ID of station
    private $station;      // ORM of station

    private $errors = [];

    public function validate()
    {
        return $this->validateTime() & $this->validateTemperature() & $this->validateRain() & $this->validateStationId();
    }

    /**
     * create or update an object
     * @return boolean true on success
     */
    public function save()
    {
        if ($this->validate()) {
            if ($this->id != null && $this->id > 0) {
                $this->update();
            } else {
                $this->id = $this->create();
            }

            return true;
        }

        return false;
    }

    /**
     * Creates a new object in the database
     * @return integer ID of the newly created object (lastInsertId)
     */
    public function create()
    {

    }

    /**
     * Saves the object to the database
     */
    public function update()
    {

    }

    /**
     * Get an object from database
     * @param integer $id
     * @return object single object or null
     */
    public static function get($id)
    {

    }

    public static function getAll() {

    }

    /**
     * Get an array of objects from database
     * @param int $station_id
     * @return array array of objects or empty array
     */
    public static function getAllByStation($station_id)
    {

    }

    /**
     * Deletes the object from the database
     * @param integer $id
     */
    public static function delete($id)
    {

    }

    private function validateTime()
    {
        try {
            if ($this->time == '') {
                $this->errors['time'] = "Messzeitpunkt darf nicht leer sein";
                return false;
            } else if (new DateTime($this->time) > new DateTime()) {
                $this->errors['time'] = "Messzeitpunkt " . htmlspecialchars($this->time) . " darf nicht in der Zukunft liegen";
                return false;
            } else {
                unset($this->errors['time']);
                return true;
            }
        }catch (Exception $e) {
            $this->errors['time'] = "Messzeitpunkt " . htmlspecialchars($this->time) . " ungültig";
            return false;
        }
    }

    private function validateTemperature()
    {
        if ((!is_numeric($this->temperature) && !is_double($this->temperature)) || $this->temperature < -50 || $this->temperature > 150) {
            $this->errors['temperature'] = "Temperatur ungueltig";
            return false;
        } else {
            unset($this->errors['temperature']);
            return true;
        }
    }

    private function validateRain()
    {
        if ((!is_numeric($this->rain) && !is_double($this->rain))  || $this->rain < 0 || $this->rain > 10000) {
            $this->errors['rain'] = "Regenmenge ungueltig";
            return false;
        } else {
            unset($this->errors['rain']);
            return true;
        }
    }

    private function validateStationId()
    {
        if (!is_numeric($this->station_id) && $this->station_id <= 0) {
            $this->errors['station_id'] = "StationID ungueltig";
            return false;
        } else {
            unset($this->errors['station_id']);
            return true;
        }
    }

    /**
     * @return boolean
     */
    public function hasError($field)
    {
        return !empty($this->errors[$field]);
    }

    /**
     * @return array
     */
    public function getError($field)
    {
        return $this->errors[$field];
    }

    public function jsonSerialize()
    {
        $data = [
            "id" => intval($this->id),
            "time" => $this->time,
            "temperature" => round(doubleval($this->temperature), 2),
            "rain" => round(doubleval($this->rain), 2),
        ];

        if ($this->station_id != null && is_numeric($this->station_id)) {
            $data['station_id'] = intval($this->station_id);      // include id
        }

        if ($this->station != null && is_object($this->station)) {
            $data['station'] = $this->station;      // include object
        }

        return $data;
    }

}
