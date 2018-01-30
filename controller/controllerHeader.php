<?php

class ControllerHeader{
	
	private $banco;

	public function __construct($banco){
		$this->banco = $banco;
	}
	
	public function pegaCategorias(){

		$lista['feminino'] = $this->montaCategorias(1);
		$lista['masculino'] = $this->montaCategorias(2);
		
		return $lista;
	}
	
	private function montaCategorias($genero){
		
		$categoriaSubcategoria = new CategoriaSubcategoria([ 2 => $genero, 3 => '', 4 => '' ]);
		
		$categoriaSubcategoriaDAO = new CategoriaSubcategoriaDAO($this->banco);
		
		$resultC = $categoriaSubcategoriaDAO->selecionaCategorias($categoriaSubcategoria);
		
		$lista = null;
		
		$genero = $genero == 1 ? 'produtos=[feminino' : 'produtos=[masculino';
		
		while ($linhasC = $resultC->fetch_array()){
			
			$categoriaSubcategoria->setIdCategoria($linhasC['id']);
			
			$categoria = stringLimpa("{$linhasC['nome']}");
			
			$caminho = $genero .'+'. $categoria .']';
				
			$lista.= "<div>";
			$lista.= "<p><a href='{$caminho}'>{$linhasC['nome']}</a></p><ul>";
			$resultS = $categoriaSubcategoriaDAO->selecionaSubcategorias($categoriaSubcategoria);
		
			while ($linhasS = $resultS->fetch_array()){
				
				$subcategoria = stringLimpa("{$linhasS['nome']}");
				
				$caminho = $genero.'+'.$categoria .'+'. $subcategoria .']';
				
				$lista.= "<li><a href='{$caminho}'>{$linhasS['nome']}</a></li>";
			}
			
			$lista.= "</ul></div>";
		}
			
		return $lista;
	}
	
	public function pegaItensDaSacola(){
		
		include '../model/domain/sacola.php';
		include '../model/dao/sacolaDAO.php';

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
	
} 


$banco = new BancoDedados();

$ControllerHeader = new ControllerHeader($banco);

$listaCategorias = $ControllerHeader->pegaCategorias();

$sacola = $ControllerHeader->pegaItensDaSacola();

$banco->fechaConexao();

?>