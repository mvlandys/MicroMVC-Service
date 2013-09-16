<?php
    namespace Matheos\MicroMVC;

    class Router {
        private $routes;

        function __construct() {
            $AppConfig = \Matheos\MicroMVC\AppConfig::getInstance();
            $Hostname  = $AppConfig->config->Core->hostname;

            if ($_SERVER["SERVER_NAME"] != $Hostname) {
                header("Location: http://" . $Hostname . $_SERVER["REQUEST_URI"]);
                exit(1);
            } else {
                $this->routes = $this->get_Routes();
            }
        }

        private function get_Routes() {
            $routeData  = array();
            $jsonConfig = json_decode( file_get_contents("Config/routes.json") );

            foreach( $jsonConfig as $route=>$data ) {
                $routeData[] = new Route($route, $data[0], $data[1], $data[2]);
            }

            return $routeData;
        }

        public function dispatch() {
            $matchFound = false;

            foreach($this->routes as $route) {
                if ($_SERVER["REQUEST_METHOD"] != $route->request && $route->request != "ANY") continue;
                if (preg_match("@^".$route->getRegex()."*(/)?(\?*)?@i", $_SERVER["REQUEST_URI"], $matches)) {
                    call_user_func_array(array(new $route->controller, $route->method),array_slice($matches, 1));
                    $matchFound = true;
                    break;
                }
            }

            if ($matchFound == false) {
                throw new \Exception($_SERVER["REQUEST_METHOD"] . " Route does not exist: " . $_SERVER["REQUEST_URI"]);
            }
        }
    }