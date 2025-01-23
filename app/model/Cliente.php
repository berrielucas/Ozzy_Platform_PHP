<?php
// Model Cliente
class ClienteModel {
    public $idCliente;
    public $nome;
    public $telefone1;
    public $telefone2;
    public $email;
    private $senha;
    public $logradouro;
    public $cep;
    public $numero;
    public $cidade;
    public $estado;
    public $cpf;

    public function __construct($idCliente, $nome, $telefone1, $telefone2, $email, $senha, $logradouro, $cep, $numero, $cidade, $estado, $cpf){
        $this->idCliente=$idCliente;
        $this->nome=$nome;
        $this->telefone1=$telefone1;
        $this->telefone2=$telefone2;
        $this->email=$email;
        $this->senha=$senha;
        $this->logradouro=$logradouro;
        $this->cep=$cep;
        $this->numero=$numero;
        $this->cidade=$cidade;
        $this->estado=$estado;
        $this->cpf=$cpf;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>