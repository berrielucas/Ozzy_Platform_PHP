<?php

require_once __DIR__ . '\RouteFunction.php';
require_once __DIR__ . '\Url.php';

class Router extends RouteFunction
{

    public function run() {
        
        $route = Url::decode();

        if ($route["params"][0]!=="api") {
            $this->loadRouter();
        } else {
            array_shift($route["params"]);
            if (count($route["params"])<1) {
                http_response_code(404);
                echo json_encode(["success" => false, "errors" => "Url não encontrada"]);
                exit;
            }
            $this->loadApiRouter($route["params"]);
        }
    }
}


?>