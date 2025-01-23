<?php

class ServicoVisitaDao {
    public function create(ServicoVisitaModel $obj){
        try {
            $banco = Conexao::conectar();
            $sql = "INSERT INTO servicovisita (idVisita, idServico, quantidade, preco) VALUES (?,?,?,?)";
            $query = $banco->prepare($sql);
            $query->execute([$obj->idVisita, $obj->idServico, $obj->quantidade, $obj->preco]);
            $id = $banco->lastInsertId();
            Conexao::desconectar();
            return $id;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function readAll($id){
        try {
            $banco = Conexao::conectar();
            $sql = "SELECT sv.*, s.nome AS 'nome', s.preco AS 'precoUnitario' FROM servicovisita sv INNER JOIN servico s ON sv.idServico = s.idServico WHERE sv.idVisita = ? ORDER BY s.nome ASC;";
            $query = $banco->prepare($sql);
            $query->execute([$id]);
            $response = $query->fetchAll(PDO::FETCH_ASSOC);
            $servicosvisitas = [];
            if ($response) {
                foreach ($response as $servico) {
                    $servicosvisitas[] = new ServicoVisitaModel($servico["idVisita"], $servico["idServico"], $servico["quantidade"], $servico["preco"], $servico["nome"], $servico["precoUnitario"]);
                }
            }
            Conexao::desconectar();
            return $servicosvisitas;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function delete($idVisita, $idServico){
        try {
            $banco = Conexao::conectar();
            $sql = "DELETE FROM servicovisita WHERE idVisita = ? AND idServico = ?";
            $query = $banco->prepare($sql);
            $query->execute([$idVisita, $idServico]);
            Conexao::desconectar();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}

?>