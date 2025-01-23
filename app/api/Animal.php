<?php

require_once __DIR__ . '\Api.php';
require_once "./app/model/Animal.php";
require_once "./app/dao/animalDao.php";

class Animal extends Api {

    public function cadastrarAnimal(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AnimalDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        $animal = new AnimalModel(null, $_data_http["nome"], $_data_http["peso"], $_data_http["nascimento"], $_data_http["cor"], $_data_http["observacao"], $_data_http["idCliente"], null);

        $response = $objDao->create($animal);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao registrar animal"]);
            exit;
        }

        $animal->idAnimal = $response;
        echo json_encode(["success" => true, "data" => $animal]); 
    }
    
    public function listarAnimais(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AnimalDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        $response = $objDao->readAll();

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao listar animais"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response]);
    }

    public function dadosAnimal(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AnimalDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["id"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `id`"]);
            exit;
        }

        $response = $objDao->read($_data_http["id"]);

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao buscar animal"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Animal não existe na base"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => new AnimalModel($response["idAnimal"], $response["nome"], $response["peso"], $response["nascimento"], $response["cor"], $response["observacao"], $response["idCliente"], $response["nomeCliente"])]);
    }

    public function atualizarAnimal(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AnimalDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idAnimal"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idAnimal`"]);
            exit;
        }

        $animal = new AnimalModel($_data_http["idAnimal"], $_data_http["nome"], $_data_http["peso"], $_data_http["nascimento"], $_data_http["cor"], $_data_http["observacao"], $_data_http["idCliente"], null);

        $response = $objDao->update($animal);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao atualizar animal"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $animal]); 
    }

    public function deletarAnimal(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AnimalDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idAnimal"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idAnimal`"]);
            exit;
        }

        $response = $objDao->delete($_data_http["idAnimal"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao apagar animal"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Animal deletado com sucesso!"]); 
    }
}

?>