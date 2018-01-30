<?php

class Sacola {

    private $id;
    private $idCliente;
    private $idProduto;
    private $quantidade;
    private $data;
    private $produto;

    public function __construct($dados) {
        for ($i = 0; $i <= 5; $i++)
            $dados[$i] = isset($dados[$i]) ? $dados[$i] : null;

        $this->id = $dados[0];
        $this->idCliente = $dados[1];
        $this->idProduto = $dados[2];
        $this->quantidade = $dados[3];
        $this->data = $dados[4];
        $this->produto = $dados[5];
    }

    function getId() {
        return $this->id;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdProduto() {
        return $this->idProduto;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getData() {
        return $this->data;
    }

    function getProduto() {
        return $this->produto;
    }

}
