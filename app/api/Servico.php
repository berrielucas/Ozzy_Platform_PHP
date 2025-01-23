<?php

require_once __DIR__ . '\Api.php';
require_once "./app/model/Servico.php";
require_once "./app/dao/servicoDao.php";

class Servico extends Api {

    public function cadastrarServico(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ServicoDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        $servico = new ServicoModel(null, $_data_http["nome"], $_data_http["descricao"], $_data_http["preco"]);

        $response = $objDao->create($servico);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao registrar serviço"]);
            exit;
        }

        $servico->idServico = $response;
        echo json_encode(["success" => true, "data" => $servico]); 
    }
    
    public function listarServicos(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ServicoDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }
        
        $response = $objDao->readAll();

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao listar serviços"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response]);
    }

    public function dadosServico(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ServicoDao();
                
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
            echo json_encode(["success" => false, "erros" => "Erro ao buscar serviço"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Serviço não existe na base"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => new ServicoModel($response["idServico"], $response["nome"], $response["descricao"], $response["preco"])]);
    }

    public function atualizarServico(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ServicoDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idServico"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idServico`"]);
            exit;
        }

        $servico = new ServicoModel($_data_http["idServico"], $_data_http["nome"], $_data_http["descricao"], $_data_http["preco"]);

        $response = $objDao->update($servico);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao atualizar serviço"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $servico]); 
    }

    public function deletarServico(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new ServicoDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idServico"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idServico`"]);
            exit;
        }

        $response = $objDao->delete($_data_http["idServico"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao apagar serviço"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Serviço deletado com sucesso!"]); 
    }
}

?>