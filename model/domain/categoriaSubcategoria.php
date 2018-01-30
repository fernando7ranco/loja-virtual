<?php

class CategoriaSubcategoria {

    private $idCategoria;
    private $idSubcategoria;
    private $generoCategoria;
    private $nomeCategoria;
    private $nomeSubcategoria;

    public function __construct($dados) {
        for ($i = 0; $i <= 4; $i++)
            $dados[$i] = isset($dados[$i]) ? $dados[$i] : null;

        $this->idCategoria = $dados[0];
        $this->idSubcategoria = $dados[1];
        $this->generoCategoria = $dados[2];
        $this->nomeCategoria = ucwords($dados[3]);
        $this->nomeSubcategoria = ucwords($dados[4]);
    }
    
    function getIdCategoria() {
        return $this->idCategoria;
    }

    function getIdSubcategoria() {
        return $this->idSubcategoria;
    }

    function getGeneroCategoria($condicao = null) {
        
        if($condicao == 'texto')
            return $this->generoToString();
        
        return $this->generoCategoria;
    }

    function getNomeCategoria() {
        return $this->nomeCategoria;
    }

    function getNomeSubcategoria() {
        return $this->nomeSubcategoria;
    }

    private function generoToString() {

        switch ($this->generoCategoria) {
            case 1: $genero = 'feminino';
                break;
            case 2: $genero = 'masculino';
                break;
            default: $genero = '';
                break;
        }
        return $genero;
    }
    
    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setIdSubcategoria($idSubcategoria) {
        $this->idSubcategoria = $idSubcategoria;
    }

    public function setGeneroCategoria($generoCategoria) {
        $this->generoCategoria = $generoCategoria;
    }

    public function setNomeCategoria($nomeCategoria) {
        $this->nomeCategoria = $nomeCategoria;
    }

    public function setNomeSubcategoria($nomeSubcategoria) {
        $this->nomeSubcategoria = $nomeSubcategoria;
    }



}
