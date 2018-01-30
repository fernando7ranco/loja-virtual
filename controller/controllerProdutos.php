<?php
	
include '../model/domain/categoriaSubcategoria.php';
include '../model/dao/categoriaSubcategoriaDAO.php';	

include '../model/domain/produto.php';
include '../model/dao/produtoDAO.php';

include '../model/funcoes/todasFuncoes.php';

include '../model/dataBase/bancoDedados.php';

class ControllerProdutos{
	
	private $banco;
	private $dados;
	
	public function __construct($banco,$dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $name => $value)
			$this->dados[] = $value;
		
	}
	
	public function pegaProdutos($GET){
		
		$GCS = isset($GET['GCS']) ? explode(' ',$GET['GCS']) : null;
		
		if(!$GCS[0] == 'feminino' || !$GCS[0] == 'masculino') $GCS[0] = null;
		$categoria = isset($GCS[1]) ? str_replace('-',' ',$GCS[1]) : null;
		$subcategoria = isset($GCS[2]) ? str_replace('-',' ',$GCS[2]) : null;
		$order = isset($GET['ordem']) ? $GET['ordem'] : null;
		$search = isset($GET['search']) ? trim($GET['search']) : null;
		$pagina = isset($GET['pagina']) ? (($GET['pagina']-1) * 20) : 0;
		
		$filtros = [	
						"<a href='produtos'>HOME</a>",
						$GCS[0] ? "<a href='produtos=[{$GCS[0]}]'>{$GCS[0]}</a>" : null,
						$categoria ? "<a href='produtos=[{$GCS[0]}+{$GCS[1]}]'>{$categoria}</a>" : null,
						$subcategoria ? "<a href='produtos=[{$GCS[0]}+{$GCS[1]}+{$GCS[2]}]'>{$subcategoria}</a>" : null,
						$search ? "<span>Busca Por '{$search}'</span>" : null
					];
					
		if($GCS[0]) 
			$genero = $GCS[0] == 'feminino' ? 'AND C.genero = 1' : 'AND C.genero = 2';
		else
			$genero = null;
		
		$categoria = $categoria ? "AND C.nome = '". $categoria."'" : null;
		$subcategoria = $subcategoria ? "AND S.nome = '". $subcategoria ."'" : null;
		
		if(is_numeric($order)){
			switch($order){
				case 1: $order = 'ORDER BY P.valor DESC'; break;
				case 2: $order = 'ORDER BY P.valor ASC'; break;
				case 3: $order = 'ORDER BY P.desconto DESC'; break;
				case 4: $order = 'ORDER BY P.avaliacoes DESC'; break;
				default:$order = 'ORDER BY P.id DESC';
			}
		}
		
		if($search)
			$search = "AND (S.nome LIKE '{$search}%'  OR P.nome LIKE '{$search}%')";

		$condicao[] = "{$genero} {$categoria} {$subcategoria} {$search} {$order} LIMIT {$pagina},20";
		$condicao[] = "{$genero} {$categoria} {$subcategoria} {$search} {$order}";
		
		$produtoDAO = new ProdutoDAO($this->banco);
		
		$return = $produtoDAO->selecionaProdutos($condicao, true); // true para pegar botão favorito do produto
		
		$return['filtros'] = implode(' > ',array_filter($filtros));
		
		return $return;
	}
	
} 


$banco = new BancoDedados();

$ControllerProdutos = new ControllerProdutos($banco);

$produtos = $ControllerProdutos->pegaProdutos(@$_GET);

$banco->fechaConexao();

?>