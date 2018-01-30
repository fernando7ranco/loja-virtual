<?php

include '../model/domain/sacola.php';
include '../model/dao/sacolaDAO.php';

include '../model/domain/produto.php';
include '../model/dao/produtoDAO.php';

include '../model/domain/categoriaSubcategoria.php';
include '../model/dao/categoriaSubcategoriaDAO.php';


include '../model/dataBase/bancoDedados.php';


class ControllerSacola{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $value)
			$this->dados[] = $value;
		
	}
	
	public function pegaItensDaSacola(){
		
		if(isset($_SESSION['info-cliente'])){
			
			$sacolaDAO = new SacolaDAO($this->banco);
			$idCliente = $_SESSION['info-cliente']['id'];
			
			$sacola1 = $sacolaDAO->selecionaNaItensSacola($idCliente);
			
		}
		if(!isset($sacola1)) $sacola1 = [];
		
		if(isset($_SESSION['sacola-cliente'])){
			$sacola2 = [];
			$sacola2 = $_SESSION['sacola-cliente'];
			
			foreach($sacola1 as $itens1){
				foreach($sacola2 as $idx => $itens2){
					if($itens1[0] == $itens2[1])
						unset($sacola2[$idx]);
				}
			}
		
		}
		if(!isset($sacola2)) $sacola2 = [];
		
		$sacola = array_merge($sacola1,$sacola2);
		$return = null;
		
		if(isset($sacola)){
		
			$produtoDAO = new ProdutoDAO($this->banco);
			
			foreach($sacola as $item){
				$dados = [];
				
				if(count($item) == 3){
					$dados[0] = $item[0];
					$dados[2] = $item[1];
					$dados[3] = $item[2];
				}else{
					$dados[2] = $item[0];
					$dados[3] = $item[1];
				}
			
				
				$dados[5] = $produtoDAO->selecionaProduto($item[0]);
				$return[] = new Sacola($dados);
			}
		}
		
		return $return;
	}
	
	public function alterarItemNaSacola(){
		
		if($this->dados[0]){
			$sacolaDAO = new SacolaDAO($this->banco);
			$sacola = new Sacola($this->dados);
			$sacolaDAO->alterarQuantidade($sacola);
		}else{
			$sacola = $_SESSION['sacola-cliente'];
			
			foreach($sacola as $idx => $itens){
				if($itens[0] == $this->dados[2]){
					$_SESSION['sacola-cliente'][$idx][1] = $this->dados[3];
					break;
				}
				
			}
		}
	}	
	
	public function removerItemDaSacola(){
		
		if($this->dados[0]){
			$sacolaDAO = new SacolaDAO($this->banco);
			$sacola = new Sacola($this->dados);
			$sacolaDAO->deletarItensNaSacola($sacola);
		}else{
			$sacola = $_SESSION['sacola-cliente'];
			
			foreach($sacola as $idx => $itens){
				if($itens[0] == $this->dados[2]){
					unset($_SESSION['sacola-cliente'][$idx]);
					break;
				}
				
			}
		}
	}
	
} 

$banco = new BancoDeDados;



if(isset($_POST['alterarQuantidadeDeItens'])){
	
	$dados[] = $_POST['idItem'];
	$dados[] = isset($_SESSION['info-cliente']) ? $_SESSION['info-cliente']['id'] : null;
	$dados[] = $_POST['idProduto'];
	$dados[] = $_POST['quantidade'];
	
 	$controllerSacola = new ControllerSacola($banco, $dados);
	$controllerSacola->alterarItemNaSacola();
	$banco->fechaConexao();
	exit;
}

if(isset($_POST['removerItemDaSacola'])){
	
	$dados[] = $_POST['idItem'];
	$dados[] = isset($_SESSION['info-cliente']) ? $_SESSION['info-cliente']['id'] : null;
	$dados[] = $_POST['idProduto'];
	$dados[] = $_POST['quantidade'];
	
 	$controllerSacola = new ControllerSacola($banco, $dados);
	$controllerSacola->removerItemDaSacola();
	$banco->fechaConexao();
	exit;
}

$controllerSacola = new ControllerSacola($banco);
$sacola = $controllerSacola->pegaItensDaSacola();

$banco->fechaConexao();

?>