<?php

class Produto {

    private $id;
	private $produtoCS;
    private $imagens;
    private $nome;
    private $descricao;
    private $valor;
    private $desconto;
    private $dataDesconto;
    private $parcelas;
    private $novidade;
    private $quantidade;
    private $informacoes;
    private $avaliacoes;
    private $favorito;

    public function __construct($dado) {

        for ($i = 0; $i <= 16; $i++)
            $dados[$i] = isset($dado[$i]) ? $dado[$i] : null;

		$cs = array_slice($dados, 1, 5);

		array_splice($dados, 1, 5);

        $this->id = $dados[0];
        $this->produtoCS = new CategoriaSubcategoria($cs);
        $this->imagens = $dados[1];
        $this->nome = $dados[2];
        $this->descricao = $dados[3];
        $this->valor = $dados[4];
        $this->desconto = $dados[6] < date("y-m-d") ? 0 : $dados[5];
        $this->dataDesconto = $dados[6];
        $this->parcelas = $dados[7];
        $this->novidade = $dados[8];
        $this->quantidade = $dados[9];
        $this->informacoes = $dados[10];
        $this->avaliacoes = $dados[11];
	
    }
	
    public function getId() {
        return $this->id;
    }

    public function getProdutoCS() {
        return $this->produtoCS;
    }

    public function getImagens($condicao = null) {
		if($condicao === 'array')
			return explode('/',$this->imagens);
        return $this->imagens;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getValor($condicao = true) {
		if($condicao === 'desconto')
			return $this->valorComDesconto();
		
        return $this->numeroDecimal($this->valor,$condicao);
    }

    public function getDesconto() {
        return $this->desconto;
    }

    public function getDataDesconto() {
        return $this->dataDesconto;
    }

    public function getParcelas($condicao = null) {
		
		if($condicao === 'array'){
			
			$array = json_decode($this->parcelas);

			$valorD = $this->valorComDesconto(false);
			
			foreach($array as $values){
		
				$calc = ($valorD + $this->numeroDecimal($values[0],false))/$values[1];
				$valor = number_format(round($calc,2),2,',','');
				$parcelas[] = ['acrescimo' => $values[0], 'vezes' => $values[1], 'valor' => $valor] ;
				
			}
			return $parcelas;
		}
		
        return $this->parcelas;
    }

    public function getNovidade() {
        return $this->novidade;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }
	
	public function getInformacoes() {
        return $this->informacoes;
    }
	
	public function getAvaliacoes($condicao = null) {
		
		if($condicao === 'ranque')
			return $this->cincoEstrelas();
	
        return $this->avaliacoes;
    }
	
	
	public function getFavorito() {
        return $this->favorito;
    }
	
	public function setFavorito($favorito) {
        $this->favorito = $favorito;
    }
	
	public function setValor($valor) {
        $this->valor = $valor;
    }
	
    public function numeroDecimal($valor, $condicao = true) {
        
        if (!$this->validaValor($valor))
            return null;
                
        $valor = preg_replace('/\D/i', '', $valor);

        if (strlen($valor) > 3)
            $valor = preg_replace('/^(0+)(\d)/i', "$2", $valor);

        $num = strlen($valor);
        if ($num < 3) {
            for ($i = 0; $i < (3 - $num); $i++) {
                $valor = '0' . $valor;
            }
        }

        if ($condicao) {
            $valor = preg_replace('/(\d+)(\d{2})/i', "$1,$2", $valor);
            $valor = preg_replace('/(\d+)(\d{3})(\,\d{2})/i', "$1.$2$3", $valor);
            $valor = preg_replace('/(\d+)(\d{3})(\.\d{3}\,\d{2})/i', "$1.$2$3", $valor);
            $valor = preg_replace('/(\d+)(\d{3})(\.\d{3}\.\d{3}\,\d{2})/i', "$1.$2$3", $valor);
        } else {
            $valor = preg_replace('/(\d)(\d{2})$/i', "$1.$2", $valor);
        }

        return $valor;
    }
    
    private function validaValor($valor){
       
       if (preg_match("/^(\d\.?\,?){1,}$/", $valor))
            return true;
       
       return false;
    }
	
	public function valorComDesconto($condicao = true){
		
		$valor = $this->numeroDecimal($this->valor, false);
		$valor = $valor - ($this->desconto / 100 * $this->valor);
		$valor = number_format(round($valor,2),2,'.','');
		
		return $condicao ? $this->numeroDecimal($valor) : $valor;
	}	
	
	public function cincoEstrelas(){
		$avaliacoes = $this->avaliacoes ? explode('/',$this->avaliacoes) : [0,0];
		$porcentagem = round($avaliacoes[0] * 20,2);
		
		$estrelas = null;
		for($i = 0; $i < 5; $i++) $estrelas .= "<img src='img/icones/estrela.png' id='estrelaAvaliacao'>";
		
		$retorno="<div id='avaliacoesCincoEstrelasDoProduto'>
					<sup>{$avaliacoes[0]}</sup>
					<div id='localPorcentagemEstrelas'>
						<div style='width:{$porcentagem}%'></div>
						<div>{$estrelas}</div>
					</div> 
					{$avaliacoes[1]} avaliações 
				</div>";
				
		return $retorno;
	}
	
}
