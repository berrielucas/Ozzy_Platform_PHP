<?php

class ClienteDao {
    public function create(ClienteModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO cliente(nome, telefone1, telefone2, email, senha, logradouro, cep, numero, cidade, estado, cpf) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->telefone1, $obj->telefone2, $obj->email, $obj->senha, $obj->logradouro, $obj->cep, $obj->numero, $obj->cidade, $obj->estado, $obj->cpf]);
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
            $sql = "SELECT * FROM cliente ORDER BY nome ASC";
            $response = $banco->query($sql);
            $clientes = [];
            foreach ($response as $cliente) {
                $clientes[] = new ClienteModel($cliente["idCliente"], $cliente["nome"], $cliente["telefone1"], $cliente["telefone2"], $cliente["email"], $cliente["senha"], $cliente["logradouro"], $cliente["cep"], $cliente["numero"], $cliente["cidade"], $cliente["estado"], $cliente["cpf"]);
            }
            Conexao::desconectar();
            return $clientes;
        } catch (PDOException $e) {
            return null;
        }
    }


    public function read($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM cliente WHERE idCliente = ?";
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
            $sql = "DELETE FROM cliente WHERE idCliente = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(ClienteModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE cliente SET nome=?, telefone1=?, telefone2=?, email=?, logradouro=?, cep=?, numero=?, cidade=?, estado=?, cpf=? WHERE idCliente=?";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->telefone1, $obj->telefone2, $obj->email, $obj->logradouro, $obj->cep, $obj->numero, $obj->cidade, $obj->estado, $obj->cpf, $obj->idCliente]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>