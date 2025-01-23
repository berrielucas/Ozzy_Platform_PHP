<?php

require_once __DIR__ . '\Api.php';
require_once "./app/model/Visita.php";
require_once "./app/dao/visitaDao.php";
require_once "./app/model/ServicoVisita.php";
require_once "./app/dao/servicoVisitaDao.php";

class Visita extends Api {

    public function cadastrarVisita(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        $visita = new VisitaModel(null, $_data_http["data"], $_data_http["total"], $_data_http["idCliente"], $_data_http["idAnimal"], null, null, null, $_data_http["concluido"]);

        $responseVisita = $objDao->create($visita);

        if (!$responseVisita) {
            echo json_encode(["success" => false, "erros" => "Erro ao agendar visita"]);
            exit;
        }

        $visita->idServico = $responseVisita;

        if (count($_data_http["servicos"])>0) {
            foreach ($_data_http["servicos"] as $servico) {
                $servicoVisita = new ServicoVisitaModel($responseVisita, $servico["idServico"], 1, $servico["preco"], null, null);
                $responseSV = $svDao->create($servicoVisita);
            }
        }

        echo json_encode(["success" => true, "data" => $visita]); 
    }
    
    public function listarVisitas(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
                
        if (Url::getMethod()!="GET") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }
        
        $response = $objDao->readAll();

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao listar visitas"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response]);
    }

    public function dadosVisita(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
                
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

        $responseVisita = $objDao->read($_data_http["id"]);

        if (is_null($responseVisita)) {
            echo json_encode(["success" => false, "erros" => "Erro ao buscar visita"]);
            exit;
        }

        if (!$responseVisita) {
            echo json_encode(["success" => false, "erros" => "Visita não existe na base"]);
            exit;
        }

        $responseSV = $svDao->readAll($_data_http["id"]);

        if (!$responseSV || is_null($responseSV)) {
            $responseSV = [];
        }

        echo json_encode(["success" => true, "data" => new VisitaModel($responseVisita["idVisita"], $responseVisita["data"], $responseVisita["total"], $responseVisita["idCliente"], $responseVisita["idAnimal"], $responseVisita["nomeCliente"], $responseVisita["nomeAnimal"], $responseSV, $responseVisita["concluido"]==1?true:false)]);
    }

    public function atualizarVisita(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idVisita"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idVisita`"]);
            exit;
        }

        $visita = new VisitaModel($_data_http["idVisita"], $_data_http["data"], $_data_http["total"], $_data_http["idCliente"], $_data_http["idAnimal"], null, null, null, $_data_http["concluido"]);

        $responseVisita = $objDao->update($visita);

        if (!$responseVisita) {
            echo json_encode(["success" => false, "erros" => "Erro ao atualizar visita"]);
            exit;
        }

        if (isset($_data_http["servicosAdicionados"])) {
            if (count($_data_http["servicosAdicionados"])>0) {
                foreach ($_data_http["servicosAdicionados"] as $servico) {
                    $servicoVisita = new ServicoVisitaModel($_data_http["idVisita"], $servico["idServico"], 1, $servico["preco"], null, null);
                    $responseSV = $svDao->create($servicoVisita);
                }
            }
        }

        if (isset($_data_http["servicosRemovidos"])) {
            if (count($_data_http["servicosRemovidos"])>0) {
                foreach ($_data_http["servicosRemovidos"] as $servico) {
                    $responseSV = $svDao->delete($_data_http["idVisita"], $servico["idServico"]);
                }
            }
        }

        echo json_encode(["success" => true, "data" => $visita]); 
    }

    public function deletarVisita(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
                
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idVisita"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar o parâmetro `idVisita`"]);
            exit;
        }

        $response = $objDao->delete($_data_http["idVisita"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao apagar visita"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Visita deletado com sucesso!"]); 
    }

    public function removerServico(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new VisitaDao();
        $svDao = new ServicoVisitaDao();
                
        if (Url::getMethod()!="DELETE") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!isset($_data_http["idVisita"])||!isset($_data_http["idServico"])) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar os parâmetros `idVisita` e `idServico`"]);
            exit;
        }

        $response = $svDao->delete($_data_http["idVisita"], $_data_http["idServico"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao remover serviço"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => "Serviço removido com sucesso!"]); 
    }

}

?>