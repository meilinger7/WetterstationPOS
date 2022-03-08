<?php

abstract class Controller
{
    public function render($view, $model = null)
    {
        include 'views/layouts/top.php';
        include 'views/' . $view . '.php';
        include 'views/layouts/bottom.php';
    }

    protected function redirect($location)
    {
        header('Location: index.php?r=' . $location);
    }

    public static function showError($title, $message)
    {
        include 'views/error.php';
    }

    /**
     * helper method for extraction POST data
     * @param $field
     * @return mixed|null
     */
    protected function getDataOrNull($field) {
        return isset($_POST[$field]) ? $_POST[$field] : null;
    }

}
