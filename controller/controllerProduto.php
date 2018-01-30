<?php

include '../model/domain/produto.php';
include '../model/dao/produtoDAO.php';

include '../model/domain/categoriaSubcategoria.php';
include '../model/dao/categoriaSubcategoriaDAO.php';

include '../model/dao/avaliacoesDAO.php';

include '../model/dataBase/bancoDedados.php';

include '../model/funcoes/todasFuncoes.php';

class ControllerProduto{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $value)
			$this->dados[] = $value;
		
	}
	
	public function pegarProduto(){
	
		$produtoDAO = new ProdutoDAO($this->banco);
		$produto = $produtoDAO->selecionaProduto($this->dados[0]);
		return $produtoDAO->botaoFavorito($produto);
	}
	
	public function inserirProdutoNaSacola(){
		
		if(isset($_SESSION['info-cliente'])){
			
			include '../model/domain/sacola.php';
			include '../model/dao/sacolaDAO.php';
		
			$sacola = new Sacola($this->dados);
			$sacolaDAO = new SacolaDAO($this->banco);
			
			if($sacolaDAO->verificaNaSacola($sacola) == 0)
				return $sacolaDAO->inserirNaSacola($sacola);
			
		}else{
			
			$condicao = true;
			
			array_splice($this->dados, 0, 2);
			
			if(isset($_SESSION['sacola-cliente'])){
				foreach($_SESSION['sacola-cliente'] as $items){
					if($items[0] == $this->dados[0]){
						$condicao = false;
						break;
					}		
				}
			}
			
			if($condicao)
				$_SESSION['sacola-cliente'][] = $this->dados;
		}
		
	}
	
	public function produtosRelacionados($produto){
	
		$produtoDAO = new ProdutoDAO($this->banco);
		return $produtoDAO->produtoDaMesmaSubacategoria($produto);
	}
	
	public function feedbackAvaliacoes(){
		
		$avaliacoesDAO = new AvaliacoesDAO($this->banco);
		return $avaliacoesDAO->selecionaMediaAvalicoes($this->dados[0]);
	}
	
	public function pegaAvaliacoesCliente(){
		
		$avaliacoesDAO = new AvaliacoesDAO($this->banco);
		return $avaliacoesDAO->selecionaAvaliacoesCliente($this->dados[0]);
	}
} 

if(isset($_POST['inserirNaSacola'])){
	
	$dados[] = null;
	$dados[] = isset($_SESSION['info-cliente']) ? $_SESSION['info-cliente']['id'] : null;
	$dados[] = $_POST['idProduto'];
	$dados[] = 1;
	
	$banco = new BancoDedados;
	
	$ControllerProduto = new ControllerProduto($banco, $dados);
	$produto = $ControllerProduto->inserirProdutoNaSacola();
	
	$banco->fechaConexao();
	exit;
	
}

if(isset($_GET['produto']) and is_numeric($_GET['produto'])){
	$dados[0] = $_GET['produto'];
	
	$banco = new BancoDedados;
	$ControllerProduto = new ControllerProduto($banco, $dados);
	$produto = $ControllerProduto->pegarProduto();
	
	if(!$produto) die('produto não encontrado no sistema');
	
	$produtosRelacionados = $ControllerProduto->produtosRelacionados($produto);
	
	$feedbackAvaliacoes = $ControllerProduto->feedbackAvaliacoes();
	
	$avaliacoesDeClientes = $ControllerProduto->pegaAvaliacoesCliente();
	
	$banco->fechaConexao();
}else{
	die('<h2>selecione um produto para visualizar</h2>');
}


?>