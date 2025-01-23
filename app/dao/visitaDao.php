<?php

require_once __DIR__ . '\servicoVisitaDao.php';

class VisitaDao {
    public function create(VisitaModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO visita (data, concluido, total, idCliente, idAnimal) VALUES (?,?,?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->data, $obj->concluido, $obj->total, $obj->idCliente, $obj->idAnimal]);
            $id = $banco->lastInsertId();
            Conexao::desconectar();
            return $id;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function readAll(){
        try {
            $svDao = new ServicoVisitaDao();
            $banco = Conexao::conectar();
            $sql = "SELECT v.*, a.nome AS 'nomeAnimal', c.nome AS 'nomeCliente' FROM visita v INNER JOIN animal a ON v.idAnimal = a.idAnimal INNER JOIN cliente c ON v.idCliente = c.idCliente ORDER BY v.concluido ASC, v.data ASC;";
            $response = $banco->query($sql);
            $visitas = [];
            foreach ($response as $visita) {
                $responseSV = $svDao->readAll($visita["idVisita"]);
                if (!$responseSV || is_null($responseSV)) {
                    $responseSV = [];
                }
                $visitas[] = new VisitaModel($visita["idVisita"], $visita["data"], $visita["total"], $visita["idCliente"], $visita["idAnimal"], $visita["nomeCliente"], $visita["nomeAnimal"], $responseSV, $visita["concluido"]==1?true:false);
            }
            Conexao::desconectar();
            return $visitas;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function read($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT v.*, a.nome AS 'nomeAnimal', c.nome AS 'nomeCliente' FROM visita v INNER JOIN animal a ON v.idAnimal = a.idAnimal INNER JOIN cliente c ON v.idCliente = c.idCliente WHERE v.idVisita = ?;";
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
            $sql = "DELETE FROM visita WHERE idVisita = ?";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(VisitaModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "UPDATE visita SET data=?, concluido=?, total=?, idCliente=?, idAnimal=? WHERE idVisita=?";
            $query = $banco->prepare($sql);
            $query->execute([$obj->data, $obj->concluido, $obj->total, $obj->idCliente, $obj->idAnimal, $obj->idVisita]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>