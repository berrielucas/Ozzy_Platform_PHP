<?php

class Conexao {

    private static $conexao = null;

    public static function conectar(){
        if (self::$conexao==null) {
            try {
                self::$conexao = new PDO("mysql:host=".$_ENV["HOST"].";dbname=".$_ENV["BANCO"], $_ENV["USER"], $_ENV["PASSWORD"]);
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Banco de dados conectado";
            } catch (PDOException $e) {
                die("Erro ao conectar com o banco de dados - Erro: ".$e);
            }
        }
        return self::$conexao;
    }

    public static function desconectar(){
        self::$conexao = null;
    }

}

?>