<?php

class AuthDao {
    
    public function loginClient($email, $senha){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM cliente WHERE email = ?";
            $query = $banco->prepare($sql);
            $query->execute([$email]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            
            Conexao::desconectar();
            
            if ($lista) {
                $cliente = new ClienteModel($lista["idCliente"], $lista["nome"], $lista["telefone1"], $lista["telefone2"], $lista["email"], $lista["senha"], $lista["logradouro"], $lista["cep"], $lista["numero"], $lista["cidade"], $lista["estado"], $lista["cpf"]);

                if ($cliente->senha==MD5($senha)) {
                    return $cliente;
                }
            }

            return false;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function updatePasswordClient($email, $senha){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE cliente SET senha=? WHERE email=?";
            $query = $banco->prepare($sql);
            $query->execute([MD5($senha), $email]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function loginUser($email, $senha){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM funcionario WHERE email = ?";
            $query = $banco->prepare($sql);
            $query->execute([$email]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);

            Conexao::desconectar();

            if ($lista) {
                $funcionario = new FuncionarioModel($lista["idFuncionario"], $lista["nome"], $lista["telefone1"], $lista["telefone2"], $lista["email"], $lista["senha"], $lista["logradouro"], $lista["cep"], $lista["numero"], $lista["cidade"], $lista["estado"], $lista["cpf"], $lista["ativo"]==1 ? true : false, $lista["adm"]==1 ? true : false);
    
    
                if ($funcionario->senha==MD5($senha)) {
                    return $funcionario;
                }
            }

            return false;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function updatePasswordUser($email, $senha){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE funcionario SET senha=? WHERE email=?";
            $query = $banco->prepare($sql);
            $query->execute([MD5($senha), $email]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function searchPeopleByEmail($email, $type){
        try {

            $banco = Conexao::conectar();
            $sql = "";
            if ($type=="user") {
                $sql = "SELECT * FROM funcionario WHERE email = ?";
            } else {
                $sql = "SELECT * FROM cliente WHERE email = ?";
            }
            $query = $banco->prepare($sql);
            $query->execute([$email]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            
            Conexao::desconectar();
            
            if ($lista) {
                if ($type=="user") {
                    return new FuncionarioModel($lista["idFuncionario"], $lista["nome"], $lista["telefone1"], $lista["telefone2"], $lista["email"], $lista["senha"], $lista["logradouro"], $lista["cep"], $lista["numero"], $lista["cidade"], $lista["estado"], $lista["cpf"], $lista["ativo"]==1 ? true : false, $lista["adm"]==1 ? true : false);
                } else {
                    return new ClienteModel($lista["idCliente"], $lista["nome"], $lista["telefone1"], $lista["telefone2"], $lista["email"], $lista["senha"], $lista["logradouro"], $lista["cep"], $lista["numero"], $lista["cidade"], $lista["estado"], $lista["cpf"]);
                }
            }

            return false;

        } catch (PDOException $e) {
            return null;
        }
    }
}

?>