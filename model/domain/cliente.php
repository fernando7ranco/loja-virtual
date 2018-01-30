<?php

class Cliente {

    private $id;
    private $nome;
    private $cpf;
    private $rg;
    private $cep;
    private $endereco;
    private $bairro;
    private $estado;
    private $telefone;
    private $email;
    private $senha;

    public function __construct($dados) {
        for ($i = 0; $i <= 10; $i++)
            $dados[$i] = isset($dados[$i]) ? $dados[$i] : null;

        $this->id = $dados[0];
        $this->nome = $dados[1];
        $this->cpf = $dados[2];
        $this->rg = ucwords($dados[3]);
        $this->cep = $dados[4];
        $this->endereco = $dados[5];
        $this->bairro = $dados[6];
        $this->estado = $dados[7];
        $this->telefone = $dados[8];
        $this->email = $dados[9];
        $this->senha = $dados[10];
    
    }

    public function validaDados() {
        $retorno = true;
	
        if (!preg_match("/^([A-Z a-zÀ-ú]){3,50}$/", $this->nome))
            $retorno = $this->nome = '';

        if (!preg_match("/^((\d{3})\.(\d{3})\.(\d{3})\-(\d{2})){1,14}$/", $this->cpf))
            $retorno = $this->cpf = '';

        if (!preg_match("/^(\d){10}$/", $this->rg))
            $retorno = $this->rg = '';

        if (!preg_match("/^([0-9]){8}$/", $this->cep))
            $retorno = $this->cep = '';

        if (!preg_match("/^([A-Z a-zÀ-ú](\d{1,6})?){1,80}$/", $this->endereco))
            $retorno = $this->endereco = '';

        if (!preg_match("/^([A-Z a-zÀ-ú]){1,50}$/", $this->bairro))
            $retorno = $this->bairro = '';

        if (!preg_match("/^([A-Z]){2}$/", $this->estado))
            $retorno = $this->estado = '';

        if (!preg_match("/^(\(\d{2}\) (\d{4,5})-\d{4}){0,15}$/", $this->telefone))
            $this->telefone = '';

        if (!preg_match("/(^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)){1,80}$/", $this->email))
            $retorno = $this->email = '';

        if (!preg_match("/^([a-zA-Z0-9]){6,16}$/", $this->senha))
            $retorno = $this->senha = '';

        return $retorno;
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getRg() {
        return $this->rg;
    }

    function getCep() {
        return $this->cep;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getEstado() {
        return $this->estado;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }
    
}
