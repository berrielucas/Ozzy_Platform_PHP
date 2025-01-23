<?php
// Model Funcionario
class FuncionarioModel {
    public $idFuncionario;
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
    public $ativo;
    public $adm;


    public function __construct($idFuncionario, $nome, $telefone1, $telefone2, $email, $senha, $logradouro, $cep, $numero, $cidade, $estado, $cpf, $ativo, $adm){
        $this->idFuncionario=$idFuncionario;
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
        $this->ativo=$ativo;
        $this->adm=$adm;
    }

    public function __get($key){
        return $this->{$key};
    }

    public function __set($key, $value){
        $this->{$key}=$value;
    }
}

?>