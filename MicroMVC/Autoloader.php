<?php
    function autoload_MicroMVC( $classname ) {
        $classname  = explode("\\", $classname);

        if (count($classname) < 2) {
            return;
        }

        $namespace  = $classname[1];
        $controller = $classname[2];

        if ( $namespace == "MicroMVC" ) {
            $filename   = dirname(__FILE__) . "/" . $controller . ".php";
            if (is_readable($filename)) {
                require_once $filename;
            }
        }
    }

    function autoload_App($classname) {
        $classname  = explode("\\", $classname);

        if (count($classname) < 2) {
            return;
        }

        $namespace  = $classname[1];
        $class      = $classname[2];
        $controller = dirname(__FILE__) . "/../" . $namespace . "/controllers/" . $class . ".php";
        $model      = dirname(__FILE__) . "/../" . $namespace . "/models/" . $class . ".php";
        $helper     = dirname(__FILE__) . "/../" . $namespace . "/helpers/" . $class . ".php";

        if (is_readable($controller)) {
            require_once $controller;
        } else if (is_readable($model)) {
            require_once $model;
        } else if (is_readable($helper)) {
            require_once $helper;
        }
    }

    function autoload_Addons($classname) {
        $cfg      = $AppConfig = \Matheos\MicroMVC\AppConfig::getInstance()->config;
        $base     = $cfg->Core->rootFolder;
        $filename = $base . "/MicroMVC/vendor/" . $classname . "/" . $classname . ".php";

        if (is_readable($filename)) {
            require_once($filename);
        }
    }

    spl_autoload_register("autoload_MicroMVC");
    spl_autoload_register("autoload_App");
    spl_autoload_register("autoload_Addons");