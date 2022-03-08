<?php

require_once('controllers/RESTController.php');

// entry point for the rest api
// e.g. GET http://localhost/php41/api.php?r=credentials/25
// or with url_rewrite GET http://localhost/php41/api/credentials/25
// select route: credentials/25 -> controller=credentials, action=GET, id=25
$route = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : ['credentials'];
$controller = sizeof($route) > 0 ? $route[0] : 'credentials';

if ($controller == 'station') {
    require_once('controllers/StationRESTController.php');

    try {
        (new StationRESTController())->handleRequest();
    } catch(Exception $e) {
        RESTController::responseHelper($e->getMessage(), $e->getCode());
    }
    
} elseif ($controller == 'measurement') {
    require_once('controllers/MeasurementRESTController.php');

    try {
        (new MeasurementRESTController())->handleRequest();
    } catch(Exception $e) {
        RESTController::responseHelper($e->getMessage(), $e->getCode());
    }
}
else {
    RESTController::responseHelper('REST-Controller "' . $controller . '" not found', '404');
}
