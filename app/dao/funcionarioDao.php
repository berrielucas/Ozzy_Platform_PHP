<?php

class FuncionarioDao {
    public function create(FuncionarioModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO funcionario(nome, telefone1, telefone2, email, senha, logradouro, cep, numero, cidade, estado, cpf, ativo, adm) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->telefone1, $obj->telefone2, $obj->email, $obj->senha, $obj->logradouro, $obj->cep, $obj->numero, $obj->cidade, $obj->estado, $obj->cpf, $obj->ativo, $obj->adm]);
            $id = $banco->lastInsertId();
            Conexao::desconectar();
            return $id;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function readAll(){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM funcionario ORDER BY nome ASC";
            $response = $banco->query($sql);
            $funcionarios = [];
            foreach ($response as $funcionario) {
                $funcionarios[] = new FuncionarioModel($funcionario["idFuncionario"], $funcionario["nome"], $funcionario["telefone1"], $funcionario["telefone2"], $funcionario["email"], $funcionario["senha"], $funcionario["logradouro"], $funcionario["cep"], $funcionario["numero"], $funcionario["cidade"], $funcionario["estado"], $funcionario["cpf"], $funcionario["ativo"]==1 ? true : false, $funcionario["adm"]==1 ? true : false);
            }
            Conexao::desconectar();
            return $funcionarios;
        } catch (PDOException $e) {
            return null;
        }
    }


    public function read($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM funcionario WHERE idFuncionario = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            Conexao::desconectar();
            return $lista;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function delete($id){
        try {
            $banco = Conexao::conectar();
            $sql = "DELETE FROM funcionario WHERE idFuncionario = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(FuncionarioModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE funcionario SET nome=?, telefone1=?, telefone2=?, email=?, logradouro=?, cep=?, numero=?, cidade=?, estado=?, cpf=?, ativo=?, adm=? WHERE idFuncionario=?";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->telefone1, $obj->telefone2, $obj->email, $obj->logradouro, $obj->cep, $obj->numero, $obj->cidade, $obj->estado, $obj->cpf, $obj->ativo, $obj->adm, $obj->idFuncionario]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>