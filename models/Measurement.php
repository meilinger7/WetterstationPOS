<?php

require_once("DatabaseObject.php");
require_once("Station.php");

class Measurement implements DatabaseObject, JsonSerializable
{
    private $id;
    private $time;
    private $temperature;
    private $rain;
    private $station_id;
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
        $db = Database::connect();
        $sql = "INSERT INTO measurement (time, temperature, rain, station_id) values(?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->time, $this->temperature, $this->rain, $this->station_id));
        $lastId = $db->lastInsertId();
        Database::disconnect();
        return $lastId;
    }

    /**
     * Saves the object to the database
     */
    public function update()
    {
        $db = Database::connect();
        $sql = "UPDATE measurement set time = ?, temperature = ?, rain = ?, station_id = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->time, $this->temperature, $this->rain, $this->station_id, $this->id));
        Database::disconnect();
    }

    /**
     * Get an object from database
     * @param integer $id
     * @return object single object or null
     */
    public static function get($id)
    {
        $db = Database::connect();
        $sql = "SELECT * FROM measurement where id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $item = $stmt->fetchObject('Measurement');  // ORM


        $sql = "SELECT * FROM station where id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($item->station_id));
        $item->station = $stmt->fetchObject('Station');  // ORM
        Database::disconnect();
        return $item !== false ? $item : null;

    }

    public static function getAll() {
        $db = Database::connect();

        $sql = "SELECT * FROM measurement ORDER BY time ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        // fetch all datasets (rows), convert to array of Credentials-objects (ORM)
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, 'Measurement');

        Database::disconnect();
        return $items;

    }

    /**
     * Get an array of objects from database
     * @param int $station_id
     * @return array array of objects or empty array
     */
    public static function getAllByStation($station_id)
    {
        $db = Database::connect();

        $sql = "SELECT * FROM measurement where station_id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute(array($station_id));
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, 'Measurement');
        
        Database::disconnect();
        return $items;
    }

    /**
     * Deletes the object from the database
     * @param integer $id
     */
    public static function delete($id)
    {
        try {
            $db = Database::connect();
            $sql = "DELETE FROM measurement WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam9(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            Database::disconnect();
            return true;    // success
        }catch (Exception $e) {
            Database::disconnect();
            return false;   // error
        }

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








    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Set the value of temperature
     *
     * @return  self
     */ 
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    

    /**
     * Set the value of rain
     *
     * @return  self
     */ 
    public function setRain($rain)
    {
        $this->rain = $rain;

        return $this;
    }

    /**
     * Set the value of station_id
     *
     * @return  self
     */ 
    public function setStationId($station_id)
    {
        $this->station_id = $station_id;

        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function getTime(){
        return $this->time;
    }

    public function getTemperature(){
        return $this->temperature;
    }

    public function getRain(){
        return $this->rain;
    }
}
