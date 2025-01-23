<?php
// Model Visita
class VisitaModel {
    public $idVisita;
    public $data; // DateTime -> yyyy-mm-dd hh:mm:ss
    public $total;
    public $idCliente;
    public $idAnimal;
    public $nomeCliente;
    public $nomeAnimal;
    public $servicos;
    public $concluido;

    public function __construct($idVisita, $data, $total, $idCliente, $idAnimal, $nomeCliente, $nomeAnimal, $servicos, $concluido){
        $this->idVisita=$idVisita;
        $this->data=$data;
        $this->total=$total;
        $this->idCliente=$idCliente;
        $this->idAnimal=$idAnimal;
        $this->nomeCliente=$nomeCliente;
        $this->nomeAnimal=$nomeAnimal;
        $this->servicos=$servicos;
        $this->concluido=$concluido;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>