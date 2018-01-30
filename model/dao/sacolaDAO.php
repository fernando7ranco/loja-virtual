<?php

class SacolaDAO {

    private $banco;

    public function __construct($bd) {
        $this->banco = $bd;
    }
	
	public function verificaNaSacola($sacola){
		
		$idCliente = $sacola->getIdCliente();
        $idProduto = $sacola->getIdproduto();
		var_dump($sacola);
		
		$sql = 'SELECT id FROM sacola WHERE id_cliente = ? AND id_produto = ?';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('ii', $idCliente, $idProduto);
        $stmt->execute();
		$result = $stmt->get_result();
		
		return $result->num_rows;
	}

    public function inserirNaSacola($sacola) {
		
		$idCliente = $sacola->getIdCliente();
        $idProduto = $sacola->getIdproduto();
		$quantidade = $sacola->getQuantidade();


        $sql = 'INSERT INTO sacola (id_cliente, id_produto, quantidade, data) VALUES (?,?,?, NOW())';
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('iii', $idCliente, $idProduto, $quantidade);
        $stmt->execute();

        return $stmt->insert_id;
	}
	
	public function selecionaNaItensSacola($idCliente){
		
		$sql = 'SELECT id, id_produto, quantidade FROM sacola WHERE id_cliente = ?';
		
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $idCliente);
        $stmt->execute();
		
		$result = $stmt->get_result();
	
		$retorno = null;
		
		$produtoDAO = new ProdutoDAO($this->banco);
		
		while($linhas = $result->fetch_array()){
			$retorno[] = [$linhas['id'], $linhas['id_produto'], $linhas['quantidade']];
		}
	
		return $retorno;
	}
	
	public function alterarQuantidade($sacola) {
		
		$idCliente = $sacola->getIdCliente();
        $idProduto = $sacola->getIdproduto();
		$quantidade = $sacola->getQuantidade();

        $sql = 'UPDATE sacola SET quantidade = ? WHERE id_cliente = ? AND id_produto = ?';
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('iii',  $quantidade, $idCliente, $idProduto);
        $stmt->execute();
		
	}	
	
	public function deletarItensNaSacola($sacola) {
		
		$idCliente = $sacola->getIdCliente();
        $idProduto = $sacola->getIdproduto();

        $sql = 'DELETE FROM sacola WHERE id_cliente = ? AND id_produto = ?';
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('ii', $idCliente, $idProduto);
        $stmt->execute();
	}
	
}

?>