<?php
    namespace Matheos\MicroMVC;

    class Controller {
        protected $json, $model;

        function __construct() {
            $this->json = new JsonResponse();

            $modelFile  = $this->className() . "Model";
            $modelClass = "\\Matheos\\App\\" . $modelFile;

            $cfg  = \Matheos\MicroMVC\AppConfig::getInstance()->config;
            $base = $cfg->Core->rootFolder;

            if (file_exists($base . "/App/models/{$modelFile}.php")) {
                $this->model = new $modelClass;
            }
        }

        public function className() {
            $class = explode('\\', get_class($this));
            return end($class);
        }
    }