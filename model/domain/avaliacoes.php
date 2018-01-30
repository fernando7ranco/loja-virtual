<?php

class Avaliacoes {

    private $id;
	private $idCliente;
	private $idProduto;
	private $avaliacao;
	private $comentario;
	private $data;

    public function __construct($dados) {
        for ($i = 0; $i <= 5; $i++)
            $dados[$i] = isset($dados[$i]) ? $dados[$i] : null;

        $this->id = $dados[0];
        $this->idCliente = $dados[1];
        $this->idProduto = $dados[2];
        $this->avaliacao = $dados[3];
        $this->comentario = $dados[4];
        $this->data = $dados[5];
       
    }
	
}
