<?php

class AnimalDao {
    public function create(AnimalModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO animal(nome, peso, nascimento, cor, observacao, idCliente) VALUES (?,?,?,?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->peso, $obj->nascimento, $obj->cor, $obj->observacao, $obj->idCliente]);
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
            $sql = "SELECT a.*, (SELECT c.nome FROM cliente c WHERE c.idCliente = a.idCliente) AS 'nomeCliente' FROM animal a ORDER BY a.nome ASC;";
            $response = $banco->query($sql);
            $animais = [];
            foreach ($response as $animal) {
                $animais[] = new AnimalModel($animal["idAnimal"], $animal["nome"], $animal["peso"], $animal["nascimento"], $animal["cor"], $animal["observacao"], $animal["idCliente"], $animal["nomeCliente"]);
            }
            Conexao::desconectar();
            return $animais;
        } catch (PDOException $e) {
            return null;
        }
    }


    public function read($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT a.*, (SELECT c.nome FROM cliente c WHERE c.idCliente = a.idCliente) AS 'nomeCliente' FROM animal a WHERE a.idAnimal = ? ORDER BY a.nome ASC;";
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
            $sql = "DELETE FROM animal WHERE idAnimal = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(AnimalModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE animal SET nome=?, peso=?, nascimento=?, cor=?, observacao=?, idCliente=? WHERE idAnimal=?";
            $query = $banco->prepare($sql);
            $query->execute([$obj->nome, $obj->peso, $obj->nascimento, $obj->cor, $obj->observacao, $obj->idCliente, $obj->idAnimal]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>