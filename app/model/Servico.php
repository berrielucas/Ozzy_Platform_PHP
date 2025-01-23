<?php
// Model Servico
class ServicoModel {
    public $idServico;
    public $nome;
    public $descricao;
    public $preco;

    public function __construct($idServico, $nome, $descricao, $preco){
        $this->idServico=$idServico;
        $this->nome=$nome;
        $this->descricao=$descricao;
        $this->preco=$preco;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>