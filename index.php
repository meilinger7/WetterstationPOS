<?php

require_once('controllers/Controller.php');

// entry point for the application
// e.g. http://localhost/php42/index.php?r=station/view&id=25
// select route: station/view&id=25 -> controller=station, action=view, id=25
$route = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : ['home'];
$controller = sizeof($route) > 0 ? $route[0] : 'home';

if ($controller == 'home') {
    require_once('controllers/HomeController.php');
    (new HomeController())->handleRequest($route);
} else if ($controller == 'station') {
    require_once('controllers/StationController.php');
    (new StationController())->handleRequest($route);
} else if ($controller == 'measurement') {
    require_once('controllers/MeasurementController.php');
    (new MeasurementController())->handleRequest($route);
} else {
    Controller::showError("Page not found", "Page for operation " . $controller . " was not found!");
}

?>
