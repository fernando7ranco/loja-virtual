<?php

$POST = $_POST;
$acao = $POST['acao'];

include '../dataBase/bancoDedados.php';

session_start();

if($acao === 'ajaxFuncaoProdutoFavorito' and isset($_SESSION['info-cliente']) ){
	$idCliente = $_SESSION['info-cliente']['id'];
	$idProduto = $POST['idProduto'];
	
	if(!is_numeric($idCliente) || !is_numeric($idProduto)) exit;
	
	$banco = new BancoDedados;
	
	$sql = 'SELECT id FROM produtos_favoritos WHERE id_cliente = ? AND id_produto = ?';
	$stmt = $banco->preparaStatement($sql);
	$stmt->bind_param('ii', $idCliente, $idProduto);
    $stmt->execute();
	$result = $stmt->get_result();
	
	if($result->num_rows === 1){
		$sql = 'DELETE FROM produtos_favoritos WHERE id_cliente = ? AND id_produto = ?';
		$stmt = $banco->preparaStatement($sql);
		$stmt->bind_param('ii', $idCliente, $idProduto);
		$stmt->execute();
		echo 0;
	}else{
		$sql = 'INSERT INTO produtos_favoritos (id_cliente, id_produto) VALUES (?,?)';
		$stmt = $banco->preparaStatement($sql);
		$stmt->bind_param('ii', $idCliente, $idProduto);
		echo 1;
		$stmt->execute();
	}
	
	$banco->fechaConexao();
	exit;
}