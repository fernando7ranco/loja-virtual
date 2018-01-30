<?php
	
include '../model/domain/categoriaSubcategoria.php';
include '../model/dao/categoriaSubcategoriaDAO.php';	

include '../model/domain/produto.php';
include '../model/dao/produtoDAO.php';

include '../model/funcoes/todasFuncoes.php';

include '../model/dataBase/bancoDedados.php';

class ControllerMeusFavoritos{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $name => $value)
			$this->dados[] = $value;
		
	}
	
	public function pegaProdutosFavoritos(){
		
		$idCliente = $_SESSION['info-cliente']['id'];
		
		$condicao[] = "AND P.id IN ( SELECT id_produto FROM produtos_favoritos WHERE id_cliente = {$idCliente} ) ORDER BY P.id DESC";

		$produtoDAO = new ProdutoDAO($this->banco);
		$return = $produtoDAO->selecionaProdutos($condicao, true);
		
		return $return;
	}
	
} 


$banco = new BancoDedados();

$ControllerMeusFavoritos = new ControllerMeusFavoritos($banco);

$produtos = $ControllerMeusFavoritos->pegaProdutosFavoritos();

$banco->fechaConexao();

?>