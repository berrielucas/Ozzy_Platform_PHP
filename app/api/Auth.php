<?php

require_once __DIR__ . '\Api.php';

// Model
require_once "./app/model/Cliente.php";
require_once "./app/model/Funcionario.php";

// Dao
require_once "./app/dao/authDao.php";

// Controllers
require_once "./app/controllers/JWTController.php";
require_once "./app/controllers/EmailController.php";



class Auth extends Api {
    
    public function login(){
        $_data_http= json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Campos `email` e `senha` obrigatórios"]);
            exit;
        }

        if (!array_key_exists("email", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `email` obrigatório"]);
            exit;
        }

        if (!array_key_exists("senha", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `senha` obrigatório"]);
            exit;
        }

        $response = $objDao->loginUser($_data_http["email"], $_data_http["senha"]);

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao logar"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Email ou senha inválidos"]);
            exit;
        }

        if ($response->ativo==false) {
            echo json_encode(["success" => false, "erros" => "Usuário inativo. Entre em contato com adminstrador"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response, "primeiroLogin" => is_null($response->senha) ? true : false]);
    }
    
    public function loginExterno(){
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Campos `email` e `senha` obrigatórios"]);
            exit;
        }

        if (!array_key_exists("email", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `email` obrigatório"]);
            exit;
        }

        if (!array_key_exists("senha", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `senha` obrigatório"]);
            exit;
        }

        $response = $objDao->loginClient($_data_http["email"], $_data_http["senha"]);

        if (is_null($response)) {
            echo json_encode(["success" => false, "erros" => "Erro ao logar"]);
            exit;
        }

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Email ou senha inválidos"]);
            exit;
        }

        echo json_encode(["success" => true, "data" => $response, "primeiroLogin" => is_null($response->senha) ? true : false]);
    }

    public function enviarEmailNewAccess() {
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        $emailController = new EmailController();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if ($_data_http==null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!array_key_exists("email", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `email` obrigatório"]);
            exit;
        }

        if (!array_key_exists("type", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `type` obrigatório"]);
            exit;
        }

        if (!array_key_exists("urlBase", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `urlBase` obrigatório"]);
            exit;
        }

        $people = $objDao->searchPeopleByEmail($_data_http["email"], $_data_http["type"]);

        if (is_null($people)) {
            echo json_encode(["success" => false, "erros" => "Erro ao buscar dados"]);
            exit;
        }

        if (!$people) {
            echo json_encode(["success" => false, "erros" => "Pessoa inexistente na plataforma"]);
            exit;
        }

        $token = JWT::encode([ "email" => $people->email, "nome" => $people->nome ], $_ENV["SECRET_TOKEN"]);

        $email = false;

        if ($_data_http["type"]=="user") {
            $email = $emailController->sendEmailNewUser($people->nome, $people->email, "suport@ozzy.com.br", $_data_http["urlBase"].str_replace('.', '+', $token));
        } else {
            $email = $emailController->sendEmailNewClient($people->nome, $people->email, "suport@ozzy.com.br", $_data_http["urlBase"].str_replace('.', '+', $token));
        }

        if (!$email) {
            echo json_encode(["success" => false, "erros" => "Erro ao enviar email"]);
            exit;
        }

        echo json_encode(["success" => true, "message" => "Email enviado com sucesso", "data" => [ "nome" => $people->nome, "email" => $people->email, "link" => $_data_http["urlBase"].str_replace('.', '+', $token) ]]);
    }

    public function enviarEmailNewPass() {
        $_data_http = json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        $emailController = new EmailController();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if ($_data_http==null) {
            echo json_encode(["success" => false, "erros" => "Necessário enviar parâmetros"]);
            exit;
        }

        if (!array_key_exists("email", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `email` obrigatório"]);
            exit;
        }

        if (!array_key_exists("type", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `type` obrigatório"]);
            exit;
        }

        if (!array_key_exists("urlBase", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `urlBase` obrigatório"]);
            exit;
        }

        $people = $objDao->searchPeopleByEmail($_data_http["email"], $_data_http["type"]);

        if (is_null($people)) {
            echo json_encode(["success" => false, "erros" => "Erro ao buscar dados"]);
            exit;
        }

        if (!$people) {
            echo json_encode(["success" => false, "erros" => "Pessoa inexistente na plataforma"]);
            exit;
        }

        $token = JWT::encode([ "email" => $people->email, "nome" => $people->nome ], $_ENV["SECRET_TOKEN"]);

        $email = $emailController->sendEmailNewPass($people->nome, $people->email, "suport@ozzy.com.br", $_data_http["urlBase"].str_replace('.', '+', $token));

        if (!$email) {
            echo json_encode(["success" => false, "erros" => "Erro ao enviar email"]);
            exit;
        }

        echo json_encode(["success" => true, "message" => "Email enviado com sucesso", "data" => [ "nome" => $people->nome, "email" => $people->email, "link" => $_data_http["urlBase"].str_replace('.', '+', $token) ]]);
    }

    public function alterarSenhaUser() {

        $_data_http= json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Campos `token` e `senha` obrigatórios"]);
            exit;
        }

        if (!array_key_exists("token", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `token` obrigatório"]);
            exit;
        }

        if (!array_key_exists("senha", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `senha` obrigatório"]);
            exit;
        }

        $payload = JWT::decode(str_replace('+', '.', $_data_http["token"]), $_ENV["SECRET_TOKEN"]);

        if (is_null($payload)) {
            echo json_encode(["success" => false, "erros" => "Token inválido"]);
            exit;
        }

        if (!$payload) {
            echo json_encode(["success" => false, "erros" => "Chave inválida"]);
            exit;
        }

        $response = $objDao->updatePasswordUser($payload["email"], $_data_http["senha"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao alterar senha"]);
            exit;
        }

        echo json_encode(["success" => true, "erros" => "Senha alterada com sucesso"]);

    }

    public function alterarSenhaClient() {
        $_data_http= json_decode(file_get_contents("php://input"), true);
        $objDao = new AuthDao();
        
        if (Url::getMethod()!="POST") {
            echo json_encode(["success" => false, "erros" => "Invalid Method"]);
            exit;
        }

        if (!$_data_http!=null) {
            echo json_encode(["success" => false, "erros" => "Campos `token` e `senha` obrigatórios"]);
            exit;
        }

        if (!array_key_exists("token", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `token` obrigatório"]);
            exit;
        }

        if (!array_key_exists("senha", $_data_http)) {
            echo json_encode(["success" => false, "erros" => "Campo `senha` obrigatório"]);
            exit;
        }

        $payload = JWT::decode(str_replace('+', '.', $_data_http["token"]), $_ENV["SECRET_TOKEN"]);

        if (is_null($payload)) {
            echo json_encode(["success" => false, "erros" => "Token inválido"]);
            exit;
        }

        if (!$payload) {
            echo json_encode(["success" => false, "erros" => "Chave inválida"]);
            exit;
        }

        $response = $objDao->updatePasswordClient($payload["email"], $_data_http["senha"]);

        if (!$response) {
            echo json_encode(["success" => false, "erros" => "Erro ao alterar senha"]);
            exit;
        }

        echo json_encode(["success" => true, "erros" => "Senha alterada com sucesso"]);
    }
}

?>