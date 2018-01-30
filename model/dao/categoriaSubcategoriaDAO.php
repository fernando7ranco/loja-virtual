
<?php

class categoriaSubcategoriaDAO {

    private $banco;

    public function __construct($bd) {
        $this->banco = $bd;
    }

	public function selecionaCategorias($categoriaSubcategoria){
		
		$genero = $categoriaSubcategoria->getGeneroCategoria();
		$nome = $categoriaSubcategoria->getNomeCategoria();
		
		$genero = $genero == 0 ? '' : "genero = '{$genero}' AND";
		
		$sql = "SELECT * FROM categoria_produtos WHERE {$genero} lCase (nome) LIKE CONCAT('%',?,'%') ORDER BY nome";
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('s',$nome);
        $stmt->execute();
        $result = $stmt->get_result();
		
		return $result;
	}
	
	public function selecionaSubcategorias($categoriaSubcategoria){
		
		$id = $categoriaSubcategoria->getIdCategoria();
		$nome = $categoriaSubcategoria->getNomeSubcategoria();
		
		$sql = "SELECT * FROM subcategoria_produtos WHERE id_categoria = ? AND  nome LIKE CONCAT('%',?,'%') ORDER BY nome";
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('is', $id, $nome);
        $stmt->execute();
        $result = $stmt->get_result();
		
		return $result;
		
	}
	
	public function inserirCategoria($categoriaSubcategoria){
		
		$genero = $categoriaSubcategoria->getGeneroCategoria();
		$nome = $categoriaSubcategoria->getNomeCategoria();
		
		$sql = 'INSERT INTO categoria_produtos (genero, nome) values (?,?)';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('is', $genero, $nome);
        $stmt->execute();
		return $stmt->affected_rows;
	}		
	
	public function inserirSubcategoria($categoriaSubcategoria){
		
		$id = $categoriaSubcategoria->getIdCategoria();
		$nome = $categoriaSubcategoria->getNomeSubcategoria();
		
		$sql = 'INSERT INTO subcategoria_produtos (id_categoria, nome) values (?,?)';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('is', $id, $nome);
        $stmt->execute();
		
		return $stmt->affected_rows;
	}	
	
	public function alterarCategoria($categoriaSubcategoria){
		
		$id = $categoriaSubcategoria->getIdCategoria();
		$genero = $categoriaSubcategoria->getGeneroCategoria();
		$nome = $categoriaSubcategoria->getNomeCategoria();
		
		$sql = 'UPDATE categoria_produtos SET genero = ?, nome = ? WHERE id = ? and (genero != ? or nome != ?)';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('isiis', $genero, $nome, $id, $genero, $nome);
        $stmt->execute();
		$stmt->set_charset("utf8");
		return $stmt->affected_rows;
	}		
	
	public function alterarSubcategoria($categoriaSubcategoria){
		
		$id = $categoriaSubcategoria->getIdSubcategoria();
		$nome = $categoriaSubcategoria->getNomeSubcategoria();

		$sql = 'UPDATE subcategoria_produtos SET  nome = ? WHERE id = ? and nome != ?';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('sis', $nome, $id, $nome);
        $stmt->execute();
		
		return $stmt->affected_rows;
	}	
	
	public function deletarCategoria($id){
		
		$sql = 'DELETE FROM categoria_produtos WHERE id = ?';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
		
		return $stmt->affected_rows;
	}	
	
	public function deletarSubcategoria($id){
		
		$sql = 'DELETE FROM subcategoria_produtos WHERE id = ?';
		$stmt = $this->banco->preparaStatement($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
		
		return $stmt->affected_rows;
	}
}

?>