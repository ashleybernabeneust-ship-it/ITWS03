<?php 
    define('BASE_PATH', 
    dirname(__DIR__));
    require './views/home.view.php';
    require './helpers.php';
    loadView('home');

?>
    