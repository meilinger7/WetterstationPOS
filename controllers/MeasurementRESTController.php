<?php

require_once('RESTController.php');
require_once('models/Measurement.php');

class MeasurementRESTController extends RESTController
{
    public function handleRequest()
    {
        switch ($this->method) {
            case 'GET':
                $this->handleGETRequest();
                break;
            case 'POST':
                $this->handlePOSTRequest();
                break;
            case 'PUT':
                $this->handlePUTRequest();
                break;
            case 'DELETE':
                $this->handleDELETERequest();
                break;
            default:
                $this->response('Method Not Allowed', 405);
                break;
        }
    }

    /**
     * get single/all measurements
     * single measurements: GET api.php?r=measurement/25 -> args[0] = 25 (measurement_id)
     * all measurements: GET api.php?r=measurement
     */
    private function handleGETRequest()
    {
        if ($this->verb == null && sizeof($this->args) == 1) {
            $model = Measurement::get($this->args[0]);  // single measurement
            $this->response($model);
        } else if ($this->verb == null && empty($this->args)) {
            $model = Measurement::getAll();             // all measurements
            $this->response($model);
        } else {
            $this->response("Bad request", 400);
        }
    }

    /**
     * create measurement: POST api.php?r=measurement
     */
    private function handlePOSTRequest()
    {
        $model = new Measurement();
        $model->setTime($this->getDataOrNull('time'));
        $model->setTemperature($this->getDataOrNull('temperature'));
        $model->setRain($this->getDataOrNull('rain'));
        $model->setStationId($this->getDataOrNull('station_id'));

        if ($model->save()) {
            $this->response("OK", 201);
        } else {
            $this->response($model->getErrors(), 400);
        }
    }

    /**
     * update measurement: PUT api.php?r=measurement/25 -> args[0] = 25
     */
    private function handlePUTRequest()
    {
        if ($this->verb == null && sizeof($this->args) == 1) {

            $model = Measurement::get($this->args[0]);
            $model->setTime($this->getDataOrNull('time'));
            $model->setTemperature($this->getDataOrNull('temperature'));
            $model->setRain($this->getDataOrNull('rain'));
            $model->setStationId($this->getDataOrNull('station_id'));

            if ($model->save()) {
                $this->response("OK");
            } else {
                $this->response($model->getErrors(), 400);
            }

        } else {
            $this->response("Not Found", 404);
        }
    }

    /**
     * delete measurement: DELETE api.php?r=measurement/25 -> args[0] = 25
     */
    private function handleDELETERequest()
    {
        if ($this->verb == null && sizeof($this->args) == 1) {
            Measurement::delete($this->args[0]);
            $this->response("OK", 200);
        } else {
            $this->response("Not Found", 404);
        }
    }

}
