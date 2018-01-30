<?php

include '../../model/domain/categoriaSubcategoria.php';
include '../../model/dao/categoriaSubcategoriaDAO.php';
include '../../model/dataBase/bancoDedados.php';
include '../../model/funcoes/todasFuncoes.php';

class ControllerCategoriasSubcategorias{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $value)
			$this->dados[] = $value;
		
	}
	
	public function mostraCategorias(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 2 => $this->dados[0], 3=> $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$result = $categoriaSubcategoriaDAO->selecionaCategorias($categoriaSubcategoria);
		
		$lista = null;
		
		while ($linhas = $result->fetch_array()){
			
			$dados = [ 0 => $linhas['id'], 2 => $linhas['genero'], 3 => $linhas['nome'] ];
			$categoriaSubcategoria = new CategoriaSubcategoria($dados);
			
			$lista.="<li value='{$categoriaSubcategoria->getIdCategoria()}'>
						<div>
							<a>{$categoriaSubcategoria->getNomeCategoria()}</a>
							<span>{$categoriaSubcategoria->getGeneroCategoria('texto')}</span>
						</div><button id='btEditar'>editar</button><button id='btExcluir'>excluir</button>
					</li>";
		}
		return $lista;
	}	
	
	public function requisitarCategoria(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 2 => $this->dados[0], 3=> $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$result = $categoriaSubcategoriaDAO->selecionaCategorias($categoriaSubcategoria);
		$lista = null;
		while ($linhas = $result->fetch_array())
			$lista[] = [$linhas['id'], $linhas['nome']];
		
		return $lista;
	}
	
	public function mostraSubcategorias(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 0 => $this->dados[0], 4 => $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$result = $categoriaSubcategoriaDAO->selecionaSubcategorias($categoriaSubcategoria);
		
		$lista = null;
		
		while ($linhas = $result->fetch_array()){
			
			$dados = [ 1 => $linhas['id'], 4 => $linhas['nome'] ];
			$categoriaSubcategoria = new CategoriaSubcategoria($dados);
			
			$lista.="<li>
						<div value='{$categoriaSubcategoria->getIdSubcategoria()}'>
							{$categoriaSubcategoria->getNomeSubcategoria()}
						</div><button id='btEditar'>editar</button><button id='btExcluir'>excluir</button>
					</li>";
		}
		return $lista;
	}
	
	public function adicionarCategoria(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 2 => $this->dados[0], 3 => $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->inserirCategoria($categoriaSubcategoria);
	}
	
	public function adicionarSubcategoria(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 0 => $this->dados[0], 4 => $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->inserirSubcategoria($categoriaSubcategoria);
	}	
	
	public function editarCategoria(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 0 => $this->dados[0], 2 => $this->dados[1], 3 => $this->dados[2] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->alterarCategoria($categoriaSubcategoria);
	}
	
	public function editarSubcategoria(){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 1 => $this->dados[0], 4 => $this->dados[1] ]);
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->alterarSubcategoria($categoriaSubcategoria);
	}
	
	public function excluirCategoria(){
		
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->deletarCategoria($this->dados[0]);
	}	
	
	public function excluirSubcategoria(){
		
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		return $categoriaSubcategoriaDAO->deletarSubcategoria($this->dados[0]);
	}
	
} 

@$POST = $_POST;

if(isset($POST['buscarPorCategorias'])){
	
	$genero = $POST['genero'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$genero, $nome]);
	echo $controllerCategoriasSubcategorias->mostraCategorias();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['buscarPorSubcategorias'])){
	
	$idCategoria = $POST['idCategoria'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idCategoria, $nome]);
	echo $controllerCategoriasSubcategorias->mostraSubcategorias();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['adicionarCategoria'])){
	
	$genero = $POST['genero'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$genero, $nome]);
	echo $controllerCategoriasSubcategorias->adicionarCategoria();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['adicionarSubcategoria'])){
	
	$idCategoria = $POST['idCategoria'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idCategoria, $nome]);
	echo $controllerCategoriasSubcategorias->adicionarSubcategoria();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['requisitarCategoria'])){
	
	$genero = $POST['genero'];
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$genero, '']);
	$retorno = $controllerCategoriasSubcategorias->requisitarCategoria();
	
	echo json_encode($retorno); 
	
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['editarCategoria'])){
	
	$idCategoria = $POST['idCategoria'];
	$genero = $POST['genero'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idCategoria, $genero, $nome]);
	echo $controllerCategoriasSubcategorias->editarCategoria();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['editarSubcategoria'])){
	
	$idSubcategoria = $POST['idSubcategoria'];
	$nome = $POST['nome'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idSubcategoria, $nome]);
	echo $controllerCategoriasSubcategorias->editarSubcategoria();
	$banco->fechaConexao();
	exit;
	
}

if(isset($POST['excluirCategoria'])){
	
	$idCategoria = $POST['idCategoria'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idCategoria]);
	echo $controllerCategoriasSubcategorias->excluirCategoria();
	$banco->fechaConexao();
	exit;
	
}
if(isset($POST['excluirSubcategoria'])){
	
	$idSubcategoria = $POST['idSubcategoria'];
	
	$banco = new bancoDedados;
	$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [$idSubcategoria]);
	echo $controllerCategoriasSubcategorias->excluirSubcategoria();
	$banco->fechaConexao();
	exit;
	
}

$banco = new bancoDedados;
$controllerCategoriasSubcategorias = new ControllerCategoriasSubcategorias($banco, [0, '']);
$listaCB = $controllerCategoriasSubcategorias->mostraCategorias();
$banco->fechaConexao();


?>