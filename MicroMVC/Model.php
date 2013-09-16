<?php
    namespace Matheos\MicroMVC;

    class Model {
        protected   $AppConfig;
        private     $dbORM;

        function __construct() {
            $this->AppConfig = \Matheos\MicroMVC\AppConfig::getInstance();
        }

        function __get( $var ) {
            if ($var == "db") {
                if (!isset($this->dbORM)) {
                    $DBConf = $this->AppConfig->config->DB;
                    if ($DBConf->enabled == "true") {
                        $database    = \Matheos\MicroMVC\Database::getInstance();
                        $this->dbORM = \Matheos\MicroMVC\Database::$db;
                    }
                }
                return $this->dbORM;
            }

            return null;
        }

        function ormToArray($orm) {
            $array = array();

            if (empty($orm)) {
                return $array;
            }

            foreach($orm as $key=>$val) {
                if (gettype($val) == "object") {
                    $val = $this->ormToArray($val);
                }
                $array[$key] = $val;
            }

            return $array;
        }
    }