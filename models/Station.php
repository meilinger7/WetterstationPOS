<?php

require_once("DatabaseObject.php");

class Station implements DatabaseObject, JsonSerializable
{
    private $id;
    private $name;
    private $altitude;
    private $location;

    private $errors = [];

    public function validate()
    {
        return $this->validateName() & $this->validateAltitude() & $this->validateLocation();
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
        $sql = "INSERT INTO station (name, altitude, location) values(?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->name, $this->altitude, $this->location));
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
        $sql = "UPDATE station set name = ?, altitude = ?, location = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($this->name, $this->altitude, $this->location, $this->id));
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
        $sql = "SELECT * FROM station where id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $item = $stmt->fetchObject('Station');
        Database::disconnect();
        return $item !== false ? $item : null;
    }

    /**
     * Get an array of objects from database
     * @return array array of objects or empty array
     */
    public static function getAll()
    {
        $db = Database::connect();

        $sql = "SELECT * FROM station ORDER BY name ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        // fetch all datasets (rows), convert to array of Credentials-objects (ORM)
        $items = $stmt->fetchAll(PDO::FETCH_CLASS, 'Station');

        Database::disconnect();
        return $items;
    }

    /**
     * Deletes the object from the database
     * @param integer $id
     * @return bool true on success
     */
    public static function delete($id)
    {
        try {
            $db = Database::connect();
            $sql = "DELETE FROM station WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            Database::disconnect();
            return true;    // success
        }catch (Exception $e) {
            Database::disconnect();
            return false;   // error
        }
    }

    private function validateName()
    {
        if ($this->name == '') {
            $this->errors['name'] = "Name darf nicht leer sein";
            return false;
        } else if (strlen($this->name) > 64) {
            $this->errors['name'] = "Name zu lang";
            return false;
        } else {
            unset($this->errors['name']);
            return true;
        }
    }

    private function validateAltitude()
    {
        if (!is_numeric($this->altitude) || $this->altitude < 0 || $this->altitude > 4000) {
            $this->errors['altitude'] = "Höhe ungültig";
            return false;
        } else {
            unset($this->errors['altitude']);
            return true;
        }
    }

    private function validateLocation()
    {
        if ($this->location == '') {
            $this->errors['location'] = "Ort darf nicht leer sein";
            return false;
        } else if (strlen($this->location) > 255) {
            $this->errors['location'] = "Ort zu lang";
            return false;
        } else {
            unset($this->errors['location']);
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
        //return get_object_vars($this);
        return [
            "id" => intval($this->id),
            "name" => $this->name,
            "altitude" => intval($this->altitude),
            "location" => $this->location,
        ];
    }


    public function setName($name){
        $this->name = $name;
    }
    public function setAltitude($altitude){
        $this->altitude = $altitude;
    }
    public function setLocation($location){
        $this->location = $location;
    }
    

}
