<?php

require_once __DIR__ . '\Api.php';
require_once "./app/model/Cliente.php";
require_once "./app/dao/clienteDao.php";

class Cliente extends Api {

    public function cadastrarCliente(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ClienteDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        $cliente = new ClienteModel(null, $_data_http["nome"], $_data_http["telefone1"], $_data_http["telefone2"], $_data_http["email"], is_null($_data_http["senha"]) ? null :MD5($_data_http["senha"]), $_data_http["logradouro"], $_data_http["cep"], $_data_http["numero"], $_data_http["cidade"], $_data_http["estado"], $_data_http["cpf"]);

        $response = $objDao->create($cliente);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao registrar cliente"]);
            exit;
        }

        $cliente->idCliente = $response;
        echo json_encode(["success" => true, "data" => $cliente]); 
    }
    
    public function listarClientes(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ClienteDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }
        
        $response = $objDao->readAll();

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao listar clientes"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response]);
    }

    public function dadosCliente(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ClienteDao();
                
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
            echo json_encode(["success" => false, "erros" => "Erro ao buscar cliente"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Cliente não existe na base"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => new ClienteModel($response["idCliente"], $response["nome"], $response["telefone1"], $response["telefone2"], $response["email"], $response["senha"], $response["logradouro"], $response["cep"], $response["numero"], $response["cidade"], $response["estado"], $response["cpf"])]);
    }

    public function atualizarCliente(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ClienteDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idCliente"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idCliente`"]);
            exit;
        }

        $cliente = new ClienteModel($_data_http["idCliente"], $_data_http["nome"], $_data_http["telefone1"], $_data_http["telefone2"], $_data_http["email"], null, $_data_http["logradouro"], $_data_http["cep"], $_data_http["numero"], $_data_http["cidade"], $_data_http["estado"], $_data_http["cpf"]);

        $response = $objDao->update($cliente);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao atualizar cliente"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $cliente]); 
    }

    public function deletarCliente(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ClienteDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idCliente"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idCliente`"]);
            exit;
        }

        $response = $objDao->delete($_data_http["idCliente"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao apagar cliente"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Cliente deletado com sucesso!"]); 
    }
}

?>