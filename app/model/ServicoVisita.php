<?php
// Model ServicoVisita
class ServicoVisitaModel {
    private $idVisita;
    public $idServico;
    public $quantidade;
    public $preco;
    public $nome;
    public $precoUnitario;

    public function __construct($idVisita, $idServico, $quantidade, $preco, $nome, $precoUnitario){
        $this->idVisita=$idVisita;
        $this->idServico=$idServico;
        $this->quantidade=$quantidade;
        $this->preco=$preco;
        $this->nome=$nome;
        $this->precoUnitario=$precoUnitario;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>