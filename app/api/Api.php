<?php

require_once "./router/Url.php";

abstract class Api
{    
    function __call($name, $arguments)
    {
        http_response_code(404);
        echo json_encode([ "success" => false, "errors" => "Método Inexistente" ]);
    }
}


?>