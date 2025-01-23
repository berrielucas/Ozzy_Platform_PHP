<?php

require_once __DIR__ . '\Api.php';
require_once "./app/model/Funcionario.php";
require_once "./app/dao/funcionarioDao.php";

class Funcionario extends Api {

    public function cadastrarFuncionario(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new FuncionarioDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        $funcionario = new FuncionarioModel(null, $_data_http["nome"], $_data_http["telefone1"], $_data_http["telefone2"], $_data_http["email"], is_null($_data_http["senha"]) ? null : MD5($_data_http["senha"]), $_data_http["logradouro"], $_data_http["cep"], $_data_http["numero"], $_data_http["cidade"], $_data_http["estado"], $_data_http["cpf"], $_data_http["ativo"], $_data_http["adm"]);

        $response = $objDao->create($funcionario);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao registrar funcionário"]);
            exit;
        }

        $funcionario->idFuncionario = $response;
        echo json_encode(["success" => true, "data" => $funcionario]); 
    }
    
    public function listarFuncionarios(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new FuncionarioDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }
        
        $response = $objDao->readAll();

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao listar funcionários"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response]);
    }

    public function dadosFuncionario(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new FuncionarioDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idFuncionario"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idFuncionario`"]);
            exit;
        }

        $response = $objDao->read($_data_http["idFuncionario"]);

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao buscar funcionário"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Funcionário não existe na base"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => new FuncionarioModel($response["idCliente"], $response["nome"], $response["telefone1"], $response["telefone2"], $response["email"], $response["senha"], $response["logradouro"], $response["cep"], $response["numero"], $response["cidade"], $response["estado"], $response["cpf"], $_data_http["ativo"]==1 ? true : false, $_data_http["adm"]==1 ? true : false)]);
    }

    public function atualizarFuncionario(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new FuncionarioDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idFuncionario"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idFuncionario`"]);
            exit;
        }

        $funcionario = new FuncionarioModel($_data_http["idFuncionario"], $_data_http["nome"], $_data_http["telefone1"], $_data_http["telefone2"], $_data_http["email"], null, $_data_http["logradouro"], $_data_http["cep"], $_data_http["numero"], $_data_http["cidade"], $_data_http["estado"], $_data_http["cpf"], $_data_http["ativo"], $_data_http["adm"]);

        $response = $objDao->update($funcionario);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao atualizar funcionário"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $funcionario]); 
    }

    public function deletarFuncionario(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new FuncionarioDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idFuncionario"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idFuncionario`"]);
            exit;
        }

        $response = $objDao->delete($_data_http["idFuncionario"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao apagar funcionário"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Funcionário deletado com sucesso!"]); 
    }
}

?>