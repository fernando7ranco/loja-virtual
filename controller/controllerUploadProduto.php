<?php

include '../../model/domain/produto.php';
include '../../model/dao/produtoDAO.php';
include '../../model/domain/categoriaSubcategoria.php';
include '../../model/dao/categoriaSubcategoriaDAO.php';
include '../../model/dataBase/bancoDedados.php';
include '../../model/funcoes/todasFuncoes.php';

class ControllerUploadProduto{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $name => $value)
			$this->dados[$name] = $value;
		
	}
	
	public function anunciarProduto(){
		
		$produto = new Produto($this->dados);
		$produtoDAO = new ProdutoDAO($this->banco);
		return $produtoDAO->inserirProduto($produto);
		
	}	
	
	public function editarProduto(){
		
		$produto = new Produto($this->dados);
	
		$produtoDAO = new ProdutoDAO($this->banco);
		return $produtoDAO->alterarProduto($produto);
		
	}
	
	public function listarCategorias(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 2 => $this->dados[0], 3=> $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$result = $categoriaSubcategoriaDAO->selecionaCategorias($categoriaSubcategoria);
		$lista = null;
		while ($linhas = $result->fetch_array())
			$lista[] = [$linhas['id'], $linhas['nome']];
		
		return $lista;
	}	
	
	public function listarSubcategorias(){

		$categoriaSubcategoria = new CategoriaSubcategoria([ 0 => $this->dados[0], 4 => $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$result = $categoriaSubcategoriaDAO->selecionaSubcategorias($categoriaSubcategoria);
		$lista = null;
		while ($linhas = $result->fetch_array())
			$lista[] = [$linhas['id'], $linhas['nome']];
		
		return $lista;
	}
	
	public function pegarProduto(){
	
		$produtoDAO = new ProdutoDAO($this->banco);
		return $produtoDAO->selecionaProduto($this->dados[0]);
	}
	
} 

@$POST = $_POST;

if(isset($POST['anunciarProduto'])){


	$dados[1] = $POST['categoria'];
	$dados[] = $POST['subcategoria'];
	$dados[6] = $_FILES;
	$dados[] = $POST['nome'];
	$dados[] = $POST['descricao'] ? $POST['descricao'] : '';
	$dados[] = $POST['valor'];
	$dados[] = $POST['desconto'] ? $POST['desconto'] : 0;
	$dados[] = isset($POST['dataDesconto']) ? $POST['dataDesconto'] : '0000-00-00';
	$dados[] = isset($POST['parcelas']) ? $POST['parcelas'] : '';
	$dados[] = isset($POST['novidade']) ? 1 : 0;
	$dados[] = $POST['quantidade'];
	$dados[] = isset($POST['informacoes']) ? $POST['informacoes'] : '';
	
	$banco = new BancoDedados;
	$controllerAnunciarProduto = new ControllerUploadProduto($banco,$dados);
	echo $controllerAnunciarProduto->anunciarProduto();
	$banco->fechaConexao();
	exit;
	
}

if (isset($POST['editarProduto'])) {

	$idProduto = $_GET['produto'];
	
	$banco = new BancoDedados;
    $query = $banco->executaQuery("SELECT id,imagens FROM produtos WHERE id = {$idProduto}");
    
    if ($query->num_rows == 1) {
        
		$imgs['atuais'] = explode('/', $query->fetch_array()['imagens']);
		$imgs['agora'] = isset($POST['imagens']) ? $POST['imagens'] : [];
		$imgs['novas'] = isset($_FILES) ? $_FILES : [];
		
		$dados[] = $idProduto;
		$dados[] = $POST['categoria'];
		$dados[] = $POST['subcategoria'];
		$dados[6] = $imgs;
		$dados[] = $POST['nome'];
		$dados[] = $POST['descricao'] ? $POST['descricao'] : '';
		$dados[] = $POST['valor'];
		$dados[] = $POST['desconto'] ? $POST['desconto'] : 0;
		$dados[] = isset($POST['dataDesconto']) ? $POST['dataDesconto'] : '0000-00-00';
		$dados[] = isset($POST['parcelas']) ? $POST['parcelas'] : '';
		$dados[] = isset($POST['novidade']) ? 1 : 0;
		$dados[] = $POST['quantidade'];
		$dados[] = isset($POST['informacoes']) ? $POST['informacoes'] : '';
		
		$controllerAnunciarProduto = new ControllerUploadProduto($banco,$dados);
		echo $controllerAnunciarProduto->editarProduto();
	}
	$banco->fechaConexao();
	exit;
}

if(isset($POST['listarCategorias'])){
	
	$dados = [$POST['genero'] ,''];
	
	$banco = new BancoDedados;
	$controllerAnunciarProduto = new ControllerUploadProduto($banco,$dados);
	$retorno = $controllerAnunciarProduto->listarCategorias();
	echo json_encode($retorno);
	$banco->fechaConexao();
	exit;
}

if(isset($POST['listarSubcategorias'])){
	
	$dados = [$POST['idCategoria'] ,''];
	
	$banco = new BancoDedados;
	$controllerAnunciarProduto = new ControllerUploadProduto($banco,$dados);
	$retorno = $controllerAnunciarProduto->listarSubcategorias();
	echo json_encode($retorno);
	$banco->fechaConexao();
	exit;
}
if(basename($_SERVER['PHP_SELF']) === 'editar_produto.php'){
	if(isset($_GET['produto']) and is_numeric($_GET['produto'])){
		$dados[0] = $_GET['produto'];
		
		$banco = new BancoDedados;
		$controllerAnunciarProduto = new ControllerUploadProduto($banco,$dados);
		$produto = $controllerAnunciarProduto->pegarProduto();
		$banco->fechaConexao();
		
		if(!$produto) die('produto não encontrado no sistema');
		
	}else{
		die('<h2>selecione um produto para editar</h2>');
	}
}

?>