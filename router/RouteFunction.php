<?php

require_once __DIR__ . '\Url.php';

abstract class RouteFunction
{
    protected function loadRouter()
    {
        require_once "./app/views/index.html";
    }

    protected function loadApiRouter($paths)
    {
        $entidade = $paths[0];

        if (!file_exists("./app/api/".$entidade.".php")||count($paths)>2) {
            http_response_code(404);
            echo json_encode(["success" => false, "error" => "Url não encontrada"]);
            exit;
        }
        
        require_once "./app/api/".$entidade.".php";

        if (class_exists($entidade)) {
            $api = new $entidade();
            if (count($paths)<2) {
                http_response_code(404);
                echo json_encode(["success" => false, "errors" => "Método Inexistente"]);
                exit;
            }
            $action = $paths[1];
            $api->$action();
        }
        
    }
    
    function __call($name, $arguments)
    {
        http_response_code(404);
        require_once '.\app\views\not-found.php';
    }
}

?>