<?php

class ProdutoDAO {

    private $banco;
	const SSQL = "SELECT P.id,
					P.categoria as idCategoria, 
					P.subcategoria as idSubcategoria,
					C.genero as genero,
					C.nome as nomeCategoria, 
					S.nome as nomeSubcategoria,
					P.imagens,
					P.nome,
					P.descricao,
					P.valor,
					P.desconto,
					P.data_desconto,
					P.parcelas,
					P.novidade,
					P.quantidade,
					P.informacoes,
					P.avaliacoes
				FROM categoria_produtos C INNER JOIN subcategoria_produtos S INNER JOIN produtos P ON C.id = S.id_categoria  
				WHERE S.id = P.subcategoria";
				
    public function __construct($bd) {
        $this->banco = $bd;
    }

    public function inserirProduto($produto) {

		$categoria = $produto->getProdutoCS()->getIdCategoria();
        $subcategoria = $produto->getProdutoCS()->getIdSubCategoria();
        $FILES = $produto->getImagens();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor(false);
		$desconto = $produto->getDesconto();
        $dataDesconto = $produto->getDataDesconto();
        $parcelas = $produto->getparcelas();
        $novidade = $produto->getNovidade();
        $quantidade = $produto->getQuantidade();
        $informacoes = $produto->getInformacoes();
	
        $imgNames = [];
        $numImgs = count($FILES['imagens']['name']);
        for ($i = 0; $i < $numImgs; $i++) {
            $tmp_name = $FILES['imagens']['tmp_name'][$i];
            $name = $FILES['imagens']['name'][$i];
            $newName = 'image' . $i . date("Ymdhsi") . substr($name, -4);
            if (move_uploaded_file($tmp_name, '../img/produtos/' . $newName))
                $imgNames[] = $newName;
        }

        $imgNames = implode('/', $imgNames);

        $sql = 'INSERT INTO produtos (categoria, subcategoria, imagens, nome, descricao, valor, desconto, data_desconto, parcelas, novidade, quantidade, informacoes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('iisssdissiis', $categoria, $subcategoria, $imgNames, $nome, $descricao, $valor, $desconto, $dataDesconto, $parcelas, $novidade, $quantidade, $informacoes);
        $stmt->execute();

        return $stmt->insert_id;
	}
	
	public function alterarProduto($produto) {

        $idProduto = $produto->getId();
        $categoria = $produto->getProdutoCS()->getIdCategoria();
        $subcategoria = $produto->getProdutoCS()->getIdSubCategoria();
        $imagens = $produto->getImagens();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor(false);
		$desconto = $produto->getDesconto();
        $dataDesconto = $produto->getDataDesconto();
        $parcelas = $produto->getparcelas();
        $novidade = $produto->getNovidade();
        $quantidade = $produto->getQuantidade();
        $informacoes = $produto->getInformacoes();
	
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET categoria = ? WHERE id = ? AND categoria != ?');
        $stmt->bind_param('iii', $categoria, $idProduto, $categoria);
        $stmt->execute();
		
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET subcategoria = ? WHERE id = ? AND subcategoria != ?');
        $stmt->bind_param('iii', $subcategoria, $idProduto, $subcategoria);
        $stmt->execute();

		for ($i = 0; $i < 6; $i++) {
            $antiga = isset($imagens['atuais'][$i]) ? $imagens['atuais'][$i] : 0;
            $atual = isset($imagens['agora'][$i]) ? $imagens['agora'][$i] : 0;

            if ($antiga AND !in_array($antiga, $imagens['agora']) AND file_exists("../img/produtos/{$antiga}")){
                unlink("../img/produtos/{$antiga}");
            }

            if (isset($imagens['novas']['imagens']['name'][$i])) {
                $tmp_name = $imagens['novas']['imagens']['tmp_name'][$i];
                $name = $imagens['novas']['imagens']['name'][$i];
                $newName = 'image' . $i . date("Ymdhsi") . substr($name, -4);
                if (move_uploaded_file($tmp_name, '../img/produtos/' . $newName)){
                    $imgNames[] = $newName;
                }
            }else if ($atual){
                $imgNames[] = $atual;
            }
        }
		$imagens = implode('/', $imgNames);
		
        $stmt = $this->banco->preparaStatement('UPDATE produtos SET imagens = ? WHERE id = ? AND imagens != ?');
        $stmt->bind_param('sis', $imagens, $idProduto, $imagens);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE produtos SET nome = ? WHERE id = ? AND nome != ?');
        $stmt->bind_param('sis', $nome, $idProduto, $nome);
        $stmt->execute(); 
		
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET descricao = ? WHERE id = ? AND descricao != ?');
        $stmt->bind_param('sis', $descricao, $idProduto, $descricao);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE produtos SET valor = ? WHERE id = ? AND valor != ?');
        $stmt->bind_param('did', $valor, $idProduto, $valor);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE produtos SET desconto = ? WHERE id = ? AND desconto != ?');
        $stmt->bind_param('iii', $desconto, $idProduto, $desconto);
        $stmt->execute();
		
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET data_desconto = ? WHERE id = ? AND data_desconto != ?');
        $stmt->bind_param('sis', $dataDesconto, $idProduto, $dataDesconto);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE produtos SET parcelas = ? WHERE id = ? AND parcelas != ?');
        $stmt->bind_param('sis', $parcelas, $idProduto, $parcelas);
        $stmt->execute();

        $stmt = $this->banco->preparaStatement('UPDATE produtos SET novidade = ? WHERE id = ? AND novidade != ?');
        $stmt->bind_param('iii', $novidade, $idProduto, $novidade);
        $stmt->execute(); 
		
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET quantidade = ? WHERE id = ? AND quantidade != ?');
        $stmt->bind_param('iii', $quantidade, $idProduto, $quantidade);
        $stmt->execute();
		
		$stmt = $this->banco->preparaStatement('UPDATE produtos SET informacoes = ? WHERE id = ? AND informacoes != ?');
        $stmt->bind_param('sis', $informacoes, $idProduto, $informacoes);
        $stmt->execute();

        return $idProduto;
	}
	
