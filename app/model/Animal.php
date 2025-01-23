<?php
// Model Animal
class AnimalModel {
    public $idAnimal;
    public $nome;
    public $peso;
    public $nascimento; // Date -> yyyy-mm-dd
    public $cor;
    public $observacao;
    public $idCliente;
    public $nomeCliente;

    public function __construct($idAnimal, $nome, $peso, $nascimento, $cor, $observacao, $idCliente, $nomeCliente){
        $this->idAnimal=$idAnimal;
        $this->nome=$nome;
        $this->peso=$peso;
        $this->nascimento=$nascimento;
        $this->cor=$cor;
        $this->observacao=$observacao;
        $this->idCliente=$idCliente;
        $this->nomeCliente=$nomeCliente;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>