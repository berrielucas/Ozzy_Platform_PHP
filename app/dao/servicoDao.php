<?php

class ServicoDao {
    public function create(ServicoModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO servico (nome, descricao, preco) VALUES (?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->descricao, $obj->preco]);
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
            $sql = "SELECT * FROM servico  ORDER BY nome ASC;";
            $response = $banco->query($sql);
            $servicos = [];
            foreach ($response as $servico) {
                $servicos[] = new ServicoModel($servico["idServico"], $servico["nome"], $servico["descricao"], $servico["preco"]);
            }
            Conexao::desconectar();
            return $servicos;
        } catch (PDOException $e) {
            return null;
        }
    }


    public function read($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT * FROM servico WHERE idServico = ?;";
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
            $sql = "DELETE FROM servico WHERE idServico = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(ServicoModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE servico SET nome=?, descricao=?, preco=? WHERE idServico=?";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->descricao, $obj->preco, $obj->idServico]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>