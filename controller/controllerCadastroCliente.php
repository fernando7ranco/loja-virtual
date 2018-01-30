<?php

include '../model/domain/categoriaSubcategoria.php';
include '../model/dao/categoriaSubcategoriaDAO.php';	

include '../model/domain/produto.php';
include '../model/dao/produtoDAO.php';

include '../model/domain/cliente.php';
include '../model/dao/clienteDAO.php';

include '../model/dataBase/bancoDedados.php';

include '../model/funcoes/todasFuncoes.php';

class ControllerCadastroCliente{
	
	private $banco;
	private $dados;
	
	public function __construct($banco, $dados = [null]){
		
		$this->banco = $banco;
		
		foreach($dados as $name => $value)
			$this->dados[] = $value;
		
	}
	
	public function pegaCliente(){
		
		$clienteDAO = new ClienteDAO($this->banco);
		return $clienteDAO->selecionaClienteId($this->dados[0]);
	}
	
	public function editarCadastro(){
		
		$cliente = new Cliente($this->dados[1]);
		$validacao = $cliente->validaDados();
		
		$euCliente = $this->pegaCliente();
		
		$clienteDAO = new ClienteDAO($this->banco);
	
		if($euCliente->getCpf() != $cliente->getCpf() and $clienteDAO->verificarCpf($cliente->getCpf()) > 0 )
			return 'cpf';
		if($euCliente->getRg() != $cliente->getRg() and $clienteDAO->verificarRg($cliente->getRg()) > 0)
			return 'rg';
	
		return $clienteDAO->alterarCliente($cliente);
				
	
	}
	

} 

@$POST = $_POST;

$banco = new BancoDeDados;

if(isset($POST['editarCadastro'])){

	$dados[] = $idCliente;
	
	foreach($_POST['dados'] as $valor)
		$dados[] = $valor;
		
	$controllerCadastroCliente = new controllerCadastroCliente($banco,[$idCliente, $dados]);
	echo $controllerCadastroCliente->editarCadastro();
	$banco->fechaConexao();
	exit;
}

$controllerCadastroCliente = new ControllerCadastroCliente($banco,[$idCliente]);
$cliente = $controllerCadastroCliente->pegaCliente();
$banco->fechaConexao();

?>