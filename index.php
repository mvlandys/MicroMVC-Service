<?php
    require_once("MicroMVC/Autoloader.php");
    require_once("Config/config.php");

    $router = new \Matheos\MicroMVC\Router();
    $router->dispatch();