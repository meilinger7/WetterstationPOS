<?php

require_once('Controller.php');
require_once('models/Station.php');

class HomeController extends Controller
{
    /**
     * @param $route array, e.g. [home, view]
     */
    public function handleRequest($route)
    {
        $operation = sizeof($route) > 1 ? $route[1] : 'index';

        if ($operation == 'index') {
            $this->actionIndex();
        } else {
            Controller::showError("Page not found", "Page for operation " . $operation . " was not found!");
        }
    }

    public function actionIndex()
    {
        $model = Station::getAll();
        $this->render('home/index', $model);
    }

}
