<?php

require_once('RESTController.php');
require_once('models/Station.php');
require_once('models/Measurement.php');

class StationRESTController extends RESTController
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
     * get single/all stations
     * single station: GET api.php?r=/station/25 -> args[0] = 25
     * all stations: GET api.php?r=station
     * all measurements of single station: GET api.php?r=/station/2/measurement -> arg[0] = 2, args[1] = measurement
     */
    private function handleGETRequest()
    {

    }

    /**
     * create station: POST api.php?r=station
     */
    private function handlePOSTRequest()
    {

    }

    /**
     * update station: PUT api.php?r=station/25 -> args[0] = 25
     */
    private function handlePUTRequest()
    {

    }

    /**
     * delete station: DELETE api.php?r=station/25 -> args[0] = 25
     */
    private function handleDELETERequest()
    {

    }

}