	public function selecionaProduto($id){
		
		$sql = self::SSQL .' AND P.id = ?';
		
        $stmt = $this->banco->preparaStatement($sql);

        $stmt->bind_param('i', $id);
        $stmt->execute();
		
		$result = $stmt->get_result();
		
		$retorno = null;
		while($linhas = $result->fetch_array()){
			$retorno = new Produto($linhas);
		}

		return $retorno;
	}
	
	public function selecionaProdutos($condicao,$btProdutoFavorito = false){
		
		$sql = self::SSQL . " {$condicao[0]}";
				
		$return = ['produtos' => null, 'quantidade' => 0];
		
		$query =  $this->banco->executaQuery($sql);
		
		while($linhas = $query->fetch_array()){
			
			$produto = new Produto($linhas);
			if($btProdutoFavorito)
				$produto = $this->botaoFavorito($produto);
			
			$return['produtos'][] = $produto;
		}
		
		if(isset($condicao[1])){
			$sql = "SELECT P.id FROM categoria_produtos C INNER JOIN subcategoria_produtos S INNER JOIN produtos P ON C.id = S.id_categoria WHERE S.id = P.subcategoria {$condicao[1]}";	
			$return['quantidade'] =  $this->banco->executaQuery($sql)->num_rows;
		}
		
		return $return;
	}
	
	public function botaoFavorito($produto){
		
		
		if(isset($_SESSION['info-cliente'])){
			$idProduto = $produto->getId();
			$sql = 'SELECT id FROM produtos_favoritos WHERE id_cliente = ? AND id_produto = ?';
			$stmt = $this->banco->preparaStatement($sql);
			$stmt->bind_param('ii', $_SESSION['info-cliente']['id'], $idProduto);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 1)
				$produto->setFavorito("<div id='btProdutoFavorito' class='btProdutoFavorito' value='{$idProduto}' ><div id='foco'><img src='img/icones/coracao.png'></div></div>");
			else
				$produto->setFavorito("<div id='btProdutoFavorito' class='btProdutoFavorito' value='{$idProduto}' ><div><img src='img/icones/coracao.png'></div></div>");
		}else
			$produto->setFavorito("<div id='btProdutoFavorito'><div><img src='img/icones/coracao.png'></div></div>");
		
		return $produto;
	}
	
	public function produtoDaMesmaSubacategoria($produto){
		
		$subacategoria = $produto->getProdutoCS()->getIdSubcategoria();
		
		$sql = self::SSQL . ' AND P.subcategoria = ? ORDER BY RAND() LIMIT 6';
		
        $stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $subacategoria);
        $stmt->execute();
		
		$result = $stmt->get_result();
		
		$retorno = null;
		while($linhas = $result->fetch_array())
			$retorno[] = new Produto($linhas);
	
		return $retorno;
	}
}

?>