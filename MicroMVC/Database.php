<?php
    namespace Matheos\MicroMVC;

    class Database {
        protected static $instance = null;
        private static $pdo;
        public  static $db;

        public function __construct() {
            // Cannot construct
        }

        protected function __clone() {
            // Cloning Disabled
        }

        private static function init() {
            $AppConfig = \Matheos\MicroMVC\AppConfig::getInstance();
            $DBConfig  = $AppConfig->config->DB;

            $Server     = $DBConfig->host;
            $Database	= $DBConfig->database;
            $Username	= $DBConfig->username;
            $Password   = $DBConfig->password;

            try {
                self::$pdo  = new \PDO("mysql:host=".$Server.";dbname=".$Database, $Username, $Password);
                self::$db   = new \NotORM(self::$pdo);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        public static function getInstance() {
            if (!isset(static::$instance)) {
                static::init();
                static::$instance = new static;
            }
            return static::$instance;
        }

        public function pdoQuery($SQL, $Data) {
            try {
                $Query = $this->pdo->prepare($SQL);
                $Query->execute($Data);

                if ($Query->columnCount() > 0) {
                    return $Query->fetchAll(\PDO::FETCH_ASSOC);
                } else {
                    return null;
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }